<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Attributes;
use App\Constants\FieldTypes;
use App\Constants\PromotionType;
use App\Constants\Status;
use App\Http\Requests\PromotionRequest;
use App\Models\Promotion;
use Exception;

/**
 * Promotions CRUD Controller
 */
class PromotionCrudController extends CustomCrudController
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
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/promotions');
        $this->crud->setEntityNameStrings('Promotion', 'Promotions');

        $this->crud->addClause('where',function ($q){
            return $q->where(Attributes::USER_ID, null)->where(Attributes::TYPE, PromotionType::PUBLIC);
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

        // Column: Title
        $this->addNameColumn("Title", 1, Attributes::TITLE);

        // column: Image
        $this->addImageColumn("Image");

        // Column: Content
        $this->addContentColumn();

        // Column: Offer
        $this->addOfferColumn("Offer Percentage", 1, Attributes::OFFER);

        // Column: Type
        $this->addPromotionTypeColumn("Type", 1, Attributes::TYPE);

        // Column: Posted At
        $this->addPostedAtColumn("Posted At");

        // Column: Valid Until
        $this->addPostedAtColumn("Valid Until",1, Attributes::VALID_UNTIL);

        // Column: Promo Code
        $this->addPromotionCodeColumn("Promo Code", 1, Attributes::PROMO_CODE);

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
        $this->crud->setValidation(PromotionRequest::class);

        // Field: Name
        $this->addNameField(Attributes::TITLE, "Title");

        // Field: Image
        $this->addFeaturedImageField(Attributes::IMAGE, "Image", true);

        // Field: Content
        $this->addContentField(Attributes::CONTENT, Attributes::CONTENT, null, FieldTypes::CKEDITOR, 5, 200);

        // Field: Offer
        $this->addOfferField(Attributes::OFFER, "Discount Percentage (%)");

        // Field: Available From
        $this->addDateField(Attributes::AVAILABLE_FROM , "Start Date");

        // Field: Valid Until
        $this->addDateField(Attributes::VALID_UNTIL , "End Date");

        // Field: Type
        $this->addHiddenField(Attributes::TYPE, PromotionType::PUBLIC);

        // Field: Promo Code
        $this->addPromotionCodeField(Attributes::PROMO_CODE, "Promo Code");

        // Field: Status
        $this->addStatusField(Status::all());

    }
}
