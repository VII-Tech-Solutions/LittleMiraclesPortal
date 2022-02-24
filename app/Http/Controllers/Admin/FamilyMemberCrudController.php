<?php


namespace App\Http\Controllers\Admin;

use App\Constants\Attributes;
use App\Constants\FieldTypes;
use App\Constants\Relationship;
use App\Constants\Status;
use App\Constants\Gender;
use App\Http\Requests\FamilyMemberRequest;
use App\Http\Requests\UserRequest;
use App\Models\FamilyMember;
use App\Models\User;
use Exception;

/**
 * Family Member CRUD Controller

 */
class FamilyMemberCrudController extends CustomCrudController
{
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     * @throws Exception
     */
    public function setup()
    {
        $this->crud->setModel(FamilyMember::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/family-members');
        $this->crud->setEntityNameStrings('Family Member', 'Family Members');

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
        $this->addStatusFilter(Status::all());

        // Filter: Gender
        $this->addGenderFilter(Gender::all());

        // Filter: Relationship
        $this->addRelationshipFilter(Relationship::all());

        // column: ID
        $this->addIDColumn("ID", 1, Attributes::ID);

        // Column: First Name
        $this->addNameColumn("First Name", 1, Attributes::FIRST_NAME);

        // Column: Last Name
        $this->addNameColumn("Last Name", 1, Attributes::LAST_NAME);

        // column: Gender
        $this->addGenderColumn("Gender" , 1 , Attributes::GENDER_NAME);

        // column: Birth Date
        $this->addDateColumn("Birth Date", 1 ,  Attributes::BIRTH_DATE);

        //column: Relationship
        $this->addRelationshipColumn("Relationship" , 1 , Attributes::RELATIONSHIP_NAME);

        // column: User ID
        $this->addIDColumn("User ID", 1, Attributes::USER_ID);

        // Column: Family ID
        $this->addIDColumn("Family ID", 1, Attributes::FAMILY_ID);

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
        $this->crud->setValidation(FamilyMemberRequest::class);

        // Field: First Name
        $this->addNameField(Attributes::FIRST_NAME, "First Name");

        // Field: Last Name
        $this->addNameField(Attributes::LAST_NAME, "Last Name");

        // Field: Gender
        $this->addGenderField(Gender::all(),Attributes::GENDER,"Gender");

        // Field: Birth Date
        $this->addDateField(Attributes::BIRTH_DATE,"Birth Date");

        // Field: Relationship
        $this->addRelationshipField(Relationship::all(),Attributes::RELATIONSHIP,"Relationship");

        // Field: Status
        $this->addStatusField(Status::all());

    }

}
