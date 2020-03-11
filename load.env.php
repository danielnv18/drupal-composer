<?php

/**
 * @file
 * This file is included very early. See autoload.files in composer.json.
 */

use Dotenv\Dotenv;
use Dotenv\Exception\InvalidPathException;

/**
 * Load any .env file. See /.env.example.
 */
try {
  $dotenv = Dotenv::createImmutable(__DIR__);
  $dotenv->safeLoad();
}
catch (InvalidPathException $exception) {
  // Do nothing.
}
