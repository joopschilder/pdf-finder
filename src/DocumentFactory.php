<?php

use IO\Shell\Pdfinfo;
use PDF\Document;

class DocumentFactory
{
    private Pdfinfo $pdfinfo;

    public function __construct(?Pdfinfo $pdfinfo = null)
    {
        $this->pdfinfo = $pdfinfo ?? new Pdfinfo();
    }

    public static function create(): self
    {
        return new self();
    }

    public function createDocument(SplFileInfo $file): Document
    {
        $metadata = $this->pdfinfo->getMetadata($file);
        return new Document($file, $metadata);
    }
}
