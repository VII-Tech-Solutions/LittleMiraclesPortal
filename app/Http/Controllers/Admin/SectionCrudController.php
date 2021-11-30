<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Attributes;
use App\Constants\FieldTypes;
use App\Constants\SectionTypes;
use App\Constants\Status;
use App\Http\Requests\SectionRequest;
use App\Models\Section;

class SectionCrudController extends CustomCrudController
{
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     * @throws Exception
     */
    public function setup()
    {
        $this->crud->setModel(Section::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/sections');
        $this->crud->setEntityNameStrings('Section', 'Sections');
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

        // Filter: Status
        $this->addTypeFilter(SectionTypes::all());

        // Column: Image
        $this->addImageColumn("Image", 1, Attributes::IMAGE);

        // Column: Title
        $this->addNameColumn("Title", 1, Attributes::TITLE);

        // Column: Content
        $this->addContentColumn();

        // Column: Action Text
        $this->addNameColumn("Action_Text", 1, Attributes::ACTION_TEXT);

        // Column: Go To
        $this->addNameColumn("Go_To", 1, Attributes::GO_TO);

        // Column: Status
        $this->addStatusColumn(Attributes::STATUS_NAME);

        // Column: Type
        $this->addSectionTypeColumn(Attributes::TYPE_NAME);

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
        $this->crud->setValidation(SectionRequest::class);

        // Field: Featured Image
        $this->addFeaturedImageField(Attributes::IMAGE, Attributes::IMAGE, true);

        // Field: Title
        $this->addNameField(Attributes::TITLE);

        // Field: Description
        $this->addContentField(Attributes::CONTENT, Attributes::CONTENT, null, FieldTypes::TEXTAREA, 5, 200);

        // Field: Link
        $this->addNameField(Attributes::ACTION_TEXT, Attributes::ACTION_TEXT);

        // Field: Icon
        $this->addNameField(Attributes::GO_TO , Attributes::GO_TO);

        // Field: Status
        $this->addStatusField(Status::all());

        // Field: Status
        $this->addTypeField(SectionTypes::all());
    }
}
