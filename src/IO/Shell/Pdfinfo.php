<?php

namespace IO\Shell;

use PDF\Metadata;

class Pdfinfo
{
    use ShellCommandExecutor;

    public function getMetadata(string $filepath): Metadata
    {
        $lines = $this->shellExec('pdfinfo', '-isodates', $filepath);

        $data = [];
        foreach ($lines as $line) {
            $parts = explode(':', $line, 2);
            if (count($parts) === 2) {
                $data[trim($parts[0])] = trim($parts[1]);
            }
        }

        return (new Metadata)->fillWith($data);
    }
}
