<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Attributes;
use App\Constants\FieldTypes;
use App\Constants\Gender;
use App\Constants\IsPopular;
use App\Constants\Relationship;
use App\Constants\SessionPackageTypes;
use App\Constants\SectionTypes;
use App\Constants\Status;
use App\Constants\SessionStatus;
use App\Constants\StudioCategory;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\FetchOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\InlineCreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Custom CRUD Controller
 */
class CustomCrudController extends CrudController
{

    use ListOperation, CreateOperation, UpdateOperation, DeleteOperation, FetchOperation, InlineCreateOperation;

    /**
     * Add Name Field
     * @param string|null $field_name
     * @param string|null $label
     * @param string|null $tab_name
     * @param array $limit
     * @param bool $disabled
     */
    function addNameField($field_name = null, $label = null, $tab_name = null, $limit = [], $disabled = false)
    {
        if (is_null($field_name)) {
            $field_name = Attributes::NAME;
        }
        if (is_null($label)) {
            $label = "Title";
        }
        if(!is_array($limit)){
            $limit = [
                Attributes::MAXLENGTH => $limit
            ];
        }
        CRUD::addField([
            Attributes::NAME => $field_name,
            Attributes::TYPE => FieldTypes::TEXT,
            Attributes::LABEL => ucwords($label),
            Attributes::ATTRIBUTES => array_merge([
                ], $limit) + $this->disabled($disabled),
            Attributes::TAB => $tab_name
        ]);
    }

    /**
     * Add Email Field
     * @param string|null $field_name
     * @param string|null $label
     * @param string|null $tab_name
     * @param array $limit
     * @param bool $disabled
     */
    function addEmailField($field_name = null, $label = null, $tab_name = null, $limit = [], $disabled = false)
    {
        if (is_null($field_name)) {
            $field_name = Attributes::EMAIL;
        }
        if (is_null($label)) {
            $label = "Email";
        }
        if(!is_array($limit)){
            $limit = [
                Attributes::MAXLENGTH => $limit
            ];
        }
        CRUD::addField([
            Attributes::NAME => $field_name,
            Attributes::TYPE => FieldTypes::TEXT,
            Attributes::LABEL => ucwords($label),
            Attributes::ATTRIBUTES => array_merge([
                ], $limit) + $this->disabled($disabled),
            Attributes::TAB => $tab_name
        ]);
    }
    /**
     * Add Number Field for phone number and country code
     * @param string|null $field_name
     * @param string|null $label
     * @param string|null $tab_name
     * @param array $limit
     * @param bool $disabled
     */
    function addNumberField($field_name = null, $label = null, $tab_name = null, $limit = [], $disabled = false)
    {
        if (is_null($field_name)) {
            $field_name = Attributes::PHONE_NUMBER;
        }
        if (is_null($label)) {
            $label = "Phone Number";
        }
        if(!is_array($limit)){
            $limit = [
                Attributes::MAXLENGTH => $limit
            ];
        }
        CRUD::addField([
            Attributes::NAME => $field_name,
            Attributes::TYPE => FieldTypes::NUMBER,
            Attributes::LABEL => ucwords($label),
            Attributes::ATTRIBUTES => array_merge([
                ], $limit) + $this->disabled($disabled),
            Attributes::TAB => $tab_name
        ]);
    }
    /**
     * Add Question Field
     * @param string|null $field_name
     * @param string|null $label
     * @param string|null $tab_name
     * @param array $limit
     * @param bool $disabled
     */
    function addQuestionField($field_name = null, $label = null, $tab_name = null, $limit = [], $disabled = false)
    {
        if (is_null($field_name)) {
            $field_name = Attributes::QUESTION;
        }
        if (is_null($label)) {
            $label = "Question";
        }
        if(!is_array($limit)){
            $limit = [
                Attributes::MAXLENGTH => $limit
            ];
        }
        CRUD::addField([
            Attributes::NAME => $field_name,
            Attributes::TYPE => FieldTypes::TEXT,
            Attributes::LABEL => ucwords($label),
            Attributes::ATTRIBUTES => array_merge([
                ], $limit) + $this->disabled($disabled),
            Attributes::TAB => $tab_name
        ]);
    }

    /**
     * Add Tags Field
     * @param string|null $tab_name
     */
    function addTagField($field_name = null, $label = null, $tab_name = null, $limit = [], $disabled = false)
    {
        if (is_null($field_name)) {
            $field_name = Attributes::TAG;
        }
        if (is_null($label)) {
            $label = "Tags";
        }
        if(!is_array($limit)){
            $limit = [
                Attributes::MAXLENGTH => $limit
            ];
        }
        CRUD::addField([
            Attributes::NAME => $field_name,
            Attributes::TYPE => FieldTypes::TEXT,
            Attributes::LABEL => ucwords($label),
            Attributes::ATTRIBUTES => array_merge([
                ], $limit) + $this->disabled($disabled),
            Attributes::TAB => $tab_name
        ]);
    }



    /**
     * Add Description Field
     * @param string|null $name
     * @param string|null $label
     * @param string|null $tab_name
     * @param string $field_type
     * @param int $rows
     * @param integer|array $limit
     */
    function addDescriptionField($name = null, $label = null, $tab_name = null, $field_type = FieldTypes::TEXTAREA, $rows = 5, $limit = [], $hint = null)
    {
        if (is_null($name)) {
            $name = Attributes::DESCRIPTION;
        }
        if (is_null($label)) {
            $label = ucwords(Attributes::DESCRIPTION);
        }
        if(!is_array($limit)){
            $limit = [
                Attributes::MAXLENGTH => $limit
            ];
        }
        CRUD::addField([
            Attributes::NAME => $name,
            Attributes::TYPE => $field_type,
            Attributes::LABEL => ucwords($label),
            Attributes::ATTRIBUTES => array_merge([
                Attributes::ROWS => $rows,
            ], $limit),
            Attributes::TAB => $tab_name,
            Attributes::HINT => $hint,
            'options'       => [
                Attributes::DIR => Attributes::LTR,
                "language" => 'en',
//                'removePlugins' => 'embed,Embed',
//                'removeButtons'        => 'Source,Save,Templates,NewPage,ExportPdf,Preview,Print,Cut,Undo,Find,Replace,SelectAll,Scayt,Form,Checkbox,Redo,PasteText,PasteFromWord,About,Maximize,ShowBlocks,BGColor,Styles,TextColor,Format,Font,FontSize,Image,CopyFormatting,NumberedList,Outdent,Blockquote,JustifyLeft,RemoveFormat,Indent,BulletedList,Underline,Strike,Subscript,Superscript,CreateDiv,JustifyCenter,Flash,Table,Anchor,Language,JustifyBlock,JustifyRight,HorizontalRule,Smiley,SpecialChar,PageBreak,Iframe,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Italic,Bold',
            ]

        ]);
    }


