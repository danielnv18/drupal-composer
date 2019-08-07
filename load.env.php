<?php

/**
 * This file is included very early. See autoload.files in composer.json and
 * https://getcomposer.org/doc/04-schema.md#files
 */

use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\Dotenv\Exception\ExceptionInterface;

/**
 * Load .env.local file.
 */
$dotenv = new Dotenv();
try {
  $dotenv->load(__DIR__.'/.env.local');
}
catch (ExceptionInterface $e) {
  // Do nothing.
}
