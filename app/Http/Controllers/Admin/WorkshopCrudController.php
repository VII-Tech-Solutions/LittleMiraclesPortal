<?php


namespace App\Http\Controllers\Admin;

use App\Constants\Attributes;
use App\Constants\FieldTypes;
use App\Constants\Status;
use App\Http\Requests\WorkshopRequest;
use App\Models\Workshop;
use Exception;

/**
 * Workshop CRUD Controller
 */
class WorkshopCrudController extends CustomCrudController
{
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     * @throws Exception
     */
    public function setup()
    {
        $this->crud->setModel(Workshop::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/workshops');
        $this->crud->setEntityNameStrings('Workshop', 'Workshops');
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

        // Column: Title
        $this->addNameColumn("Title", 1, Attributes::TITLE);

        // column: Image
        $this->addImageColumn("Image");

        // Column: Content
        $this->addContentColumn();

        // Column: Price
        $this->addPriceColumn("Price", 1, Attributes::PRICE);

        // Column: Date
        $this->addPostedAtColumn( Attributes::POSTED_AT);

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
        $this->crud->setValidation(WorkshopRequest::class);

        // Field: Title
        $this->addNameField(Attributes::TITLE, "Title");

        // Field: Image
        $this->addFeaturedImageField(Attributes::IMAGE, "Image", true);

        // Field: Content
        $this->addContentField(Attributes::CONTENT, Attributes::CONTENT, null, FieldTypes::CKEDITOR, 5, 200);

        // Field: Date
        $this->addPostedAtField(Attributes::POSTED_AT);

        // Field: Price
        $this->addPriceField(Attributes::PRICE, "Price");

        // Field: Status
        $this->addStatusField(Status::all());

    }
}
