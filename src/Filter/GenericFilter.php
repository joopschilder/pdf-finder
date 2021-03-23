<?php

namespace Filter;

use PDF\Document;

class GenericFilter implements DocumentFilter
{
    private string $term;

    public function __construct(string $term)
    {
        $this->term = $term;
    }

    public function allows(Document $document): bool
    {
        if ($this->term === '') {
            return true;
        }

        foreach ($document->getProperties() as $key => $value) {
            if (stripos($value, $this->term) !== false) {
                return true;
            }
        }
        return false;
    }

    public function __toString(): string
    {
        return sprintf('[*] contains \'%s\'', $this->term);
    }
}
