<?php

namespace IO\Input;

use Filter\DocumentFilter;
use Filter\FilterFactory;
use IO\Exception\DirectoryNotFoundException;
use IO\Exception\DirectoryNotReadableException;
use IO\Exception\NotADirectoryException;

class FinderArguments
{
    use ArgvAccess;

    private ?string $directory;
    private array $filters;

    public static function createFromGlobals(): self
    {
        $arguments = self::getArguments();

        $dir = array_shift($arguments) ?? getcwd();
        $dir = rtrim($dir, DIRECTORY_SEPARATOR);

        return new self($dir, $arguments);
    }

    public function __construct(?string $directory, array $filters)
    {
        $this->guardUnusableDirectory($directory);
        $this->directory = realpath($directory);

        $factory = new FilterFactory();
        $this->filters = array_map([$factory, 'createFromString'], $filters);
    }

    public function getDirectory(): string
    {
        return $this->directory;
    }

    /**
     * @return DocumentFilter[]
     */
    public function getFilters(): array
    {
        return $this->filters;
    }

    private function guardUnusableDirectory(string $directory): void
    {
        if (!file_exists($directory)) {
            throw new DirectoryNotFoundException($directory);
        }
        if (!is_dir($directory)) {
            throw new NotADirectoryException($directory);
        }
        if (!is_readable($directory)) {
            throw new DirectoryNotReadableException($directory);
        }
    }
}
