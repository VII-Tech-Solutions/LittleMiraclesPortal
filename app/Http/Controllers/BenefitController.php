<?php

namespace App\Http\Controllers;

use App\API\Controllers\CustomController;
use App\Constants\Attributes;
use App\Constants\BookingType;
use App\Constants\OrderStatus;
use App\Constants\PaymentGateways;
use App\Constants\PaymentStatus;
use App\Constants\PromotionStatus;
use App\Constants\PromotionType;
use App\Helpers\MailjetHelpers;
use App\Models\Helpers;
use App\Models\Order;
use App\Models\Promotion;
use App\Models\Transaction;
use Benefit\plugin\iPayBenefitPipe;
use VIITech\Helpers\Constants\CastingTypes;
use VIITech\Helpers\GlobalHelpers;
use Illuminate\Http\JsonResponse;

class BenefitController extends CustomController
{

    static function checkout($benefit_data)
    {
        require('Benefit/plugin/BenefitAPIPlugin.php');
        $order_uid = Helpers::appendEnvNumber() . time() . Helpers::generateBigRandomNumber();
        $amount = $benefit_data[Attributes::AMOUNT];
        $order_id = $benefit_data[Attributes::ORDER_ID];
        $description = $benefit_data[Attributes::DESCRIPTION];
        $customer_phone_number = $benefit_data[Attributes::CUSTOMER_PHONE_NUMBER];
        $payment_secret = $benefit_data[Attributes::PAYMENT_SECRET];
        $merchant_id = $benefit_data[Attributes::MERCHANT_ID];

        $pipe = new iPayBenefitPipe();
        // modify the following to reflect your "Tranportal ID", "Tranportal Password ", "Terminal Resourcekey"
        $pipe->setkey(env('TERMINAL_RESOURCEKEY'));
        $pipe->setid(env('TRANPORTAL_ID'));
        $pipe->setpassword(env('TRANPORTAL_PASSWORD'));
        $pipe->setaction("1");
        $pipe->setcardType("D");
        $pipe->setcurrencyCode("048");

        $pipe->setresponseURL(url("/api/benefit/process"));
        $pipe->seterrorURL(url("/api/benefit/process"));

        $pipe->setudf2($customer_phone_number);
        $pipe->setudf3($order_uid);

        $pipe->settrackId((string)($order_id . '-' . rand(10, 100)));
        $pipe->setamt($amount);
        $isSuccess = $pipe->performeTransaction();
        if ($isSuccess == 1) {
            return $pipe->getresult();
        } else {
            return $pipe->geterror() . ' ' . $pipe->geterrorText();
        }
    }

    /**
     * Get iPayBenefitPipe Object
     * @return iPayBenefitPipe
     */
    static function getBenefitPipe()
    {
        $ipay_benefit_pipe = new iPayBenefitPipe();

        // modify the following to reflect your "Alias Name", "resource.cgn" file path, "keystore.pooh" file path.
        $ipay_benefit_pipe->setAlias(Helpers::getBenefitAlias());
        $ipay_benefit_pipe->setResourcePath(Helpers::getBenefitAuthFolderPath()); //only the path that contains the file; do not write the file name
        $ipay_benefit_pipe->setKeystorePath(Helpers::getBenefitAuthFolderPath()); //only the path that contains the file; do not write the file name

        return $ipay_benefit_pipe;
    }

