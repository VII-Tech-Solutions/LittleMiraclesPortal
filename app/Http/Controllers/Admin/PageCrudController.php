<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Attributes;
use App\Constants\FieldTypes;
use App\Constants\Status;
use App\Http\Requests\PageRequest;
use App\Models\Page;

class PageCrudController extends CustomCrudController
{
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     * @throws Exception
     */
    public function setup()
    {
        $this->crud->setModel(Page::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/pages');
        $this->crud->setEntityNameStrings('Page', 'Pages');
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
        $this->addNameColumn("Title", 1, Attributes::TITLE);

        // Column: Content
        $this->addContentColumn();

        // Column: Slug
        $this->addNameColumn("Slug",2,Attributes::SLUG);

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
        $this->crud->setValidation(PageRequest::class);

        // Field: Title
        $this->addNameField(Attributes::TITLE);

        // Field: Content
        $this->addContentField(Attributes::CONTENT, Attributes::CONTENT, null, FieldTypes::CKEDITOR, 5, 200);

        // Field: Slug
        $this->addNameField(Attributes::SLUG,'Slug',null,Attributes::LTR,[],true);

        // Field: Status
        $this->addStatusField(Status::all());

    }
}
