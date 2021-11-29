<?php


namespace App\Http\Controllers\Admin;
use App\Constants\Attributes;
use App\Constants\Status;
use App\Http\Requests\DailyTipRequest;
use App\Models\DailyTip;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\Backdrop;
use App\Constants\FieldTypes;

class DailyTipCrudController extends CustomCrudController
{
//Attributes::IMAGE, Attributes::TITLE,Attributes::POSTED_AT, Attributes::CONTENT, Attributes::STATUS,
    public function setup()
    {
        CRUD::setModel(DailyTip::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/daily-tip');
        CRUD::setEntityNameStrings('Daily tip', 'Daily tips');
    }

    protected function setupListOperation()
    {
        // Filter: Status
        $this->addStatusFilter(Status::all());

        // Column: Title
        $this->addNameColumn("Title", 1, Attributes::TITLE);

        // column: Featured Image
        $this->addImageColumn("Featured Image");

        // Column: Posted At
        $this->addPostedAtColumn("Posated At", 3, Attributes::POSTED_AT);

        // Column: Content
        $this->addContentColumn();

        // Column: Status
        $this->addStatusColumn(Attributes::STATUS_NAME);

    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(DailyTipRequest::class);

        //Field: Name
        $this->addNameField(Attributes::TITLE, "Title");

        // Field: Featured Image
        $this->addFeaturedImageField(Attributes::IMAGE, "Image", true);

        //Field: Posted At
        $this->addPostedAtField(Attributes::POSTED_AT, "Posted At");

        // Field: Content
        $this->addContentField(Attributes::CONTENT, Attributes::CONTENT, null, FieldTypes::TEXTAREA, 5, 200);
        
        // Field: status
        $this->addStatusField(Status::all());


    }
}
