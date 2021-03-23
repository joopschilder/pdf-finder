<?php

namespace IO\Exception;

class DirectoryNotReadableException extends IOException
{
    public function __construct(string $directory)
    {
        parent::__construct(sprintf('Directory \'%s\' is not readable', $directory));
    }
}
