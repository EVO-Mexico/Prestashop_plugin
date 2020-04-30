<?php

namespace Payments;

class RequestTokenRefund extends RequestToken
{

    protected $_params = [
        "merchantId"           => ["type" => "mandatory"],
        "originalMerchantTxId" => ["type" => "mandatory"],
        "password"             => ["type" => "mandatory"],
        "action"               => [
            "type"   => "mandatory",
            "values" => [Payments::ACTION_REFUND, Payments::ACTION_CAPTURE],
        ],
        "timestamp"            => ["type" => "mandatory"],
        "allowOriginUrl"       => ["type" => "mandatory"],
        "amount"               => ["type" => "mandatory"],
        "originalTxId"         => ["type" => "optional"],
        "agentId"              => ["type" => "optional"],
    ];

    public function __construct()
    {
        parent::__construct();
        $this->_data["action"] = Payments::ACTION_REFUND;
    }

}
