<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Attributes;
use App\Constants\PaymentMethods;
use App\Constants\PaymentStatus;
use App\Http\Requests\TransactionRequest;
use App\Models\Order;
use App\Models\Session;
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

        // override show view
        $this->crud->setShowView("show.transaction");
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

        // Column: User Name
        $this->addColumn(Attributes::USER_NAME, 'User Name');

        // Column: Session ID
        $this->addColumn(Attributes::SESSION_ID, 'Session ID');

        // Column: Amount
        $this->addNameColumn("Amount", 1, Attributes::AMOUNT);

        // Column: Payment Method
        $this->addColumn(Attributes::GATEWAY,  Helpers::readableText(Attributes::GATEWAY));

        // Column: Date
        $this->addColumn(Attributes::CREATED_AT,  Helpers::readableText(Attributes::DATE));

        // Column: Status
        $this->addStatusColumn(Attributes::STATUS_NAME);

        // Filter: Status
        $this->addStatusFilter(PaymentStatus::all());

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

        // Field: ID
        $this->addNumberField(Attributes::ID, Helpers::readableText(Attributes::TRANSACTION_ID), null, [], true);

        // Field: Amount
        $this->addNumberField(Attributes::AMOUNT, Helpers::readableText(Attributes::AMOUNT));

        // Field: Order ID
        $this->addNumberField(Attributes::ORDER_ID, Helpers::readableText(Attributes::ORDER_ID));

        // Field: gateway
        $this->addNameField(Attributes::GATEWAY, Helpers::readableText(Attributes::GATEWAY));

        // Field: payment method
        $this->addDropdownField(PaymentMethods::all(), Attributes::PAYMENT_METHOD, Helpers::readableText(Attributes::PAYMENT_METHOD));

        // Field: success indicator
        $this->addNameField(Attributes::SUCCESS_INDICATOR, Helpers::readableText(Attributes::SUCCESS_INDICATOR));

        // Field: description
        $this->addNameField(Attributes::DESCRIPTION, Helpers::readableText(Attributes::DESCRIPTION));

        // Field: error message
        $this->addNameField(Attributes::ERROR_MESSAGE, Helpers::readableText(Attributes::ERROR_MESSAGE));

        // Field: session version
        $this->addNameField(Attributes::SESSION_VERSION, Helpers::readableText(Attributes::SESSION_VERSION));

        // Field: payment id
        $this->addNameField(Attributes::PAYMENT_ID, Helpers::readableText(Attributes::PAYMENT_ID));

        // Field: session
        $this->addNameField(Attributes::SESSION_NAME, Helpers::readableText(Attributes::SESSION_NAME));

        // Field: status
        $this->addDropdownField(PaymentStatus::all(), Attributes::STATUS, Helpers::readableText(Attributes::STATUS));

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
