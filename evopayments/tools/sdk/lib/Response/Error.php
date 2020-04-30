<?php

namespace Payments;

class ResponseError extends Response
{

    protected $_errors = [];

    public function __construct($response, $request, $info = [])
    {
        parent::__construct($response, $info);
        $this->_errors = new ResponseErrorErrors($this->data["errors"]);
        $this->_request = $request;
    }

    public function get_error($name = null)
    {
        if (!is_null($name)) {
            if (isset($this->errors->{$name})) {
                return $this->errors->{$name};
            }

            return null;
        }

        return $this->errors;
    }

}
