<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Attributes;
use App\Constants\Status;
use App\Constants\StudioCategory;
use App\Http\Requests\StudioMetadataRequest;
use App\Models\Helpers;
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
        $this->addStatusFilter(Status::only([Status::ACTIVE, Status::DRAFT]));

        // Filter: Category
        $this->addCategoryFilter(StudioCategory::all());

        // Column: ID
        $this->addColumn( Attributes::ID, 'ID');

        // Column: Title
        $this->addNameColumn("Title", 1, Attributes::TITLE);

        // Column: Content
        $this->addColumn( Attributes::PRICE, 'Price');

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

        // Field: Price
        $this->addPriceField(Attributes::PRICE, 'Price');

        // Field: Image
        $this->addFeaturedImageField(Attributes::IMAGE, Attributes::IMAGE, true);

        // Field: Status
        $this->addStatusField(Status::only([Status::ACTIVE, Status::DRAFT]));

        // Field: Category
        $this->addCategoryField(StudioCategory::all());

        // Field: Thickness
        $this->addCategoryField(StudioMetadata::where(Attributes::CATEGORY, StudioCategory::CANVAS_THICKNESS)->pluck(Attributes::TITLE, Attributes::ID), Attributes::THICKNESS_ID, Helpers::readableText(Attributes::THICKNESS), null, true);

        // Field: Print Type
        $this->addCategoryField(StudioMetadata::where(Attributes::CATEGORY, StudioCategory::PRINT_TYPE)->pluck(Attributes::TITLE, Attributes::ID), Attributes::PRINT_TYPE_ID, Helpers::readableText(Attributes::PRINT_TYPE), null, true);

        // Field: Paper Type
        $this->addCategoryField(StudioMetadata::where(Attributes::CATEGORY, StudioCategory::PAPER_TYPE)->pluck(Attributes::TITLE, Attributes::ID), Attributes::PAPER_TYPE_ID, Helpers::readableText(Attributes::PAPER_TYPE), null, true);
    }
}
