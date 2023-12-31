<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Attributes;
use App\Constants\Days;
use App\Constants\FieldTypes;
use App\Constants\Gender;
use App\Constants\Guideline;
use App\Constants\IsPopular;
use App\Constants\LoginProvider;
use App\Constants\QuestionType;
use App\Constants\Relationship;
use App\Constants\SectionTypes;
use App\Constants\SessionPackageTypes;
use App\Constants\Status;
use App\Constants\StudioCategory;
use App\Models\BackdropCategory;
use App\Models\CakeCategory;
use App\Models\FeedbackQuestion;
use App\Models\Helpers;
use App\Models\Media;
use App\Models\Package;
use App\Models\PackageBenefit;
use App\Models\Photographer;
use App\Models\User;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\FetchOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\InlineCreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Prologue\Alerts\Facades\Alert;

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
        if (!is_array($limit)) {
            $limit = [
                Attributes::MAXLENGTH => $limit
            ];
        }
        CRUD::addField([
            Attributes::NAME => $field_name,
            Attributes::TYPE => FieldTypes::TEXT,
            Attributes::LABEL => ucwords($label),
            Attributes::ATTRIBUTES => array_merge([], $limit) + $this->disabled($disabled),
            Attributes::TAB => $tab_name
        ]);
    }

    function addColumnWithSearchLogic($label = null, $attribute_name = null, $search_logic = null, $search_column = null, $model = null)
    {
        if (is_null($label)) {
            $label = "Name";
        }
        if (is_null($attribute_name)) {
            $attribute_name = Attributes::NAME;
        }
        if (!is_null($search_logic)) {
            $this->crud->addColumn([
                Attributes::LABEL => $label,
                Attributes::NAME => $attribute_name,
                Attributes::SEARCH_LOGIC => function ($query, $column, $searchTerm) use (&$search_logic, $search_column, $model) {
                    $entry = $model::query()->where($search_column, 'like', '%' . $searchTerm . '%')->pluck('id')->all();
                    $query->orWhereIn($search_logic, $entry);
                }
            ]);
        } else {
            $this->crud->addColumn([
                Attributes::LABEL => $label,
                Attributes::NAME => $attribute_name,
            ]);
        }

    }

    /**
     * Add Icon Field
     * @param string|null $field_name
     * @param string|null $label
     * @param string|null $tab_name
     * @param array $limit
     * @param bool $disabled
     */
    function addIconField($field_name = null, $label = null, $tab_name = null, $limit = [], $disabled = false)
    {
        if (is_null($field_name)) {
            $field_name = Attributes::ICON;
        }
        if (is_null($label)) {
            $label = "Icon";
        }
        if (!is_array($limit)) {
            $limit = [
                Attributes::MAXLENGTH => $limit
            ];
        }
        CRUD::addField([
            Attributes::NAME => $field_name,
            Attributes::TYPE => FieldTypes::ICON_PICKER,
            Attributes::LABEL => ucwords($label),
            Attributes::ICONSET => "materialdesign",
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
        if (!is_array($limit)) {
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
     * Add Number Field
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
        if (!is_array($limit)) {
            $limit = [
                Attributes::MAXLENGTH => $limit
            ];
        }
        CRUD::addField([
            Attributes::NAME => $field_name,
            Attributes::TYPE => FieldTypes::NUMBER,
            Attributes::LABEL => ucwords($label),
            Attributes::ATTRIBUTES => array_merge([], $limit) + $this->disabled($disabled),
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
        if (!is_array($limit)) {
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
        if (!is_array($limit)) {
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
     * Add Session Detail Field
     */
    function addSessionDetailField($name, $label, $item_label, $model, $model_attribute = Attributes::TITLE)
    {

        CRUD::addField([
            Attributes::NAME => $name,
            Attributes::LABEL => $label,
            Attributes::TYPE => 'repeatable',
            Attributes::FAKE => true,
            Attributes::FIELDS => [
                [
                    Attributes::LABEL => $item_label, // Table column heading
                    Attributes::TYPE => FieldTypes::SELECT2,
                    Attributes::NAME => Attributes::ID, // the column that contains the ID of that connected entity;
                    Attributes::ATTRIBUTE => $model_attribute, // foreign key attribute that is shown to user
                    Attributes::MODEL => $model, // foreign key model
                ],
            ]
        ]);

    }


    /**
     * Add Hidden Field
     */
    function addHiddenField($name, $value)
    {

        CRUD::addField(
            [   // Hidden
                Attributes::NAME => $name,
                Attributes::TYPE => FieldTypes::HIDDEN,
                Attributes::VALUE => $value,
            ]
        );

    }


    /**
     * Add Session Detail Field from Array
     */
    function addSessionDetailFieldFromArray($name, $label, $item_label, $attribute_name, $options, $allow_null = false)
    {

        CRUD::addField([
            Attributes::NAME => $name,
            Attributes::LABEL => $label,
            Attributes::TYPE => 'repeatable',
            Attributes::FIELDS => [
                [
                    Attributes::LABEL => $item_label,
                    Attributes::NAME => $attribute_name,
                    Attributes::ALLOWS_NULL => $allow_null,
                    Attributes::TYPE => FieldTypes::SELECT2_FROM_ARRAY,
                    Attributes::OPTIONS => $options,
                ],
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
    function addDescriptionField($name = null, $label = null, $tab_name = null, $field_type = FieldTypes::TEXTAREA, $rows = 5, $limit = [], $hint = null)
    {
        if (is_null($name)) {
            $name = Attributes::DESCRIPTION;
        }
        if (is_null($label)) {
            $label = ucwords(Attributes::DESCRIPTION);
        }
        if (!is_array($limit)) {
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
            'options' => [
                Attributes::DIR => Attributes::LTR,
                "language" => 'en',
//                'removePlugins' => 'embed,Embed',
//                'removeButtons'        => 'Source,Save,Templates,NewPage,ExportPdf,Preview,Print,Cut,Undo,Find,Replace,SelectAll,Scayt,Form,Checkbox,Redo,PasteText,PasteFromWord,About,Maximize,ShowBlocks,BGColor,Styles,TextColor,Format,Font,FontSize,Image,CopyFormatting,NumberedList,Outdent,Blockquote,JustifyLeft,RemoveFormat,Indent,BulletedList,Underline,Strike,Subscript,Superscript,CreateDiv,JustifyCenter,Flash,Table,Anchor,Language,JustifyBlock,JustifyRight,HorizontalRule,Smiley,SpecialChar,PageBreak,Iframe,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Italic,Bold',
            ]
        ]);
    }

    /**
     * Add Password Field
     */
    function addPasswordField()
    {
        CRUD::addField([
            Attributes::NAME => Attributes::PASSWORD,
            Attributes::TYPE => FieldTypes::TEXT,
            Attributes::LABEL => "Password",
        ]);
    }

    /**
     * Add Details Field
     * @param string|null $name
     * @param string|null $label
     * @param string|null $tab_name
     * @param string $field_type
     * @param int $rows
     * @param integer|array $limit
     */
    function addDetailsField($name = null, $label = null, $tab_name = null, $field_type = FieldTypes::TEXTAREA, $rows = 5, $limit = [], $hint = null)
    {
        if (is_null($name)) {
            $name = Attributes::DETAILS;
        }
        if (is_null($label)) {
            $label = ucwords(Attributes::DETAILS);
        }
        if (!is_array($limit)) {
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
            'options' => [
                Attributes::DIR => Attributes::LTR,
                "language" => 'en',
//                'removePlugins' => 'embed,Embed',
//                'removeButtons'        => 'Source,Save,Templates,NewPage,ExportPdf,Preview,Print,Cut,Undo,Find,Replace,SelectAll,Scayt,Form,Checkbox,Redo,PasteText,PasteFromWord,About,Maximize,ShowBlocks,BGColor,Styles,TextColor,Format,Font,FontSize,Image,CopyFormatting,NumberedList,Outdent,Blockquote,JustifyLeft,RemoveFormat,Indent,BulletedList,Underline,Strike,Subscript,Superscript,CreateDiv,JustifyCenter,Flash,Table,Anchor,Language,JustifyBlock,JustifyRight,HorizontalRule,Smiley,SpecialChar,PageBreak,Iframe,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Italic,Bold',
            ]

        ]);
    }

    /**
     * Add Example Field
     * @param string|null $name
     * @param string|null $label
     * @param string|null $tab_name
     * @param string $field_type
     * @param int $rows
     * @param integer|array $limit
     */
    function addExampleField($name = null, $label = null, $tab_name = null, $field_type = FieldTypes::TEXTAREA, $rows = 5, $limit = [], $hint = null)
    {
        if (is_null($name)) {
            $name = Attributes::EXAMPLE;
        }
        if (is_null($label)) {
            $label = ucwords(Attributes::EXAMPLE);
        }
        if (!is_array($limit)) {
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
            'options' => [
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
        if (!is_array($limit)) {
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
            'options' => [
                Attributes::DIR => Attributes::LTR,
                "language" => 'en',
//                'removePlugins' => 'embed,Embed',
//                'removeButtons'        => 'Source,Save,Templates,NewPage,ExportPdf,Preview,Print,Cut,Undo,Find,Replace,SelectAll,Scayt,Form,Checkbox,Redo,PasteText,PasteFromWord,About,Maximize,ShowBlocks,BGColor,Styles,TextColor,Format,Font,FontSize,Image,CopyFormatting,NumberedList,Outdent,Blockquote,JustifyLeft,RemoveFormat,Indent,BulletedList,Underline,Strike,Subscript,Superscript,CreateDiv,JustifyCenter,Flash,Table,Anchor,Language,JustifyBlock,JustifyRight,HorizontalRule,Smiley,SpecialChar,PageBreak,Iframe,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Italic,Bold',
            ]

        ]);
    }


    /**
     * Add Time Field
     * @param string|null $label
     * @param string|null $field_name
     */
    function addTimeField($label = null, $field_name = null)
    {
        if (is_null($label)) {
            $label = "Time";
        }

        if (is_null($field_name)) {
            $field_name = Attributes::TIME;
        }

        CRUD::addField([
            Attributes::NAME => $field_name,
            Attributes::TYPE => FieldTypes::TIME,
            Attributes::LABEL => $label,
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
        if (!is_array($limit)) {
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
            'options' => [
                Attributes::DIR => Attributes::LTR,
                "language" => 'en',
//                'removePlugins' => 'embed,Embed',
//                'removeButtons'        => 'Source,Save,Templates,NewPage,ExportPdf,Preview,Print,Cut,Undo,Find,Replace,SelectAll,Scayt,Form,Checkbox,Redo,PasteText,PasteFromWord,About,Maximize,ShowBlocks,BGColor,Styles,TextColor,Format,Font,FontSize,Image,CopyFormatting,NumberedList,Outdent,Blockquote,JustifyLeft,RemoveFormat,Indent,BulletedList,Underline,Strike,Subscript,Superscript,CreateDiv,JustifyCenter,Flash,Table,Anchor,Language,JustifyBlock,JustifyRight,HorizontalRule,Smiley,SpecialChar,PageBreak,Iframe,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Italic,Bold',
            ]

        ]);
    }

    /**
     * Add cake Category Column
     * @param string|null $label
     * @param int $priority
     * @param string $column_name
     */

    function addCakeCategoryColumn($label = null, $priority = 1, $column_name = Attributes::IMAGE)
    {
        if (is_null($label)) {
            $label = "Category";
        }
        $this->crud->addColumn([
            Attributes::NAME => $column_name,
            Attributes::LABEL => $label,
            Attributes::PRIORITY => $priority
        ]);
    }

    /**
     * Add Column
     * @param $column_name
     * @param $label
     */
    function addColumn($column_name, $label)
    {
        $this->crud->addColumn([
            Attributes::NAME => $column_name,
            Attributes::LABEL => $label,
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
        if (!is_array($limit)) {
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
            'options' => [
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
    function addTagCategoryField($field_name = null, $label = null)
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
    function addOfferField($field_name = null, $label = null)
    {
        if (is_null($field_name)) {
            $field_name = Attributes::OFFER;
        }
        CRUD::addField([
            Attributes::LABEL => is_null($label) ? "Offer" : ucwords($label),
            Attributes::NAME => Attributes::OFFER,
            Attributes::TYPE => FieldTypes::NUMBER,
        ]);
    }

    /**
     * Add Promotion Type Field
     */
    function addPromotionTypeField($field_name = null, $label = null)
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
    function addPromotionCodeField($field_name = null, $label = null)
    {
        if (is_null($field_name)) {
            $field_name = Attributes::PROMO_CODE;
        }
        CRUD::addField([
            Attributes::LABEL => is_null($label) ? "Promo Code" : ucwords($label),
            Attributes::NAME => Attributes::PROMO_CODE,
            Attributes::TYPE => FieldTypes::TEXT,

        ]);
    }

    /**
     * Add Price Field for workshop
     */
    function addPriceField($field_name = null, $label = null)
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
    function addRatingField($field_name = null, $label = null)
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
    function addDateField($field_name = null, $label = null)
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
    function addPostedAtField($field_name = null, $label = null)
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
    function addValidUntilField($field_name = null, $label = null)
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
            Attributes::DEFAULT => 1,
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
        ], $statuses, function ($value) use ($column_name) {
            $this->crud->addClause('where', $column_name, $value);
        });
    }

    function addCustomCategoryFilter($attribute_name = Attributes::CATEGORY, $label = 'Category', $model = BackdropCategory::class, $clause = Attributes::CATEGORY_ID)
    {
        $this->crud->addFilter([
            Attributes::TYPE => FieldTypes::DROPDOWN,
            Attributes::NAME => $attribute_name,
            Attributes::LABEL => $label,
        ], $model::all()->pluck('name', 'id')->toArray(), function ($value) use ($clause) {
            $this->crud->addClause('where', $clause, $value);
        });
    }

    function addPackageIdFilter($attribute_name = Attributes::PACKAGE_NAME, $label = 'Package Name', $model = Package::class, $clause = Attributes::PACKAGE_ID)
    {
        $this->crud->addFilter([
            Attributes::TYPE => FieldTypes::DROPDOWN,
            Attributes::NAME => $attribute_name,
            Attributes::LABEL => $label,
        ], $model::all()->pluck('title', 'id')->toArray(), function ($value) use ($clause) {
            $this->crud->addClause('where', $clause, $value);
        });
    }

    function addPhotographerFilter($attribute_name = Attributes::PHOTOGRAPHER, $label = "Photographer", $model = Photographer::class, $clause = Attributes::PHOTOGRAPHER)
    {
        $this->crud->addFilter([
            Attributes::TYPE => FieldTypes::DROPDOWN,
            Attributes::NAME => $attribute_name,
            Attributes::LABEL => $label,
        ], $model::all()->pluck('name', 'id')->toArray(), function ($value) use ($clause) {
            $this->crud->addClause('where', $clause, $value);
        });
    }

    /**
     * Add Question Type Filter Field
     */
    function addQuestionTypeFilter($Types = null, $column_name = Attributes::QUESTION_TYPE, $label = "Status")
    {
        if (is_null($Types)) {
            $Types = QuestionType::all();
        }
        if (is_null($column_name)) {
            $column_name = Attributes::QUESTION_TYPE;
        }
        $this->crud->addFilter([
            Attributes::TYPE => FieldTypes::DROPDOWN,
            Attributes::NAME => $column_name,
            Attributes::LABEL => $label
        ], $Types, function ($value) use ($column_name) {
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
        ], $Genders, function ($value) use ($column_name) {
            $this->crud->addClause('where', $column_name, $value);
        });
    }

    /**
     * Add LoginProvider Filter
     * @param null $providers
     * @param string $column_name
     * @param string $label
     */
    function addLoginProviderFilter($providers = null, $column_name = Attributes::PROVIDER, $label = "Provider")
    {
        if (is_null($providers)) {
            $providers = LoginProvider::all();
        }
        $this->crud->addFilter([
            Attributes::TYPE => FieldTypes::DROPDOWN,
            Attributes::NAME => $column_name,
            Attributes::LABEL => $label
        ], $providers, function ($value) use ($column_name) {
            $this->crud->addClause('where', $column_name, $value);
        });
    }

    /**
     * Add Relationship Filter Field
     */
    function addRelationshipFilter($Relationship = null, $column_name = Attributes::RELATIONSHIP, $label = "Relationship")
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
        ], $Relationship, function ($value) use ($column_name) {
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
        ], $statuses, function ($value) use ($column_name) {
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
        ], $statuses, function ($value) use ($column_name) {
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
        ], $statuses, function ($value) use ($column_name) {
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
        ], $statuses, function ($value) use ($column_name) {
            $this->crud->addClause('where', $column_name, $value);
        });
    }

    /**
     * Add Repeatable Days Field
     */
    function addRepeatableDaysField()
    {

        CRUD::addField([
            Attributes::LABEL => 'Hours',
            Attributes::NAME => Attributes::HOURS,
            'type' => 'repeatable',
            'fields' => [
                [
                    Attributes::LABEL => "Day",
                    Attributes::NAME => Attributes::DAY_ID,
                    Attributes::ALLOWS_NULL => false,
                    Attributes::TYPE => FieldTypes::SELECT2_FROM_ARRAY,
                    Attributes::OPTIONS => Days::all(),
                ],
                [
                    Attributes::NAME => Attributes::FROM,
                    Attributes::TYPE => FieldTypes::TIME,
                    Attributes::LABEL => 'From',
                ],
                [
                    Attributes::NAME => Attributes::TO,
                    Attributes::TYPE => FieldTypes::TIME,
                    Attributes::LABEL => 'To',
                ],
            ],

            // optional
            'new_item_label' => 'Add Day', // customize the text of the button
            'init_rows' => 1, // number of empty rows to be initialized, by default 1
            'min_rows' => 1, // minimum rows allowed, when reached the "delete" buttons will be hidden

        ]);

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
     * Boolean Options
     * @return string[]
     */
    function booleanOptions()
    {
        return [
            false => "No",
            true => "Yes"
        ];
    }

    /**
     * Add Chat with Everyone Field
     * @param $attribute_name
     * @return void
     */
    function addChatWithEveryoneField($attribute_name = null)
    {
        CRUD::addField([
            Attributes::LABEL => "Chat with Everyone",
            Attributes::NAME => $attribute_name,
            Attributes::TYPE => FieldTypes::SELECT2_FROM_ARRAY,
            Attributes::OPTIONS => $this->booleanOptions(),
            Attributes::DEFAULT => false
        ]);
    }

    /**
     * Add Firebase Field
     * @param $attribute_name
     * @return void
     */
    function addFirebaseIdField($attribute_name = null)
    {
        CRUD::addField([
            Attributes::LABEL => "Firebase Id",
            Attributes::NAME => $attribute_name,
            Attributes::TYPE => FieldTypes::TEXT,
            Attributes::DEFAULT => null,
            Attributes::ALLOWS_NULL => true
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
     * Add Question Type Field
     * @param null $genders
     * @param null $attribute_name
     * @param null $label
     * @param null $tab_name
     * @param false $allow_null
     */
    function addQuestionTypeField($genders = null, $attribute_name = null, $label = null, $tab_name = null, $allow_null = false)
    {
        /** @var FeedbackQuestion $entry */
        $entry = $this->crud->getCurrentEntry();

        if (is_null($genders)) {
            $genders = QuestionType::all();
        }
        if (is_null($attribute_name)) {
            $attribute_name = Attributes::QUESTION_TYPE;
        }
        if (is_null($label)) {
            $label = ucfirst(Attributes::QUESTION_TYPE);
        }
        CRUD::addField([
            Attributes::LABEL => $label,
            Attributes::NAME => $attribute_name,
            Attributes::ALLOWS_NULL => $allow_null,
            Attributes::TYPE => FieldTypes::SELECT_TOGGLE,
            Attributes::OPTIONS => $genders,
            Attributes::TAB => $tab_name,
            Attributes::HIDE_WHEN => [
                1 => [
                    Attributes::OPTIONS,
                ]
            ]

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
    function addRelationshipField($relationships = null, $name = null, $label = null, $tab_name = null, $allow_null = false, $type = FieldTypes::SELECT2_FROM_ARRAY, $entity = null, $model = null, $attribute = null)
    {

        if (is_null($name)) {
            $name = Attributes::RELATIONSHIP;
        }
        if (is_null($label)) {
            $label = ucfirst(Attributes::RELATIONSHIP);
        }

        CRUD::addField([
            Attributes::LABEL => $label,
            Attributes::NAME => $name,
            Attributes::ALLOWS_NULL => $allow_null,
            Attributes::TYPE => $type,
            Attributes::ENTITY => $entity,
            Attributes::MODEL => $model,
            Attributes::OPTIONS => $relationships,
            Attributes::TAB => $tab_name,
            Attributes::ATTRIBUTE => $attribute,

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
     * Add Details Column
     * @param null $label
     * @param int $priority
     * @param string $column_name
     */
    function addDetailsColumn($label = null, $priority = 1, $column_name = Attributes::DETAILS)
    {
        if (is_null($label)) {
            $label = "Details";
        }
        if (is_null($column_name)) {
            $column_name = Attributes::DETAILS;
        }
        $this->crud->addColumn([
            Attributes::NAME => $column_name,
            Attributes::LABEL => $label,
            Attributes::PRIORITY => $priority
        ]);
    }

    /**
     * Add Example Column
     * @param null $label
     * @param int $priority
     * @param string $column_name
     */
    function addExampleColumn($label = null, $priority = 1, $column_name = Attributes::EXAMPLE)
    {
        if (is_null($label)) {
            $label = "Examples";
        }
        if (is_null($column_name)) {
            $column_name = Attributes::EXAMPLE;
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
     * Add Question Type Column
     * @param null $label
     * @param int $priority
     * @param string $column_name
     */
    function addQuestionTypeColumn($label = null, $priority = 1, $column_name = Attributes::QUESTION_TYPE)
    {
        if (is_null($label)) {
            $label = "Question Type";
        }
        if (is_null($column_name)) {
            $column_name = Attributes::QUESTION_TYPE;
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
    function addQuestionColumn($label = null, $priority = 1, $column_name = Attributes::QUESTION, $limit = 80)
    {
        if (is_null($label)) {
            $label = "Question";
        }
        $this->crud->addColumn([
            Attributes::NAME => $column_name,
            Attributes::LABEL => $label,
            Attributes::PRIORITY => $priority,
            Attributes::LIMIT => $limit,
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
            Attributes::PRIORITY => $priority,
            Attributes::TYPE => Attributes::IMAGE
        ]);
    }

    /**
     * Add Category Column
     * @param string|null $label
     * @param int $priority
     * @param string $column_name
     */
    function addCategoryColumn($label = null, $priority = 1, $column_name = Attributes::CATEGORY)
    {
        if (is_null($label)) {
            $label = "Category";
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
            $label = "Offer";
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
            $label = "Type";
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
            $label = "Date";
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
            $label = "Code";
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
            $label = "Price";
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
            $label = "Total Price";
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
            $label = "User ID";
        }
        $this->crud->addColumn([
            Attributes::NAME => $column_name,
            Attributes::LABEL => $label,
            Attributes::PRIORITY => $priority,
        ]);
    }

    /**
     * Add UserName With Search
     */
    function addUserNameColumn()
    {
        $this->crud->addColumn([
            Attributes::LABEL => 'User Name',
            Attributes::NAME => Attributes::USER_ID,
            Attributes::ENTITY => 'user',
            Attributes::ATTRIBUTE => Attributes::FULL_NAME,
            Attributes::MODEL => "App\Models\User",
            'searchLogic' => function ($query, $column, $searchTerm) {
//                $user = User::where(Attributes::FIRST_NAME, 'like', '%'.$searchTerm.'%')->orWhere(Attributes::LAST_NAME, 'like', '%'.$searchTerm.'%')->pluck('id')->all();
                $user = User::select(Attributes::ID, Attributes::FIRST_NAME, Attributes::LAST_NAME)
                    ->orWhere(DB::raw("concat(" . Attributes::FIRST_NAME . ", ' ', " . Attributes::LAST_NAME . ")"), 'LIKE', "%" . $searchTerm . "%")
                    ->get();
                $query->orWhereIn(Attributes::USER_ID, $user);
            }
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
            $label = "Rating";
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
            $label = "Posted At";
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
     * Add Options Column
     * @param string|null $label
     * @param int $priority
     * @param string $column_name
     */
    function addOptionColumn($label = null, $priority = 1, $column_name = Attributes::OPTIONS)
    {
        if (is_null($label)) {
            $label = "Options";
        }
        if (is_null($column_name)) {
            $column_name = Attributes::OPTIONS;
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
     * Add Icon Column
     * @param string|null $label
     * @param int $priority
     * @param string $column_name
     */
    function addIconColumn($label = null, $priority = 1, $column_name = Attributes::ICON)
    {
        if (is_null($label)) {
            $label = "Icon";
        }
        if (is_null($column_name)) {
            $column_name = Attributes::ICON;
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
     * Add Pro Past Experience Column
     * @param string|null $label
     * @param int $priority
     * @param string $column_name
     */
    function addProPastExperienceColumn(string $label = 'Pro Past Experience', int $priority = 1, string $column_name = Attributes::PRO_PAST_EXPERIENCE)
    {
        $this->crud->addColumn([
            Attributes::NAME => $column_name,
            Attributes::LABEL => $label,
            Attributes::PRIORITY => $priority,
            Attributes::TYPE => Attributes::BOOLEAN,
            Attributes::OPTION => [0 => Attributes::NO, 1 => Attributes::YES]
        ]);
    }

    /**
     * Add Happy Past Experience Column
     * @param string|null $label
     * @param int $priority
     * @param string $column_name
     */
    function addHappyPastExperienceColumn(string $label = 'Happy Past Experience', int $priority = 1, string $column_name = Attributes::HAPPY_PAST_EXPERIENCE)
    {
        $this->crud->addColumn([
            Attributes::NAME => $column_name,
            Attributes::LABEL => $label,
            Attributes::PRIORITY => $priority,
            Attributes::TYPE => Attributes::BOOLEAN,
            Attributes::OPTION => [0 => Attributes::NO, 1 => Attributes::YES]
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
    function addTypeColumn($attribute = Attributes::TYPE, $priority = 1, $label = Attributes::TYPE)
    {
        $this->crud->addColumn([
            Attributes::NAME => $attribute,
            Attributes::LABEL => $label,
            Attributes::PRIORITY => $priority
        ]);
    }

    /**
     * Add Benefits Field
     * @param string|null $TAB_NAME
     */
    function addBenefitsField($tab_name = null)
    {
        CRUD::addField([
            Attributes::TYPE => FieldTypes::RELATIONSHIP,
            Attributes::NAME => Attributes::BENEFITS, // the method on your model that defines the relationship
            Attributes::AJAX => true,
            Attributes::INLINE_CREATE => [Attributes::ENTITY => Attributes::BENEFITS], // specify the entity in singular
            Attributes::TAB => $tab_name,
        ]);
    }

    /**
     * Add Sub Packages Field
     * @param string|null $TAB_NAME
     */
    function addSubPackagesField($tab_name = null)
    {
        // Field: Sub Package
        CRUD::addField([
            Attributes::TYPE => FieldTypes::RELATIONSHIP,
            Attributes::NAME => 'subpackages', // the method on your model that defines the relationship
            Attributes::LABEL => 'Sub Packages', // the method on your model that defines the relationship
            Attributes::AJAX => true,
            Attributes::INLINE_CREATE => [Attributes::ENTITY => 'sub-packages'], // specify the entity in singular
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
    function addReviewStatusColumn($attribute = Attributes::STATUS, $priority = 1)
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
     * Add Can Chat Column
     * @param $attribute
     * @param $priority
     * @return void
     */
    function addChatWithEveryoneColumn($attribute = Attributes::CHAT_WITH_EVERYONE, $priority = 1)
    {
        $this->crud->addColumn([
            Attributes::NAME => $attribute,
            Attributes::LABEL => "Chat with Everyone",
            Attributes::PRIORITY => $priority
        ]);
    }

    /**
     * Add Firebase Id
     * @param $attribute
     * @param $priority
     * @return void
     */
    function addFirebaseIdColumn($attribute = Attributes::FIREBASE_ID, $priority = 1)
    {
        $this->crud->addColumn([
            Attributes::NAME => $attribute,
            Attributes::LABEL => "Firebase Id",
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
        if (!is_array($limit)) {
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
            Attributes::DEFAULT => Guideline::NO,
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
    function addDropdownField($constant = null, $attribute_name = null, $label = null, $tab_name = null, $allow_null = false)
    {
        if (is_null($constant)) {
            $constant = IsPopular::all();
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
            Attributes::OPTIONS => $constant,
            Attributes::TAB => $tab_name,
            Attributes::DEFAULT => Guideline::NO,
        ]);
    }

    /**
     * Add Location Link Field
     * @param string|null $field_name
     * @param string|null $label
     * @param string|null $tab_name
     * @param array $limit
     * @param bool $disabled
     */
    function addLocationField($field_name = null, $label = null, $tab_name = null, $limit = [], $disabled = false)
    {
        if (is_null($field_name)) {
            $field_name = Attributes::LOCATION_LINK;
        }
        if (is_null($label)) {
            $label = "Location Link";
        }
        if (!is_array($limit)) {
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
     * Add Location Text Field
     * @param string|null $field_name
     * @param string|null $label
     * @param string|null $tab_name
     * @param array $limit
     * @param bool $disabled
     */
    function addLocationTextField($field_name = null, $label = null, $tab_name = null, $limit = [], $disabled = false)
    {
        if (is_null($field_name)) {
            $field_name = Attributes::LOCATION_TEXT;
        }
        if (is_null($label)) {
            $label = "Location Text";
        }
        if (!is_array($limit)) {
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
     * Add Text Field
     * @param string $label
     * @param string $name
     * @param bool $disabled
     */
    function addTextField($name, $label, $disabled = false)
    {
        CRUD::addField([
            Attributes::LABEL => $label,
            Attributes::NAME => $name,
            Attributes::TYPE => FieldTypes::TEXT,
            Attributes::ATTRIBUTES => $this->disabled($disabled),
        ]);
    }

    /**
     * @param $name
     * @param $label
     * @param $default
     * @param $disabled
     * @return void
     */
    function addBooleanField($name, $label, $default = 0, $disabled = false)
    {
        CRUD::addField([
            Attributes::LABEL => $label,
            Attributes::NAME => $name,
            Attributes::TYPE => FieldTypes::CHECKBOX,
            Attributes::DEFAULT => $default,
            Attributes::ATTRIBUTES => $this->disabled($disabled),
        ]);
    }


    /**
     * Add Options Field
     * @param string|null $tab_name
     */
    function addOptionsField($tab_name = null)
    {
        CRUD::addField([
            Attributes::TYPE => FieldTypes::REPEATABLE,
            Attributes::LABEL => "Answers",
            Attributes::NAME => "options",
            "visibility" => [
                'field_name' => Attributes::QUESTION_TYPE,
                'value' => 1,
                'add_disabled' => false, // if you need to disable this field value to not be send through create/update request set it to true, otherwise set it to true
            ],
            Attributes::TAB => $tab_name,
            Attributes::FIELDS => [
                [
                    Attributes::NAME => Attributes::ID,
                    Attributes::TYPE => Attributes::HIDDEN,
                ],
                [
                    Attributes::NAME => Attributes::VALUE,
                    Attributes::TYPE => FieldTypes::TEXT,
                ]
            ],
            Attributes::INIT_ROWS => 0, // number of empty rows to be initialized, by default 1


        ]);
    }

    /**
     * Add Categories
     */
    function addCategoriesField()
    {
        CRUD::addField([
            Attributes::LABEL => 'Category', // Table column heading
            Attributes::TYPE => FieldTypes::SELECT2,
            Attributes::NAME => Attributes::CATEGORY_ID, // the column that contains the ID of that connected entity;
            Attributes::ATTRIBUTE => Attributes::NAME, // foreign key attribute that is shown to user
            Attributes::MODEL => BackdropCategory::class, // foreign key model
            Attributes::DEFAULT => BackdropCategory::first(), // foreign key model
        ]);

    }

    /**
     * Add Media Field
     * @param string|null $label
     * @param string|null $tab_name
     */
    function addMediaField($label = null, $tab_name = null)
    {
        if (is_null($label)) {
            $label = "Media";
        }
        CRUD::addField([
            Attributes::TYPE => FieldTypes::MEDIA,
            Attributes::NAME => Attributes::MEDIA,
            Attributes::LABEL => $label,
            Attributes::FAKE => true,
            Attributes::TAB => $tab_name,
        ]);
    }

    function addPhotographerField($label = null, $tab_name = null) {
        if (is_null($label)) {
            $label = "Photographer";
        }
        CRUD::addField([
            Attributes::TYPE => FieldTypes::PHOTOGRAPHER,
            Attributes::NAME => Attributes::PHOTOGRAPHER_ID,
            Attributes::LABEL => $label,
            Attributes::FAKE => true,
            Attributes::TAB => "Photographer",
        ]);
    }

    function addSubPackagePhotographerField($label = null, $tab_name = null) {
        if (is_null($label)) {
            $label = "Photographer";
        }
        CRUD::addField([
            Attributes::TYPE => FieldTypes::SUBPACKAGE_PHOTOGRAPHER,
            Attributes::NAME => Attributes::PHOTOGRAPHER_ID,
            Attributes::LABEL => $label,
            Attributes::FAKE => true,
            Attributes::TAB => "Photographer",
        ]);
    }

    /**
     * Add Cake Category
     */
    function addCakeCategoryField()
    {
        CRUD::addField([
            Attributes::LABEL => 'Category', // Table column heading
            Attributes::TYPE => FieldTypes::SELECT2,
            Attributes::NAME => Attributes::CATEGORY_ID, // the column that contains the ID of that connected entity;
            Attributes::ATTRIBUTE => Attributes::NAME, // foreign key attribute that is shown to user
            Attributes::MODEL => CakeCategory::class, // foreign key model
            Attributes::DEFAULT => CakeCategory::first(), // foreign key model
        ]);

    }

    /**
     * Disabled
     * @param boolean $is_disabled
     * @return array
     */
    function disabled($is_disabled = false)
    {
        if ($is_disabled) {
            return [
                'readonly' => 'readonly',
                'disabled' => 'disabled',
            ];
        }
        return [];
    }

    /**
     * Fetch Benefit
     */
    protected function fetchBenefit()
    {
        return $this->fetch(PackageBenefit::class);
    }


    /**
     * File Upload
     * @param Request $request
     * @return array|RedirectResponse|Response
     */
    public function fileUpload(Request $request)
    {
        $back_url = request()->headers->get(Attributes::REFERER) ?? null;
        $item_id = intval($request->item_id);
        $session_id = is_null($request->session_id) ? null : intval($request->session_id);
        if (!$item_id) {
            return back()->withInput();
        }
        if ($request->hasFile(Attributes::MEDIA)) {
            $files = $request->allFiles()[Attributes::MEDIA];
            foreach ($files as $file) {
                $media = Helpers::uploadFile(null, $file, null, "assets/media", false, true, true, $session_id);
            }
        }

        Alert::success('Media saved for this entry.')->flash();
        return !is_null($back_url) ? Redirect::to($back_url . "#media") : back();
    }


    public function fetchMoreMedia(Request $request)
    {
        if ($request->filled(Attributes::LAST_FETCHED_MEDIA_ID)) {
            $last_media_id = $request->{Attributes::LAST_FETCHED_MEDIA_ID};
            $total = Media::where(Attributes::STATUS, Status::ACTIVE)->where(Attributes::ID, '<', $last_media_id)->count();
            $media = Media::where(Attributes::STATUS, Status::ACTIVE)->where(Attributes::ID, '<', $last_media_id)->take(48)->orderBy(Attributes::CREATED_AT, Attributes::DESC)->select([Attributes::ID, Attributes::URL])->get()->unique()->toArray();
            $data = [];
            $data['has_more_media'] = $total > 48;
            $data['media'] = $media;
            return response()->json($data);
        }

    }

    /**
     * Media
     * @param array $media_ids
     */
    function media($media_ids = [])
    {
        $item_id = $this->crud->getCurrentEntryId();
        $media_ids = collect($media_ids);

        // type
        $type = basename($this->crud->getRoute());
        $model = Helpers::getModel($type);
        $item_primary_column = Helpers::getModelPrimaryColumn($type);
        $relationship_model = Helpers::getModelRelationship($type);

        if (is_null($item_id)) {
            return;
        }
        if (is_null($media_ids) || $media_ids->isEmpty()) {
            $media_ids = $this->crud->getRequest()->get(Attributes::MEDIA_IDS);
        }
        if (is_null($media_ids) || $media_ids->isEmpty()) {
            $relationship_model::where($item_primary_column, $item_id)->delete();
            return;
        }

        // featured image
//        $featured_media_id = intval($media_ids->pull(0));
//        $item = $model::find($item_id);
//        if(!is_null($item)){
//            $relationship_model::createOrUpdate([
//                $item_primary_column => $item_id,
//                Attributes::MEDIA_ID => intval($featured_media_id),
//                Attributes::ORDER => 1
//            ]);
//            $media = Media::find($featured_media_id);
//            if(!is_null($media)){
//                $item->featured_image = $media->path;
//            }
//            $item->featured_image_id = $featured_media_id;
//            $item->save();
//        }

        // other media items
        $count = 2;
        if (!$media_ids->isEmpty()) {
            foreach ($media_ids as $media_id) {
                $relationship_model::createOrUpdate([
                    $item_primary_column => $item_id,
                    Attributes::MEDIA_ID => $media_id,
                    Attributes::ORDER => $count
                ]);
                $count++;
            }
        }
    }
}
