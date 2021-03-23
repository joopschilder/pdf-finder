<?php

namespace IO\Input;

use Filter\DocumentFilter;
use Filter\FilterFactory;
use IO\Exception\DirectoryNotFoundException;
use IO\Exception\NotADirectoryException;

class FinderArguments
{
    use ArgvAccess;

    private ?string $directory;
    private array $filters;

    public function __construct(?string $directory, array $filters)
    {
        $this->directory = $directory;
        $this->filters = $filters;

        $factory = new FilterFactory();
        $this->filters = array_map([$factory, 'createFromString'], $this->filters);
    }

    public static function createFromGlobals(): self
    {
        $arguments = self::getArguments();

        $dir = array_shift($arguments) ?? getcwd();
        $dir = rtrim($dir, DIRECTORY_SEPARATOR);

        return new self($dir, $arguments);
    }

    public function getDirectory(): string
    {
        if (!file_exists($this->directory)) {
            throw new DirectoryNotFoundException($this->directory);
        }
        if (!is_dir($this->directory)) {
            throw new NotADirectoryException($this->directory);
        }
        
        return $this->directory;
    }

    /**
     * @return DocumentFilter[]
     */
    public function getFilters(): array
    {
        return $this->filters;
    }
}
