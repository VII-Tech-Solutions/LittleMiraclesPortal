<?php


namespace App\Http\Controllers\Admin;

use App\Constants\Attributes;
use App\Constants\Status;
use App\Http\Requests\BackdropCategoryRequest;
use App\Http\Requests\CakeCategoryRequest;
use App\Http\Requests\PackageBenefitRequest;
use App\Models\BackdropCategory;
use App\Models\Benefit;
use App\Models\CakeCategory;
use App\Models\PackageBenefit;
use Exception;

/**
 * Package Benefit CRUD Controller

 */
class CakeCategoryCrudController extends CustomCrudController
{
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     * @throws Exception
     */
    public function setup()
    {
        $this->crud->setModel(CakeCategory::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/cake-categories');
        $this->crud->setEntityNameStrings('Cake Category', 'Cake Categories');
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

        // column: ID
        $this->addIDColumn("ID", 1, Attributes::ID);

        // column: Name
        $this->addNameColumn("Name",2, Attributes::NAME);


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
        $this->crud->setValidation(CakeCategoryRequest::class);

        // Field: Name
        $this->addNameField(Attributes::NAME,"Name");



        // Field: Status
        $this->addStatusField(Status::all());

    }
}
