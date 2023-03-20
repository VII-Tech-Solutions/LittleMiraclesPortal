<?php

namespace App\Http\Controllers\Admin;

use App\Constants\AllowedSelection;
use App\Constants\Attributes;
use App\Http\Requests\SubPackageRequest;
use App\Models\PackagePhotographer;
use App\Models\PackageSubPackage;
use App\Models\SubPackage;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

/**
 * SubPackageCrudController CRUD Controller
 */
class SubPackageCrudController extends CustomCrudController
{

    use CreateOperation {
        store as traitStore;
    }
    use UpdateOperation {
        update as traitUpdate;
    }

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

        // deny access
        if (!str_contains(url()->current(), 'inline')) {
            $this->crud->denyAccess(["create"]);
        }
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
        $this->addIDColumn("ID", 1, Attributes::ID);

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
        $this->addDropdownField(AllowedSelection::all(), Attributes::BACKDROP_ALLOWED, "Backdrops Allowed");

        // Field: Cakes Allowed
        $this->addDropdownField(AllowedSelection::all(), Attributes::CAKE_ALLOWED, "Cakes Allowed");

        if (!str_contains(url()->current(), 'inline')) {
            // Field: Photographer
            $this->addSubPackagePhotographerField("Photographer", "Photographer");
        }
    }

    /**
     * Store
     * @return RedirectResponse
     */
    public function store()
    {
        // get package id
        if (str_contains(url()->current(), 'inline')) {
            $http_referrer = $this->crud->getRequest()->get('http_referrer');
            $str_pos = strpos($http_referrer, '/admin/packages/');
            $id = substr($http_referrer, $str_pos + strlen('/admin/packages/'), 1);
        }

        if (!str_contains(url()->current(), 'inline')) {
            // get photographers
            $photographers = $this->crud->getRequest()->get(Attributes::PHOTOGRAPHERS) ?? null;

            // get additional charge
            $additional_charge = [];
            foreach ($photographers as $photographer) {
                $additional_charge[$photographer] = $this->crud->getRequest()->get(Attributes::ADDITIONAL_CHARGE . "_" . $photographer);
            }
        }
        // get package id
        $package_id = $this->crud->getRequest()->get(Attributes::PACKAGE_ID);

        // update and return response
        $result = $this->traitStore();

        // add subpackage
        if (str_contains(url()->current(), 'inline')) {
            $package_sub_package = new PackageSubPackage();
            $package_sub_package->package_id = $result['data']['id'];
            $package_sub_package->sub_package_id = $id;
            $package_sub_package->save();
        }

        // photographers
        if (!str_contains(url()->current(), 'inline')) {
            $this->addPhotographers($photographers, $additional_charge, $package_id);
        }

        // return response
        return $result;
    }

    /**
     * Update
     * @return Response
     */
    public function update()
    {
        if (!str_contains(url()->current(), 'inline')) {
            // get photographers
            $photographers = $this->crud->getRequest()->get(Attributes::PHOTOGRAPHERS);

            // get additional charge
            $additional_charge = [];
            if (!is_null($photographers)) {
                foreach ($photographers as $photographer) {
                    $additional_charge[$photographer] = $this->crud->getRequest()->get(Attributes::ADDITIONAL_CHARGE . "_" . $photographer);
                }
            }
        }

        // get package id
        $package_id = $this->crud->getRequest()->get(Attributes::PACKAGE_ID);

        // update and return response
        $result = $this->traitUpdate();

        if (!str_contains(url()->current(), 'inline')) {
            // photographers
            $this->addPhotographers($photographers, $additional_charge, $package_id);
        }
        // return response
        return $result;
    }

    /**
     * Add Photographers
     * @param $photographers
     * @param $additional_charge
     * @return void
     */
    public function addPhotographers($photographers, $additional_charge, $package_id)
    {
        $sub_package_id = $this->crud->entry->id;
        $sub_package_photographers = Collect();
        if (!is_null($photographers)) {
            foreach ($photographers as $key => $photographer) {
                $package_photographer = PackagePhotographer::createOrUpdate([
                    Attributes::PHOTOGRAPHER_ID => $photographer,
                    Attributes::PACKAGE_ID => $package_id,
                    Attributes::SUB_PACKAGE_ID => $sub_package_id,
                    Attributes::ADDITIONAL_CHARGE => $additional_charge[$photographer],
                ], [
                    Attributes::PACKAGE_ID,
                    Attributes::PHOTOGRAPHER_ID,
                    Attributes::SUB_PACKAGE_ID
                ]);

                $sub_package_photographers->add($package_photographer->id);
            }
        }
        PackagePhotographer::where(Attributes::PACKAGE_ID, $package_id)->where(Attributes::SUB_PACKAGE_ID, $sub_package_id)->whereNotIn(Attributes::ID, $sub_package_photographers)->forceDelete();
    }


}
