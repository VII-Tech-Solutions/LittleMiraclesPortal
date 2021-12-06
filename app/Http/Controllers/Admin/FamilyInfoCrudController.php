<?php


namespace App\Http\Controllers\Admin;

use App\Constants\Attributes;
use App\Constants\Status;
use App\Http\Requests\FamilyInfoRequest;
use App\Models\FamilyInfo;
use Exception;

/**
 * Family Information CRUD Controller

 */
class FamilyInfoCrudController  extends CustomCrudController
{
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     * @throws Exception
     */
    public function setup()
    {
        $this->crud->setModel(FamilyInfo::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/family-info');
        $this->crud->setEntityNameStrings('Family Information', 'Family Informations');
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

        // column: ID
        $this->addIDColumn("ID", 1, Attributes::ID);

        // column: User ID
        $this->addIDColumn("User ID", 1, Attributes::USER_ID);

        // Column: Family ID
        $this->addIDColumn("Family ID", 1, Attributes::FAMILY_ID);

        // Column: Question ID
        $this->addIDColumn("Question ID", 1, Attributes::QUESTION_ID);

        // Column: Answer
        $this->addAnswerColumn("Answer",1, Attributes::ANSWER);

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
        $this->crud->setValidation(FamilyInfoRequest::class);

        // Field: Answer
        $this->addAnswerField(Attributes::ANSWER,"Answer");

        // Field: Status
        $this->addStatusField(Status::all());

    }
}
