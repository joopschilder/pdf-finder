<?php

namespace IO\Exception;

class NotADirectoryException extends IOException
{
    public function __construct(string $directory)
    {
        parent::__construct(sprintf('Argument \'%s\' is not a directory', $directory));
    }
}