    /**
    * Add Content Field
     * @param string|null $name
     * @param string|null $label
     * @param string|null $tab_name
     * @param string $field_type
     * @param int $rows
     * @param integer|array $limit
     */
    function addContentField($name = null, $label = null, $tab_name = null, $field_type = FieldTypes::TEXTAREA, $rows = 5, $limit = [], $hint = null)
    {
        if (is_null($name)) {
            $name = Attributes::CONTENT;
        }
        if (is_null($label)) {
            $label = ucwords(Attributes::CONTENT);
        }
        if(!is_array($limit)){
            $limit = [
                Attributes::MAXLENGTH => $limit
            ];
        }
        CRUD::addField([
            Attributes::NAME => $name,
            Attributes::TYPE => $field_type,
            Attributes::LABEL => ucwords($label),
            Attributes::ATTRIBUTES => array_merge([
                Attributes::ROWS => $rows,
            ], $limit),
            Attributes::TAB => $tab_name,
            Attributes::HINT => $hint,
            'options'       => [
                Attributes::DIR => Attributes::LTR,
                "language" => 'en',
//                'removePlugins' => 'embed,Embed',
//                'removeButtons'        => 'Source,Save,Templates,NewPage,ExportPdf,Preview,Print,Cut,Undo,Find,Replace,SelectAll,Scayt,Form,Checkbox,Redo,PasteText,PasteFromWord,About,Maximize,ShowBlocks,BGColor,Styles,TextColor,Format,Font,FontSize,Image,CopyFormatting,NumberedList,Outdent,Blockquote,JustifyLeft,RemoveFormat,Indent,BulletedList,Underline,Strike,Subscript,Superscript,CreateDiv,JustifyCenter,Flash,Table,Anchor,Language,JustifyBlock,JustifyRight,HorizontalRule,Smiley,SpecialChar,PageBreak,Iframe,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Italic,Bold',
            ]

        ]);
    }


    /**
     * Add Description Field
     * @param string|null $name
     * @param string|null $label
     * @param string|null $tab_name
     * @param string $field_type
     * @param int $rows
     * @param integer|array $limit
     */
    function addAnswerField($name = null, $label = null, $tab_name = null, $field_type = FieldTypes::TEXTAREA, $rows = 5, $limit = [], $hint = null)
    {
        if (is_null($name)) {
            $name = Attributes::ANSWER;
        }
        if (is_null($label)) {
            $label = ucwords(Attributes::ANSWER);
        }
        if(!is_array($limit)){
            $limit = [
                Attributes::MAXLENGTH => $limit
            ];
        }
        CRUD::addField([
            Attributes::NAME => $name,
            Attributes::TYPE => $field_type,
            Attributes::LABEL => ucwords($label),
            Attributes::ATTRIBUTES => array_merge([
                Attributes::ROWS => $rows,
            ], $limit),
            Attributes::TAB => $tab_name,
            Attributes::HINT => $hint,
            'options'       => [
                Attributes::DIR => Attributes::LTR,
                "language" => 'en',
//                'removePlugins' => 'embed,Embed',
//                'removeButtons'        => 'Source,Save,Templates,NewPage,ExportPdf,Preview,Print,Cut,Undo,Find,Replace,SelectAll,Scayt,Form,Checkbox,Redo,PasteText,PasteFromWord,About,Maximize,ShowBlocks,BGColor,Styles,TextColor,Format,Font,FontSize,Image,CopyFormatting,NumberedList,Outdent,Blockquote,JustifyLeft,RemoveFormat,Indent,BulletedList,Underline,Strike,Subscript,Superscript,CreateDiv,JustifyCenter,Flash,Table,Anchor,Language,JustifyBlock,JustifyRight,HorizontalRule,Smiley,SpecialChar,PageBreak,Iframe,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Italic,Bold',
            ]

        ]);
    }




    /**
     * Add Custom Cake AND custom Backdrop Field
     * @param string|null $name
     * @param string|null $label
     * @param string|null $tab_name
     * @param string $field_type
     * @param int $rows
     * @param integer|array $limit
     */
    function addCustomField($name = null, $label = null, $tab_name = null, $field_type = FieldTypes::TEXTAREA, $rows = 5, $limit = [], $hint = null)
    {
        if (is_null($name)) {
            $name = Attributes::CUSTOM_CAKE;
        }
        if (is_null($label)) {
            $label = ucwords(Attributes::CUSTOM_CAKE);
        }
        if(!is_array($limit)){
            $limit = [
                Attributes::MAXLENGTH => $limit
            ];
        }
        CRUD::addField([
            Attributes::NAME => $name,
            Attributes::TYPE => $field_type,
            Attributes::LABEL => ucwords($label),
            Attributes::ATTRIBUTES => array_merge([
                Attributes::ROWS => $rows,
            ], $limit),
            Attributes::TAB => $tab_name,
            Attributes::HINT => $hint,
            'options'       => [
                Attributes::DIR => Attributes::LTR,
                "language" => 'en',
//                'removePlugins' => 'embed,Embed',
//                'removeButtons'        => 'Source,Save,Templates,NewPage,ExportPdf,Preview,Print,Cut,Undo,Find,Replace,SelectAll,Scayt,Form,Checkbox,Redo,PasteText,PasteFromWord,About,Maximize,ShowBlocks,BGColor,Styles,TextColor,Format,Font,FontSize,Image,CopyFormatting,NumberedList,Outdent,Blockquote,JustifyLeft,RemoveFormat,Indent,BulletedList,Underline,Strike,Subscript,Superscript,CreateDiv,JustifyCenter,Flash,Table,Anchor,Language,JustifyBlock,JustifyRight,HorizontalRule,Smiley,SpecialChar,PageBreak,Iframe,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Italic,Bold',
            ]

        ]);
    }


