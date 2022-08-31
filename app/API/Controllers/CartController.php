<?php

namespace App\API\Controllers;

use App\API\Transformers\ListCartItemsTransformer;
use App\Constants\Attributes;
use App\Constants\CartItemStatus;
use App\Constants\Messages;
use App\Helpers;
use App\Models\CartItem;
use App\Models\Package;
use App\Models\StudioMetadata;
use App\Models\User;
use Dingo\Api\Http\Response;
use Illuminate\Http\JsonResponse;
use VIITech\Helpers\Constants\CastingTypes;
use VIITech\Helpers\GlobalHelpers;

/**
 * Class CartController
 * @package App\API\Controllers
 */
class CartController extends CustomController
{
    public function addCartItem() {
        // get current user
        $user = Helpers::resolveUser();
        if (is_null($user)) {
            return GlobalHelpers::formattedJSONResponse(Messages::PERMISSION_DENIED, null, null, Response::HTTP_UNAUTHORIZED);
        }

        // get parameters
        $package_id = GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::PACKAGE_ID, null, CastingTypes::INTEGER);
        $package_type = GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::PACKAGE_TYPE, null, CastingTypes::INTEGER);
        $title = GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::TITLE, null, CastingTypes::STRING);
        $description = GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::DESCRIPTION, null, CastingTypes::STRING);
        $display_image = GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::DISPLAY_IMAGE, null, CastingTypes::INTEGER);
        $media_ids = GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::DISPLAY_IMAGE, null, CastingTypes::STRING);
        $album_size = GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::ALBUM_SIZE, null, CastingTypes::INTEGER);
        $spreads = GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::SPREADS, null, CastingTypes::INTEGER);
        $paper_type = GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::PAPER_TYPE, null, CastingTypes::INTEGER);
        $cover_type = GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::COVER_TYPE, null, CastingTypes::INTEGER);
        $canvas_size = GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::CANVAS_SIZE, null, CastingTypes::INTEGER);
        $canvas_type = GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::CANVAS_TYPE, null, CastingTypes::INTEGER);
        $quantity = GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::QUANTITY, null, CastingTypes::INTEGER);
        $print_type = GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::PRINT_TYPE, null, CastingTypes::INTEGER);
        $paper_size = GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::PAPER_SIZE, null, CastingTypes::INTEGER);
        $additional_comments = GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::ADDITIONAL_COMMENTS, null, CastingTypes::STRING);

        // calculate total price
        /** @var Package $package */
        $package = Package::find($package_id);
        $specs_price = StudioMetadata::whereIn(Attributes::ID, [$album_size, $spreads, $paper_type, $cover_type, $canvas_size, $paper_size, $print_type])->pluck(Attributes::PRICE)->sum();
        $total_price = ($package->price + $specs_price) * $quantity;

        // create cart item
        $cart_item = CartItem::createOrUpdate([
            Attributes::PACKAGE_ID => $package_id,
            Attributes::PACKAGE_TYPE => $package_type,
            Attributes::TITLE => $title,
            Attributes::DESCRIPTION => $description,
            Attributes::DISPLAY_IMAGE => $display_image,
            Attributes::MEDIA_IDS => $media_ids,
            Attributes::ALBUM_SIZE => $album_size,
            Attributes::SPREADS => $spreads,
            Attributes::PAPER_TYPE => $paper_type,
            Attributes::COVER_TYPE => $cover_type,
            Attributes::CANVAS_TYPE => $canvas_type,
            Attributes::CANVAS_SIZE => $canvas_size,
            Attributes::QUANTITY => $quantity,
            Attributes::PRINT_TYPE => $print_type,
            Attributes::PAPER_SIZE => $paper_size,
            Attributes::ADDITIONAL_COMMENTS => $additional_comments,
            Attributes::USER_ID => $user->id,
            Attributes::TOTAL_PRICE => $total_price
        ]);

        // return response
        if (is_a($cart_item, CartItem::class)) {
            return GlobalHelpers::formattedJSONResponse(Messages::CART_ITEM_ADDED, null, null, Response::HTTP_OK);
        }

        return GlobalHelpers::formattedJSONResponse(Messages::UNABLE_TO_PROCESS, null, null, Response::HTTP_BAD_REQUEST);
    }

    /**
     * List Cart Items
     * @return JsonResponse
     */
    public function listCartItems() {

        // get current user
        $user = Helpers::resolveUser();
        if (is_null($user)) {
            return GlobalHelpers::formattedJSONResponse(Messages::PERMISSION_DENIED, null, null, Response::HTTP_UNAUTHORIZED);
        }

        //  get user cart items (unpurchased)
        $cart_items = CartItem::where(Attributes::USER_ID, $user->id)->where(Attributes::STATUS, CartItemStatus::UNPURCHASED);
        $total_price = $cart_items->pluck(Attributes::TOTAL_PRICE)->sum();
        $cart_items = $cart_items->get();

        // return response
        return Helpers::returnResponse([
            Attributes::TOTAL_PRICE => $total_price,
            Attributes::CART_ITEMS => CartItem::returnTransformedItems($cart_items, ListCartItemsTransformer::class),
        ]);
    }
}
