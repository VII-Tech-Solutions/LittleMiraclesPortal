<?php

namespace App\Helpers;

use App\Constants\Attributes;
use App\Constants\Messages;
use App\Constants\PaymentGateways;
use App\Constants\PaymentMethods;
use App\Constants\Values;
use App\Http\Controllers\BenefitController;
use App\Models\Order;
use App\Models\Transaction;
use Dingo\Api\Http\Response;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Crypt;
use VIITech\Helpers\Constants\DebuggerLevels;
use VIITech\Helpers\GlobalHelpers;
use App\Models\Helpers;

class PaymentHelpers
{

    /**
     * Generate Payment Link
     * @param Order $order
     * @param $payment_method
     */
    static function generatePaymentLink(Order $order, $payment_method)
    {
        GlobalHelpers::debugger("PaymentHelpers@generatePaymentLink", DebuggerLevels::INFO);
        // process url
        $process_url = url('/api/payment/process');

        // create transaction
        $transaction = new Transaction();
        $transaction->payment_method = $payment_method;
        $transaction->order_id = $order->id;
        $transaction->save();

        // get personal info
        $customer_name = $order->user->first_name . ' ' . $order->user->last_name;
        $customer_phone_number = $order->user->phone_number;

        // get amount
        $amount = $order->subtotal;
        if (!GlobalHelpers::isProductionEnv()) {
            // test amount
            $amount = Values::TEST_AMOUNT;
        }

        if ($payment_method == PaymentMethods::CREDIT_CARD) {
            // todo success_url
            // todo error_url
            $transaction->gateway = PaymentGateways::CREDIMAX;
            $transaction->save();

            // get merchant id and api password
            $merchant_id = env('MERCHANT_ID');
            $api_password = env('PAYMENT_SECRET');

            if (is_null($merchant_id) && is_null($api_password)) {
                return GlobalHelpers::formattedJSONResponse(Messages::UNABLE_TO_PROCESS, null, null, Response::HTTP_BAD_REQUEST);
            }

            $create_session_data = [
                "apiOperation" => "INITIATE_CHECKOUT",
                "apiPassword" => env('PAYMENT_SECRET'),
                "apiUsername" => "merchant." . env('MERCHANT_ID'),
                "interaction.returnUrl" => $process_url,
                "interaction.merchant.name" => env('MERCHANT_NAME'),
                "interaction.operation" => "PURCHASE",
                "interaction.displayControl.billingAddress" => "HIDE",
                "merchant" => env('MERCHANT_ID'),
                "order.amount" => $amount,
                "order.currency" => "BHD",
                "order.description" => "Booking",
                "order.id" => $transaction->id,
            ];

            GlobalHelpers::debugger(json_encode($create_session_data), DebuggerLevels::INFO);
            $client = new Client();
            $response = $client->request('POST', "https://credimax.gateway.mastercard.com/api/nvp/version/68", [
                'form_params' => $create_session_data,
            ]);
            $response_body = Helpers::parseQuery($response->getBody()->getContents());
            GlobalHelpers::debugger(json_encode($response_body), DebuggerLevels::INFO);
            $request_response_result = $response_body['result']; #return SUCCESS or FAIL

            if ($request_response_result == 'SUCCESS' && !is_null($merchant_id)) {
                $session_id = $response_body['session.id'];
                $transaction->success_indicator = $response_body['successIndicator'];
                $transaction->save();
            }

            try {
                $query = http_build_query([
                    "session_id" => Crypt::encryptString($session_id),
                    "merchant_id" => $merchant_id ?? null,
                    "transaction_id" => $transaction->id,
                    "success_indicator" => $response_body['successIndicator'] ?? null,
                    Attributes::DESCRIPTION => "Credimax Little Miracles"
                ]);
                $payment_url = env('APP_URL') . "/api/payment/redirect?$query";
            } catch (Exception $e) {
                return $e->getMessage();
            }
        } else {
            $success_url = url("/api/benefit/approved?order_id=$order->id");
            $error_url = url("/api/benefit/declined?order_id=$order->id");
            $transaction->success_url = $success_url;
            $transaction->error_url = $error_url;
            $transaction->gateway = PaymentGateways::BENEFIT;
            $transaction->save();

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
     * @return string
     */
    static function generateBenefitPaymentLink($amount, $transaction_id, $customer_name, $customer_phone_number, $success_url, $error_url)
    {
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
                Attributes::MERCHANT_ID => env('BENEFIT_MERCHANT_ID'),
                Attributes::DESCRIPTION => "Little Miracles"
            ];

            return BenefitController::checkout($benefit_request_data);
        } catch (Exception|GuzzleException $e) {
            Helpers::captureException($e);
        }

        return null;
    }
}
