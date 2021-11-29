<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Attributes;
use App\Constants\FieldTypes;
use App\Constants\Status;
use App\Http\Requests\OnboardingRequest;
use App\Models\Onboarding;
use Exception;

/**
 * Onboarding CRUD Controller
 */
class OnboardingCrudController extends CustomCrudController
{

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     * @throws Exception
     */
    public function setup()
    {
        $this->crud->setModel(Onboarding::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/onboardings');
        $this->crud->setEntityNameStrings('Onboarding', 'Onboardings');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        // Column: Name
        $this->addNameColumn("Title", 1, Attributes::TITLE);

        // Column: Content
        $this->addContentColumn();

        // Column: Image
        $this->addImageColumn();

        // Column: Order
        $this->addOrder();

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
        $this->crud->setValidation(OnboardingRequest::class);

        // Field: Name
        $this->addNameField(Attributes::TITLE);

        // Field: Description
        $this->addContentField(Attributes::CONTENT, Attributes::CONTENT, null, FieldTypes::TEXTAREA, 5, 200);

        // Field: Featured Image
        $this->addFeaturedImageField(Attributes::IMAGE, Attributes::IMAGE, true);

        // Field: Order
        $this->addOrderField();

        // Field: Status
        $this->addStatusField(Status::all());
    }
}
