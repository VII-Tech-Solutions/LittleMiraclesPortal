<?php


namespace App\Http\Controllers\Admin;

use App\Constants\Attributes;

use App\Constants\IsPopular;
use App\Constants\MediaType;
use App\Constants\Status;
use App\Constants\StudioPackageTypes;
use App\Constants\StudioPrintCategory;
use App\Helpers;
use App\Http\Requests\StudioPackageRequest;
use App\Models\Media;
use App\Models\StudioPackage;
use App\Models\Trip;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Redirect;
use Prologue\Alerts\Facades\Alert;

/**
 * Studio Package CRUD Controller
 */
class StudioPackageCrudController extends CustomCrudController
{
    use CreateOperation { store as traitStore; }
    use UpdateOperation { update as traitUpdate; }

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     * @throws Exception
     */
    public function setup()
    {
        $this->crud->setModel(StudioPackage::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/studio-packages');
        $this->crud->setEntityNameStrings('Studio Package', 'Studio Packages');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        //Attributes::SESSION_STATUS, added need filter

        // Filter: Status
        $this->addStatusFilter(Status::all());

        // Column: ID
        $this->addIDColumn("ID",1,Attributes::ID);

        // Column: Title
        $this->addNameColumn("Title", 1, Attributes::TITLE);

        // column: Image
        $this->addImageColumn("Image");

        // column: Starting Price
        $this->addPriceColumn("Starting Price",1, Attributes::STARTING_PRICE);

        // Column: Status
        $this->addStatusColumn(Attributes::STATUS_NAME);

        // Column: Status
        $this->addColumn(Attributes::TYPE_NAME,'Type');

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
        $this->crud->setValidation( StudioPackageRequest::class);

        // Field: Title
        $this->addNameField(Attributes::TITLE, "Title");

        // Field: Image
        $this->addFeaturedImageField(Attributes::IMAGE, "Image", true);

        // Field: Starting Price
        $this->addPriceField(Attributes::STARTING_PRICE, "Starting Price");

        // Field: Tyoe
        $this->addStatusField(StudioPackageTypes::all(), Attributes::TYPE, 'Type');


        // Field: Benefits
        $this->addBenefitsField();

        // Field: Status
        $this->addStatusField(Status::all());


        // Field: Media
        $this->addMediaField("Media", "Media");


    }




    /**
     * Store
     * @return RedirectResponse
     */
    public function store()
    {

        // get media ids
        $media_ids = $this->crud->getRequest()->get(Attributes::MEDIA_IDS);
        // don't accept if less than 4
        if(!is_array($media_ids) || count($media_ids) < 4 ){
            Alert::error("You need to select at least 4 images! ")->flash();
            return back()->withInput();
        }
        $this->crud->getRequest()->request->remove(Attributes::MEDIA_IDS);

        // create and return response
        $result = $this->traitStore();

        // media
        $this->media($media_ids);

        // clear cache
        Helpers::clearCache(StudioPackage::class);

        // return response
        return $result;
    }

    /**
     * Update
     * @return Response|RedirectResponse
     */
    public function update()
    {

        // get media ids
        $media_ids = $this->crud->getRequest()->get(Attributes::MEDIA_IDS);
        // don't accept if less than 4
        if(!is_array($media_ids) || count($media_ids) < 4 ){
            Alert::error("You need to select at least 4 images! ")->flash();
            return back()->withInput();
        }
        $this->crud->getRequest()->request->remove(Attributes::MEDIA_IDS);

        // update and return response
        $result = $this->traitUpdate();

        // media
        $this->media($media_ids);

        // clear cache
        Helpers::clearCache(StudioPackage::class);
        // return response
        return $result;
    }

}
