<?php


namespace App\Http\Controllers\Admin;

use App\Constants\Attributes;

use App\Constants\IsPopular;
use App\Constants\Status;
use App\Constants\StudioPrintCategory;
use App\Helpers;
use App\Http\Requests\StudioPackageRequest;
use App\Models\StudioPackage;
use App\Models\Trip;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;
use Prologue\Alerts\Facades\Alert;

/**
 * Studio Package CRUD Controller
 */
class StudioPackageCrudController extends CustomCrudController
{
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

        // Field: Status
        $this->addStatusField(Status::all());


        // Field: Media
        $this->addMediaField("Media", "Media");


    }


    /**
     * File Upload
     * @param Request $request
     * @return array|RedirectResponse|Response
     */
    public function fileUpload(Request $request){
        $back_url = request()->headers->get(Attributes::REFERER) ?? null;
        $item_id = intval($request->item_id);
        if(!$item_id){
            return back()->withInput();
        }
        if($request->hasFile(Attributes::MEDIA)) {
            $files = $request->allFiles()[Attributes::MEDIA];
            foreach ($files as $file){
                $media = Helpers::uploadFile(null, $file, null, "assets/studio", false, true);
                }
            }

        Alert::success('Media saved for this entry.')->flash();
        return !is_null($back_url) ? Redirect::to($back_url."#media") : back();
    }
}
