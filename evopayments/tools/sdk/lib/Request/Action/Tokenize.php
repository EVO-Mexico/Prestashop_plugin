<?php

namespace Payments;

class RequestActionTokenize extends RequestAction
{

    protected $_params = [
        "merchantId"      => ["type" => "mandatory"],
        "token"           => ["type" => "mandatory"],
        "number"          => ["type" => "mandatory"],
        "nameOnCard"      => ["type" => "mandatory"],
        "expiryMonth"     => ["type" => "mandatory"],
        "expiryYear"      => ["type" => "mandatory"],
        "startMonth"      => ["type" => "optional"],
        "startYear"       => ["type" => "optional"],
        "issueNumber"     => ["type" => "optional"],
        "cardDescription" => ["type" => "optional"],
    ];
}
