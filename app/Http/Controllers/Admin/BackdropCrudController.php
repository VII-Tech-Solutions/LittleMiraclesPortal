<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Attributes;
use App\Constants\Status;
use App\Http\Requests\BackdropRequest;
use App\Models\Backdrop;
use Exception;

/**
 * Backdrop CRUD Controller
 */
class BackdropCrudController extends CustomCrudController
{

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     * @throws Exception
     */
    public function setup()
    {
        $this->crud->setModel(Backdrop::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/backdrops');
        $this->crud->setEntityNameStrings('Backdrop', 'Backdrops');
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

        // Column: Name
        $this->addNameColumn("Title", 1, Attributes::TITLE);

        // Column: Category
        $this->addCakeCategoryColumn("Category", 1, Attributes::CATEGORY);

        // column: Image
        $this->addImageColumn("Image");

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
        $this->crud->setValidation(BackdropRequest::class);

        // Field: Name
        $this->addNameField(Attributes::TITLE, "Title");

        // Field: category
        $this->addTagCategoryField(Attributes::CATEGORY, "Category");

        // Field: Featured Image
        $this->addFeaturedImageField(Attributes::IMAGE, "Image", true);

        // Field: status
        $this->addStatusField(Status::all());

    }
}
