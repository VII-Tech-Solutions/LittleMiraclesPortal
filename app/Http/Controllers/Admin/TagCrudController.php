<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Attributes;
use App\Constants\Status;
use App\Http\Requests\TagRequest;
use App\Models\Tag;

class TagCrudController extends CustomCrudController
{
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     * @throws Exception
     */
    public function setup()
    {
        $this->crud->setModel(Tag::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/tags');
        $this->crud->setEntityNameStrings('Tag', 'Tags');
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

        // Column: Title
        $this->addNameColumn("Title", 1,Attributes::TITLE);

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
        $this->crud->setValidation(TagRequest::class);

        // Field: Name
        $this->addNameField(Attributes::TITLE, "Title");

        // Field: Status
        $this->addStatusField(Status::all());

    }
}
