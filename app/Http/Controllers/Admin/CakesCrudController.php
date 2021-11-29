<?php


namespace App\Http\Controllers\Admin;
use App\Constants\Attributes;
use App\Constants\Status;
use App\Http\Requests\CakesRequest;
use App\Models\Cake;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\Backdrop;
use App\Constants\FieldTypes;

class CakesCrudController extends CustomCrudController
{

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(Cake::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/cakes');
        CRUD::setEntityNameStrings('Cake', 'Cakes');
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
        CRUD::setValidation(CakesRequest::class);

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
