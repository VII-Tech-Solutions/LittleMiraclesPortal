<?php
namespace Benefit\plugin;

use Exception;

require_once("parseResource.php");
require_once("Keystore.php");


class iPayBenefitPipe {
	protected $id = null;
	protected $action = null;
	protected $password = null;
	protected $amt = null;
	protected $trackId = null;
	protected $udf1 = null;
	protected $udf2 = null;
	protected $udf3 = null;
	protected $udf4 = null;
	protected $udf5 = null;
	protected $currencyCode = null;
	protected $member = null;
	protected $cardType = null;
	protected $expMonth = null;
	protected $expYear = null;
	protected $cardNo = null;
	protected $paymentData = null;
	protected $paymentMethod = null;
	protected $transactionIdentifier = null;
	protected $responseURL = null;
	protected $errorURL = null;
	protected $key = null;
	protected $iv = "PGKEYENCDECIVSPC";
	protected $result = null;
	protected $status = null;
	protected $error = null;
	protected $errorText = null;
	protected $trandata = null;
	protected $endPoint = "https://www.benefit-gateway.bh/payment/API/hosted.htm"; // live
//	protected $endPoint = "https://test.benefit-gateway.bh/payment/API/hosted.htm"; // test
	protected $tranDate = null;
	protected $authRespCode = null;
	protected $authCode = null;
	protected $transId = null;
	protected $tranid = null;
	protected $ref = null;
	protected $paymentId = null;
	protected $pin = null;
	protected $ticketNo = null;
	protected $bookingId = null;
	protected $transactionDate = null;
	protected $transUpdateTime = null;

    protected $keystorePath = "";
    protected $resourcePath = "";
    protected $auth = "";
    protected $date = "";
    protected $error_text = "";

	/* Get */
	function getendPoint() {
		return $this->endPoint;
	}
	function getpin() {
		return $this->pin;
	}
	function getid() {
		return $this->id;
	}
	function getaction() {
		return $this->action;
	}
	function getpassword() {
		return $this->password;
	}
	function getamt() {
		return $this->amt;
	}
	function gettrackId() {
		return $this->trackId;
	}
	function getudf1() {
		return $this->udf1;
	}
	function getudf2() {
		return $this->udf2;
	}
	function getudf3() {
		return $this->udf3;
	}
	function getudf4() {
		return $this->udf4;
	}
	function getudf5() {
		return $this->udf5;
	}
	function getcurrencyCode() {
		return $this->currencyCode;
	}
	function getmember() {
		return $this->member;
	}
	function getcardType() {
		return $this->cardType;
	}
	function getexpMonth() {
		return $this->expMonth;
	}
	function getexpYear() {
		return $this->expYear;
	}
	function getcardNo() {
		return $this->cardNo;
	}
	function getpaymentData() {
		return $this->paymentData;
	}
	function getpaymentMethod() {
		return $this->paymentMethod;
	}
	function gettransactionIdentifier() {
		return $this->transactionIdentifier;
	}
	function getresponseURL() {
		return $this->responseURL;
	}
	function geterrorURL() {
		return $this->errorURL;
	}
	function getkey() {
		return $this->key;
	}
	function getstatus() {
		return $this->status;
	}
	function getresult() {
		return $this->result;
	}
	function geterror() {
		return $this->error;
	}
	function geterrorText() {
		return $this->errorText;
	}
	function gettranDate() {
		return $this->tranDate;
	}
	function getauthRespCode() {
		return $this->authRespCode;
	}
	function getauthCode() {
		return $this->authCode;
	}
	function gettransId() {
		return $this->transId;
	}
	function gettranId() {
		return $this->tranId;
	}
	function getref() {
		return $this->ref;
	}
	function getpaymentId() {
		return $this->paymentId;
	}
	function getticketNo() {
		return $this->ticketNo;
	}
	function getbookingId() {
		return $this->bookingId;
	}
	function gettransactionDate() {
		return $this->transactionDate;
	}
	function gettransUpdateTime() {
		return $this->transUpdateTime;
	}
    function getauth()
    {
        return $this->auth;
    }
    function getDate()
    {
        return $this->date;
    }
    function geterror_text()
    {
        return $this->error_text;
    }

