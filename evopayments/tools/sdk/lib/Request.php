<?php

namespace Payments;

class Request extends Executable
{

    protected $_token_request;
    protected $_action_request;
    protected $_keys = [
        "token"      => "token",
        "merchantId" => "merchantId",
    ];

    public function __construct()
    {
        parent::__construct();
        $this->_data["timestamp"] = time();
        call_user_func_array([$this, "_set"], func_get_args());
    }

    public function __call($name, $value)
    {
        switch ($name) {
            case "tokenize":
                return new RequestTokenize($value);
                break;
            case "auth":
                return new RequestAuth($value);
                break;
            case "capture":
                return new RequestCapture($value);
                break;
            case "purchase":
                return new RequestPurchase($value);
                break;
            case "refund":
                return new RequestRefund($value);
                break;
            case "statuscheck":
            case "status_check":
                return new RequestStatusCheck($value);
                break;
            case "void":
                return new RequestVoid($value);
                break;
        }

        return parent::__call($name, $value);
    }

    public function validate()
    {
        $data = $this->_data;
        if ((is_array($this->_params)) and (count($this->_params) > 0) and (is_array($this->_data))) {
            foreach ($this->_params as $key => $value) {
                if ($value["type"] == "mandatory") {
                    if (!isset($this->_data[$key])) {
                        $ex = new PaymentsExceptionParamNotSet($key, null, isset($ex) ? $ex : null);
                    }
                } else {
                    if ($value["type"] == "conditional") {
                        if (is_array($value["mandatory"])) {
                            foreach ($value["mandatory"] as $check => $value) {
                                if ((isset($this->_data[$check])) and ($this->_data[$check] == $value) and (!isset($this->_data[$key]))) {
                                    $ex = new PaymentsExceptionParamNotSet($key, null, isset($ex) ? $ex : null);
                                }
                            }
                        }
                    }
                }
            }
            foreach ($this->_data as $check => $value) {
                if (!isset($this->_params[$check])) {
                    unset($data[$check]);
                }
            }
        }
        if (isset($ex)) {
            throw $ex;
        }

        return $data;
    }

    public function execute($callback = null, $result_from_prev = [])
    {
        try {
            $this->_data["merchantId"] = Config::$MerchantId;
            $this->_data["password"] = Config::$Password;
            $token_result = $this->_token_request->execute(null, $this->_data);
            if (is_a($token_result, "Payments\ResponseError")) {
                return $token_result;
            }
            foreach ($token_result as $k => $v) {
                $this->_data[$this->_keys($k)] = $v;
            }

            return $this->_action_request->execute($callback, $this->_data);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    protected function _keys($k)
    {
        if (isset($this->_keys[$k])) {
            return $this->_keys[$k];
        }

        return $k;
    }

    protected function _exec_post($url, $data, $callback = null)
    {
        if (empty($url)) {
            throw new PaymentsExceptionConfigurationEndpointNotSet;
        }
        if ((empty($data)) or (!is_array($data)) or (count($data) == 0)) {
            throw new PaymentsExceptionProcessDataNotSet;
        }
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, Config::$Method);
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);

        $response = curl_exec($ch);
        $info = curl_getinfo($ch);

        if ($response === false) {
            throw new PaymentsExceptionExecuteNetworkError(curl_error($ch), curl_errno($ch));
        }
        curl_close($ch);
        $response = json_decode(trim($response), true);
        if ((!is_null($callback)) && (is_callable($callback))) {
            call_user_func($callback, $response);
        } else {
            if (!isset($response["result"]) or $response["result"] != "success") {
                return new ResponseError($response, $data, $info);
            }

            return new ResponseSuccess($response, $info);
        }
    }

    public function token()
    {
        $this->_data["merchantId"] = Config::$MerchantId;
        $this->_data["password"] = Config::$Password;

        return $this->_token_request->execute(null, $this->_data);
    }

    public function __debugInfo()
    {
        $data = [];
        $data["request"] = $this->_data;
        if ($this->_token_request instanceof Request) {
            $data["token_request"] = $this->_token_request->_data;
        }
        if ($this->_action_request instanceof Request) {
            $data["action_request"] = $this->_action_request->_data;
        }

        return $data;
    }

}
