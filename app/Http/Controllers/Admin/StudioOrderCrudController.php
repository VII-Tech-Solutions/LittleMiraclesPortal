<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Attributes;
use App\Constants\BookingType;
use App\Http\Requests\StudioOrderRequest;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;

/**
 * Class StudioOrderCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class StudioOrderCrudController extends CustomCrudController
{
    use ListOperation;
    use CreateOperation;
    use UpdateOperation;
    use DeleteOperation;
    use ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Order::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/studio-order');
        CRUD::setEntityNameStrings('studio order', 'studio orders');

        // show studio orders
        $this->crud->addClause("where", function($q) {
            return $q->where(Attributes::BOOKING_TYPE, BookingType::STUDIO);
        });

        // deny access
        $this->crud->denyAccess(["create", "update", "delete"]);

        // override show view
        $this->crud->setShowView("show.studio-order");

    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {


        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
        // Column: ID
        $this->addIDColumn("ID", 1, Attributes::ID);

        // Column: Total Price
        $this->addPriceColumn("Total Price", 1, Attributes::TOTAL_PRICE);

        // Column: Subtotal Price
        $this->addPriceColumn("Subtotal Price", 1, Attributes::SUBTOTAL);

        // Column: User name
        $this->addNameColumn("User Name", 1, Attributes::USER_NAME);

        // Column: Promo Code
        $this->addPromotionCodeColumn("Promo Code", 1, Attributes::PROMO_CODE);


    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(StudioOrderRequest::class);



        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
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
