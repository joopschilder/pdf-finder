<?php

namespace IO\Input;

use IO\Exception\FileNotFoundException;
use IO\Exception\FileNotReadableException;
use IO\Exception\MissingFileArgumentException;
use SplFileInfo;

class ShowInfoArguments
{
    use ArgvAccess;

    private SplFileInfo $file;

    public static function createFromGlobals(): self
    {
        $arguments = self::getArguments();
        return new self(array_shift($arguments));
    }

    public function __construct(?string $file)
    {
        $this->guardUnusableFile($file);
        $this->file = new SplFileInfo($file);
    }

    public function getFile(): SplFileInfo
    {
        return $this->file;
    }

    private function guardUnusableFile(string $file): void
    {
        if (is_null($file)) {
            throw new MissingFileArgumentException();
        }
        if (!file_exists($file)) {
            throw new FileNotFoundException($file);
        }
        if (!is_readable($file)) {
            throw new FileNotReadableException($file);
        }
    }
}
