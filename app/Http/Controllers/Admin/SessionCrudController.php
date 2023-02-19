<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Attributes;
use App\Constants\FieldTypes;
use App\Constants\SessionDetailsType;
use App\Constants\SessionStatus;
use App\Http\Requests\SessionRequest;
use App\Models\Backdrop;
use App\Models\Cake;
use App\Models\FamilyMember;
use App\Models\Helpers;
use App\Models\Package;
use App\Models\PaymentMethod;
use App\Models\Photographer;
use App\Models\Session;
use App\Models\SessionDetail;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Exception;
use Illuminate\Http\RedirectResponse;
use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

/**
 * Session CRUD Controller
 */
class SessionCrudController extends CustomCrudController
{
    use CreateOperation {
        store as traitStore;
    }
    use UpdateOperation {
        update as traitUpdate;
    }

    use ShowOperation {
        show as traitShow;
    }

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     * @throws Exception
     */
    public function setup()
    {
        $this->crud->setModel(Session::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/sessions');
        $this->crud->setEntityNameStrings('Session', 'Sessions');

        // deny access
        $this->crud->denyAccess(["create"]);

        // don't show sub-sessions
        $this->crud->addClause('where', function ($q) {
            return $q->whereNull(Attributes::SESSION_ID);
        });

        // override edit view
        $this->crud->setEditView('edit.session');
        $this->crud->setShowView("show.session");

    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {

        // Filter: Status
        $this->addStatusFilter(SessionStatus::all());

        // Filter: Package Name
        $this->addPackageIdFilter(Attributes::TITLE, Helpers::readableText(Attributes::PACKAGE_NAME), Package::class, Attributes::PACKAGE_ID);

        // Filter: Photographer
        $this->addPhotographerFilter();

        // Column: ID
        $this->addColumn(Attributes::ID, 'ID');

        // Column: Title
        $this->addNameColumn("Title", 1, Attributes::TITLE);

        // Column: Total Price
        $this->addTotalPriceColumn("Total Price", 1, Attributes::TOTAL_PRICE);

        // Column: User ID
        $this->addUserNameColumn();

        // Column: Package Name
        $this->addIDColumn("Package Name", 1, Attributes::PACKAGE_NAME);

        // Column: Extra People
        $this->addNumberColumn("Extra People", 1, Attributes::EXTRA_PEOPLE);

        // Column: Photographer
        $this->addNameColumn("Photographer", 1, Attributes::PHOTOGRAPHER_NAME);

        // Column: Status
        $this->addStatusColumn(Attributes::STATUS_NAME);

    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {

        // Validation
        $this->crud->setValidation(SessionRequest::class);

        // Field: Title
        $this->addNameField(Attributes::TITLE, "Title");

        // Field: Date
        $this->addDateField(Attributes::DATE, 'Date');

        // Field: Time
        $this->addTimeField('Time', Attributes::TIME);

        // Field: Backdrops
        $this->addSessionDetailField(Attributes::BACKDROPS, "Backdrops", "Backdrop", Backdrop::class);

        // Field: Cakes
        $this->addSessionDetailField(Attributes::CAKES, "Cakes", "Cake", Cake::class);

        // Field: Backdrops
//        $this->addSessionDetailField(Attributes::CAKES, "Cakes", "Cake", Cake::class);

        //  Field: People
//        $this->addSessionDetailField(Attributes::PEOPLE, "People", "People", FamilyMember::class, Attributes::FULL_NAME);

        // Field: Additions
//        $this->addSessionDetailField(Attributes::ADDITIONS, "Additions", "Addition", StudioPackage::class, Attributes::TITLE);

        // TODO Field: Guideline

        // Field: Custom Backdrop
        $this->addCustomField(Attributes::CUSTOM_BACKDROP, "Custom Backdrops", null, FieldTypes::TEXTAREA, 5, 200);

        // Field: Custom Cake
        $this->addCustomField(Attributes::CUSTOM_CAKE, "Custom Cake", null, FieldTypes::TEXTAREA, 5, 200);

        // Field: Comments
        $this->addDescriptionField(Attributes::COMMENTS, "Comments", null, FieldTypes::TEXTAREA, 5, 200);

        // Field: Total Price
        $this->addPriceField(Attributes::TOTAL_PRICE, "Total Price");

        // Field: Status
        $this->addStatusField(SessionStatus::all(), Attributes::STATUS, "Status");

        // Field: Photographer
        $this->addStatusField(Photographer::pluck(Attributes::NAME, Attributes::ID), Attributes::PHOTOGRAPHER, "Photographer");

        // Field: Media
        $this->addMediaField("Media", "Media");

    }

    /**
     * Store
     * @return Response|RedirectResponse
     */
    public function store()
    {

        // get backdrops
        $backdrops = $this->crud->getRequest()->get(Attributes::BACKDROPS);

        // create
        $result = $this->traitStore();


        // clear cache
        Helpers::clearCache(Session::class);


        // return response
        return $result;
    }

    /**
     * Update
     * @return Response|RedirectResponse
     */
    public function update()
    {

        // get media ids
        $media_ids = $this->crud->getRequest()->get(Attributes::MEDIA_IDS);

        $this->crud->getRequest()->request->remove(Attributes::MEDIA_IDS);


        /** @var Session $session */
        $session = $this->crud->getCurrentEntry();

        // get backdrops
        $backdrops = $this->crud->getRequest()->get(Attributes::BACKDROPS);
        $this->crud->getRequest()->request->remove(Attributes::BACKDROPS);
        $backdrops = json_decode($backdrops, true);
        $backdrops = collect($backdrops)->flatten()->filter();

        // get cakes
        $cakes = $this->crud->getRequest()->get(Attributes::CAKES);
        $this->crud->getRequest()->request->remove(Attributes::CAKES);
        $cakes = json_decode($cakes, true);
        $cakes = collect($cakes)->flatten()->filter();

        // update and return response
        $result = $this->traitUpdate();

        // add backdrops
        if ($backdrops->isNotEmpty()) {
            foreach ($backdrops as $item) {

                $item_exists = SessionDetail::where(Attributes::SESSION_ID, $session->id)
                    ->where(Attributes::TYPE, SessionDetailsType::BACKDROP)
                    ->where(Attributes::VALUE, $item)->exists();

                if (!$item_exists) {
                    SessionDetail::createOrUpdate([
                        Attributes::TYPE => SessionDetailsType::BACKDROP,
                        Attributes::VALUE => $item,
                        Attributes::SESSION_ID => $session->id,
                        Attributes::PACKAGE_ID => $session->package_id,
                        Attributes::USER_ID => $session->user_id,
                        Attributes::FAMILY_ID => $session->family_id
                    ]);
                }
            }

            // delete remaining
//            SessionDetail::where(Attributes::SESSION_ID, $session->id)
//                ->where(Attributes::TYPE, SessionDetailsType::BACKDROP)
//                ->whereNotIn(Attributes::VALUE, $backdrops)->delete();
        }

        // add cakes
        if ($cakes->isNotEmpty()) {
            foreach ($cakes as $cake) {
                $cake_exists = SessionDetail::where(Attributes::SESSION_ID, $session->id)
                    ->where(Attributes::TYPE, SessionDetailsType::CAKE)
                    ->where(Attributes::VALUE, $cake)->exists();

                if (!$cake_exists) {
                    SessionDetail::createOrUpdate([
                        Attributes::TYPE => SessionDetailsType::CAKE,
                        Attributes::VALUE => $cake,
                        Attributes::SESSION_ID => $session->id,
                        Attributes::PACKAGE_ID => $session->package_id,
                        Attributes::USER_ID => $session->user_id,
                        Attributes::FAMILY_ID => $session->family_id
                    ]);
                }
            }
        }

        // media
        $update_media = $session->media()->whereNotIn(Attributes::ID, $media_ids ?? [])->delete();

        // clear cache
        Helpers::clearCache(Session::class);


        // return response
        return $result;
    }

    protected function setupShowOperation()
    {
        $this->crud->addColumn([
            'name'     => 'family_id',
            'label'    => 'Family',
            'type'     => 'closure',
            'function' => function ($entry) {
                $people = $entry->people()->first();
                return $people ? $people->first_name . ' ' . $people->last_name : ' - ';
            }
        ]);

        $this->crud->addColumn([
            'name'     => 'photographer',
            'label'    => 'Photographer',
            'type'     => 'closure',
            'function' => function($entry) {
                return $entry->photographer_name ?? ' - ';
            }
        ]);

        $this->crud->addColumn([
            'name'     => 'payment_method',
            'label'    => 'Payment Method',
            'type'     => 'closure',
            'function' => function($entry) {
                return $entry->payment_method_label ?: ' - ';
            }
        ]);

        $this->crud->addColumn([
            'name'     => 'status',
            'label'    => 'Status',
            'type'     => 'closure',
            'function' => function($entry) {
                return $entry->status_name ?: ' - ';
            }
        ]);
    }

}
