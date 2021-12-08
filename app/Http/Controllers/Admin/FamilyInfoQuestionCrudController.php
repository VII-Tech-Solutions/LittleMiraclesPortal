<?php


namespace App\Http\Controllers\Admin;

use App\Constants\Attributes;
use App\Constants\QuestionType;
use App\Constants\Status;
use App\Http\Requests\FamilyInfoQuestionRequest;
use App\Models\FamilyInfoQuestion;
use App\Models\FamilyInfoQuestionOption;
use CRUD;
use Exception;

/**
 * Family Information Questions CRUD Controller

 */
class FamilyInfoQuestionCrudController extends CustomCrudController
{

    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore; } //IMPORTANT HERE
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitUpdate; } //IMPORTANT HERE


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

        // Column: Order
        $this->addOrder();


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
        $this->addOptionsField();

        // Field: Order
        $this->addOrderField();

        // Field: Status
        $this->addStatusField(Status::all());

    }


    public function store()
    {
        $items = collect(json_decode(request('options'), true));

        // create the main item as usual
        $response = $this->traitStore();

        // instead of returning, take a little time to create the question options
        $question_id = $this->crud->entry->id;


        // add the post_id to the items collection
        $items->each(function($item, $key) use ($question_id) {
            $item[Attributes::QUESTION_ID] = $question_id;

           FamilyInfoQuestionOption::create($item);
        });

        return $response;
    }

    public function update()
    {
        $items = collect(json_decode(request('options'), true));

        $response = $this->traitUpdate();

        // instead of returning, take a little time to update the question's answers too
        $question_id = $this->crud->entry->id;
        $created_ids = [];

        $items->each(function($item, $key) use ($question_id, &$created_ids) {
            $item[Attributes::QUESTION_ID] = $question_id;

            if ($item['id']) {
                $option = FamilyInfoQuestionOption::find($item['id']);
                $option->update($item);
            } else {

                $created_ids[] = FamilyInfoQuestionOption::create($item)->id;

            }

        });

        // delete removed answers
        $related_items_in_request = collect(array_merge($items->where('id', '!=', '')->pluck('id')->toArray(), $created_ids));
        $related_items_in_db = $this->crud->getCurrentEntry()->answers;

        $related_items_in_db->each(function($item, $key) use ($related_items_in_request) {
            if (!$related_items_in_request->contains($item['id'])) {
                $item->delete();
            }
        });

        return $response;
    }

}
