<?php

namespace App\Http\Controllers\Admin;

use App\Constants\AllowedOutdoor;
use App\Constants\AllowedSelection;
use App\Constants\Attributes;
use App\Constants\FieldTypes;
use App\Constants\Guideline;
use App\Constants\IsPopular;
use App\Constants\Status;
use App\Constants\SessionPackageTypes;
use App\Http\Requests\SessionPackageRequest;
use App\Http\Requests\SubPackageRequest;
use App\Models\Package;
use App\Models\SubPackage;
use Exception;

/**
 * SubPackageCrudController CRUD Controller
 */
class SubPackageCrudController extends CustomCrudController
{

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     * @throws Exception
     */
    public function setup()
    {
        $this->crud->setModel(SubPackage::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/sub-packages');
        $this->crud->setEntityNameStrings('Sub Package', 'Sub Packages');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {



        // Column: ID
        $this->addIDColumn("ID",1,Attributes::ID);

        // Column: Title
        $this->addNameColumn("Title", 1, Attributes::TITLE);


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
        $this->crud->setValidation(SubPackageRequest::class);

        // Field: Title
        $this->addNameField(Attributes::TITLE, "Title");

        // Field: Description
        $this->addNameField(Attributes::DESCRIPTION, "Description");

        // Field: Backdrops Allowed
        $this->addDropdownField(AllowedSelection::all(),Attributes::BACKDROP_ALLOWED, "Backdrops Allowed");

        // Field: Cakes Allowed
        $this->addDropdownField(AllowedSelection::all(),Attributes::CAKE_ALLOWED, "Cakes Allowed");


    }
}
