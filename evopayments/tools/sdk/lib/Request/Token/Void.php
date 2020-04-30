<?php

namespace Payments;

class RequestTokenVoid extends RequestTokenRefund
{

    protected $_params = [
        "merchantId"           => ["type" => "mandatory"],
        "originalMerchantTxId" => ["type" => "mandatory"],
        "password"             => ["type" => "mandatory"],
        "action"               => [
            "type"   => "mandatory",
            "values" => [Payments::ACTION_VOID],
        ],
        "timestamp"            => ["type" => "mandatory"],
        "allowOriginUrl"       => ["type" => "mandatory"],
        "originalTxId"         => ["type" => "optional"],
        "agentId"              => ["type" => "optional"],
    ];

    public function __construct()
    {
        parent::__construct();
        $this->_data["action"] = Payments::ACTION_VOID;
    }

}
