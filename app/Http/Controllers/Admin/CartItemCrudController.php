<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Attributes;
use App\Constants\StudioCategory;
use App\Http\Requests\CartItemRequest;
use App\Models\Helpers;
use App\Models\StudioMetadata;
use App\Models\StudioPackage;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class CartItemCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CartItemCrudController extends CustomCrudController
{
    use ListOperation;
    use CreateOperation;
    use UpdateOperation;
    use DeleteOperation;
    use ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\CartItem::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/cart-item');
        CRUD::setEntityNameStrings('cart item', 'cart items');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('package_id');
        CRUD::column('package_type');
        CRUD::column('title');
        CRUD::column('description');
        CRUD::column('display_image');
        CRUD::column('media_ids');
        CRUD::column('album_size');
        CRUD::column('spreads');
        CRUD::column('paper_type');
        CRUD::column('cover_type');
        CRUD::column('canvas_size');
        CRUD::column('canvas_type');
        CRUD::column('quantity');
        CRUD::column('print_type');
        CRUD::column('paper_size');
        CRUD::column('additional_comment');
        CRUD::column('status');
        CRUD::column('total_price');
        CRUD::column('user_id');
        CRUD::column('album_title');
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(CartItemRequest::class);

        // Field: Package Type
        $this->addCategoryField(StudioPackage::pluck(Attributes::TITLE, Attributes::ID), Attributes::ALBUM_SIZE, Helpers::readableText(Attributes::ALBUM_SIZE), null, true);

        CRUD::field(Attributes::TITLE);

        CRUD::field('description');

        $this->addBooleanField(Attributes::DISPLAY_IMAGE, Helpers::readableText(Attributes::DISPLAY_IMAGE), null, true);

        CRUD::field('media_ids');

        // Field: Album Size
        $this->addCategoryField(StudioMetadata::where(Attributes::CATEGORY, StudioCategory::ALBUM_SIZE)->pluck(Attributes::TITLE, Attributes::ID), Attributes::ALBUM_SIZE, Helpers::readableText(Attributes::ALBUM_SIZE), null, true);

        // Field: Paper Type
        $this->addCategoryField(StudioMetadata::where(Attributes::CATEGORY, StudioCategory::SPREADS)->pluck(Attributes::TITLE, Attributes::ID), Attributes::SPREADS, Helpers::readableText(Attributes::SPREADS), null, true);

        // Field: Paper Type
        $this->addCategoryField(StudioMetadata::where(Attributes::CATEGORY, StudioCategory::PAPER_TYPE)->pluck(Attributes::TITLE, Attributes::ID), Attributes::PAPER_TYPE, Helpers::readableText(Attributes::PAPER_TYPE), null, true);

        // Field: Cover Type
        $this->addCategoryField(StudioMetadata::where(Attributes::CATEGORY, StudioCategory::COVER_TYPE)->pluck(Attributes::TITLE, Attributes::ID), Attributes::COVER_TYPE, Helpers::readableText(Attributes::COVER_TYPE), null, true);

        // Field: Canvas Size
        $this->addCategoryField(StudioMetadata::where(Attributes::CATEGORY, StudioCategory::CANVAS_SIZE)->pluck(Attributes::TITLE, Attributes::ID), Attributes::CANVAS_SIZE, Helpers::readableText(Attributes::CANVAS_SIZE), null, true);

        CRUD::field('canvas_type');

        CRUD::field('quantity');

        // Field: Print Type
        $this->addCategoryField(StudioMetadata::where(Attributes::CATEGORY, StudioCategory::PRINT_TYPE)->pluck(Attributes::TITLE, Attributes::ID), Attributes::PRINT_TYPE, Helpers::readableText(Attributes::PRINT_TYPE), null, true);

        // Field: Paper Size
        $this->addCategoryField(StudioMetadata::where(Attributes::CATEGORY, StudioCategory::PAPER_SIZE)->pluck(Attributes::TITLE, Attributes::ID), Attributes::PAPER_SIZE, Helpers::readableText(Attributes::PAPER_SIZE), null, true);

        CRUD::field('additional_comment');

        CRUD::field('status');

        CRUD::field('total_price');

        CRUD::field('user_id');

        CRUD::field('album_title');

        // Field: Media
        $this->addMediaField("Media", "Media");

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
}
