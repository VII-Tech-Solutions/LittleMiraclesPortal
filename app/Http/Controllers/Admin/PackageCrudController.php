<?php

namespace App\Http\Controllers\Admin;

use App\Constants\AllowedOutdoor;
use App\Constants\AllowedSelection;
use App\Constants\Attributes;
use App\Constants\FieldTypes;
use App\Constants\Guidline;
use App\Constants\IsPopular;
use App\Constants\Status;
use App\Constants\SessionPackageTypes;
use App\Http\Requests\SessionPackageRequest;
use App\Models\Package;
use Exception;

/**
 * Package CRUD Controller
 */
class PackageCrudController extends CustomCrudController
{

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
        $this->addStatusFilter(Status::all());

        // Filter: Session Package Type Filter
        $this->addPackageTypeFilter(SessionPackageTypes::all(), Attributes::TYPE,"Package Type");

        // Filter: Is Popular Filter
        $this->addIsPopularFilter(IsPopular::all(), Attributes::IS_POPULAR,"Is Popular");

        // Filter: Outdoor Allowed Filter
        $this->addIsPopularFilter(AllowedOutdoor::all(), Attributes::OUTDOOR_ALLOWED,"Outdoor Allowed");

        // Column: ID
        $this->addIDColumn("ID",1,Attributes::ID);

        // Column: Title
        $this->addNameColumn("Title", 1, Attributes::TITLE);

        // Column: Price
        $this->addPriceColumn("Price", 1, Attributes::PRICE);

        // Column: Is Popular
        $this->addIsPopularColumn("Is Popular", 1, Attributes::IS_POPULAR_NAME);

        // Column: Outdoor Allowed
        $this->addIsPopularColumn("Outdoor Allowed", 1, Attributes::OUTDOOR_ALLOWED_NAME);

        // Column: Has Guideline
        $this->addIsPopularColumn("Has Guideline", 1, Attributes::HAS_GUIDELINE_NAME);

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

        // Field: Benefits
        $this->addBenefitsField();

        // Field: Backdrops Allowed
        $this->addIsPopularField(AllowedSelection::all(),Attributes::BACKDROP_ALLOWED, "Backdrops Allowed");

        // Field: Outdoor Allowed
        $this->addIsPopularField(AllowedOutdoor::all(),Attributes::OUTDOOR_ALLOWED, "Outdoor Allowed");

        // Field: Has Guideline
        $this->addIsPopularField(Guidline::all(),Attributes::HAS_GUIDELINE, "Has Guideline");

        // Field: Cakes Allowed
        $this->addNumberField(Attributes::CAKE_ALLOWED, "Cakes Allowed");

        // Field: Location Text
        $this->addLocationTextField(Attributes::LOCATION_TEXT,"Location Text");

        // Field: Location link
        $this->addLocationField(Attributes::LOCATION_LINK, "Location Link");

        // Field: Status
        $this->addStatusField(Status::all());

    }
}
