<?php

namespace App\Http\Controllers\Admin;

use App\Constants\AllowedOutdoor;
use App\Constants\AllowedSelection;
use App\Constants\Attributes;
use App\Constants\FieldTypes;
use App\Constants\Guideline;
use App\Constants\IsPopular;
use App\Constants\SessionPackageTypes;
use App\Constants\Status;
use App\Http\Requests\SessionPackageRequest;
use App\Models\Helpers;
use App\Models\Package;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Prologue\Alerts\Facades\Alert;

/**
 * Package CRUD Controller
 */
class PackageCrudController extends CustomCrudController
{

    use CreateOperation { store as traitStore; }
    use UpdateOperation { update as traitUpdate; }

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     * @throws Exception
     */
    public function setup()
    {
        $this->crud->setModel(Package::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/packages');
        $this->crud->setEntityNameStrings('Package', 'Packages');
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
        $this->addStatusFilter(Status::only([Status::ACTIVE, Status::DRAFT]));

        // Filter: Session Package Type Filter
        $this->addPackageTypeFilter(SessionPackageTypes::all(), Attributes::TYPE,"Package Type");

        // Filter: Is Popular Filter
        $this->addIsPopularFilter(IsPopular::all(), Attributes::IS_POPULAR,"Is Popular");

        // Filter: Five Sessions Gift
        $this->addIsPopularFilter(IsPopular::all(), Attributes::FIVE_SESSIONS_GIFT,"Five Sessions Gift");

        // Filter: Has Guideline Filter
        $this->addIsPopularFilter(Guideline::all(), Attributes::HAS_GUIDELINE,"Has Guideline");

        // Filter: Outdoor Allowed Filter
        $this->addIsPopularFilter(AllowedOutdoor::all(), Attributes::OUTDOOR_ALLOWED,"Outdoor Allowed");

        // Column: ID
        $this->addIDColumn("ID",1,Attributes::ID);

        // Column: Title
        $this->addNameColumn("Title", 1, Attributes::TITLE);

        // Column: Price
        $this->addPriceColumn("Price", 1, Attributes::PRICE);

        // Column: Type
        $this->addTypeColumn(Attributes::TYPE_NAME , 1,"Type");

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
        $this->crud->setValidation(SessionPackageRequest::class);

        // Field: Title
        $this->addNameField(Attributes::TITLE, "Title");

        // Field: Tag
        $this->addTagField(Attributes::TAG, Attributes::TAG, null, 100);

        // Field: Image
        $this->addFeaturedImageField(Attributes::IMAGE, "Image", true);

        // Field: Price
        $this->addPriceField(Attributes::PRICE, "Price");

        // Field: Is Popular
        $this->addIsPopularField(IsPopular::all(),Attributes::IS_POPULAR,"Is Popular");

        // Field: Type
        $this->addPackageTypeField(SessionPackageTypes::all(), Attributes::TYPE, "Type");

        // Field: Content
        $this->addContentField(Attributes::CONTENT, Attributes::CONTENT, null, FieldTypes::TEXTAREA, 5, 200);

        // Field: Sub Package
        $this->addSubPackagesField();

        // Field: Benefits
        $this->addBenefitsField();

        // Field: Minimum Backdrops
        $this->addDropdownField(AllowedSelection::all(),Attributes::MIN_BACKDROP, "Minimum Backdrops");

        // Field: Backdrops Allowed
        $this->addDropdownField(AllowedSelection::all(),Attributes::BACKDROP_ALLOWED, "Backdrops Allowed");

        // Field: Cakes Allowed
        $this->addDropdownField(AllowedSelection::all(),Attributes::CAKE_ALLOWED, "Cakes Allowed");

        // Field: Outdoor Allowed
        $this->addDropdownField(AllowedOutdoor::all(),Attributes::OUTDOOR_ALLOWED, "Outdoor Allowed");

        // Field: Has Guideline
        $this->addIsPopularField(Guideline::all(),Attributes::HAS_GUIDELINE, "Has Guideline");

        // Field: Five Sessions Gift
        $this->addDropdownField(AllowedOutdoor::all(),Attributes::FIVE_SESSIONS_GIFT, "Five Sessions Gift");

        // Field: Location Text
        $this->addLocationTextField(Attributes::LOCATION_TEXT,"Location Text");

        // Field: Location link
        $this->addLocationField(Attributes::LOCATION_LINK, "Location Link");

        // Field: Status
        $this->addStatusField(Status::only([Status::ACTIVE, Status::DRAFT]));


        // Field: Media
        $this->addMediaField("Media", "Media");


    }

    /**
     * Store
     * @return RedirectResponse
     */
    public function store()
    {

        // get media ids
        $media_ids = $this->crud->getRequest()->get(Attributes::MEDIA_IDS);
        // don't accept if less than 4
        if(!is_array($media_ids) || count($media_ids) < 4 ){
            Alert::error("You need to select at least 4 images! ")->flash();
            return back()->withInput();
        }
        $this->crud->getRequest()->request->remove(Attributes::MEDIA_IDS);

        // create and return response
        $result = $this->traitStore();

        // media
        $this->media($media_ids);

        // clear cache
        Helpers::clearCache(Package::class);

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
        // don't accept if less than 4
        if(!is_array($media_ids) || count($media_ids) < 4 ){
            Alert::error("You need to select at least 4 images! ")->flash();
            return back()->withInput();
        }
        $this->crud->getRequest()->request->remove(Attributes::MEDIA_IDS);

        // update and return response
        $result = $this->traitUpdate();

        // media
        $this->media($media_ids);

        // clear cache
        Helpers::clearCache(Package::class);
        // return response
        return $result;
    }

}
