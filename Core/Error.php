<?php

namespace Core;

use App\Config;

class Error
{

    /**
     * Error handler. Convert all errors to Exceptions by throwing an ErrorException.
     *
     * @param int $level
     * @param string $message
     * @param string $file
     * @param int $line
     *
     * @return void
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
     *
     * @param Exception $exception  The exception
     *
     * @return void
     */
    public static function exceptionHandler($exception)
    {
        $code = $exception->getCode() == 500 ?: 404;

        http_response_code($code);

        if (Config::SHOW_ERRORS) {
            echo $exception;
        } else {
            $log = dirname(__DIR__) . '/logs/' . date('Y-m-d') . '.txt';
            ini_set('error_log', $log);
            error_log($exception);
            View::view("$code.html");
        }
    }
}
