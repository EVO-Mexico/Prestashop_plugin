<?php

namespace Payments;

class RequestActionRefund extends RequestAction
{

    protected $_params = [
        "merchantId" => ["type" => "mandatory"],
        "token"      => ["type" => "mandatory"],
    ];

    public function __construct()
    {
        parent::__construct();
        $this->_data["action"] = Payments::ACTION_REFUND;
    }

}
