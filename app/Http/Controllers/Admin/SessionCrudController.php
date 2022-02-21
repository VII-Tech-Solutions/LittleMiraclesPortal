<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Attributes;
use App\Constants\FieldTypes;
use App\Constants\SessionDetailsType;
use App\Constants\SessionStatus;
use App\Helpers;
use App\Http\Requests\SessionRequest;
use App\Models\Backdrop;
use App\Models\Media;
use App\Models\Package;
use App\Models\Session;
use App\Models\SessionDetail;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Exception;
use Illuminate\Http\RedirectResponse;
use Prologue\Alerts\Facades\Alert;

/**
 * Session CRUD Controller
 */
class SessionCrudController extends CustomCrudController
{

    use CreateOperation {store as traitStore;}
    use UpdateOperation {update as traitUpdate;}

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

        // Column: Title
        $this->addNameColumn("Title", 1, Attributes::TITLE);

        // Column: Total Price
        $this->addTotalPriceColumn("Total Price", 1, Attributes::TOTAL_PRICE);

        // Column: User ID
        $this->addIDColumn("User Name", 1, Attributes::USER_NAME);

        // Column: Package Name
        $this->addIDColumn("Package Name", 1, Attributes::PACKAGE_NAME);

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

        // Field: Backdrops
        $this->addSessionDetailField(Attributes::BACKDROPS, "Backdrops", "Backdrop", Backdrop::class);

        // Field: Backdrops
//        $this->addSessionDetailField(Attributes::CAKES, "Cakes", "Cake", Cake::class);

        // Field: People
//        $this->addSessionDetailField(Attributes::PEOPLE, "People", "People", User::class, Attributes::FULL_NAME);

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
        if($backdrops->isNotEmpty()){
            foreach ($backdrops as $item){

                $item_exists = SessionDetail::where(Attributes::SESSION_ID, $session->id)
                    ->where(Attributes::TYPE, SessionDetailsType::BACKDROP)
                    ->where(Attributes::VALUE, $item)->exists();

                if(!$item_exists){
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

        // update and return response
        $result = $this->traitUpdate();

        // media
        $update_media = $session->media()->whereNotIn(Attributes::ID, $media_ids)->delete();

        // clear cache
        Helpers::clearCache(Session::class);



        // return response
        return $result;
    }

}