    /**
     * Add Featured Image Field
     * @param null $field_name
     * @param null $label
     * @param bool $remove_hint
     * @param null $hint_message
     * @param null $tab_name
     */
    function addFeaturedImageField($field_name = null, $label = null, $remove_hint = false, $hint_message = null, $tab_name = null)
    {
        if (is_null($field_name)) {
            $field_name = Attributes::FEATURED_IMAGE;
        }

        if (is_null($hint_message)) {
            $hint_message = "<strong>Note: </strong>Maximum image size is <strong>7MB.</strong>";
        }
        CRUD::addField([
            Attributes::LABEL => is_null($label) ? "Featured Image" : ucwords($label),
            Attributes::NAME => $field_name,
            Attributes::TYPE => Attributes::IMAGE,
            Attributes::HINT => !$remove_hint ? $hint_message : "",
            Attributes::CROP => false, // set to true to allow cropping, false to disable
            Attributes::ASPECT_RATIO => 1, // Commit or set to 0 to allow any aspect ratio
            Attributes::TAB => $tab_name,
        ]);
    }

    /**
     * Add Tag Category Field
     */
    function addTagCategoryField($field_name= NULL, $label = null )
    {
        if (is_null($field_name)) {
            $field_name = Attributes::CATEGORY;
        }
        CRUD::addField([
            Attributes::LABEL => is_null($label) ? "Category" : ucwords($label),
            Attributes::NAME => Attributes::CATEGORY,
            Attributes::TYPE => FieldTypes::TEXT,

        ]);
    }
    /**
     * Add Offer Field
     */
    function addOfferField($field_name= NULL, $label = null )
    {
        if (is_null($field_name)) {
            $field_name = Attributes::OFFER;
        }
        CRUD::addField([
            Attributes::LABEL => is_null($label) ? "Offer" : ucwords($label),
            Attributes::NAME => Attributes::OFFER,
            Attributes::TYPE => FieldTypes::TEXT,

        ]);
    }
    /**
     * Add Promotion Type Field
     */
    function addPromotionTypeField($field_name= NULL, $label = null )
    {
        if (is_null($field_name)) {
            $field_name = Attributes::TYPE;
        }
        CRUD::addField([
            Attributes::LABEL => is_null($label) ? "Type" : ucwords($label),
            Attributes::NAME => Attributes::TYPE,
            Attributes::TYPE => FieldTypes::TEXT,

        ]);
    }
    /**
     * Add Promotion Code Field
     */
    function addPromotionCodeField($field_name= NULL, $label = null )
    {
        if (is_null($field_name)) {
            $field_name = Attributes::CODE;
        }
        CRUD::addField([
            Attributes::LABEL => is_null($label) ? "Code" : ucwords($label),
            Attributes::NAME => Attributes::CODE,
            Attributes::TYPE => FieldTypes::TEXT,

        ]);
    }
    /**
     * Add Price Field for workshop
     */
    function addPriceField($field_name= NULL, $label = null )
    {
        if (is_null($field_name)) {
            $field_name = Attributes::PRICE;
        }
        CRUD::addField([
            Attributes::LABEL => is_null($label) ? "Price" : ucwords($label),
            Attributes::NAME => $field_name,
            Attributes::TYPE => FieldTypes::NUMBER,
            Attributes::ATTRIBUTES => ["step" => "any"], // allow decimals
            Attributes::PREFIX => "BHD",
        ]);
    }
    /**
     * Add Rating Field for Review table
     */
    function addRatingField($field_name= NULL, $label = null )
    {
        if (is_null($field_name)) {
            $field_name = Attributes::RATING;
        }
        CRUD::addField([
            Attributes::LABEL => is_null($label) ? "Rating" : ucwords($label),
            Attributes::NAME => Attributes::RATING,
            Attributes::TYPE => FieldTypes::NUMBER,
            Attributes::ATTRIBUTES => ["step" => "any"], // allow decimals
        ]);
    }
    /**
     * Add Promotion Date Field
     */
    function addDateField($field_name= NULL, $label = null )
    {
        if (is_null($field_name)) {
            $field_name = Attributes::DATE;
        }
        CRUD::addField([
            Attributes::LABEL => is_null($label) ? "Date" : ucwords($label),
            Attributes::NAME => $field_name,
            Attributes::TYPE => FieldTypes::DATE_PICKER,

        ]);
    }
    /**
     * Add Tag Posted At Field
     */
    function addPostedAtField($field_name= NULL, $label = null )
    {
        if (is_null($field_name)) {
            $field_name = Attributes::POSTED_AT;
        }
        CRUD::addField([
            Attributes::LABEL => is_null($label) ? "Posted At" : ucwords($label),
            Attributes::NAME => Attributes::POSTED_AT,
            Attributes::TYPE => FieldTypes::DATE_PICKER,

        ]);
    }

    /**
     * Add Tag Posted At Field
     */
    function addValidUntilField($field_name= NULL, $label = null )
    {
        if (is_null($field_name)) {
            $field_name = Attributes::VALID_UNTIL;
        }
        CRUD::addField([
            Attributes::LABEL => is_null($label) ? "Valid Until" : ucwords($label),
            Attributes::NAME => Attributes::VALID_UNTIL,
            Attributes::TYPE => FieldTypes::DATE_PICKER,

        ]);
    }



