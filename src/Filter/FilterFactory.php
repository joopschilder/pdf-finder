<?php

namespace Filter;

class FilterFactory
{
    public function createFromString(string $string): DocumentFilter
    {
        if (preg_match('/^.+=.*$/', $string)) {
            [$prop, $term] = explode('=', $string);
            return new SpecificFilter(trim($prop), trim($term));
        }
        return new GenericFilter($string);
    }
}
