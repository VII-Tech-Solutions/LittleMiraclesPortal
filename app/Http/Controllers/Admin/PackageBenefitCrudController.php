<?php


namespace App\Http\Controllers\Admin;

use App\Constants\Attributes;
use App\Constants\Status;
use App\Http\Requests\PackageBenefitRequest;
use App\Models\PackageBenefit;
use Exception;

/**
 * Package Benefit CRUD Controller

 */
class PackageBenefitCrudController extends CustomCrudController
{
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     * @throws Exception
     */
    public function setup()
    {
        $this->crud->setModel(PackageBenefit::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/package-benefits');
        $this->crud->setEntityNameStrings('Package Benefit', 'Package Benefits');
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

        // column: Icon
        $this->addIconColumn("Icon",1,Attributes::ICON);

        // column: Title
        $this->addNameColumn("Title",1, Attributes::TITLE);

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
        $this->crud->setValidation(PackageBenefitRequest::class);

        // Field: Title
        $this->addNameField(Attributes::TITLE,"Title");
        $this->addIconField(Attributes::ICON,"Icon");



        // Field: Status
        $this->addStatusField(Status::all());

    }
}
