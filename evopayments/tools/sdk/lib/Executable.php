<?php

namespace Payments;

abstract class Executable extends Configurable
{

    public abstract function validate();

    public abstract function execute($callback = null, $result_from_prev = []);
}
