<?php

/**
 * @file
 * Local env.
 */

use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\Dotenv\Exception\ExceptionInterface;

/**
 * Load .env.local file.
 */
$dotenv = new Dotenv();
try {
  $dotenv->load(__DIR__ . '/.env.local');
}
catch (ExceptionInterface $e) {
  // Do nothing.
}
