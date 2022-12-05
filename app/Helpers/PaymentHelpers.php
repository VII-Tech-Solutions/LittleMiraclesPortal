<?php

namespace App\Helpers;

use App\Constants\Attributes;
use App\Constants\Messages;
use App\Constants\PaymentMethods;
use App\Constants\Values;
use App\Http\Controllers\BenefitController;
use App\Models\Helpers;
use App\Models\Order;
use App\Models\Transaction;
use Dingo\Api\Http\Response;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Crypt;
use VIITech\Helpers\GlobalHelpers;
use function Webmozart\Assert\Tests\StaticAnalysis\null;

class PaymentHelpers
{

    /**
     * Generate Payment Link
     * @param Order $order
     * @param $payment_method
     * @return array|JsonResponse
     */
    static function generatePaymentLink(Order $order, $payment_method)
    {
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
        $amount = !is_null($order->discount_price) ? $order->discount_price : $order->total_price;
        if (!GlobalHelpers::isProductionEnv()) {
            // test amount
            $amount = Values::TEST_AMOUNT;
        }

        if ($payment_method == PaymentMethods::CREDIT_CARD) {
            // todo success_url
            // todo error_url

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
                "interaction.merchant.name" => env('MERCHANT_MAME'),
                "interaction.operation" => "AUTHORIZE",
                "interaction.displayControl.billingAddress" => "HIDE",
                "merchant" => env('MERCHANT_ID'),
                "order.amount" => $amount,
                "order.currency" => "BHD",
                "order.description" => "Booking",
                "order.id" => $transaction->id,
            ];

            $client = new Client();
            $response = $client->request('POST', "https://credimax.gateway.mastercard.com/api/nvp/version/68", [
                'form_params' => $create_session_data,
            ]);

            $response_body = Helpers::parseQuery($response->getBody()->getContents());
            $request_response_result = $response_body['result']; #return SUCCESS or FAIL

//            // todo check how to extract data
//            foreach (explode("&", $request_response_result) as $data) {
//                $response_result = (explode("=", $data));
//                $response_data[$response_result[0]] = str_replace('"', '', $response_result[1]);
//            }

//            if ($request_response_result == 'SUCCESS') {
//                $session_id = $response_data['session.id'];
//                $transaction->success_indicator = $response_data['successIndicator'];
//                $transaction->save();
//            }

            if ($request_response_result == 'SUCCESS' && !is_null($merchant_id)) {
                $session_id = $response_body['session.id'];
                $transaction->success_indicator = $response_body['successIndicator'];
                $transaction->save();
            }

            $query = http_build_query([
                "session_id" => Crypt::encryptString($session_id),
                "merchant_id" => $merchant_id ?? null,
                "transaction_id" => $transaction->id,
                "success_indicator" => $response_body->successIndicator ?? null
            ]);

            $payment_url = env('APP_URL') . "/api/payment/redirect?$query";
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