    /**
     * Add Order Field
     */
    function addOrderField($hint = null, $is_disabled = false)
    {
        CRUD::addField([
            Attributes::LABEL => "Order",
            Attributes::NAME => Attributes::ORDER,
            Attributes::TYPE => FieldTypes::NUMBER,
            Attributes::HINT => $hint,
            Attributes::ATTRIBUTES => $this->disabled($is_disabled),
        ]);
    }
    /**
     * Add Status Filter Field
     */
    function addStatusFilter($statuses = null, $column_name = Attributes::STATUS, $label = "Status")
    {
        if (is_null($statuses)) {
            $statuses = Status::all();
        }
        $this->crud->addFilter([
            Attributes::TYPE => FieldTypes::DROPDOWN,
            Attributes::NAME => $column_name,
            Attributes::LABEL => $label
        ], $statuses, function ($value) use($column_name) {
            $this->crud->addClause('where', $column_name, $value);
        });
    }

    /**
     * Add Gender Filter Field
     */
    function addGenderFilter($Genders = null, $column_name = Attributes::GENDER, $label = "Gender")
    {
        if (is_null($Genders)) {
            $Genders = Gender::all();
        }
        $this->crud->addFilter([
            Attributes::TYPE => FieldTypes::DROPDOWN,
            Attributes::NAME => $column_name,
            Attributes::LABEL => $label
        ], $Genders, function ($value) use($column_name) {
            $this->crud->addClause('where', $column_name, $value);
        });
    }

    /**
     * Add Relationship Filter Field
     */
    function addRelationshipFilter($Relationship = null, $column_name = Attributes::RELATIONSHIP, $label = "Gender")
    {
        if (is_null($Relationship)) {
            $Relationship = Relationship::all();
        }
        if (is_null($column_name)) {
            $column_name = Attributes::RELATIONSHIP;
        }
        $this->crud->addFilter([
            Attributes::TYPE => FieldTypes::DROPDOWN,
            Attributes::NAME => $column_name,
            Attributes::LABEL => $label
        ], $Relationship, function ($value) use($column_name) {
            $this->crud->addClause('where', $column_name, $value);
        });
    }

    function addCategoryFilter($statuses = null, $column_name = Attributes::CATEGORY, $label = "Category")
    {
        if (is_null($statuses)) {
            $statuses = StudioCategory::all();
        }
        $this->crud->addFilter([
            Attributes::TYPE => FieldTypes::DROPDOWN,
            Attributes::NAME => $column_name,
            Attributes::LABEL => $label
        ], $statuses, function ($value) use($column_name) {
            $this->crud->addClause('where', $column_name, $value);
        });
    }

    function addTypeFilter($statuses = null, $column_name = Attributes::TYPE, $label = "Type")
    {
        if (is_null($statuses)) {
            $statuses = SectionTypes::all();
        }
        $this->crud->addFilter([
            Attributes::TYPE => FieldTypes::DROPDOWN,
            Attributes::NAME => $column_name,
            Attributes::LABEL => $label
        ], $statuses, function ($value) use($column_name) {
            $this->crud->addClause('where', $column_name, $value);
        });
    }

    /**
     * Add Type Filter Field
     */
    function addPackageTypeFilter($statuses = null, $column_name = Attributes::TYPE, $label = "Package Type")
    {
        if (is_null($statuses)) {
            $statuses = SessionPackageTypes::all();
        }
        $this->crud->addFilter([
            Attributes::TYPE => FieldTypes::DROPDOWN,
            Attributes::NAME => $column_name,
            Attributes::LABEL => $label
        ], $statuses, function ($value) use($column_name) {
            $this->crud->addClause('where', $column_name, $value);
        });
    }

    /**
     * Add Is Popular Filter Field
     */
    function addIsPopularFilter($statuses = null, $column_name = Attributes::IS_POPULAR, $label = "Is Popular")
    {
        if (is_null($statuses)) {
            $statuses = IsPopular::all();
        }
        $this->crud->addFilter([
            Attributes::TYPE => FieldTypes::DROPDOWN,
            Attributes::NAME => $column_name,
            Attributes::LABEL => $label
        ], $statuses, function ($value) use($column_name) {
            $this->crud->addClause('where', $column_name, $value);
        });
    }

    /**
     * Add Status Field
     * @param null $statuses
     * @param null $attribute_name
     * @param null $label
     * @param null $tab_name
     * @param false $allow_null
     */
    function addStatusField($statuses = null, $attribute_name = null, $label = null, $tab_name = null, $allow_null = false)
    {
        if (is_null($statuses)) {
            $statuses = Status::all();
        }
        if (is_null($attribute_name)) {
            $attribute_name = Attributes::STATUS;
        }
        if (is_null($label)) {
            $label = ucfirst(Attributes::STATUS);
        }
        CRUD::addField([
            Attributes::LABEL => $label,
            Attributes::NAME => $attribute_name,
            Attributes::ALLOWS_NULL => $allow_null,
            Attributes::TYPE => FieldTypes::SELECT2_FROM_ARRAY,
            Attributes::OPTIONS => $statuses,
            Attributes::TAB => $tab_name,
        ]);
    }

    /**
     * Add SectionType Field
     * @param null $types
     * @param null $attribute_name
     * @param null $label
     * @param null $tab_name
     * @param false $allow_null
     */
    function addTypeField($types = null, $attribute_name = null, $label = null, $tab_name = null, $allow_null = false)
    {
        if (is_null($types)) {
            $types = SectionTypes::all();
        }
        if (is_null($attribute_name)) {
            $attribute_name = Attributes::TYPE;
        }
        if (is_null($label)) {
            $label = ucfirst(Attributes::TYPE);
        }
        CRUD::addField([
            Attributes::LABEL => $label,
            Attributes::NAME => $attribute_name,
            Attributes::ALLOWS_NULL => $allow_null,
            Attributes::TYPE => FieldTypes::SELECT2_FROM_ARRAY,
            Attributes::OPTIONS => $types,
            Attributes::TAB => $tab_name,
        ]);
    }

