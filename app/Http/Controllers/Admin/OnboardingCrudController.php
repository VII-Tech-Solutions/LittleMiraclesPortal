<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Attributes;
use App\Constants\FieldTypes;
use App\Http\Controllers\Admin\CustomCrudController;
use App\Http\Requests\OnboardingRequest;
use App\Models\Onboarding;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class OnboardingCrudController extends CustomCrudController
{


    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(Onboarding::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/onboarding');
        CRUD::setEntityNameStrings('Onboarding', 'Onboardings');

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
        $this->addNameColumn("title", 1, "title");

        // Column: Content
        $this->addContentColumn();

        // Column: image
        $this->addImageColumn();

        // Column: order
        $this->addOrder();

    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
//        CRUD::setValidation(OnboardingRequest::class);

//         Field: Name
        $this->addNameField(Attributes::TITLE);

////
        // Field: Description
        $this->addContentField(Attributes::CONTENT, Attributes::CONTENT, null, FieldTypes::TEXTAREA, 5, 200, "Hint: Content of the last item will not be shown in the app");
//
        // Field: Featured Image
        $this->addFeaturedImageField(Attributes::IMAGE, Attributes::IMAGE, true);
//
        // Field: Order
        $this->addOrderField();
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
}
