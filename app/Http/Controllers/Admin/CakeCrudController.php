<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Attributes;
use App\Constants\Status;
use App\Http\Requests\CakeRequest;
use App\Models\Cake;
use App\Models\CakeCategory;
use Exception;

/**
 * Cake CRUD Controller
 */
class CakeCrudController extends CustomCrudController
{

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     * @throws Exception
     */
    public function setup()
    {
        $this->crud->setModel(Cake::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/cakes');
        $this->crud->setEntityNameStrings('Cake', 'Cakes');
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

        $this->addCustomCategoryFilter(Attributes::CATEGORY,"Category",CakeCategory::class,Attributes::CATEGORY_ID);
        // Column: Title
        $this->addNameColumn("Title", 1, Attributes::TITLE);

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
        $this->crud->setValidation(CakeRequest::class);

        // Field: Name
        $this->addNameField(Attributes::TITLE, "Title");

        // Field: Featured Image
        $this->addFeaturedImageField(Attributes::IMAGE, "Image", true);

        // Field: Status
        $this->addStatusField(Status::only([Status::ACTIVE, Status::DRAFT]));

    }
}
