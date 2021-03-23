#!/usr/bin/env php
<?php

use IO\ExceptionHandler;
use IO\Input\ShowInfoArguments;
use IO\Output\DocumentOutput;

require_once __DIR__ . '/../vendor/autoload.php';

ExceptionHandler::registerCallback();

$arguments = ShowInfoArguments::createFromGlobals();
$file = $arguments->getFile();

$documentFactory = DocumentFactory::create();
$document = $documentFactory->createDocument($file);

$output = DocumentOutput::forDocument($document);
$output->render();
