<?php


namespace App\Http\Controllers\Admin;

use App\Constants\Attributes;
use App\Constants\FieldTypes;
use App\Constants\ReviewStatus;
use App\Constants\Status;
use App\Http\Requests\ReviewRequest;
use App\Models\Review;
use Exception;

/**
 * Review CRUD Controller
 */
class ReviewCrudController extends CustomCrudController
{
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     * @throws Exception
     */
    public function setup()
    {
        $this->crud->setModel(Review::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/reviews');
        $this->crud->setEntityNameStrings('Review', 'Reviews');

        // deny access
        $this->crud->denyAccess(["create"]);

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
        $this->addStatusFilter(ReviewStatus::all());

        // Column: User ID
        $this->addIDColumn("User ID", 1, Attributes::USER_ID);

        // Column: User Name
        $this->addNameColumn("User Name", 1, Attributes::USER_NAME);

        // column: User Image
        $this->addImageColumn("User Image",1,Attributes::USER_IMAGE);

        // Column: Rating
        $this->addRatingColumn("Rating",1,Attributes::RATING);

        // Column: Comment
        $this->addContentColumn("Comment",1,Attributes::COMMENT);

        // Column: Posted At
        $this->addDateColumn("Posted At", 1, Attributes::POSTED_AT);

        // Column: Package ID
        $this->addIDColumn("Package ID", 1, Attributes::PACKAGE_ID);

        // Column: Session ID
        $this->addIDColumn("Session ID", 1, Attributes::SESSION_ID);

        // Column: Status
        $this->addReviewStatusColumn(Attributes::STATUS_NAME);

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
        $this->crud->setValidation(ReviewRequest::class);
        // Field: COMMENT
        $this->addContentField(Attributes::COMMENT, Attributes::COMMENT, null, FieldTypes::TEXTAREA, 5, 200);

        // Field: Posted At
        $this->addDateField(Attributes::POSTED_AT, "Posted At");

        // Field: Rating
        $this->addRatingField(Attributes::RATING, "Rating");

        // Field: Status
        $this->addStatusField(ReviewStatus::all());

    }
}
