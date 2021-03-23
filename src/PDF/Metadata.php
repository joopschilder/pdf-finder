<?php

namespace PDF;

use Cocur\Slugify\Slugify;

class Metadata
{
    public ?string $abbreviation = null;
    public ?string $author = null;
    public ?string $creationdate = null;
    public ?string $creator = null;
    public ?string $encrypted = null;
    public ?string $form = null;
    public ?string $javascript = null;
    public ?string $keywords = null;
    public ?string $linearized = null;
    public ?string $moddate = null;
    public ?string $optimized = null;
    public ?string $page_rot = null;
    public ?string $page_size = null;
    public ?string $pages = null;
    public ?string $pdf_subtype = null;
    public ?string $pdf_version = null;
    public ?string $producer = null;
    public ?string $standard = null;
    public ?string $subject = null;
    public ?string $subtitle = null;
    public ?string $suspects = null;
    public ?string $tagged = null;
    public ?string $title = null;
    public ?string $userproperties = null;

    public function fillWith(array $array): Metadata
    {
        $slugify = new Slugify(['separator' => '_']);

        $array = array_filter($array, static fn(string $v) => trim($v) !== '');
        foreach ($array as $key => $value) {
            $key = $slugify->slugify($key);
            if (property_exists(__CLASS__, $key)) {
                $this->{$key} = trim($value);
            }
        }

        return $this;
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
