<?php

namespace App\API\Controllers;

use App\API\Transformers\ListCartItemsTransformer;
use App\API\Transformers\ListOrdersTransformer;
use App\Constants\AllProducts;
use App\Constants\Attributes;
use App\Constants\CartItemStatus;
use App\Constants\Messages;
use App\Constants\OrderStatus;
use App\Helpers;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\Package;
use App\Models\Promotion;
use App\Models\StudioMetadata;
use Dingo\Api\Http\Response;
use Exception;
use Illuminate\Http\JsonResponse;
use VIITech\Helpers\Constants\CastingTypes;
use VIITech\Helpers\GlobalHelpers;

/**
 * Class CartController
 * @package App\API\Controllers
 */
class CartController extends CustomController
{

    /**
     * Add Cart Item
     *
     * @return JsonResponse
     */
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
        $media_ids = GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::MEDIA_IDS, null, CastingTypes::STRING);
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
        $album_title = GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::ALBUM_TITLE, null, CastingTypes::STRING);

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
            Attributes::TOTAL_PRICE => $total_price,
            Attributes::ALBUM_TITLE => $album_title
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

        // get user cart items (unpurchased)
        $cart_items = CartItem::where(Attributes::USER_ID, $user->id)->where(Attributes::STATUS, CartItemStatus::UNPURCHASED);
        $total_price = $cart_items->pluck(Attributes::TOTAL_PRICE)->sum();
        $cart_items = $cart_items->get();

        // return response
        return Helpers::returnResponse([
            Attributes::TOTAL_PRICE => $total_price,
            Attributes::CART_ITEMS => CartItem::returnTransformedItems($cart_items, ListCartItemsTransformer::class),
        ]);
    }

    /**
     * Remove Cart Item
     * @param $id
     * @return JsonResponse
     * @throws Exception
     */
    public function removeCartItem($id) {

        // get current user
        $user = Helpers::resolveUser();
        if (is_null($user)) {
            return GlobalHelpers::formattedJSONResponse(Messages::PERMISSION_DENIED, null, null, Response::HTTP_UNAUTHORIZED);
        }

        // get item
        $cart_item = CartItem::where(Attributes::ID, $id)->where(Attributes::USER_ID, $user->id)->first();
        if (is_null($cart_item)) {
            return GlobalHelpers::formattedJSONResponse(Messages::ITEM_NOT_FOUND, null, null, Response::HTTP_BAD_REQUEST);
        }

        // remove cart item
        if ($cart_item->delete()) {
            return GlobalHelpers::formattedJSONResponse(Messages::CART_ITEM_REMOVED, null, null, Response::HTTP_OK);
        }

        return GlobalHelpers::formattedJSONResponse(Messages::UNABLE_TO_PROCESS, null, null, Response::HTTP_BAD_REQUEST);
    }

    /**
     * Apply Promo Code
     *
     * @param $id
     * @return JsonResponse
     */
    public function applyPromoCode() {

        // get current user info
        $user = Helpers::resolveUser();
        if (is_null($user)) {
            return GlobalHelpers::formattedJSONResponse(Messages::PERMISSION_DENIED, null, null, Response::HTTP_UNAUTHORIZED);
        }

        // get parameters
        $code = GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::CODE, null, CastingTypes::STRING);

        // validate code
        if (!is_null($code)) {
            // get promotion
            /** @var Promotion $promotion */
            $promotion = Promotion::active()->where(Attributes::PROMO_CODE, $code)->first();

            if (is_null($promotion)) {
                return GlobalHelpers::formattedJSONResponse(Messages::INVALID_PROMOTION_CODE, null, null, Response::HTTP_BAD_REQUEST);
            }

            if ($promotion->package_id != AllProducts::ALL) {
                return GlobalHelpers::formattedJSONResponse(Messages::PROMOTION_CODE_NOT_FOR_THIS_PACKAGE, null, null, Response::HTTP_BAD_REQUEST);
            }

            // calculate
            $cart_items = CartItem::where(Attributes::USER_ID, $user->id)->where(Attributes::STATUS, CartItemStatus::UNPURCHASED);
            $original_price = $cart_items->pluck(Attributes::TOTAL_PRICE)->sum();
            $offer = $promotion->offer;
            $discount_amount = $original_price * ($offer / 100);
            $total_price_after_discount = $original_price - $discount_amount;

            // return response
            return GlobalHelpers::formattedJSONResponse(Messages::PROMO_CODE_APPLIED, [
                Attributes::ORIGINAL_PRICE => Helpers::formattedPrice($original_price),
                Attributes::DISCOUNT_PRICE => Helpers::formattedPrice($discount_amount),
                Attributes::TOTAL_PRICE => Helpers::formattedPrice($total_price_after_discount)
            ], null, Response::HTTP_OK);
        }

        return GlobalHelpers::formattedJSONResponse(Messages::INVALID_PROMOTION_CODE, null, null, Response::HTTP_BAD_REQUEST);
    }

    /**
     * Checkout
     *
     * @return JsonResponse
     */
    public function checkout() {
        // get current user info
        $user = Helpers::resolveUser();
        if (is_null($user)) {
            return GlobalHelpers::formattedJSONResponse(Messages::PERMISSION_DENIED, null, null, Response::HTTP_UNAUTHORIZED);
        }

        // get cart items
        $cart_items = CartItem::where(Attributes::USER_ID, $user->id)->where(Attributes::STATUS, CartItemStatus::UNPURCHASED)->get();

        // get parameters
        $promo_code = GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::CODE, null, CastingTypes::STRING);
        $total_price = GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::TOTAL_PRICE, null, CastingTypes::DOUBLE);
        $discount_price = GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::DISCOUNT_PRICE, null, CastingTypes::DOUBLE);

        // create order
        $order = Order::createOrUpdate([
            Attributes::PROMO_CODE => $promo_code,
            Attributes::TOTAL_PRICE => $total_price,
            Attributes::DISCOUNT_PRICE => $discount_price,
            Attributes::USER_ID => $user->id
        ]);

        if (!is_a($order, Order::class)) {
            return GlobalHelpers::formattedJSONResponse(Messages::UNABLE_TO_PROCESS, null, null, Response::HTTP_BAD_REQUEST);
        }

        // add order items
        foreach ($cart_items as $item) {
            OrderItems::createOrUpdate([
                Attributes::ORDER_ID => $order->id,
                Attributes::ITEM_ID => $item->id,
                Attributes::USER_ID => $user->id
            ]);

            // change item status
            $item->status = CartItemStatus::PURCHASED;
            $item->save();
        }

        // return response
        return GlobalHelpers::formattedJSONResponse(Messages::ORDER_CREATED, null, null, Response::HTTP_OK);
    }

    /**
     * List Orders
     *
     * @return JsonResponse
     */
    public function listOrders() {
        // get current user info
        $user = Helpers::resolveUser();
        if (is_null($user)) {
            return GlobalHelpers::formattedJSONResponse(Messages::PERMISSION_DENIED, null, null, Response::HTTP_UNAUTHORIZED);
        }

        // get orders
        $orders = Order::where(Attributes::USER_ID, $user->id)->where(Attributes::STATUS, '!=', OrderStatus::CANCELLED)->get();


        $order_items = $orders->map->orderItems;
        $order_items = $order_items->flatten()->unique(Attributes::ID);

        return Helpers::returnResponse([
            Attributes::ORDERS => Order::returnTransformedItems($orders, ListOrdersTransformer::class),
            Attributes::ORDER_ITEMS => $order_items,
        ]);
    }
}
