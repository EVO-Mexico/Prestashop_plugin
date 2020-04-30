<?php

namespace Payments;

class RequestTokenTokenize extends RequestToken
{

    protected $_params = [
        "action"         => [
            "type"   => "mandatory",
            "values" => [Payments::ACTION_TOKENIZE],
        ],
        "merchantId"     => ["type" => "mandatory"],
        "password"       => ["type" => "mandatory"],
        "timestamp"      => ["type" => "mandatory"],
        "allowOriginUrl" => ["type" => "mandatory"],
        "customerId"     => ["type" => "optional"],
    ];

    public function __construct()
    {
        parent::__construct();
        $this->_data["action"] = Payments::ACTION_TOKENIZE;
    }

}
