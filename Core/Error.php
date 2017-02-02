<?php

namespace Core;
use App\Config;

class Error
{
    /**
     * Convert errors to exceptions
     */
    public static function exceptionErrorHandler($severity, $message, $file, $line)
    {
        if (!(error_reporting() & $severity)) {
            return;
        }
        throw new \ErrorException($message, 0, $severity, $file, $line);
    }

    /**
     * Exception handler.
     */
    public static function exceptionHandler($exception)
    {
        $code = $exception->getCode() == 404 ?: 500;
        http_response_code($code);

        if (Config::SHOW_ERRORS) {
            echo $exception;
        } else {
            error_log($exception);
            View::renderTemplate("$code.html");
        }
    }
}