    /**
     * Process
     * @return string
     */
    function process()
    {
        require_once("Benefit/plugin/BenefitAPIPlugin.php");

        $trandata = isset($_POST['trandata']) ? $_POST['trandata'] : "";

        if ($trandata != "") {
            $pipe = new iPayBenefitPipe();

            // modify the following to reflect your "Terminal Resourcekey"
            $pipe->setkey(env('TERMINAL_RESOURCEKEY'));

            $pipe->settrandata($trandata);

            $returnValue = $pipe->parseResponseTrandata();
            if ($returnValue == 1) {
                $paymentID = $pipe->getpaymentId();
                $result = $pipe->getresult();
                $responseCode = $pipe->getauthRespCode();
                $transactionID = $pipe->gettransId();
                $referenceID = $pipe->getref();
                $trackID = $pipe->gettrackId();
                $amount = $pipe->getamt();
                $UDF1 = $pipe->getudf1();
                $UDF2 = $pipe->getudf2();
                $UDF3 = $pipe->getudf3();
                $UDF4 = $pipe->getudf4();
                $UDF5 = $pipe->getudf5();
                $authCode = $pipe->getauthCode();
                $postDate = $pipe->gettranDate();
                $errorCode = $pipe->geterror();
                $errorText = $pipe->geterrorText();

                // Remove any HTML/CSS/javascrip from the page. Also, you MUST NOT write anything on the page EXCEPT the word "REDIRECT=" (in upper-case only) followed by a URL.
                // If anything else is written on the page then you will not be able to complete the process.
                if ($pipe->getresult() == "CAPTURED") {
                    $errorText = "";
                    return "REDIRECT=" . url('/api/benefit/approved');
                } else if ($pipe->getresult() == "NOT CAPTURED" || $pipe->getresult() == "CANCELED" || $pipe->getresult() == "DENIED BY RISK" || $pipe->getresult() == "HOST TIMEOUT") {
                    if ($pipe->getresult() == "NOT CAPTURED") {
                        switch ($pipe->getAuthRespCode()) {
                            case "05":
                                $response = "Please contact issuer";
                                break;
                            case "14":
                                $response = "Invalid card number";
                                break;
                            case "33":
                                $response = "Expired card";
                                break;
                            case "36":
                                $response = "Restricted card";
                                break;
                            case "38":
                                $response = "Allowable PIN tries exceeded";
                                break;
                            case "51":
                                $response = "Insufficient funds";
                                break;
                            case "54":
                                $response = "Expired card";
                                break;
                            case "55":
                                $response = "Incorrect PIN";
                                break;
                            case "61":
                                $response = "Exceeds withdrawal amount limit";
                                break;
                            case "62":
                                $response = "Restricted Card";
                                break;
                            case "65":
                                $response = "Exceeds withdrawal frequency limit";
                                break;
                            case "75":
                                $response = "Allowable number PIN tries exceeded";
                                break;
                            case "76":
                                $response = "Ineligible account";
                                break;
                            case "78":
                                $response = "Refer to Issuer";
                                break;
                            case "91":
                                $response = "Issuer is inoperative";
                                break;
                            default:
                                // for unlisted values, please generate a proper user-friendly message
                                $response = "Unable to process transaction temporarily. Try again later or try using another card.";
                                break;
                        }
                    } else if ($pipe->getresult() == "CANCELED") {
                        $response = "Transaction was canceled by user.";
                    } else if ($pipe->getresult() == "DENIED BY RISK") {
                        $response = "Maximum number of transactions has exceeded the daily limit.";
                    } else if ($pipe->getresult() == "HOST TIMEOUT") {
                        $response = "Unable to process transaction temporarily. Try again later.";
                    }
                    return "REDIRECT=" . url('/api/benefit/declined');
                } else {
                    //Unable to process transaction temporarily. Try again later or try using another card.
                    return "REDIRECT=" . url('/api/benefit/error');
                }
            } else {
                $errorText = $pipe->geterrorText();
            }

        } else if (isset($_POST['ErrorText'])) {
            $paymentID = $_POST["paymentid"];
            $trackID = $_POST["trackid"];
            $amount = $_POST["amt"];
            $UDF1 = $_POST["udf1"];
            $UDF2 = $_POST["udf2"];
            $UDF3 = $_POST["udf3"];
            $UDF4 = $_POST["udf4"];
            $UDF5 = $_POST["udf5"];
            $errorText = $_POST["ErrorText"];
            return "REDIRECT=" . url('/api/benefit/declined');
        } else {
            $errorText = "Unknown Exception";
            return "REDIRECT=" . url('/api/benefit/error');
        }

        return "REDIRECT=" . url('/api/benefit/error');
    }

