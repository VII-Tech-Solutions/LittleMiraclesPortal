<?php


namespace App\Http\Controllers\Admin;

use App\Constants\Attributes;
use App\Constants\Status;
use App\Http\Requests\UserStudioSpecsRequest;
use App\Models\UserStudioSpecs;
use Exception;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * User Studio Specs CRUD Controller

 */
class UserStudioSpecsCrudController extends CustomCrudController
{
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     * @throws Exception
     */
    public function setup()
    {
        $this->crud->setModel(UserStudioSpecs::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/user-studio-specs');
        $this->crud->setEntityNameStrings('User Studio Specs', 'User Studios Specs');


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

        // column: User ID
        $this->addIDColumn("User ID", 1, Attributes::USER_ID);

        // Column: Family ID
        $this->addIDColumn("Family ID", 1, Attributes::FAMILY_ID);

        // Column: Studio Package ID
        $this->addIDColumn("Studio Package ID", 1, Attributes::STUDIO_PACKAGE_ID);

        // Column: Studio Specs ID
        $this->addIDColumn("Studio Specs ID", 1, Attributes::STUDIO_SPECS_ID);

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
        $this->crud->setValidation(UserStudioSpecsRequest::class);

        // Field: Status
        $this->addStatusField(Status::all());

    }

}
