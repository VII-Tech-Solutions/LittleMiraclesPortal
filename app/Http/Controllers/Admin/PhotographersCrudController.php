<?php


namespace App\Http\Controllers\Admin;
use App\Constants\Attributes;
use App\Helpers;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\Photographers;
use Exception;
//use Illuminate\Http\RedirectResponse;
//use Illuminate\Http\Request;


class PhotographersCrudController extends CustomCrudController
{
    use CreateOperation { store as traitStore; }
    use UpdateOperation { update as traitUpdate; }

    public function setup()
    {
        CRUD::setModel(Photographers::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/photographers');
        CRUD::setEntityNameStrings('Photographers', 'Photographers');
    }


}
