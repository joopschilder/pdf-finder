<?php

namespace IO\Output;

use PDF\Document;
use Symfony\Component\Console\Output\OutputInterface;

class DocumentListingOutput implements Output
{
    /** @var Document[] */
    private iterable $documents;

    public function __construct(iterable $documents)
    {
        $this->documents = $documents;
    }

    public static function forDocuments(iterable $documents): self
    {
        return new self($documents);
    }

    public function render(?OutputInterface $output = null): void
    {
        if (count($this->documents) === 0) {
            print('Your search yielded no results.' . PHP_EOL);
            return;
        }

        $template = new TableTemplate([
            'Filename' => [
                'min_width' => 40,
                'max_width' => 80,
            ],
            'Title'    => [
                'min_width'  => 40,
                'max_width'  => 80,
                'null_value' => '-',

            ],
            'Author'   => [
                'min_width'  => 16,
                'max_width'  => 32,
                'null_value' => '-',
            ],
            'Path'     => [
                'min_width' => 16,
                'max_width' => 32,
                'formatter' => static function (string $path) {
                    $search = sprintf('/home/%s', get_current_user());
                    return str_replace($search, '~', $path);
                },
            ],
        ]);

        foreach ($this->documents as $document) {
            $template->addRow([
                $document->file->getBasename(),
                $document->metadata->title,
                $document->metadata->author,
                $document->file->getPath(),
            ]);
        }

        $template->generate($output)->render();
    }
}
