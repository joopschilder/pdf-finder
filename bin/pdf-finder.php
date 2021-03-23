#!/usr/bin/env php
<?php

use IO\ExceptionHandler;
use IO\Input\FinderArguments;
use IO\Output\DocumentListingOutput;
use PDF\Document;

require_once __DIR__ . '/../vendor/autoload.php';

ExceptionHandler::registerCallback();

$arguments = FinderArguments::createFromGlobals();
$directory = $arguments->getDirectory();
$filters = $arguments->getFilters();

printf('Scanning "%s"...%s', $directory, PHP_EOL);
$locator = new RecursiveDocumentLocator();
$documents = $locator->findDocuments($directory);

foreach ($filters as $filter) {
    printf('Applying filter { %s }...%s', $filter, PHP_EOL);
    $documents = $documents->filter(fn(Document $document) => $filter->allows($document));
}

DocumentListingOutput::forDocuments($documents)->render();
