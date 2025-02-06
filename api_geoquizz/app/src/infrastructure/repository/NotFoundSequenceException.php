<?php

namespace api_geoquizz\infrastructure\repository;

use Exception;

class NotFoundSequenceException extends Exception
{
    public function __construct ($message, $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}