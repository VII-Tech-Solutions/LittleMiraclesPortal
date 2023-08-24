<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Attributes;
use App\Constants\FieldTypes;
use App\Constants\NotificationTypes;
use App\Constants\Status;
use App\Constants\Values;
use App\Helpers\FirebaseHelper;
use App\Http\Requests\NotificationRequest;
use App\Models\Notification;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Exception;
use Illuminate\Http\RedirectResponse;
use Backpack\CRUD\app\Http\Controllers\Operations\Response;
use Kreait\Firebase\Messaging\CloudMessage;

/**
 * Class NotificationCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class NotificationCrudController extends CustomCrudController
{

    use CreateOperation {
        store as traitStore;
    }
    use UpdateOperation {
        update as traitUpdate;
    }

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     * @throws Exception
     */
    public function setup()
    {
        $this->crud->setModel(Notification::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/notifications');
        $this->crud->setEntityNameStrings('Notification', 'Notifications');
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
        $this->addStatusFilter();

        // Filter: Type
        $this->addStatusFilter(NotificationTypes::all(), Attributes::TYPE, 'Type');

        // Column: Title
        $this->addNameColumn("Title", 1, Attributes::TITLE);

        // Column: Message
        $this->addNameColumn("Message", 1, Attributes::MESSAGE);

        // Column: Type
        $this->addNameColumn("Type", 2, Attributes::TYPE_NAME);

        // deny access
        $this->crud->denyAccess(["delete"]);

        // Column: Status
        $this->addStatusColumn();
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
        $this->crud->setValidation(NotificationRequest::class);

        // Field: Name
        $this->addNameField(Attributes::TITLE, "Title", null, 200);

        // Field: Message
        $this->addDescriptionField(Attributes::MESSAGE, "Message", null, FieldTypes::TEXTAREA, 5, 1024);

        // Field: Item Type
        $this->addStatusField(NotificationTypes::all(), Attributes::ITEM_TYPE, "Item Type", null, false);

        // Field: Status
        $this->addStatusField();
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
     * Store
     * @return RedirectResponse
     */
    public function store()
    {

        // create and return response
        $result = $this->traitStore();

        // Send FCM
        $status = $this->crud->getRequest()->get(Attributes::STATUS);
        if ($status == Status::ACTIVE) {
            $response = FirebaseHelper::sendFCMByTopic(Values::FCM_DEFAULT_TOPIC, null, null, request());
            // TODO send FCM
//            Helpers::sendFCM($this->crud->getRequest()->all());
        }

        // return $response
        return $result;
    }

    /**
     * Update
     * @return Response|RedirectResponse
     */
    public function update()
    {

        // update and return response
        $result = $this->traitUpdate();

        // Send FCM
        $status = $this->crud->getRequest()->get(Attributes::STATUS);
        if ($status == Status::ACTIVE) {
            $response = FirebaseHelper::sendFCMByTopic(Values::FCM_DEFAULT_TOPIC, null, null, request());
            // TODO send FCM
//            Helpers::sendFCM($this->crud->getRequest()->all());
        }

        // return response
        return $result;
    }
}
