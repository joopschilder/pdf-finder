<?php

namespace IO\Exception;

class FileNotReadableException extends IOException
{
    public function __construct(string $file)
    {
        parent::__construct(sprintf('File \'%s\' is not readable', $file));
    }
}
