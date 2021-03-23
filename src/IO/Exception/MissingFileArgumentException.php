<?php

namespace IO\Exception;


class MissingFileArgumentException extends IOException
{
    public function __construct()
    {
        parent::__construct('Missing file argument');
    }
}
