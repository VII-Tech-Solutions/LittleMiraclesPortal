<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Attributes;
use App\Constants\FieldTypes;
use App\Constants\Status;
use App\Constants\StudioCategory;
use App\Http\Requests\StudioMetadataRequest;
use App\Models\StudioMetadata;

class StudioMetadataCrudController extends CustomCrudController
{
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     * @throws Exception
     */
    public function setup()
    {
        $this->crud->setModel(StudioMetadata::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/studio-metadata');
        $this->crud->setEntityNameStrings('Studio Metadata', 'Studio Metadata');
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

        // Filter: Category
        $this->addCategoryFilter(StudioCategory::all());

        // Column: Title
        $this->addNameColumn("Title", 1, Attributes::TITLE);

        // Column: Content
        $this->addContentColumn("Description",1, Attributes::DESCRIPTION);

        // Column: Image
        $this->addImageColumn("Image", 1, Attributes::IMAGE);

        // Column: Type
        $this->addStudioMetadataColumn(Attributes::CATEGORY_NAME);

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
        $this->crud->setValidation(StudioMetadataRequest::class);

        // Field: Title
        $this->addNameField(Attributes::TITLE);

        // Field: Description
        $this->addContentField(Attributes::DESCRIPTION, Attributes::DESCRIPTION, null, FieldTypes::TEXTAREA, 5, 200);

        // Field: Featured Image
        $this->addFeaturedImageField(Attributes::IMAGE, Attributes::IMAGE, true);

        // Field: Status
        $this->addStatusField(Status::all());

        // Field: Category
        $this->addCategoryField(StudioCategory::all());
    }
}