    /**
     * Approved
     * @return JsonResponse
     */
    function approved()
    {
        require_once("Benefit/plugin/BenefitAPIPlugin.php");

        $myObj = new iPayBenefitPipe();
        $myObj->setkey(env('TERMINAL_RESOURCEKEY'));

        // get parameters
        $payment_id = $this->getData("paymentid") ?? null;
        $order_id = explode('-', $this->getData("trackid"))[0] ?? null;

        // get transaction
        $transaction = Transaction::where(Attributes::PAYMENT_ID, $payment_id)->where(Attributes::ORDER_ID, $order_id)->first();

        $trandata = "";
        $paymentID = "";
        $result = "";
        $responseCode = "";
        $transactionID = "";
        $referenceID = "";
        $trackID = "";
        $amount = "";
        $UDF1 = "";
        $UDF2 = "";
        $UDF3 = "";
        $UDF4 = "";
        $UDF5 = "";
        $authCode = "";
        $postDate = "";
        $errorCode = "";
        $errorText = "";

        $trandata = $this->getData("trandata") ?? "";

        if ($trandata != "") {
            $returnValue = $myObj->parseEncryptedRequest($trandata);
            if ($returnValue == 0) {
                $paymentID = $myObj->getPaymentId();
                $result = $myObj->getRef();
                $responseCode = $myObj->getAuthRespCode();
                $transactionID = $myObj->getTransId();
                $referenceID = $myObj->getRef();
                $trackID = $myObj->getTrackId();
                $amount = $myObj->getAmt();
                $UDF1 = $myObj->getUdf1();
                $UDF2 = $myObj->getUdf2();
                $UDF3 = $myObj->getUdf3();
                $UDF4 = $myObj->getUdf4();
                $UDF5 = $myObj->getUdf5();
                $authCode = $myObj->getAuth();
                $postDate = $myObj->getDate();
                $errorCode = $myObj->getError();
                $errorText = $myObj->getError_text();
            } else {
                $errorText = $myObj->getError_text();
            }
        } else if ($this->getData("ErrorText") !== null) {
            $paymentID = $this->getData("paymentid");
            $trackID = $this->getData("Trackid");
            $amount = $this->getData("amt");
            $UDF1 = $this->getData("UDF1");
            $UDF2 = $this->getData("UDF2");
            $UDF3 = $this->getData("UDF3");
            $UDF4 = $this->getData("UDF4");
            $UDF5 = $this->getData("UDF5");
            $errorText = $this->getData("ErrorText");
        } else {
            $errorText = "Unknown Exception";
        }

        if (empty($errorText)) {
            return $this->showResult(true, $errorText);
        } else {
            return $this->showResult(false, $errorText);
        }
    }

