<?php


namespace App\Http\Controllers\Admin;

use App\Constants\Attributes;
use App\Constants\QuestionType;
use App\Constants\Status;
use App\Http\Requests\FamilyInfoQuestionRequest;
use App\Models\FamilyInfoQuestion;
use Exception;

/**
 * Family Information Questions CRUD Controller

 */
class FamilyInfoQuestionCrudController extends CustomCrudController
{
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     * @throws Exception
     */
    public function setup()
    {
        $this->crud->setModel(FamilyInfoQuestion::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/family-info-questions');
        $this->crud->setEntityNameStrings('Family Information Question', 'Family Information Questions');
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

        // Filter: Question Type
        $this->addQuestionTypeFilter(QuestionType::all());

        // column: ID
        $this->addIDColumn("ID", 1, Attributes::ID);

        // column: Question
        $this->addQuestionColumn("Question", 1, Attributes::QUESTION);

        // Column: Question Type
        $this->addQuestionTypeColumn("Type", 1, Attributes::QUESTION_TYPE_NAME);

        // column: Options
        $this->addOptionColumn( "Options" , 1 , Attributes::OPTIONS);

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
        $this->crud->setValidation(FamilyInfoQuestionRequest::class);

        // Field: Question
        $this->addQuestionField(Attributes::QUESTION,"Question");

        // Field: Question Type
        $this->addQuestionTypeField(QuestionType::all(),Attributes::QUESTION_TYPE,"Question Type");

        // Field: Options
        $this->addTextField(Attributes::OPTIONS,"Options");

        // Field: Status
        $this->addStatusField(Status::all());

    }

}