    /**
     * Add Gender Field
     * @param null $genders
     * @param null $attribute_name
     * @param null $label
     * @param null $tab_name
     * @param false $allow_null
     */
    function addGenderField($genders = null, $attribute_name = null, $label = null, $tab_name = null, $allow_null = false)
    {
        if (is_null($genders)) {
            $genders = Gender::all();
        }
        if (is_null($attribute_name)) {
            $attribute_name = Attributes::GENDER;
        }
        if (is_null($label)) {
            $label = ucfirst(Attributes::GENDER);
        }
        CRUD::addField([
            Attributes::LABEL => $label,
            Attributes::NAME => $attribute_name,
            Attributes::ALLOWS_NULL => $allow_null,
            Attributes::TYPE => FieldTypes::SELECT2_FROM_ARRAY,
            Attributes::OPTIONS => $genders,
            Attributes::TAB => $tab_name,
        ]);
    }

    /**
     * Add Relationship Field
     * @param null $relationships
     * @param null $attribute_name
     * @param null $label
     * @param null $tab_name
     * @param false $allow_null
     */
    function addRelationshipField($relationships = null, $attribute_name = null, $label = null, $tab_name = null, $allow_null = false)
    {
        if (is_null($relationships)) {
            $relationships = Relationship::all();
        }
        if (is_null($attribute_name)) {
            $attribute_name = Attributes::RELATIONSHIP;
        }
        if (is_null($label)) {
            $label = ucfirst(Attributes::RELATIONSHIP);
        }
        CRUD::addField([
            Attributes::LABEL => $label,
            Attributes::NAME => $attribute_name,
            Attributes::ALLOWS_NULL => $allow_null,
            Attributes::TYPE => FieldTypes::SELECT2_FROM_ARRAY,
            Attributes::OPTIONS => $relationships,
            Attributes::TAB => $tab_name,
        ]);
    }
    /**
     * Add Studio Metadata Category Field
     * @param null $statuses
     * @param null $attribute_name
     * @param null $label
     * @param null $tab_name
     * @param false $allow_null
     */
    function addCategoryField($statuses = null, $attribute_name = null, $label = null, $tab_name = null, $allow_null = false)
    {
        if (is_null($statuses)) {
            $statuses = StudioCategory::all();
        }
        if (is_null($attribute_name)) {
            $attribute_name = Attributes::CATEGORY;
        }
        if (is_null($label)) {
            $label = ucfirst(Attributes::CATEGORY);
        }
        CRUD::addField([
            Attributes::LABEL => $label,
            Attributes::NAME => $attribute_name,
            Attributes::ALLOWS_NULL => $allow_null,
            Attributes::TYPE => FieldTypes::SELECT2_FROM_ARRAY,
            Attributes::OPTIONS => $statuses,
            Attributes::TAB => $tab_name,
        ]);
    }



    /**
     * Add Name Column
     * @param null $label
     * @param int $priority
     * @param string $column_name
     */
    function addNameColumn($label = null, $priority = 1, $column_name = Attributes::NAME)
    {
        if (is_null($label)) {
            $label = "Title";
        }
        if (is_null($column_name)) {
            $column_name = Attributes::NAME;
        }
        $this->crud->addColumn([
            Attributes::NAME => $column_name,
            Attributes::LABEL => $label,
            Attributes::PRIORITY => $priority
        ]);
    }

    /**
     * Add Tag Column
     * @param null $label
     * @param int $priority
     * @param string $column_name
     */
    function addTagColumn($label = null, $priority = 1, $column_name = Attributes::TAG)
    {
        if (is_null($label)) {
            $label = "Tag";
        }
        if (is_null($column_name)) {
            $column_name = Attributes::TAG;
        }
        $this->crud->addColumn([
            Attributes::NAME => $column_name,
            Attributes::LABEL => $label,
            Attributes::PRIORITY => $priority
        ]);
    }
    /**
     * Add Email Column
     * @param null $label
     * @param int $priority
     * @param string $column_name
     */
    function addEmailColumn($label = null, $priority = 1, $column_name = Attributes::EMAIL)
    {
        if (is_null($label)) {
            $label = "Email";
        }
        if (is_null($column_name)) {
            $column_name = Attributes::EMAIL;
        }
        $this->crud->addColumn([
            Attributes::NAME => $column_name,
            Attributes::LABEL => $label,
            Attributes::PRIORITY => $priority
        ]);
    }
    /**
     * Add Provider Column
     * @param null $label
     * @param int $priority
     * @param string $column_name
     */
    function addProviderColumn($label = null, $priority = 1, $column_name = Attributes::PROVIDER)
    {
        if (is_null($label)) {
            $label = "Provider";
        }
        if (is_null($column_name)) {
            $column_name = Attributes::PROVIDER;
        }
        $this->crud->addColumn([
            Attributes::NAME => $column_name,
            Attributes::LABEL => $label,
            Attributes::PRIORITY => $priority
        ]);
    }
    /**
     * Add Is Popular Column
     * @param null $label
     * @param int $priority
     * @param string $column_name
     */
    function addIsPopularColumn($label = null, $priority = 1, $column_name = Attributes::IS_POPULAR)
    {
        if (is_null($label)) {
            $label = "Is Popular";
        }
        if (is_null($column_name)) {
            $column_name = Attributes::IS_POPULAR;
        }
        $this->crud->addColumn([
            Attributes::NAME => $column_name,
            Attributes::LABEL => $label,
            Attributes::PRIORITY => $priority
        ]);
    }
    /**
     * Add Gender Column
     * @param null $label
     * @param int $priority
     * @param string $column_name
     */
    function addGenderColumn($label = null, $priority = 1, $column_name = Attributes::GENDER)
    {
        if (is_null($label)) {
            $label = "Gender";
        }
        if (is_null($column_name)) {
            $column_name = Attributes::GENDER;
        }
        $this->crud->addColumn([
            Attributes::NAME => $column_name,
            Attributes::LABEL => $label,
            Attributes::PRIORITY => $priority
        ]);
    }

