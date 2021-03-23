<?php

namespace IO\Output;

use PDF\Document;
use Symfony\Component\Console\Output\OutputInterface;

class DocumentOutput implements Output
{
    private Document $document;

    public function __construct(Document $document)
    {
        $this->document = $document;
    }

    public static function forDocument(Document $document): self
    {
        return new self($document);
    }

    public function render(?OutputInterface $output = null): void
    {
        $template = new TableTemplate([
            'Property' => [
                'min_width'  => 20,
                'max_width'  => 20,
            ],
            'Value'    => [
                'min_width'  => 80,
                'max_width'  => 80,
                'null_value' => '-',
            ],
        ]);

        foreach ($this->document->getProperties() as $property => $value) {
            $template->addRow([$property, $value]);
        }

        $template->generate($output)->render();
    }
}
