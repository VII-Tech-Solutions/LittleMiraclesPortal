<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Attributes;
use App\Constants\FieldTypes;
use App\Constants\IsFeatured;
use App\Constants\SectionTypes;
use App\Constants\Status;
use App\Http\Requests\SectionRequest;
use App\Models\Section;
use Exception;

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

        // Filter: Is Featured Filter
        $this->addIsPopularFilter(IsFeatured::all(), Attributes::IS_FEATURED,"Is Featured");

        // Column: Title
        $this->addNameColumn("Title", 1, Attributes::TITLE);

        // Column: Content
        $this->addContentColumn();

        // Column: Image
        $this->addImageColumn("Image");

        // Column: Action Text
        $this->addNameColumn("Action Text", 1, Attributes::ACTION_TEXT);

        // Column: Go To
        $this->addNameColumn("Go To", 1, Attributes::GO_TO);

        // Column: Type
        $this->addSectionTypeColumn(Attributes::TYPE_NAME);

        // Column: Is Featured
        $this->addIsPopularColumn("Is Featured", 1, Attributes::IS_FEATURED_NAME);

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
        $this->crud->setValidation(SectionRequest::class);

        // Field: Title
        $this->addNameField(Attributes::TITLE);

        // Field: Description
        $this->addContentField(Attributes::CONTENT, Attributes::CONTENT, null, FieldTypes::TEXTAREA, 5, 200);

        // Field: Featured Image
        $this->addFeaturedImageField(Attributes::IMAGE, Attributes::IMAGE, true);

        // Field: Link
        $this->addNameField(Attributes::ACTION_TEXT, 'Action Text');

        // Field: Go To
        $this->addNameField(Attributes::GO_TO , 'Go To');

        // Field: Status
        $this->addStatusField(Status::all());

        // Field: Is Featured
        $this->addIsPopularField(IsFeatured::all(),Attributes::IS_FEATURED,"Is Featured");

        // Field: Section Type
        $this->addTypeField(SectionTypes::all());
    }
}
