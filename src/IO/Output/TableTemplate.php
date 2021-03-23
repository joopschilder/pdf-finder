<?php

namespace IO\Output;

use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;

class TableTemplate
{
    private array $headers;
    private array $properties;
    private array $rows = [];

    public function __construct(array $properties)
    {
        $this->headers = array_keys($properties);
        $this->properties = array_values($properties);
    }

    public function addRow(array $row): void
    {
        $row = array_values($row);

        foreach ($row as $columnIndex => &$value) {
            if (isset($this->properties[$columnIndex]['null_value'])) {
                $value ??= $this->properties[$columnIndex]['null_value'];
            }
            if (isset($this->properties[$columnIndex]['formatter'])) {
                $value = call_user_func($this->properties[$columnIndex]['formatter'], $value);
            }
            if (isset($this->properties[$columnIndex]['max_width'])) {
                $value = $this->trim($value, $this->properties[$columnIndex]['max_width']);
            }
        }
        unset($value);

        $this->rows[] = $row;
    }

    public function generate(?OutputInterface $output = null): Table
    {
        $table = new Table($output ?? new ConsoleOutput());
        $table->setStyle('box-double');
        $table->setHeaders($this->headers);

        foreach ($this->properties as $columnIndex => $columnProperties) {
            if (isset($columnProperties['min_width'])) {
                $table->setColumnWidth($columnIndex, $columnProperties['min_width']);
            }
            if (isset($columnProperties['max_width'])) {
                $table->setColumnMaxWidth($columnIndex, $columnProperties['max_width']);
            }
        }

        $table->setRows($this->rows);
        return $table;
    }

    /**
     * Trims a string if it's longer than $length and adds '...' to the end if trimmed.
     * @param string $string
     * @param int $length
     * @return string
     */
    private function trim(string $string, int $length): string
    {
        if (strlen($string) <= $length) {
            return $string;
        }

        return '' . substr($string, 0, $length - 3) . '...';
    }
}
