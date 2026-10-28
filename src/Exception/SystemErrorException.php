<?php

namespace Goyo_Statistics\Exception;

use Exception;

class SystemErrorException extends Exception
{
    public function __construct($message, $code = 0, Exception $previous = null)
    {
        /* translators: %s: string value */
        $message = sprintf(__('System error: %s', 'goyo-statistics'), $message);
        parent::__construct($message, $code, $previous);
    }
}