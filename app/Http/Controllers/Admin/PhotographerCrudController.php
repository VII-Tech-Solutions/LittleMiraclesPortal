<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Attributes;
use App\Constants\Roles;
use App\Constants\Status;
use App\Http\Requests\PhotographerRequest;
use App\Models\Photographer;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Exception;
use App\Models\Helpers;
use App\Http\Requests\PhotographerRequest as StoreRequest;
use App\Http\Requests\PhotographerUpdateRequest as UpdateRequest;

/**
 * Photographers CRUD Controller
 */
class PhotographerCrudController extends CustomCrudController
{

    use CreateOperation {
        store as traitStore;
    }

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     * @throws Exception
     */
    public function setup()
    {
        $this->crud->setModel(Photographer::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/photographers');
        $this->crud->setEntityNameStrings('Admin & Photographers', 'Admin & Photographers');
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
        $this->addNameColumn("Name");

        // Column: Email
        $this->addEmailColumn("Email");

        // Column: Image
        $this->addImageColumn("Image");

        // Column: Role
        $this->addNameColumn("Role", 1, Attributes::ROLE_NAME);

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

        $this->crud->setValidation(UpdateRequest::class);
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
        $this->crud->setValidation(StoreRequest::class);

        // Field: Name
        $this->addNameField(Attributes::NAME, "Name");

        // Field: Email
        $this->addEmailField(Attributes::EMAIL, "Email");

        // Field: Password
        $this->addPasswordField();

        // Field: Role
        $this->addDropdownField(Roles::all(), Attributes::ROLE, "Role");

        // Field: Featured Image
        $this->addFeaturedImageField(Attributes::IMAGE, Attributes::IMAGE, true);

        // Field: Priority
        $this->addNumberField(Attributes::PRIORITY, Helpers::readableText(Attributes::PRIORITY));

        // Field: Status
        $this->addStatusField(Status::all());
    }
}
