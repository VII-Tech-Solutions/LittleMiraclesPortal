<?php


namespace App\Http\Controllers\Admin;

use App\Constants\Attributes;

use App\Constants\IsPopular;
use App\Constants\Status;
use App\Constants\StudioPrintCategory;
use App\Http\Requests\StudioPackageRequest;
use App\Models\StudioPackage;
use Exception;

/**
 * Studio Package CRUD Controller
 */
class StudioPackageCrudController extends CustomCrudController
{
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     * @throws Exception
     */
    public function setup()
    {
        $this->crud->setModel(StudioPackage::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/studio-packages');
        $this->crud->setEntityNameStrings('Studio Package', 'Studio Packages');
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

        // Filter: Studio Package Category Filter
        $this->addPackageTypeFilter(StudioPrintCategory::all(), Attributes::CATEGORY,"Print Category");

        // Column: ID
        $this->addIDColumn("ID",1,Attributes::ID);

        // Column: Title
        $this->addNameColumn("Title", 1, Attributes::TITLE);

        // column: Image
        $this->addImageColumn("Image");

        // column: Starting Price
        $this->addPriceColumn("Starting Price",1, Attributes::STARTING_PRICE);

        // column: Details
        $this->addDetailsColumn("Details",1, Attributes::DETAILS);

        // column: Examples
        $this->addExampleColumn("Examples",1, Attributes::EXAMPLE);

        // Column: Category
        $this->addCategoryColumn("Category", 1, Attributes::CATEGORY);

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
//            Attributes::TITLE => 'required',
//            Attributes::IMAGE => 'required',
//            Attributes::STARTING_PRICE => 'required',
//            Attributes::DETAILS => 'required',
//            Attributes::EXAMPLE => 'required',
//            Attributes::CATEGORY => 'required',
        // Validation
        $this->crud->setValidation( StudioPackageRequest::class);

        // Field: Title
        $this->addNameField(Attributes::TITLE, "Title");

        // Field: Image
        $this->addFeaturedImageField(Attributes::IMAGE, "Image", true);

        // Field: Starting Price
        $this->addPriceField(Attributes::STARTING_PRICE, "Starting Price");

        // Field: Details
        $this->addDetailsField(Attributes::DETAILS, "Details");

        // Field: Example
        $this->addExampleField(Attributes::EXAMPLE, "Example");

        // Field: Category
        $this->addTypeField(StudioPrintCategory::all(),Attributes::CATEGORY,"Category");

        // Field: Status
        $this->addStatusField(Status::all());

    }
}
