<?php

namespace IO;

use Throwable;

class ExceptionHandler
{
    private static bool $registered = false;

    public static function registerCallback(): void
    {
        if (self::$registered) {
            return;
        }

        set_exception_handler(static function (Throwable $t) {
            print($t->getMessage());
            exit(1);
        });

        self::$registered = true;
    }
}
