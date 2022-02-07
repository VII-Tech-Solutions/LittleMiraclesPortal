<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Attributes;
use App\Constants\FieldTypes;
use App\Constants\GiftStatus;
use App\Constants\PromotionType;
use App\Constants\Status;
use App\Http\Requests\GiftRequest;
use App\Http\Requests\PromotionRequest;
use App\Models\Package;
use App\Models\Promotion;
use Exception;

/**
 * Promotions CRUD Controller
 */
class GiftCrudController extends CustomCrudController
{
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     * @throws Exception
     */
    public function setup()
    {
        $this->crud->setModel(Promotion::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/gifts');
        $this->crud->setEntityNameStrings('Gift', 'Gifts');

        $this->crud->addClause('where',function ($q){
           return $q->where(Attributes::USER_ID, null)->where(Attributes::TYPE, PromotionType::GIFT);
        });

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

        // Column: Package
        $this->addColumn(Attributes::PACKAGE, 'Package Name');

        // Column: Available From
        $this->addDateColumn("Available From",1, Attributes::AVAILABLE_FROM);


        // Column: Valid Until
        $this->addDateColumn("Valid Until",2, Attributes::VALID_UNTIL);


        // Column: Status
        $this->addStatusColumn(Attributes::STATUS_NAME);

        // Button: Ban
        $this->crud->addButtonFromModelFunction('line', 'activation', 'giftActivation', 'beginning');

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
        $this->crud->setValidation(GiftRequest::class);

        // Field: Select Package
        $this->addRelationshipField(null, Attributes::PACKAGE_ID, 'Select Package', null, null, FieldTypes::SELECT, 'package', "App\Models\Package" ,Attributes::TITLE );

        // Field: Image
        $this->addFeaturedImageField(Attributes::IMAGE, "Image", true);

        // Field: Available From
        $this->addDateField(Attributes::AVAILABLE_FROM , "Available From");

        // Field: Valid Until
        $this->addDateField(Attributes::VALID_UNTIL , "Valid Until");

        // Field: Type
        $this->addHiddenField(Attributes::TYPE, PromotionType::GIFT);

        // Field: Status
        $this->addStatusField(GiftStatus::all());

    }
}
