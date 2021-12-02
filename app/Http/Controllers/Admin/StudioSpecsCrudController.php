<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Attributes;
use App\Constants\Status;
use App\Constants\StudioSpecsTypes;
use App\Http\Requests\StudioSpecsRequest;
use App\Models\StudioSpecs;

class StudioSpecsCrudController extends CustomCrudController
{
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     * @throws Exception
     */
    public function setup()
    {
        $this->crud->setModel(StudioSpecs::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/studio-specs');
        $this->crud->setEntityNameStrings('Studio Specs', 'Studio Specs');
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
        $this->addCategoryFilter(StudioSpecsTypes::all(),Attributes::TYPE ,"Studio Specs Type");

        // Column: Studio Print ID
        $this->addIDColumn("Studio Print ID",1,Attributes::ID);

        // Column: Studio Package ID
        $this->addIDColumn("Studio Package ID",1,Attributes::ID);

        // Column: Name
        $this->addNameColumn("Title",1 , Attributes::TITLE);

        // Column: Image
        $this->addImageColumn("Image");

        // Column: Type
        $this->addTypeColumn(Attributes::TYPE_NAME , 1,Attributes::TYPE);

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
        $this->crud->setValidation(StudioSpecsRequest::class);

        // Field: Name
        $this->addNameField(Attributes::TITLE, "Title");

        // Field: Featured Image
        $this->addFeaturedImageField(Attributes::IMAGE, Attributes::IMAGE, true);

        // Field: Type
        $this->addPackageTypeField(StudioSpecsTypes::all(), Attributes::TYPE, "Type");

        // Field: Status
        $this->addStatusField(Status::all());

    }
}
