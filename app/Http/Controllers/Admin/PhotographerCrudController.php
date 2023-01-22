<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Attributes;
use App\Constants\Roles;
use App\Constants\Status;
use App\Http\Requests\PhotographerRequest;
use App\Models\Photographer;
use Exception;
use App\Models\Helpers;

/**
 * Photographers CRUD Controller
 */
class PhotographerCrudController extends CustomCrudController
{

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
        $this->crud->setEntityNameStrings('Photographer', 'Photographers');
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
        $this->crud->setValidation(PhotographerRequest::class);

        // Field: Name
        $this->addNameField(Attributes::NAME, "Name");

        // Field: Email
        $this->addEmailField(Attributes::EMAIL, "Email");

        // Field: Role
        $this->addDropdownField(Roles::all(), Attributes::ROLE, "Role");

        // Field: Featured Image
        $this->addFeaturedImageField(Attributes::IMAGE, Attributes::IMAGE, true);

        // Field: Additional Charge
        $this->addNumberField(Attributes::ADDITIONAL_CHARGE, Helpers::readableText(Attributes::ADDITIONAL_CHARGE));

        // Field: Status
        $this->addStatusField(Status::all());

    }
}
