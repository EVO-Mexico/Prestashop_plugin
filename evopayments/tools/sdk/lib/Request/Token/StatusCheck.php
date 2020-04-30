<?php

namespace Payments;

class RequestTokenStatusCheck extends RequestToken
{

    protected $_params = [
        "merchantId"     => ["type" => "mandatory"],
        "password"       => ["type" => "mandatory"],
        "action"         => [
            "type"   => "mandatory",
            "values" => [Payments::ACTION_STATUS_CHECK],
        ],
        "timestamp"      => ["type" => "mandatory"],
        "allowOriginUrl" => ["type" => "mandatory"],
    ];

    public function __construct()
    {
        parent::__construct();
        $this->_data["action"] = Payments::ACTION_STATUS_CHECK;
    }

}
