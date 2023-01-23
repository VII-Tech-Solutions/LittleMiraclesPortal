<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Attributes;
use App\Constants\FieldTypes;
use App\Constants\Status;
use App\Http\Requests\DailyTipRequest;
use App\Models\DailyTip;
use Exception;

/**
 * Daily Tip CRUD Controller
 */
class DailyTipCrudController extends CustomCrudController
{

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * @return void
     * @throws Exception
     */
    public function setup()
    {
        $this->crud->setModel(DailyTip::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/daily-tips');
        $this->crud->setEntityNameStrings('Daily Tip', 'Daily Tips');
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

        // Column: Featured Image
        $this->addImageColumn("Featured Image");

        // Column: Posted At
        $this->addDateColumn("Posted At", 1, Attributes::POSTED_AT);

        // Column: Content
        $this->addContentColumn();

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
        $this->crud->setValidation(DailyTipRequest::class);

        // Field: Name
        $this->addNameField(Attributes::TITLE, "Title");

        // Field: Featured Image
        $this->addFeaturedImageField(Attributes::IMAGE, "Featured Image", true);

        // Field: Posted At
        $this->addDateField(Attributes::POSTED_AT, "Posted At");

        // Field: Content
        $this->addContentField(Attributes::CONTENT, Attributes::CONTENT, null, FieldTypes::CKEDITOR, 5, 200);

        // Field: Status
        $this->addStatusField(Status::only([Status::ACTIVE, Status::DRAFT]));

    }
}