    /**
     * Add Relationship Column
     * @param null $label
     * @param int $priority
     * @param string $column_name
     */
    function addRelationshipColumn($label = null, $priority = 1, $column_name = Attributes::RELATIONSHIP)
    {
        if (is_null($label)) {
            $label = "Relationship";
        }
        if (is_null($column_name)) {
            $column_name = Attributes::RELATIONSHIP;
        }
        $this->crud->addColumn([
            Attributes::NAME => $column_name,
            Attributes::LABEL => $label,
            Attributes::PRIORITY => $priority
        ]);
    }
    /**
     * Add Phone Number AND COUNTRY CODE Column
     * @param null $label
     * @param int $priority
     * @param string $column_name
     */
    function addNumberColumn($label = null, $priority = 1, $column_name = Attributes::PHONE_NUMBER)
    {
        if (is_null($label)) {
            $label = "Phone Number";
        }
        if (is_null($column_name)) {
            $column_name = Attributes::PHONE_NUMBER;
        }
        $this->crud->addColumn([
            Attributes::NAME => $column_name,
            Attributes::LABEL => $label,
            Attributes::PRIORITY => $priority
        ]);
    }
    /**
     * Add Name Column
     * @param null $label
     * @param int $priority
     * @param string $column_name
     */
    function addQuestionColumn($label = null, $priority = 1, $column_name = Attributes::QUESTION)
    {
        if (is_null($label)) {
            $label = "Question";
        }
        $this->crud->addColumn([
            Attributes::NAME => $column_name,
            Attributes::LABEL => $label,
            Attributes::PRIORITY => $priority
        ]);
    }

    /**
     * Add Image Column
     * @param string|null $label
     * @param int $priority
     * @param string $column_name
     */
    function addImageColumn($label = null, $priority = 1, $column_name = Attributes::IMAGE)
    {
        if (is_null($label)) {
            $label = "Image";
        }
        $this->crud->addColumn([
            Attributes::NAME => $column_name,
            Attributes::LABEL => $label,
            Attributes::PRIORITY => $priority
        ]);
    }

    /**
     * Add Cake Category Column
     * @param string|null $label
     * @param int $priority
     * @param string $column_name
     */
    function addCakeCategoryColumn($label = null, $priority = 1, $column_name = Attributes::IMAGE)
    {
        if (is_null($label)) {
            $label ="Category";
        }
        $this->crud->addColumn([
            Attributes::NAME => $column_name,
            Attributes::LABEL => $label,
            Attributes::PRIORITY => $priority
        ]);
    }


    /**
     * Add Offer Column
     * @param string|null $label
     * @param int $priority
     * @param string $column_name
     */
    function addOfferColumn($label = null, $priority = 1, $column_name = Attributes::OFFER)
    {
        if (is_null($label)) {
            $label ="Offer";
        }
        $this->crud->addColumn([
            Attributes::NAME => $column_name,
            Attributes::LABEL => $label,
            Attributes::PRIORITY => $priority
        ]);
    }

    /**
     * Add Promotion Type Column
     * @param string|null $label
     * @param int $priority
     * @param string $column_name
     */
    function addPromotionTypeColumn($label = null, $priority = 1, $column_name = Attributes::TYPE)
    {
        if (is_null($label)) {
            $label ="Type";
        }
        $this->crud->addColumn([
            Attributes::NAME => $column_name,
            Attributes::LABEL => $label,
            Attributes::PRIORITY => $priority
        ]);
    }
    /**
     * Add Promotion AND Workshop Date Column
     * @param string|null $label
     * @param int $priority
     * @param string $column_name
     */
    function addDateColumn($label = null, $priority = 1, $column_name = Attributes::DATE)
    {
        if (is_null($label)) {
            $label ="Date";
        }
        $this->crud->addColumn([
            Attributes::NAME => $column_name,
            Attributes::LABEL => $label,
            Attributes::PRIORITY => $priority
        ]);
    }
    /**
     * Add Promotion Date Column
     * @param string|null $label
     * @param int $priority
     * @param string $column_name
     */

    /**
     * Add Promotion Code Column
     * @param string|null $label
     * @param int $priority
     * @param string $column_name
     */
    function addPromotionCodeColumn($label = null, $priority = 1, $column_name = Attributes::CODE)
    {
        if (is_null($label)) {
            $label ="Code";
        }
        $this->crud->addColumn([
            Attributes::NAME => $column_name,
            Attributes::LABEL => $label,
            Attributes::PRIORITY => $priority,
        ]);
    }
    /**
     * Add Price  Column for Workshop
     * @param string|null $label
     * @param int $priority
     * @param string $column_name
     */
    function addPriceColumn($label = null, $priority = 1, $column_name = Attributes::PRICE)
    {
        if (is_null($label)) {
            $label ="Price";
        }
        $this->crud->addColumn([
            Attributes::NAME => $column_name,
            Attributes::LABEL => $label,
            Attributes::PRIORITY => $priority,
        ]);
    }