    /**
     * Declined
     * @return JsonResponse
     */
    function declined()
    {
        require_once("Benefit/plugin/BenefitAPIPlugin.php");

        $myObj = new iPayBenefitPipe();
        $myObj->setkey(env('TERMINAL_RESOURCEKEY'));

        $trandata = "";
        $paymentID = "";
        $result = "";
        $responseCode = "";
        $transactionID = "";
        $referenceID = "";
        $trackID = "";
        $amount = "";
        $UDF1 = "";
        $UDF2 = "";
        $UDF3 = "";
        $UDF4 = "";
        $UDF5 = "";
        $authCode = "";
        $postDate = "";
        $errorCode = "";
        $errorText = "";

        $trandata = $this->getData("trandata") ?? "";

        if ($trandata != "") {
            $returnValue = $myObj->parseEncryptedRequest($trandata);
            if ($returnValue == 0) {
                $paymentID = $myObj->getPaymentId();
                $result = $myObj->getRef();
                $responseCode = $myObj->getAuthRespCode();
                $transactionID = $myObj->getTransId();
                $referenceID = $myObj->getRef();
                $trackID = $myObj->getTrackId();
                $amount = $myObj->getAmt();
                $UDF1 = $myObj->getUdf1();
                $UDF2 = $myObj->getUdf2();
                $UDF3 = $myObj->getUdf3();
                $UDF4 = $myObj->getUdf4();
                $UDF5 = $myObj->getUdf5();
                $authCode = $myObj->getAuth();
                $postDate = $myObj->getDate();
                $errorCode = $myObj->getError();
                $errorText = $myObj->getError_text();
            } else {
                $errorText = $myObj->getError_text();
            }
        } else if ($this->getData("ErrorText") !== null) {
            $paymentID = $this->getData("paymentid");
            $trackID = $this->getData("Trackid");
            $amount = $this->getData("amt");
            $UDF1 = $this->getData("UDF1");
            $UDF2 = $this->getData("UDF2");
            $UDF3 = $this->getData("UDF3");
            $UDF4 = $this->getData("UDF4");
            $UDF5 = $this->getData("UDF5");
            $errorText = $this->getData("ErrorText");
        } else {
            $errorText = "Unknown Exception";
        }

        return $this->showResult(false, $errorText);
    }

    /**
     * Error
     * @return JsonResponse
     */
    function error()
    {

        $errorText = $this->getData("ErrorText");
        return $this->showResult(false, $errorText);
    }

    /**
     * Show Result
     * @param $success
     * @param $error_message
     * @return JsonResponse
     */
    function showResult($success, $error_message = null)
    {

        // get values
        $payment_id = GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::PAYMENTID, null, CastingTypes::STRING);
        $transaction_id = GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::TRACKID, null, CastingTypes::STRING);

        if (empty($error_message)) {
            $error_message = GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::ERRORTEXT, null, CastingTypes::STRING);
        }

        // get the transaction
        /** @var Transaction $transaction */
        $transaction = Transaction::where(Attributes::GATEWAY, PaymentGateways::BENEFIT)
            ->where(Attributes::STATUS, PaymentStatus::AWAITING_PAYMENT)
            ->where(Attributes::ID, $transaction_id)->first();

        if (!is_null($transaction)) {
            // get order
            /** @var Order $order */
            $order = Order::where(Attributes::ID, $transaction->order_id)->first();
            $order->status = $success ? OrderStatus::PAID : OrderStatus::CANCELLED;
            $order->save();

            // update transaction
            $transaction->status = $success ? PaymentStatus::CONFIRMED : PaymentStatus::REJECTED;
            $transaction->error_message = $error_message;
            $transaction->payment_id = $payment_id;
            $transaction->save();

            // get promotion
            /** @var Promotion $promotion */
            $promotion = Promotion::where(Attributes::PROMO_CODE, $order->promo_code)->first();
            if (!is_null($promotion)) {
                // set as redeemed
                if ($promotion->type == PromotionType::GIFT) {
                    $promotion->redeemed = true;
                    $promotion->save();
                }
            }

            if ($order->booking_type == BookingType::GIFT) {
                // update gift status
                /** @var Promotion $gift */
                $gift = Promotion::where(Attributes::ID, $order->promo_id)->first();
                $gift->status = PromotionStatus::ACTIVE;
                $gift->save();

                // send email notification
                MailjetHelpers::sendGift($gift);

            }
        }

        // return response
        return Helpers::returnResponse([
            Attributes::TRANSACTION => $transaction,
        ]);
    }


    /**
     * Get Data
     * @param $key
     * @return mixed
     */
    function getData($key)
    {
        return GlobalHelpers::getValueFromHTTPRequest($this->request, $key, null, CastingTypes::STRING);
    }
}
