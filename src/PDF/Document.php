<?php

namespace PDF;

use RuntimeException;
use SplFileInfo;

class Document
{
    public SplFileInfo $file;
    public Metadata $metadata;

    public function __construct(SplFileInfo $file, ?Metadata $metadata = null)
    {
        $this->file = $file;
        $this->metadata = $metadata ?? new Metadata();
    }

    public function getProperty(string $prop): ?string
    {
        if (in_array($prop, ['path', 'filepath'])) {
            return $this->file->getPath();
        }

        if (in_array($prop, ['file', 'name', 'filename'])) {
            return $this->file->getBasename();
        }

        if (property_exists($this->metadata, $prop)) {
            return $this->metadata->{$prop};
        }

        throw new RuntimeException('No such property');
    }

    public function getProperties(): array
    {
        return [
                'filepath' => $this->file->getPath(),
                'filename' => $this->file->getBasename(),
            ] + $this->metadata->toArray();
    }
}