    /**
     * Add Total Price Column for Workshop
     * @param string|null $label
     * @param int $priority
     * @param string $column_name
     */
    function addTotalPriceColumn($label = null, $priority = 1, $column_name = Attributes::TOTAL_PRICE)
    {
        if (is_null($label)) {
            $label ="Total Price";
        }
        $this->crud->addColumn([
            Attributes::NAME => $column_name,
            Attributes::LABEL => $label,
            Attributes::PRIORITY => $priority,
        ]);
    }
    /**
     * Add ID  Column for Review table
     * @param string|null $label
     * @param int $priority
     * @param string $column_name
     */
    function addIDColumn($label = null, $priority = 1, $column_name = Attributes::USER_ID)
    {
        if (is_null($label)) {
            $label ="User ID";
        }
        $this->crud->addColumn([
            Attributes::NAME => $column_name,
            Attributes::LABEL => $label,
            Attributes::PRIORITY => $priority,
        ]);
    }
    /**
     * Add rating  Column for Review
     * @param string|null $label
     * @param int $priority
     * @param string $column_name
     */
    function addRatingColumn($label = null, $priority = 1, $column_name = Attributes::RATING)
    {
        if (is_null($label)) {
            $label ="Rating";
        }
        $this->crud->addColumn([
            Attributes::NAME => $column_name,
            Attributes::LABEL => $label,
            Attributes::PRIORITY => $priority,
        ]);
    }
    /**
     * Add Posted At Column
     * @param string|null $label
     * @param int $priority
     * @param string $column_name
     */
    function addPostedAtColumn($label = null, $priority = 1, $column_name = Attributes::POSTED_AT)
    {
        if (is_null($label)) {
            $label ="Posted At";
        }
        $this->crud->addColumn([
            Attributes::NAME => $column_name,
            Attributes::LABEL => $label,
            Attributes::PRIORITY => $priority
        ]);
    }

    /**
     * Add Order Column
     * @param string|null $label
     * @param int $priority
     * @param string $column_name
     */
    function addOrder($label = null, $priority = 1, $column_name = Attributes::ORDER)
    {
        if (is_null($label)) {
            $label = "Order";
        }
        $this->crud->addColumn([
            Attributes::NAME => $column_name,
            Attributes::LABEL => $label,
            Attributes::PRIORITY => $priority,
        ]);
    }

    /**
     * Add Location Text Column
     * @param string|null $label
     * @param int $priority
     * @param string $column_name
     */
    function addLocationTextColumn($label = null, $priority = 1, $column_name = Attributes::LOCATION_TEXT)
    {
        if (is_null($label)) {
            $label = "Location Text";
        }
        $this->crud->addColumn([
            Attributes::NAME => $column_name,
            Attributes::LABEL => $label,
            Attributes::PRIORITY => $priority
        ]);
    }

    /**
     * Add Location link Column
     * @param string|null $label
     * @param int $priority
     * @param string $column_name
     */
    function addLocationLinkColumn($label = null, $priority = 1, $column_name = Attributes::LOCATION_LINK)
    {
        if (is_null($label)) {
            $label = "Location Link";
        }
        $this->crud->addColumn([
            Attributes::NAME => $column_name,
            Attributes::LABEL => $label,
            Attributes::PRIORITY => $priority
        ]);
    }

   /**
     * Add Content Column
     * @param string|null $label
     * @param int $priority
     * @param string $column_name
     */
    function addContentColumn($label = null, $priority = 1, $column_name = Attributes::CONTENT)
    {
        if (is_null($label)) {
            $label = "Content";
        }
        $this->crud->addColumn([
            Attributes::NAME => $column_name,
            Attributes::LABEL => $label,
            Attributes::PRIORITY => $priority
        ]);
    }


    /**
     * Add Answer Column
     * @param string|null $label
     * @param int $priority
     * @param string $column_name
     */
    function addAnswerColumn($label = null, $priority = 1, $column_name = Attributes::ANSWER)
    {
        if (is_null($label)) {
            $label = "Answer";
        }
        $this->crud->addColumn([
            Attributes::NAME => $column_name,
            Attributes::LABEL => $label,
            Attributes::PRIORITY => $priority
        ]);
    }



    /**
     * Add Comments Column
     * @param string|null $label
     * @param int $priority
     * @param string $column_name
     */

    function addCommentsColumn($label = null, $priority = 1, $column_name = Attributes::COMMENTS)
    {
        if (is_null($label)) {
            $label = "Additional Comments";
        }
        $this->crud->addColumn([
            Attributes::NAME => $column_name,
            Attributes::LABEL => $label,
            Attributes::PRIORITY => $priority
        ]);
    }

    /**
     * Add Past Experience Column
     * @param string|null $label
     * @param int $priority
     * @param string $column_name
     */

    function addPastExperienceColumn($label = null, $priority = 1, $column_name = Attributes::PAST_EXPERIENCE)
    {
        if (is_null($label)) {
            $label = "Past Experience";
        }
        if (is_null($column_name)) {
            $column_name = Attributes::PAST_EXPERIENCE;
        }
        $this->crud->addColumn([
            Attributes::NAME => $column_name,
            Attributes::LABEL => $label,
            Attributes::PRIORITY => $priority
        ]);
    }
    /**
     * Add Custom Backdrop Column
     * @param string|null $label
     * @param int $priority
     * @param string $column_name
     */
    function addCustomBackdropColumn($label = null, $priority = 1, $column_name = Attributes::CUSTOM_BACKDROP)
    {
        if (is_null($label)) {
            $label = "Custom Backdrop";
        }
        $this->crud->addColumn([
            Attributes::NAME => $column_name,
            Attributes::LABEL => $label,
            Attributes::PRIORITY => $priority
        ]);
    }

    /**
     * Add Custom Cake Column
     * @param string|null $label
     * @param int $priority
     * @param string $column_name
     */
    function addCustomCakeColumn($label = null, $priority = 1, $column_name = Attributes::CUSTOM_CAKE)
    {
        if (is_null($label)) {
            $label = "Custom Cake";
        }
        $this->crud->addColumn([
            Attributes::NAME => $column_name,
            Attributes::LABEL => $label,
            Attributes::PRIORITY => $priority
        ]);
    }

    /**
     * Add Type Column For Session Packages
     * @param string $attribute
     * @param int $priority
     */
    function addTypeColumn($attribute = Attributes::TYPE, $priority = 1,$label = Attributes::TYPE)
    {
        $this->crud->addColumn([
            Attributes::NAME => $attribute,
            Attributes::LABEL => $label,
            Attributes::PRIORITY => $priority
        ]);
    }

