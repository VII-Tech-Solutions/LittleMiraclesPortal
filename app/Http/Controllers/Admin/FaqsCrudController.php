<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Attributes;
use App\Constants\FieldTypes;
use App\Constants\Status;
use App\Http\Requests\FaqRequest;
use App\Http\Requests\OnboardingRequest;
use App\Models\Faq;
use App\Models\Onboarding;
use Exception;

class FaqsCrudController extends CustomCrudController
{
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     * @throws Exception
     */
    public function setup()
    {
        $this->crud->setModel(Faq::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/faqs');
        $this->crud->setEntityNameStrings('Faq', 'Faqs');
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

        // Column: Name
        $this->addQuestionColumn("Question", 1, Attributes::QUESTION);

        // Column: Content
        $this->addAnswerColumn();

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
        $this->crud->setValidation(FaqRequest::class);

        // Field: Name
        $this->addQuestionField(Attributes::QUESTION);

        // Field: Description
        $this->addAnswerField(Attributes::ANSWER, Attributes::ANSWER, null, FieldTypes::TEXTAREA, 5, 200);

        // Field: Status
        $this->addStatusField(Status::all());
    }
}
