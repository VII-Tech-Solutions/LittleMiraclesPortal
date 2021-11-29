<?php


namespace App\Http\Controllers\Admin;
use App\Constants\Attributes;
use App\Constants\Status;
use App\Http\Requests\BackdropRequest;
use App\Helpers;
use App\Models\Backdrop;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Exception;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

class BackdropCrudController extends CustomCrudController
{
    public function setup()
    {
        CRUD::setModel(Backdrop::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/backdrop');
        CRUD::setEntityNameStrings('Backdrop', 'Backdrops');
    }

    protected function setupListOperation()
    {

        // Filter: Status
        $this->addStatusFilter(Status::all());

        // Column: Name
        $this->addNameColumn("Title", 1, Attributes::TITLE);

        // Column: Category
        $this->addCakeCategoryColumn("Category", 1, Attributes::CATEGORY);

        // column: Image
        $this->addImageColumn("Image");

        // Column: Status
        $this->addStatusColumn(Attributes::STATUS_NAME);

    }


    protected function setupCreateOperation()
    {
        CRUD::setValidation(BackdropRequest::class);

        //Field: Name
        $this->addNameField(Attributes::TITLE, "Title");

        //Field: category
        $this->addTagCategoryField(Attributes::CATEGORY, "Category");
        // Field: Featured Image
        $this->addFeaturedImageField(Attributes::IMAGE, "Image", true);

        // Field: status
        $this->addStatusField(Status::all());


    }
}
