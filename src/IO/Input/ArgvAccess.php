<?php

namespace IO\Input;

trait ArgvAccess
{
    protected static function getArguments(): array
    {
        // Get local copy of $argv
        global $argv;
        $arguments = $argv;

        // Lose the script name
        array_shift($arguments);

        return $arguments;
    }
}
