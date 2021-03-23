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

        $documents = [];
        foreach ($iterator as $file) {
            if ($this->validate($file)) {
                $documents[] = $this->documentFactory->createDocument($file);
            }
        }

        return collect($documents);
    }

    private function validate(SplFileInfo $file): bool
    {
        return $file->isFile()
            && preg_match('/.pdf$/i', $file->getBasename());
    }
}
