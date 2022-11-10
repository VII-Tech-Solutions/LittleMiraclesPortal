<?php

namespace App\Helpers;

use App\Constants\Attributes;
use App\Constants\PaymentMethods;
use App\Constants\Values;
use App\Http\Controllers\BenefitController;
use App\Models\Helpers;
use App\Models\Order;
use App\Models\Transaction;
use GuzzleHttp\Exception\GuzzleException;
use VIITech\Helpers\GlobalHelpers;
use Exception;
use function Webmozart\Assert\Tests\StaticAnalysis\null;

class PaymentHelpers
{

    /**
     * Generate Payment Link
     * @param Order $order
     * @param $payment_method
     * @return array
     */
    static function generatePaymentLink(Order $order, $payment_method) {
        // process url
        $process_url = url('/api/payment/process');

        // create transaction
        $transaction = new Transaction();
        $transaction->payment_method = $payment_method;
        $transaction->order_id = $order->id;

        // get personal info
        $customer_name = $order->user->first_name . ' ' . $order->user->last_name;
        $customer_phone_number = $order->user->phone_number;
        // get amount
        $amount = !is_null($order->discount_price) ? $order->discount_price : $order->total_price;
        if (!GlobalHelpers::isProductionEnv()) {
            // test amount
            $amount = Values::TEST_AMOUNT;
        }

        if ($payment_method == PaymentMethods::CREDIT_CARD) {

        } else {
            $success_url = url("/api/payments/verify-benefit?order_id=$order->id");
            $error_url = url("/api/payments/verify-benefit?order_id=$order->id");
            $payment_url = self::generateBenefitPaymentLink($amount, $transaction->id, $customer_name, $customer_phone_number, $success_url, $error_url);
        }

        return [
            Attributes::PAYMENT_URL => $payment_url,
            Attributes::TRANSACTION => $transaction,
        ];
    }

    /**
     * Generate Benefit Payment Link
     * @param $amount
     * @param $transaction_id
     * @param $customer_name
     * @param $customer_phone_number
     * @param $success_url
     * @param $error_url
     * @return null
     */
    static function generateBenefitPaymentLink($amount, $transaction_id, $customer_name, $customer_phone_number, $success_url, $error_url) {
        try {
            $benefit_request_data = [
                Attributes::AMOUNT => $amount,
                Attributes::ORDER_ID => $transaction_id,
                Attributes::TRACKID => $transaction_id,
                Attributes::CUSTOMER_NAME => $customer_name,
                Attributes::CUSTOMER_PHONE_NUMBER => $customer_phone_number,
                Attributes::PAYMENT_SECRET => env('PAYMENT_SECRET'),
                Attributes::BENEFIT_MIDDLEWARE_TOKEN => env('PAYMENT_SECRET'),
                Attributes::SUCCESS_URL => $success_url,
                Attributes::ERROR_URL => $error_url,
                Attributes::MERCHANT_ID => env('MERCHANT_ID'),
                Attributes::DESCRIPTION => "Little Miracles"
            ];

            $url = BenefitController::checkout($benefit_request_data);
            $response_body = json_decode($url->getContent());
            return $response_body->data->payment_page ?? null;
        } catch (Exception|GuzzleException $e) {
            Helpers::captureException($e);
        }

        return null;
    }
}
