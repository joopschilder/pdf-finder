<?php

namespace IO\Exception;

class DirectoryNotFoundException extends IOException
{
    public function __construct(string $directory)
    {
        parent::__construct(sprintf('Directory \'%s\' not found', $directory));
    }
}