	/* Set */
	function setendPoint($val) {
		$this->endPoint = $val;
	}
	function setpin($val) {
		$this->pin = $val;
	}
	function setid($val) {
		$this->id = $val;
	}
	function setaction($val) {
		$this->action = $val;
	}
	function setpassword($val) {
		$this->password = $val;
	}
	function setamt($val) {
		$this->amt = $val;
	}
	function settrackId($val) {
		$this->trackId = $val;
	}
	function setudf1($val) {
		$this->udf1 = $val;
	}
	function setudf2($val) {
		$this->udf2 = $val;
	}
	function setudf3($val) {
		$this->udf3 = $val;
	}
	function setudf4($val) {
		$this->udf4 = $val;
	}
	function setudf5($val) {
		$this->udf5 = $val;
	}
	function setcurrencyCode($val) {
		$this->currencyCode = $val;
	}
	function setmember($val) {
		$this->member = $val;
	}
	function setcardType($val) {
		$this->cardType = $val;
	}
	function setexpMonth($val) {
		$this->expMonth = $val;
	}
	function setexpYear($val) {
		$this->expYear = $val;
	}
	function setcardNo($val) {
		$this->cardNo = $val;
	}
	function setpaymentData($val) {
		$this->paymentData = $val;
	}
	function setpaymentMethod($val) {
		$this->paymentMethod = $val;
	}
	function settransactionIdentifier($val) {
		$this->transactionIdentifier = $val;
	}
	function setresponseURL($val) {
		$this->responseURL = $val;
	}
	function seterrorURL($val) {
		$this->errorURL = $val;
	}
	function setkey($val) {
		$this->key = $val;
	}
	function setstatus($val) {
		$this->status = $val;
	}
	function setresult($val) {
		$this->result = $val;
	}
	function seterror($val) {
		$this->error = $val;
	}
	function seterrorText($val) {
		$this->errorText = $val;
	}
	function settrandata($val) {
		$this->trandata = $val;
	}
	function settranDate($val) {
		$this->tranDate=$val;
	}
	function setauthRespCode($val) {
		$this->authRespCode=$val;
	}
	function setauthCode($val) {
		$this->authCode=$val;
	}
	function settransId($val) {
		$this->transId=$val;
	}
	function settranId($val) {
		$this->tranId=$val;
	}
	function setref($val) {
		$this->ref=$val;
	}
	function setpaymentId($val) {
		$this->paymentId=$val;
	}
	function setticketNo($val) {
		$this->ticketNo=$val;
	}
	function setbookingId($val) {
		$this->bookingId=$val;
	}
	function settransactionDate($val) {
		$this->transactionDate=$val;
	}
	function settransUpdateTime($val) {
		$this->transUpdateTime=$val;
	}
    function setauth($val)
    {
        $this->auth = $val;
    }
    function setDate($val)
    {
        $this->date = $val;
    }
    function seterror_text($val)
    {
        $this->error_text = $val;
    }

    function createRequestData(){
		$FinalData = "";
		$trandataObj = array(array(
		'amt' => $this->amt,
		'action' => $this->action,
		'password' => $this->password,
		'id' => $this->id,
		'currencycode' => $this->currencyCode,
		'trackId' => $this->trackId,
		'udf1' => $this->udf1,
		'udf2' => $this->udf2,
		'udf3' => $this->udf3,
		'udf4' => $this->udf4,
		'udf5' => $this->udf5,
		'expYear' => $this->expYear,
		'expMonth' => $this->expMonth,
		'member' => $this->member,
		'cardNo' => $this->cardNo,
		'cardType' => $this->cardType,
		'paymentData' => $this->paymentData,
		'paymentMethod' => $this->paymentMethod,
		'transactionIdentifier' => $this->transactionIdentifier,
		'responseURL' => $this->responseURL,
		'errorURL' => $this->errorURL,
		'transId' => $this->transId,
		'pin' => $this->pin,
		'ticketNo' => $this->ticketNo,
		'bookingId' => $this->bookingId,
		'transactionDate' => $this->transactionDate,
		));

		$trandataObj[0] = array_filter($trandataObj[0]);

		$FinalData = array(array(
		  'id' => $this->id,
		  'trandata' => $this->encrypt($trandataObj,$this->key,$this->iv)
		));

//		var_dump($FinalData);
		return $FinalData;
	}

