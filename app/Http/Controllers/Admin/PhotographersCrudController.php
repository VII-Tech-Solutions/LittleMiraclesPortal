<?php


namespace App\Http\Controllers\Admin;
use App\Constants\Attributes;
use App\Constants\Status;
use App\Http\Requests\PhotographersRequest;
use App\Helpers;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\Photographer;
use Exception;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
//use Illuminate\Http\RedirectResponse;
//use Illuminate\Http\Request;


class PhotographersCrudController extends CustomCrudController
{
    use CreateOperation { store as traitStore; }
    use UpdateOperation { update as traitUpdate; }

    public function setup()
    {
        CRUD::setModel(Photographer::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/photographers');
        CRUD::setEntityNameStrings('Photographers', 'Photographers');
    }

    protected function setupListOperation()
    {

        // Filter: Status
//        $this->addStatusFilter(Status::all());

        // Column: Name
        $this->addNameColumn(Attributes::NAME,1 , 'NAME');

        // column: Image
        $this->addImageColumn("Image");

        // Column: Status
        $this->addStatusColumn(Attributes::STATUS_NAME);

    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(PhotographersRequest::class);

         //Field: Name
        $this->addNameField(Attributes::NAME, "Name");

        // Field: Featured Image
        $this->addFeaturedImageField(Attributes::IMAGE, Attributes::IMAGE, true);

//        // Field: status
        $this->addStatusField(Status::all());


    }


}