    /**
     * Add Status Column
     * @param string $attribute
     * @param int $priority
     */
    function addStatusColumn($attribute = Attributes::STATUS, $priority = 1)
    {
        $this->crud->addColumn([
            Attributes::NAME => $attribute,
            Attributes::LABEL => "Status",
            Attributes::PRIORITY => $priority
        ]);
    }

    /**
     * Add Status Column
     * @param string $attribute
     * @param int $priority
     */
    function addSectionTypeColumn($attribute = Attributes::TYPE, $priority = 1)
    {
        $this->crud->addColumn([
            Attributes::NAME => $attribute,
            Attributes::LABEL => "Type",
            Attributes::PRIORITY => $priority
        ]);
    }

    /**
     * Add Status Column
     * @param string $attribute
     * @param int $priority
     */
    function addStudioMetadataColumn($attribute = Attributes::CATEGORY, $priority = 1)
    {
        $this->crud->addColumn([
            Attributes::NAME => $attribute,
            Attributes::LABEL => "Category",
            Attributes::PRIORITY => $priority
        ]);
    }

    /**
     * Add Session Status Column
     * @param string $attribute
     * @param int $priority
     */
    function addSessionStatusColumn($attribute = Attributes::SESSION_STATUS, $priority = 1)
    {
        $this->crud->addColumn([
            Attributes::NAME => $attribute,
            Attributes::LABEL => "Session Status",
            Attributes::PRIORITY => $priority
        ]);
    }

    /**
     * Add Image Field
     * @param null $field_name
     * @param null $label
     * @param array $limit
     * @param false $disabled
     */
    function addImageField($field_name = null, $label = null, $limit = [], $disabled = false)
    {
        if (is_null($field_name)) {
            $field_name = Attributes::NAME;
        }
        if (is_null($label)) {
            $label = "Title";
        }
        if(!is_array($limit)){
            $limit = [
                Attributes::MAXLENGTH => $limit
            ];
        }
        CRUD::addField([
            Attributes::NAME => $field_name,
            Attributes::TYPE => FieldTypes::TEXT,
            Attributes::LABEL => ucwords($label),
            Attributes::ATTRIBUTES => array_merge($limit) + $this->disabled($disabled),

        ]);
    }

    /**
     * Add Type Field for session package
     * @param null $statuses
     * @param null $attribute_name
     * @param null $label
     * @param null $tab_name
     * @param false $allow_null
     */
    function addPackageTypeField($statuses = null, $attribute_name = null, $label = null, $tab_name = null, $allow_null = false)
    {
        if (is_null($statuses)) {
            $statuses = SessionPackageTypes::all();
        }
        if (is_null($attribute_name)) {
            $attribute_name = Attributes::TYPE;
        }
        if (is_null($label)) {
            $label = ucfirst(Attributes::TYPE);
        }
        CRUD::addField([
            Attributes::LABEL => $label,
            Attributes::NAME => $attribute_name,
            Attributes::ALLOWS_NULL => $allow_null,
            Attributes::TYPE => FieldTypes::SELECT2_FROM_ARRAY,
            Attributes::OPTIONS => $statuses,
            Attributes::TAB => $tab_name,
        ]);
    }

    /**
     * Add Is Popular Field for session package
     * @param null $statuses
     * @param null $attribute_name
     * @param null $label
     * @param null $tab_name
     * @param false $allow_null
     */
    function addIsPopularField($statuses = null, $attribute_name = null, $label = null, $tab_name = null, $allow_null = false)
    {
        if (is_null($statuses)) {
            $statuses = IsPopular::all();
        }
        if (is_null($attribute_name)) {
            $attribute_name = Attributes::IS_POPULAR;
        }
        if (is_null($label)) {
            $label = ucfirst(Attributes::IS_POPULAR);
        }
        CRUD::addField([
            Attributes::LABEL => $label,
            Attributes::NAME => $attribute_name,
            Attributes::ALLOWS_NULL => $allow_null,
            Attributes::TYPE => FieldTypes::SELECT2_FROM_ARRAY,
            Attributes::OPTIONS => $statuses,
            Attributes::TAB => $tab_name,
        ]);
    }

    /**
     * Add Location Field for text and link
     * @param string|null $field_name
     * @param string|null $label
     * @param string|null $tab_name
     * @param array $limit
     * @param bool $disabled
     */
    function addLocationField($field_name = null, $label = null, $tab_name = null, $limit = [], $disabled = false)
    {
        if (is_null($field_name)) {
            $field_name = Attributes::LOCATION_TEXT;
        }
        if (is_null($label)) {
            $label = "Location Text";
        }
        if(!is_array($limit)){
            $limit = [
                Attributes::MAXLENGTH => $limit
            ];
        }
        CRUD::addField([
            Attributes::NAME => $field_name,
            Attributes::TYPE => FieldTypes::URL,
            Attributes::LABEL => ucwords($label),
            Attributes::ATTRIBUTES => array_merge([
                ], $limit) + $this->disabled($disabled),
            Attributes::TAB => $tab_name
        ]);
    }
    /**
     * Add Text Field
     * @param string $label
     * @param string $name
     * @param bool $disabled
     */
    function addTextField( $name, $label, $disabled = false)
    {
        CRUD::addField([
            Attributes::LABEL => $label,
            Attributes::NAME => $name,
            Attributes::TYPE => FieldTypes::TEXT,
            Attributes::ATTRIBUTES => $this->disabled($disabled),
        ]);
    }

    /**
     * Disabled
     * @param boolean $is_disabled
     * @return array
     */
    function disabled($is_disabled = false){
        if($is_disabled){
            return [
                'readonly' => 'readonly',
                'disabled' => 'disabled',
            ];
        }
        return [];
    }
}
