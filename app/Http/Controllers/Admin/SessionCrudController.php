<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Attributes;
use App\Constants\FieldTypes;
use App\Constants\SessionStatus;
use App\Http\Requests\SessionRequest;
use App\Models\Session;
use Exception;

/**
 * Session CRUD Controller
 */
class SessionCrudController extends CustomCrudController
{
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     * @throws Exception
     */
    public function setup()
    {
        $this->crud->setModel(Session::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/sessions');
        $this->crud->setEntityNameStrings('Session', 'Sessions');
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
        $this->addStatusFilter(SessionStatus::all());

        // Column: Title
        $this->addNameColumn("Title", 1, Attributes::TITLE);

        // Column: Total Price
        $this->addTotalPriceColumn("Total Price", 1, Attributes::TOTAL_PRICE);

        // Column: User ID
        $this->addIDColumn("User Name", 1, Attributes::USER_NAME);

        // Column: Package Name
        $this->addIDColumn("Package Name", 1, Attributes::PACKAGE_NAME);

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
        $this->crud->setValidation(SessionRequest::class);

        // Field: Title
        $this->addNameField(Attributes::TITLE, "Title");

        // Field: Custom Backdrop
        $this->addCustomField(Attributes::CUSTOM_BACKDROP, "Custom Backdrops", null, FieldTypes::TEXTAREA, 5, 200);

        // Field: Custom Cake
        $this->addCustomField(Attributes::CUSTOM_CAKE, "Custom Cake", null, FieldTypes::TEXTAREA, 5, 200);

        // Field: Comments
        $this->addDescriptionField(Attributes::COMMENTS, "Comments", null, FieldTypes::TEXTAREA, 5, 200);

        // Field: Total Price
        $this->addPriceField(Attributes::TOTAL_PRICE, "Total Price");

        // Field: Status
        $this->addStatusField(SessionStatus::all(), Attributes::STATUS, "Status");
    }

}
