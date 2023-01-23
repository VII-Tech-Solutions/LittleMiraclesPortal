<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Attributes;
use App\Constants\Status;
use App\Http\Requests\SocialMediaRequest;
use App\Models\SocialMedia;

class SocialMediaCrudController extends CustomCrudController
{
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     * @throws Exception
     */
    public function setup()
    {
        $this->crud->setModel(SocialMedia::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/social-media');
        $this->crud->setEntityNameStrings('Social Media', 'Social Media');
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

        // Column: Title
        $this->addNameColumn("Title", 1, Attributes::TITLE);

        // Column: Link
        $this->addNameColumn("Link", 1, Attributes::LINK);

        // Column: Image
        $this->addImageColumn("Image");

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
        $this->crud->setValidation(SocialMediaRequest::class);

        // Field: Title
        $this->addNameField(Attributes::TITLE);

        // Field: Link
        $this->addNameField(Attributes::LINK, Attributes::LINK);

        // Field: Featured Image
        $this->addFeaturedImageField(Attributes::IMAGE, Attributes::IMAGE, true);

        // Field: Status
        $this->addStatusField(Status::only([Status::ACTIVE, Status::DRAFT]));
    }
}
