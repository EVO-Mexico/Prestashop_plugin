<?php

namespace Payments;

class RequestPurchase extends RequestAuth
{

    public function __construct($values = [])
    {
        parent::__construct();
        $this->_token_request = new RequestTokenPurchase($values);
        $this->_action_request = new RequestActionPurchase($values);
    }

}
