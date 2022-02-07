<?php

namespace App\Http\Controllers\Admin;

use Alert;
use App\Constants\Attributes;
use App\Constants\FieldTypes;
use App\Constants\GiftStatus;
use App\Constants\GiftValidityDays;
use App\Constants\PromotionStatus;
use App\Constants\PromotionType;
use App\Constants\Status;
use App\Http\Requests\GiftRequest;
use App\Http\Requests\PromotionRequest;
use App\Models\Package;
use App\Models\Promotion;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Redirect;
use VIITech\Helpers\GlobalHelpers;

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
        $this->addStatusFilter(PromotionStatus::all());

        // Column: Package
        $this->addColumn(Attributes::PACKAGE, 'Package Name');

        // Column: Available From
        $this->addDateColumn("Start Date",1, Attributes::AVAILABLE_FROM);

        // Column: Valid Until
        $this->addDateColumn("End Date",2, Attributes::VALID_UNTIL);

        // Column: Package
        $this->addColumn(Attributes::DAYS_OF_VALIDITY_TEXT, 'Days of validity');

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
        $this->addDateField(Attributes::AVAILABLE_FROM , "Start Date");

        // Field: Valid Until
        $this->addDateField(Attributes::VALID_UNTIL , "End Date");

        // Field: Days of validity
        $this->addRelationshipField( GiftValidityDays::all(),
            Attributes::DAYS_OF_VALIDITY, 'Days of validity'
        );

        // Field: Type
        $this->addHiddenField(Attributes::TYPE, PromotionType::GIFT);

        // Field: Status
        $this->addStatusField(GiftStatus::all());

    }


    /**
     * Activate
     * @param $id
     * @return RedirectResponse
     * @throws Exception
     */
    public function activate($id) {

        $activate =  Promotion::where(Attributes::USER_ID, null)->where(Attributes::TYPE, PromotionType::GIFT)->where(Attributes::ID, $id)->first();

        if(is_null($activate)){
            $response = 'Gift not found';
            Alert::error($response)->flash();

        }else{
            $activate->status = PromotionStatus::ACTIVE;

            if($activate->save()){
                $response = 'Gift updated successfully';
                Alert::success($response)->flash();
                $deActivate_all = Promotion::where(Attributes::USER_ID, null)->where(Attributes::TYPE, PromotionType::GIFT)
                    ->where(Attributes::STATUS,PromotionStatus::ACTIVE)->where(Attributes::ID,'!=', $id)->update([Attributes::STATUS => PromotionStatus::INACTIVE]);
            }
        }

        return Redirect::back();
    }


    /**
     * De Activate
     * @param $id
     * @return RedirectResponse
     * @throws Exception
     */
    public function deActivate($id) {

        $de_activate =  Promotion::where(Attributes::USER_ID, null)->where(Attributes::TYPE, PromotionType::GIFT)->where(Attributes::ID, $id)->first();

        if(is_null($de_activate)){
            $response = 'Gift not found';
            Alert::error($response)->flash();

        }else{
            // check first if there is at least one active
            $active_gifts =  Promotion::where(Attributes::USER_ID, null)->where(Attributes::TYPE, PromotionType::GIFT)->where(Attributes::ID,'!=', $id)->where(Attributes::STATUS, PromotionStatus::ACTIVE)->count();
            if($active_gifts == 0){
                $response = 'One gift must be at least activated';
                Alert::error($response)->flash();
            }else{
                $de_activate->status = PromotionStatus::INACTIVE;
                if($de_activate->save()){
                    $response = 'Gift updated successfully';
                    Alert::success($response)->flash();
                }
            }

        }

        return Redirect::back();
    }
}
