<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Attributes;
use App\Constants\FieldTypes;
use App\Constants\IsPopular;
use App\Constants\Status;
use App\Constants\SessionPackageTypes;
use App\Http\Requests\SessionPackageRequest;
use App\Models\SessionPackage;
use Exception;

/**
 * Session Package CRUD Controller
 */
class SessionPackageCrudController extends CustomCrudController
{
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     * @throws Exception
     */
    public function setup()
    {
        $this->crud->setModel(SessionPackage::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/session-package');
        $this->crud->setEntityNameStrings('Session Package', 'Session Packages');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        //Attributes::SESSION_STATUS, added need filter

        // Filter: Status
        $this->addStatusFilter(Status::all());

        // Filter: Session Package Type Filter
        $this->addPackageTypeFilter(SessionPackageTypes::all(), Attributes::TYPE,"Package Type");

        // Filter: Is Popular Filter
        $this->addIsPopularFilter(IsPopular::all(), Attributes::IS_POPULAR,"Is Popular");

        // Column: Title
        $this->addIDColumn("ID",1,Attributes::ID);

        // Column: Title
        $this->addNameColumn("Title", 1, Attributes::TITLE);

        // Column: Tag
        $this->addTagColumn("Tag", 1, Attributes::TAG);

        // column: Image
        $this->addImageColumn("Image");

        // Column: Price
        $this->addPriceColumn("Price", 1, Attributes::PRICE);

        // Column: Is Popular
        $this->addIsPopularColumn("Is Popular", 1, Attributes::IS_POPULAR_NAME);

        // Column: Type
        $this->addTypeColumn(Attributes::TYPE_NAME , 1,Attributes::TYPE);

        // Column: content
        $this->addContentColumn();

        // Column: Location Text
        $this->addLocationTextColumn();

        // Column: Location Link
        $this->addLocationLinkColumn();

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

        // Field: IS_POPULAR
        $this->addIsPopularField(IsPopular::all(),Attributes::IS_POPULAR,"Is Popular");

        // Field: Type
        $this->addPackageTypeField(SessionPackageTypes::all(), Attributes::TYPE, "Type");

        // Field: Content
        $this->addContentField(Attributes::CONTENT, Attributes::CONTENT, null, FieldTypes::TEXTAREA, 5, 200);

        // Field: Location Text
        $this->addLocationTextField(Attributes::LOCATION_TEXT,"Location Text");

        // Field: Location link
        $this->addLocationField(Attributes::LOCATION_LINK, "Location Link");

        // Field: Status
        $this->addStatusField(Status::all());

    }
}
