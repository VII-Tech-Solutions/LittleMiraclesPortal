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
//        $this->crud->addField(
//            [  // Select
//                'label'     => "Select Package",
//                'type'      => 'select',
//                'name'      => 'package_id', // the db column for the foreign key
//
//                // optional
//                // 'entity' should point to the method that defines the relationship in your Model
//                // defining entity will make Backpack guess 'model' and 'attribute'
//                'entity'    => 'package',
//
//                // optional - manually specify the related model and attribute
//                'model'     => "App\Models\Package", // related model
//                'attribute' => 'title', // foreign key attribute that is shown to user
//            ]
//        );

        $this->addRelationshipField(null, Attributes::PACKAGE_ID, 'Select Package', null, null, FieldTypes::SELECT, 'package', "App\Models\Package" ,'title' );
        // Field: Status
        $this->addStatusField(GiftStatus::all());

    }
}
