<?php

namespace Goyo_Statistics\Exception;

use Exception;
use Goyo_Statistics;

class LogException extends Exception
{
    public function __construct($message, $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);

        Goyo_Statistics::log($this->generateLogMessage($message, $code), 'error');
    }

    private function generateLogMessage($message, $code)
    {
        return sprintf(
            /* translators: %1$d: number value, %2$s: string value, %3$s: string value, %4$d: number value */
            __('Exception occurred: [Code %1$d] %2$s at %3$s:%4$d', 'goyo-statistics'),
            $code,
            $message,
            $this->getFile(),
            $this->getLine()
        );
    }
}
