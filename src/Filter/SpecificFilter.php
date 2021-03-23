<?php

namespace Filter;

use PDF\Document;
use RuntimeException;

class SpecificFilter implements DocumentFilter
{
    private string $property;
    private string $term;

    public function __construct(string $property, string $term)
    {
        $this->property = strtolower($property);
        $this->term = strtolower($term);
    }

    public function allows(Document $document): bool
    {
        if ($this->property === '') {
            return true;
        }

        try {
            $property = $document->getProperty($this->property);
            if ($this->term === '' && !empty($property)) {
                // Filter is "prop=", which only checks if it exists.
                return true;
            }
            return stripos($property, $this->term) !== false;
        } catch (RuntimeException $e) {
            // No such property exists, we don't pass
            return false;
        }
    }

    public function __toString(): string
    {
        return sprintf('property \'%s\' contains \'%s\'', $this->property, $this->term);
    }
}
