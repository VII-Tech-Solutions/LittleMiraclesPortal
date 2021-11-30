<?php


namespace App\Http\Controllers\Admin;

use App\Constants\Attributes;
use App\Constants\FieldTypes;
use App\Constants\Status;
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
        //Attributes::SESSION_STATUS, added need filter and get function

        // Filter: Status
        $this->addStatusFilter(Status::all());

        // Filter: Session Status
        $this->addStatusFilter(SessionStatus::all(), Attributes::SESSION_STATUS,"Session Status");

        // Column: Title
        $this->addNameColumn("Title", 1, Attributes::TITLE);

        // Column: Custom Backdrop
        $this->addCustomBackdropColumn();

        // Column: Custom Cake
        $this->addCustomCakeColumn();

        // Column: Comments
        $this->addCommentsColumn();

        // Column: Total Price
        $this->addTotalPriceColumn("Total Price", 1, Attributes::TOTAL_PRICE);

        // Column: User ID
        $this->addIDColumn("User ID", 1, Attributes::USER_ID);

        // Column: Package ID
        $this->addIDColumn("Package ID", 1, Attributes::PACKAGE_ID);

        // Column: Family ID
        $this->addIDColumn("Family ID", 1, Attributes::FAMILY_ID);

        // Column: Session Status
        $this->addSessionStatusColumn(Attributes::SESSION_STATUS_NAME);

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

        // Field: Session Status
        $this->addStatusField(SessionStatus::all(), Attributes::SESSION_STATUS, "Session Status");

        // Field: Title
        $this->addNameField(Attributes::TITLE, "Title");

        // Field: Custom Backdrop
        $this->addCustomField(Attributes::CUSTOM_BACKDROP, Attributes::CUSTOM_BACKDROP, null, FieldTypes::TEXTAREA, 5, 200);

        // Field: Custom Cake
        $this->addCustomField(Attributes::CUSTOM_CAKE, Attributes::CUSTOM_CAKE, null, FieldTypes::TEXTAREA, 5, 200);

        // Field: Comments
        $this->addDescriptionField(Attributes::COMMENTS, Attributes::COMMENTS, null, FieldTypes::TEXTAREA, 5, 200);

        // Field: Total Price
        $this->addPriceField(Attributes::TOTAL_PRICE, "Total Price");

        // Field: Status
        $this->addStatusField(Status::all());

    }

}
