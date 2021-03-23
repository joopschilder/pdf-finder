<?php

namespace IO\Exception;

class FileNotFoundException extends IOException
{
    public function __construct(string $file)
    {
        parent::__construct(sprintf('File \'%s\' not found', $file));
    }
}
