<?php

namespace IO\Input;

use IO\Exception\FileNotFoundException;
use IO\Exception\FileNotReadableException;
use IO\Exception\MissingFileArgumentException;
use SplFileInfo;

class ShowInfoArguments
{
    use ArgvAccess;

    private ?string $file;

    public function __construct(?string $file)
    {
        $this->file = $file;
    }

    public static function createFromGlobals(): self
    {
        $arguments = self::getArguments();
        return new self(array_shift($arguments));
    }

    public function getFile(): SplFileInfo
    {
        if (is_null($this->file)) {
            throw new MissingFileArgumentException();
        }
        if (!file_exists($this->file)) {
            throw new FileNotFoundException($this->file);
        }
        if (!is_readable($this->file)) {
            throw new FileNotReadableException($this->file);
        }

        return new SplFileInfo($this->file);
    }
}
