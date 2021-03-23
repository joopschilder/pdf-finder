<?php

use Illuminate\Support\Collection;
use PDF\Document;

class RecursiveDocumentLocator
{
    private DocumentFactory $documentFactory;

    public function __construct(?DocumentFactory $documentFactory = null)
    {
        $this->documentFactory = $documentFactory ?? new DocumentFactory();
    }

    /**
     * @return Collection<Document>|Document[]
     */
    public function findDocuments(string $directory): Collection
    {
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($directory),
            RecursiveIteratorIterator::SELF_FIRST
        );

        return collect($iterator)
            ->filter(static fn(SplFileInfo $fileInfo) => $fileInfo->isFile())
            ->filter(static fn(SplFileInfo $fileInfo) => preg_match('/.pdf$/i', $fileInfo->getBasename()))
            ->map(fn(SplFileInfo $fileInfo) => $this->documentFactory->createDocument($fileInfo));
    }
}
