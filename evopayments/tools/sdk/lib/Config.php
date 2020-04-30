<?php

namespace Payments;

class Config
{

    static $SessionTokenRequestUrl;
    static $PaymentOperationActionUrl;
    static $BaseUrl;
    static $JavaScriptUrl;
    
    static $DEFAULT_CASHIER_URL_TEST = "https://cashierui-apiuat.test.myriadpayments.com/ui/cashier";
    static $DEFAULT_JAVASCRIPT_URL_TEST = "https://cashierui-apiuat.test.myriadpayments.com/js/api.js";
    static $DEFAULT_TOKEN_URL_TEST = "https://apiuat.test.myriadpayments.com/token";
    static $DEFAULT_ACTION_URL_TEST = "https://apiuat.test.myriadpayments.com/payments";
    
    static $DEFAULT_CASHIER_URL_PRODUCTION = "https://cashierui-api.myriadpayments.com/ui/cashier";
    static $DEFAULT_JAVASCRIPT_URL_PRODUCTION = "https://cashierui-apiuat.test.myriadpayments.com/js/api.js";
    static $DEFAULT_TOKEN_URL_PRODUCTION = "https://api.myriadpayments.com/token";
    static $DEFAULT_ACTION_URL_PRODUCTION = "https://api.myriadpayments.comm/payments";
    
    static $TestUrls = [
        "SessionTokenRequestUrl"    => "",
        "PaymentOperationActionUrl" => "",
        "JavaScriptUrl"             =>  "",
        "BaseUrl"                   =>  "",
    ];
    static $ProductionUrls = [
        "SessionTokenRequestUrl"    => "",
        "PaymentOperationActionUrl" => "",
        "JavaScriptUrl"             =>  "",
        "BaseUrl"                   =>  "",
    ];
    static $Protocol = "https";
    static $Method = "POST";
    static $ContentType = "application/x-www-form-urlencoded";
    static $MerchantId = "";
    static $Password = "";

    public static function buildEvoEnv4Test($baseUrl, $javascriptUrl, $tokenUrl, $actionUrl) {
        if(empty($tokenUrl)){
            $tokenUrl = self::$DEFAULT_TOKEN_URL_TEST;
        }
        
        if(empty($actionUrl)) {
            $actionUrl = self::$DEFAULT_ACTION_URL_TEST;
        }
        
        if(empty($baseUrl)){
            $baseUrl = self::$DEFAULT_CASHIER_URL_TEST;
        }
        
        if(empty($javascriptUrl)){
            $javascriptUrl = self::$DEFAULT_JAVASCRIPT_URL_TEST;
        }

        self::$TestUrls['BaseUrl'] = $baseUrl;
        self::$TestUrls['JavaScriptUrl'] = $javascriptUrl;
        self::$TestUrls['SessionTokenRequestUrl'] = $tokenUrl;
        self::$TestUrls['PaymentOperationActionUrl'] = $actionUrl;
        self::test();

    }
    
    public static function buildEvoEnv4Prod($baseUrl, $javascriptUrl, $tokenUrl, $actionUrl) {
        if(empty($tokenUrl)){
            $tokenUrl = self::$DEFAULT_TOKEN_URL_PRODUCTION;
        }
        
        if(empty($actionUrl)) {
            $actionUrl = self::$DEFAULT_ACTION_URL_PRODUCTION;
        }
        
        if(empty($baseUrl)){
            $baseUrl = self::$DEFAULT_CASHIER_URL_PRODUCTION;
        }
        
        if(empty($javascriptUrl)){
            $javascriptUrl = self::$DEFAULT_JAVASCRIPT_URL_PRODUCTION;
        }

        self::$ProductionUrls['BaseUrl'] = $baseUrl;
        self::$ProductionUrls['JavaScriptUrl'] = $javascriptUrl;
        self::$ProductionUrls['SessionTokenRequestUrl'] = $tokenUrl;
        self::$ProductionUrls['PaymentOperationActionUrl'] = $actionUrl;
        self::production();
    }
    
    
    public static function factory()
    {
        foreach (func_get_args()[0] as $var => $value) {
            self::${ucfirst($var)} = $value;
        }
    }

    private static function test()
    {
        self::$SessionTokenRequestUrl = self::$TestUrls["SessionTokenRequestUrl"];
        self::$PaymentOperationActionUrl = self::$TestUrls["PaymentOperationActionUrl"];
        self::$BaseUrl = self::$TestUrls["BaseUrl"];
        self::$JavaScriptUrl = self::$TestUrls["JavaScriptUrl"];
    }

    private static function production()
    {
        self::$SessionTokenRequestUrl = self::$ProductionUrls["SessionTokenRequestUrl"];
        self::$PaymentOperationActionUrl = self::$ProductionUrls["PaymentOperationActionUrl"];
        self::$BaseUrl = self::$ProductionUrls["BaseUrl"];
        self::$JavaScriptUrl = self::$ProductionUrls["JavaScriptUrl"];
    }

    public static function baseUrl()
    {
        return self::$BaseUrl;
    }

    public static function javaScriptUrl()
    {
        return self::$JavaScriptUrl;
    }

}
