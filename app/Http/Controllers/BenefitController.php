<?php

namespace App\Http\Controllers;

use App\API\Controllers\CustomController;
use App\Constants\Attributes;
use App\Constants\PaymentGateways;
use App\Constants\PaymentStatus;
use App\Models\Helpers;
use App\Models\Order;
use App\Models\Transaction;
use Benefit\plugin\iPayBenefitPipe;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use VIITech\Helpers\Constants\CastingTypes;
use VIITech\Helpers\GlobalHelpers;

class BenefitController extends CustomController
{

    /**
     * Checkout
     * @param $benefit_data
     * @return \Illuminate\Http\JsonResponse
     */
    static function checkout($benefit_data)
    {
        require_once("Benefit/plugin/iPayBenefitPipe.php");
        $order_uid = Helpers::appendEnvNumber() . time() . Helpers::generateBigRandomNumber();
        $success_url = $benefit_data[Attributes::SUCCESS_URL];
        $error_url = $benefit_data[Attributes::ERROR_URL];

        $amount = $benefit_data[Attributes::AMOUNT];
        $order_id = $benefit_data[Attributes::ORDER_ID];
        $description = $benefit_data[Attributes::DESCRIPTION];
        $customer_phone_number = $benefit_data[Attributes::CUSTOMER_PHONE_NUMBER];
        $payment_secret = $benefit_data[Attributes::PAYMENT_SECRET];
        $merchant_id = $benefit_data[Attributes::MERCHANT_ID];

        // validate secret
        if ($payment_secret != env("PAYMENT_SECRET")) {
            return response()->json([
                Attributes::DATA => [
                    Attributes::PAYMENT_PAGE => null,
                    Attributes::ERROR_MESSAGE => "Invalid secret"
                ]
            ], 500);
        }

        // validate merchant id
        $merchant_id_from_alias = Helpers::getBenefitAlias();
        $merchant_id_from_alias = str_replace(env("BENEFIT_ENVIRONMENT", "test"), "", $merchant_id_from_alias);
        $merchant_id_from_alias = str_replace("TEST", "", $merchant_id_from_alias);
        $merchant_id_from_alias = str_replace("PROD", "", $merchant_id_from_alias);
        if ($merchant_id != $merchant_id_from_alias) {
            return response()->json([
                Attributes::DATA => [
                    Attributes::PAYMENT_PAGE => null,
                    Attributes::ERROR_MESSAGE => "Invalid alias"
                ]
            ], 500);
        }

        // gateway accepts 2 decimals only and third one should be zero
        $amount = GlobalHelpers::formatNumber($amount, 2) . 0;
        $ipay_benefit_pipe = BenefitController::getBenefitPipe();

        // Do NOT change the values of the following parameters at all.
        $ipay_benefit_pipe->setAction("1");
        $ipay_benefit_pipe->setCurrency("048");
        $ipay_benefit_pipe->setLanguage("USA");
        $ipay_benefit_pipe->setType("D");

        // modify the following to reflect your pages URLs
        $ipay_benefit_pipe->setResponseURL(url("/api/benefit/process"));
        $ipay_benefit_pipe->setErrorURL(url("/api/benefit/process"));

        // set a unique track ID for each transaction so you can use it later to match transaction response and identify transactions in your system and “BENEFIT Payment Gateway” portal.
        $ipay_benefit_pipe->setTrackId($order_id);

        // set transaction amount
        $ipay_benefit_pipe->setAmt($amount);

        // The following user-defined fields (UDF1, UDF2, UDF3, UDF4, UDF5) are optional fields.
        // However, we recommend setting theses optional fields with invoice/product/customer identification information as they will be reflected in “BENEFIT Payment Gateway” portal where you will be able to link transactions to respective customers. This is helpful for dispute cases.
        $ipay_benefit_pipe->setUdf2($customer_phone_number);
        $ipay_benefit_pipe->setUdf3($order_uid);

        // todo update transaction

        if (trim($ipay_benefit_pipe->performPaymentInitializationHTTP()) != 0) {
            return response()->json([
                Attributes::DATA => [
                    Attributes::PAYMENT_PAGE => null
                ]
            ], 500);
        } else {
            return response()->json([
                Attributes::SUCCESS => true,
                Attributes::DATA => [
                    Attributes::PAYMENT_PAGE => $ipay_benefit_pipe->getwebAddress(),
                    Attributes::UID => $order_uid,
                ]
            ]);
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
     * @return string
     */
    function process()
    {
        require_once("Benefit/plugin/iPayBenefitPipe.php");

        // log request
        if (env("DEBUGGER_LOGS_ENABLED", false)) {
            GlobalHelpers::logRequest($this->request, "BenefitController@process");
        }

        $myObj = $this->getBenefitPipe();

        $trandata = "";
        $paymentID = "";
        $result = "";
        $responseCode = "";
        $response = "";
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
                $result = $myObj->getresult();
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
            $trackID = $this->getData("trackid");
            $amount = $this->getData("amt");
            $UDF1 = $this->getData("udf1");
            $UDF2 = $this->getData("udf2");
            $UDF3 = $this->getData("udf3");
            $UDF4 = $this->getData("udf4");
            $UDF5 = $this->getData("udf5");
            $errorText = $this->getData("ErrorText");
        } else {
            $errorText = "Unknown Exception";
        }

        // Remove any HTML/CSS/javascript from the page. Also, you MUST NOT write anything on the page EXCEPT the word "REDIRECT=" (in upper-case only) followed by a URL.
        // If anything else is written on the page then you will not be able to complete the process.

        dd($this->getData("ErrorText"));
        if ($myObj->getResult() == "CAPTURED") {
            $errorText = "";
            return "REDIRECT=" . url('/api/benefit/approved');
        } else if ($myObj->getResult() == "NOT CAPTURED" || $myObj->getResult() == "CANCELED" || $myObj->getResult() == "DENIED BY RISK" || $myObj->getResult() == "HOST TIMEOUT") {
            if ($myObj->getResult() == "NOT CAPTURED") {
                switch ($myObj->getAuthRespCode()) {
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
            } else if ($myObj->getResult() == "CANCELED") {
                $response = "Transaction was canceled by user.";
            } else if ($myObj->getResult() == "DENIED BY RISK") {
                $response = "Maximum number of transactions has exceeded the daily limit.";
            } else if ($myObj->getResult() == "HOST TIMEOUT") {
                $response = "Unable to process transaction temporarily. Try again later.";
            }
            $errorText = $response;
            return "REDIRECT=" . url('/api/benefit/declined');
        } else {
            //Unable to process transaction temporarily. Try again later or try using another card.
            $errorText = "Unable to process transaction temporarily. Try again later or try using another card.";
            return "REDIRECT=" . url('/api/benefit/error');
        }
    }

    /**
     * Approved
     * @return View
     */
    function approved()
    {
        require_once("Benefit/plugin/iPayBenefitPipe.php");

        $myObj = $this->getBenefitPipe();

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
     * @return View
     */
    function declined()
    {
        require_once("Benefit/plugin/iPayBenefitPipe.php");

        $myObj = $this->getBenefitPipe();

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
     * @return View
     */
    function error()
    {

        $errorText = $this->getData("ErrorText");
        return $this->showResult(false, $errorText);
    }

    /**
     * Show Rmesult
     * @param $success
     * @param $error_message
     * @return View
     */
    function showResult($success, $error_message = null)
    {

        // get values
        $payment_id = GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::PAYMENTID, null, CastingTypes::STRING);
        $transaction_id = GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::TRACKID, null, CastingTypes::STRING);

        if (empty($error_message)) {
            $error_message = GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::ERRORTEXT, null, CastingTypes::STRING);
        }

        // get the order
        /** @var Transaction $transaction */
        $transaction = Transaction::where(Attributes::GATEWAY, PaymentGateways::BENEFIT)
            ->where(Attributes::STATUS, PaymentStatus::AWAITING_PAYMENT)
            ->where(Attributes::ID, $transaction_id)->first();

        if (!is_null($transaction)) {
            // update order
            $transaction->status = $success ? PaymentStatus::CONFIRMED : PaymentStatus::REJECTED;
            $transaction->error_message = $error_message;
            $transaction->payment_id = $payment_id;
            $transaction->save();
        }

        if ($success) {
            return $this->viewResponsePage($transaction->success_url);
        }
        return $this->viewResponsePage($transaction->error_url);
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

    /**
     * View Response Page
     * @param $url
     * @return View
     */
    function viewResponsePage($url){
        return view('response', ["url" => $url]);
    }
}
