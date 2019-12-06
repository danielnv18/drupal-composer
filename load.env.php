<?php

/**
 * @file
 * Local env.
 */

use Dotenv\Dotenv;

/**
 * Load any .env file. See /.env.
 */
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();
