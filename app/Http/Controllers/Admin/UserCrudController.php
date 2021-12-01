<?php


namespace App\Http\Controllers\Admin;

use App\Constants\Attributes;
use App\Constants\FieldTypes;
use App\Constants\Status;
use App\Constants\Gender;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Exception;

/**
 * User CRUD Controller

 */
class UserCrudController extends CustomCrudController
{
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     * @throws Exception
     */
    public function setup()
    {
        $this->crud->setModel(User::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/users');
        $this->crud->setEntityNameStrings('User', 'Users');
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

        // column: User ID
        $this->addIDColumn("User ID", 1, Attributes::ID);

        // Column: First Name
        $this->addNameColumn("First Name", 1, Attributes::FIRST_NAME);

        // Column: Last Name
        $this->addNameColumn("Last Name", 1, Attributes::LAST_NAME);

        // column: Gender
        $this->addGenderColumn("Gender" , 1 , Attributes::GENDER_NAME);

        // column: Birth Date
        $this->addDateColumn("Birth Date", 1 ,  Attributes::BIRTH_DATE);

        // column: Email
        $this->addEmailColumn("Email", 1 , Attributes::EMAIL);

        // column: Country Code
        $this->addNameColumn("Country Code", 1, Attributes::COUNTRY_CODE);

        // column: Phone Number
        $this->addNumberColumn("Phone Number", 1 , Attributes::PHONE_NUMBER);

        // column: Provider
        $this->addProviderColumn("Provider", 1, Attributes::PROVIDER);

        // column: Avatar
        $this->addImageColumn("Avatar",1 , Attributes::AVATAR);

        // column: Past Experience
        $this->addPastExperienceColumn("Past Experience", 1, Attributes::PAST_EXPERIENCE);

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
        $this->crud->setValidation(UserRequest::class);

        // Field: First Name
        $this->addNameField(Attributes::FIRST_NAME, "First Name");

        // Field: Last Name
        $this->addNameField(Attributes::LAST_NAME, "Last Name");
        // Field: Gender
        $this->addGenderField(Gender::all(),Attributes::GENDER,"Gender");

        // Field: Birth Date
        $this->addDateField(Attributes::BIRTH_DATE,"Birth Date");

        // Field: Email
        $this->addEmailField(Attributes::EMAIL,"Email");

        // Field: Country Code
        $this->addNumberField(Attributes::COUNTRY_CODE, "Country Code", null, 4);

        // Field: Phone Number
        $this->addNumberField(Attributes::PHONE_NUMBER, "Phone Number", null, 12);

        // Field: Provider
        $this->addTextField(Attributes::PROVIDER,"Provider");

        // Field: Avatar
        $this->addFeaturedImageField(Attributes::AVATAR, "Avatar", true);

        // Field: Past Experience
        $this->addTextField(Attributes::PAST_EXPERIENCE,"Past Experience");

        // Field: Status
        $this->addStatusField(Status::all());

    }
}
