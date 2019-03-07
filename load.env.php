<?php

/**
 * This file is included very early. See autoload.files in composer.json and
 * https://getcomposer.org/doc/04-schema.md#files
 */

use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\Dotenv\Exception\ExceptionInterface;

/**
 * Load any .env file. See /.env.example.
 */
$dotenv = new Dotenv();
try {
  $dotenv->load(__DIR__.'/.env');
}
catch (ExceptionInterface $e) {
  // Do nothing. Production environments rarely use .env files.
}
