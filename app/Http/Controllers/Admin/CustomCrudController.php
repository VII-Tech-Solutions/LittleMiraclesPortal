<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Attributes;
use App\Constants\FieldTypes;
use App\Constants\Status;
use App\Constants\SessionStatus;
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
     * Add Name Field
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
    * Add Description Field
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
            Attributes::NAME => Attributes::DATE,
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
     * Add Content Column
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
