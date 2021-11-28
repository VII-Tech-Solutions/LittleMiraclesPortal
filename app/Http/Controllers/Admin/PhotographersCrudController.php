<?php


namespace App\Http\Controllers\Admin;
use App\Constants\Attributes;
use App\Constants\Status;
use App\Helpers;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\Photographers;
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
        CRUD::setModel(Photographers::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/photographers');
        CRUD::setEntityNameStrings('Photographers', 'Photographers');
    }

    protected function setupListOperation()
    {

        // Filter: Status
//        $this->addStatusFilter(Status::all());

        // Column: Name
        $this->addNameColumn("Name");

        // column: Image
        $this->addImageColumn("Name");

        // Column: Status
        $this->addStatusColumn();

    }

//    protected function setupCreateOperation()
//    {
//        CRUD::setValidation(UserRequest::class);
//
//        // Field: Name
//        $this->addNameField(Attributes::NAME, "Name");
//
//        // Field: Email
//        $this->addTextField("Email", Attributes::EMAIL, true);
//
//        // Field: Username
//        $this->addTextField("Username", Attributes::USERNAME, true);
//
//        // Field: Avatar
//        $this->addFeaturedImageField(Attributes::AVATAR, "Avatar");
//
//        // Field: Email Verified At
//        $this->addTextField("Email Verified At", Attributes::EMAIL_VERIFIED_AT, true);
//
//        // Field: Email Verified At
//        $this->addTextField("Email Resent At", Attributes::EMAIL_RESENT_AT, true);
//
//        // Field: Login Method
//        $this->addTextField("Login Method", Attributes::PROVIDER_NAME, true);
//
//        // Field: Status
//        $this->addStatusField(UserStatus::all());
//
//
//    }


}