	function encrypt($data,$key,$iv) {
		$encrypted = openssl_encrypt(json_encode($data,true), 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
		$encrypted=unpack('C*', ($encrypted));
		$encrypted=$this->byteArray2Hex($encrypted);
		$encrypted  = urlencode($encrypted);
	  return $encrypted;
	}

	function byteArray2Hex($byteArray) {
		$result = '';
		$HEX_DIGITS = "0123456789abcdef";
		foreach ($byteArray as $value) {
			$result.= $HEX_DIGITS[$value >> 4];
			$result.= $HEX_DIGITS[$value& 0xf];
		}
		return $result;
	}


	function decryptData($data,$key,$iv) {
		$code =  $this->hex2ByteArray(trim($data));
		$code=$this->byteArray2String($code);
		$code = base64_encode($code);
		$decrypted = openssl_decrypt($code, 'AES-256-CBC', $key, OPENSSL_ZERO_PADDING, $iv);
		return $this->pkcs5_unpad($decrypted);
	}


	function hex2ByteArray($hexString) {
	  $string = hex2bin($hexString);
	  return unpack('C*', $string);
	}


	function byteArray2String($byteArray) {
	  $chars = array_map("chr", $byteArray);
	  return join($chars);
	}


	function pkcs5_unpad($text) {
		$pad = ord($text{strlen($text)-1});
		if ($pad > strlen($text)) {
			return false;
		}
		if (strspn($text, chr($pad), strlen($text) - $pad) != $pad) {
			return false;
		}
		return substr($text, 0, -1 * $pad);
	}

	function performeTransaction(){
		$data = $this->createRequestData();
		$options = array(
		  'http' => array(
			'method'  => 'POST',
			'content' => json_encode( $data ),
			'header'=>  "Content-Type: application/json\r\n" .
						"Accept: application/json\r\n"
			)
		);
		$context  = stream_context_create( $options );
		$requestResult = file_get_contents( $this->endPoint, false, $context );
		$response = json_decode($requestResult, true);

        if($response === false){
			return 0;
		}
		else{
			if(count($response) >0){
				$response = $response[0];
				$this->status = $response['status'];
				if($this->status != 1){
					$this->error = $response['error'];
					$this->errorText = $response['errorText'];
					return 0;
				}
				else{
					$this->result = $response['result'];
					if(isset($response['trandata'])){
						$this->trandata = $response['trandata'];
						if($this->trandata !=""){
							$this->parseResponseTrandata();
						}
					}

					return 1;
				}
			}
			else{
				return 0;
			}
		}
	}

	function performeInquiry(){
		$data = $this->createRequestData();

		$options = array(
		  'http' => array(
			'method'  => 'POST',
			'content' => json_encode( $data ),
			'header'=>  "Content-Type: application/json\r\n" .
						"Accept: application/json\r\n"
			)
		);
		$context  = stream_context_create( $options );
		$requestResult = file_get_contents( $this->endPoint, false, $context );
		$response = json_decode($requestResult, true);

		if($response === false){
			return 0;
		}
		else{
			if(count($response) >0){
				$response = $response[0];
				$this->status = $response['status'];
				if($this->status != 1){
					$this->error = $response['error'];
					$this->errorText = $response['errorText'];
					return 0;
				}
				else{
					$this->trandata = $response['trandata'];
					$this->result = $response['tranid'];

					return $this->parseResponseTrandata();
				}
			}
			else{
				return 0;
			}
		}
	}


	function performeUpdate(){
		$data = $this->createRequestData();

		$options = array(
		  'http' => array(
			'method'  => 'POST',
			'content' => json_encode( $data ),
			'header'=>  "Content-Type: application/json\r\n" .
						"Accept: application/json\r\n"
			)
		);
		$context  = stream_context_create( $options );
		$requestResult = file_get_contents( $this->endPoint, false, $context );
		$response = json_decode($requestResult, true);
		if($response === false){
			return 0;
		}
		else{
			if(count($response) >0){
				$response = $response[0];
				$this->status = $response['status'];
				if($this->status != 1){
					$this->error = $response['error'];
					$this->errorText = $response['errorText'];
					return 0;
				}
				else{
					$this->trandata = $response['trandata'];
					$this->result = $response['tranid'];

					return $this->parseResponseTrandata();
				}
			}
			else{
				return 0;
			}
		}
	}


	function parseResponseTrandata(){
		try{
			$ClearData = $this->decryptData($this->trandata,$this->key,$this->iv);
			$obj = json_decode(urldecode($ClearData), true)[0];
			$this->transUpdateTime=isset($obj["transUpdateTime"]) ? $obj["transUpdateTime"] : $this->transUpdateTime;
			$this->authRespCode=isset($obj["authRespCode"]) ? $obj["authRespCode"] : $this->authRespCode;
			$this->transId=isset($obj["transId"]) ? $obj["transId"] : $this->transId;
			$this->trackId=isset($obj["trackId"]) ? $obj["trackId"] : $this->trackId;
			$this->udf1=isset($obj["udf1"]) ? $obj["udf1"] : $this->udf1;
			$this->udf2=isset($obj["udf2"]) ? $obj["udf2"] : $this->udf2;
			$this->udf3=isset($obj["udf3"]) ? $obj["udf3"] : $this->udf3;
			$this->udf4=isset($obj["udf4"]) ? $obj["udf4"] : $this->udf4;
			$this->udf5=isset($obj["udf5"]) ? $obj["udf5"] : $this->udf5;
			$this->result=isset($obj["result"]) ? $obj["result"] : $this->result;
			$this->ref=isset($obj["ref"]) ? $obj["ref"] : $this->ref;
			$this->paymentId=isset($obj["paymentId"]) ? $obj["paymentId"] : $this->paymentId;
			$this->tranDate=isset($obj["date"]) ? $obj["date"] : $this->tranDate;
			$this->authCode=isset($obj["authCode"]) ? $obj["authCode"] : $this->authCode;
			$this->amt=isset($obj["amt"]) ? $obj["amt"] : $this->amt;
			return 1;
		}
		catch(Exception $ex){
			$this->errorText = $ex->getMessage();
			return 0;
		}
		return 0;
	}

    function parseEncryptedRequest($trandata)
    {
        $result = 0;
        $xmlData = null;
        $hm = null;
        try {
            if ($trandata == null) {
                return 0;
            }


            $keyParser = new KeyStore();
            $this->key = $keyParser->parseKeyStore($this->keystorePath);
            $xmlData = $this->parseResource($this->key, $this->resourcePath, $this->alias);
            if ($xmlData != null) {
                $hm = $this->parseXMLRequest($xmlData);
            } else {
                $this->error = "Alias name does not exits";
            }
            $this->key = $hm ['resourceKey'];
            $trandata = $this->decryptData($trandata, $this->key);

            $result = $this->parsetrandata($trandata);
            //echo "kkkkkkk";
            //echo $trandata;
            //die();
            return $result;
        } catch (Exception $e) {
            return -1;
        }
    }

    function parseResource($key, $resourcePath, $alias)
    {
        $xmlData = null;
        $key = null;

        try {
            $parseResouce = new parseResource();
            $parseResouce->setResourcePath($resourcePath);

            $parseResouce->setKey($this->key);

            $parseResouce->setAlias($alias);

            $parseResouce->createCGZFromCGN();

            $xmlData = $parseResouce->readZip();

            return $xmlData;
        } catch (Exception $e) {
            return null;
        }
    }

    function parseXMLRequest($request)
    {
        try {
            $responseMap = null;
            $request = trim($request);
            $request = substr($request, strpos($request, "<id>"), strlen($request) - strpos($request, "<id>"));
            $request = str_replace("</terminal>", "", $request);
            $pos = strpos($request, "<") == 0;
            if ($request == null || (strlen($request) < 0) || $pos === false) {
                return null;
            } else {
                try {
                    $responseMap = $this->parseResponse($request);
                } catch (Exception $ex) {
                    return null;
                }
            }
            return $responseMap;
        } catch (Exception $e) {
            return null;
        }
    }


    function parseResponse($response)
    {
        $begin = 0;
        $end = 0;
        $start = null;
        $value = null;
        $map = [];
        $maps = [];
        $response = trim($response);

        $pos = strpos($response, "<") == 0;
        if ($response == null || (strlen($response) < 0) || $pos === false) {
            return null;
        } else {
            do {

                if ((strpos($response, '<') !== false) && (strpos($response, '>') !== false)) {
                    $start = substr($response, ($ind = strpos($response, "<")) + 1, ((strpos($response, ">") - 1) - $ind));
                    $mapKey = substr($response, ($ind = strpos($response, ">")) + 1, ((strpos($response, "</" . $start . ">") - 1) - $ind));
                    $response = substr($response, $from = strpos($response, "</" . $start . ">") + strlen($start) + 3, strrpos($response, ">") - $from + 1);
                    $maps [$start] = $mapKey;
                } else {
                    break;
                }
            } while (strlen($response) > 0);
        }
        return $maps;
    }


    function parsetrandata($trandata)
    {
        try {
            $splitData = $this->splitData($trandata);
            if (isset ($splitData ['paymentid'])) {
                $this->paymentId = $splitData ['paymentid'];
            }
            if (isset ($splitData ['result'])) {
                $this->result = $splitData ['result'];
            }
            if (isset ($splitData ['authRespCode'])) {
                $this->authRespCode = $splitData ['authRespCode'];
            }
            if (isset ($splitData ['udf1'])) {
                $this->udf1 = $splitData ['udf1'];
            }
            if (isset ($splitData ['udf2'])) {
                $this->udf2 = $splitData ['udf2'];
            }
            if (isset ($splitData ['udf3'])) {
                $this->udf3 = $splitData ['udf3'];
            }
            if (isset ($splitData ['udf4'])) {
                $this->udf4 = $splitData ['udf4'];
            }
            if (isset ($splitData ['udf5'])) {
                $this->udf5 = $splitData ['udf5'];
            }
            if (isset ($splitData ['amt'])) {
                $this->amt = $splitData ['amt'];
            }
            if (isset ($splitData ['auth'])) {
                $this->auth = $splitData ['auth'];
            }
            if (isset ($splitData ['ref'])) {
                $this->ref = $splitData ['ref'];
            }
            if (isset ($splitData ['tranid'])) {
                $this->transId = $splitData ['tranid'];
            }
            if (isset ($splitData ['postdate'])) {
                $this->date = $splitData ['postdate'];
            }
            if (isset ($splitData ['trackId'])) {
                $this->trackId = $splitData ['trackId'];
            }
            if (isset ($splitData ['trackid'])) {
                $this->trackId = $splitData ['trackid'];
            }
            if (isset ($splitData ['action'])) {
                $this->action = $splitData ['action'];
            }
            if (isset ($splitData ['Error'])) {
                $this->error = $splitData ['Error'];
            }
            if (isset ($splitData ['ErrorText'])) {
                $this->error_text = $splitData ['ErrorText'];
            }
            if (isset ($splitData ['error_text'])) {
                $this->error_text = $splitData ['error_text'];
            }
        } catch (Exception $e) {

            return -1;
        }
        return 0;
    }

    function splitData($trandata)
    {
        $splitData = [];
        $data = explode("&", $trandata);
        foreach ($data as $value) {
            $temp = explode("=", $value);
            if (!isset($temp[1])) {
                $temp[1] = "";
            }
            $splitData [$temp [0]] = $temp [1];
        }
        return $splitData;
    }


}

?>
