<?php

namespace Filter;

use PDF\Document;

interface DocumentFilter
{
    public function allows(Document $document): bool;

    public function __toString(): string;
}
