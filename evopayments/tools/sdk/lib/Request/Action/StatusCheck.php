<?php

namespace Payments;

class RequestActionStatusCheck extends RequestAction
{

    protected $_params = [
        "merchantId"   => ["type" => "mandatory"],
        "token"        => ["type" => "mandatory"],
        "action"       => [
            "type"   => "mandatory",
            "values" => [Payments::ACTION_STATUS_CHECK],
        ],
        "txId"         => ["type" => "optional"],
        "merchantTxId" => ["type" => "optional"],
    ];

    public function __construct()
    {
        parent::__construct();
        $this->_data["action"] = Payments::ACTION_STATUS_CHECK;
    }

}
