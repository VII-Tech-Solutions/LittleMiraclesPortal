<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Attributes;
use App\Http\Requests\TransactionRequest;
use App\Models\Transaction;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\Helpers;

/**
 * Class TransactionCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class TransactionCrudController extends CustomCrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(Transaction::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/transaction');
        CRUD::setEntityNameStrings('Transaction', 'Transactions');

        // deny access
        $this->crud->denyAccess(["create"]);


    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        // Column: ID
        $this->addColumn(Attributes::ID, 'ID');

        // Column: Order ID
        $this->addColumn(Attributes::ORDER_ID, 'Order ID');

        // Column: Amount
        $this->addNameColumn("Amount", 1, Attributes::AMOUNT);

        // Column: Payment Method
        $this->addColumn(Attributes::PAYMENT_METHOD_NAME,  Helpers::readableText(Attributes::PAYMENT_METHOD));

        // Column: Status
        $this->addStatusColumn(Attributes::STATUS_NAME);

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(TransactionRequest::class);

        CRUD::field('transaction_id');
        CRUD::field('amount');
        CRUD::field('order_id');
        CRUD::field('currency');
        CRUD::field('gateway');
        CRUD::field('payment_method');
        CRUD::field('success_indicator');
        CRUD::field('success_url');
        CRUD::field('error_url');
        CRUD::field('description');
        CRUD::field('error_message');
        CRUD::field('session_version');
        CRUD::field('uid');
        CRUD::field('payment_id');
        CRUD::field('status');

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
