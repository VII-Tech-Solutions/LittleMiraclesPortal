<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Attributes;
use App\Constants\Status;
use App\Http\Requests\FeedbackRequest;
use App\Models\Feedback;
use Exception;

class FeedbackCrudController extends CustomCrudController
{
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     * @throws Exception
     */
    public function setup()
    {
        $this->crud->setModel(Feedback::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/feedback');
        $this->crud->setEntityNameStrings('Feedback', 'Feedbacks');

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

        // Filter: Status
        $this->addStatusFilter(Status::all());

        // Column: ID
        $this->addIDColumn("ID", 1, Attributes::ID);

        // Column: User Name
        $this->addUserNameColumn();

        // Column: Session Name
        $this->addIDColumn("Session Name", 1, Attributes::SESSION_NAME);

        // Column: Submitted At
        $this->addIDColumn("Submitted At", 1, Attributes::CREATED_AT);

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
        $this->crud->setValidation(FeedbackRequest::class);

        // Field: User Name
        $this->addNameField(Attributes::USER_NAME, "User Name", null, [], true);

        // Field: Session Name
        $this->addNameField(Attributes::SESSION_NAME, "Session Name", null, [], true);

        // Field: Answer
        $this->addAnswerField(Attributes::ANSWER,"Answer");

        // Field: Submitted At
        $this->addNameField(Attributes::CREATED_AT, "Submitted At", null, [], true);

    }
}
