<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Attributes;
use App\Constants\AvailableDateType;
use App\Constants\Days;
use App\Constants\Status;
use App\Http\Requests\AvailableDateRequest;
use App\Models\AvailableDate;
use App\Models\Helpers;
use App\Models\OpeningHour;
use App\Models\Photographer;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Exception;
use Illuminate\Http\RedirectResponse;

/**
 * Available Date CRUD Controller
 */
class AvailableDateCrudController extends CustomCrudController
{

    use CreateOperation {
        store as traitStore;
    }
    use UpdateOperation {
        update as traitUpdate;
    }

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * @return void
     * @throws Exception
     */
    public function setup()
    {
        $this->crud->setModel(AvailableDate::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/available-dates');
        $this->crud->setEntityNameStrings('Available Date', 'Available Dates');
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

        // Filter: Type
        $this->addStatusFilter(AvailableDateType::all(), Attributes::TYPE, "Type");

        // Column: Date
        $this->addNameColumn("Date", 1, Attributes::FULL_DATE);

        // Column: Type
        $this->addNameColumn(ucfirst(Attributes::PHOTOGRAPHER), 1, Attributes::PHOTOGRAPHER_NAME);

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
        $this->crud->setValidation(AvailableDateRequest::class);

        // Field: Start Date
        $this->addDateField(Attributes::START_DATE, "Start Date");

        // Field: End Date
        $this->addDateField(Attributes::END_DATE, "End Date");

        // Field: Photographer id
        $this->addDropdownField(Photographer::all()->pluck(Attributes::NAME, Attributes::ID), Attributes::PHOTOGRAPHER_ID, ucfirst(Attributes::PHOTOGRAPHER));

        // Field: Type
//        $this->addStatusField(AvailableDateType::all(), Attributes::TYPE, "Type");

        // Field: Days
        $this->addRepeatableDaysField();

        // Field: Status
        $this->addStatusField(Status::only([Status::ACTIVE, Status::DRAFT]));

    }

    /**
     * Store
     * @return RedirectResponse
     */
    public function store()
    {

        // get hours
        $hours = $this->crud->getRequest()->get(Attributes::HOURS);
        $this->crud->getRequest()->request->remove(Attributes::HOURS);

        // update and return response
        $result = $this->traitStore();

        // save hours
        $this->saveHours($hours);

        // return response
        return $result;
    }

    /**
     * Update
     * @return Response|RedirectResponse
     */
    public function update()
    {

        // get hours
        $hours = $this->crud->getRequest()->get(Attributes::HOURS);
        $this->crud->getRequest()->request->remove(Attributes::HOURS);

        // update and return response
        $result = $this->traitUpdate();

        // save hours
        $this->saveHours($hours);

        // return response
        return $result;
    }

    /**
     * Save Items
     * @param $items
     */
    function saveHours($items)
    {
        $available_date_id = $this->crud->getCurrentEntryId();
        $items = json_decode($items, true);
        $collection = collect($items)->sortBy(Attributes::DAY_ID)->sortBy(Attributes::FROM)->map(function ($item) use ($available_date_id) {
            $start_time = $item[Attributes::FROM];
            if (empty($start_time)) {
                return null;
            }
            $end_time = $item[Attributes::TO];
            if (empty($end_time)) {
                return null;
            }
            $day_id = $item[Attributes::DAY_ID];
            $day = Helpers::readableText(Days::getKey(intval($day_id)));
            return OpeningHour::createOrUpdate([
                Attributes::AVAILABLE_DATE_ID => $available_date_id,
                Attributes::DAY => $day,
                Attributes::DAY_ID => $day_id,
                Attributes::FROM => $start_time,
                Attributes::TO => $end_time,
                Attributes::STATUS => Status::ACTIVE,
            ]);
        })->filter();

        // delete the rest
        $ids = $collection->pluck(Attributes::ID);
        if (!$ids->isEmpty()) {
            OpeningHour::whereNotIn(Attributes::ID, $ids)->where(Attributes::AVAILABLE_DATE_ID, $available_date_id)->delete();
        }
    }
}
