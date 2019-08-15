<?php

/**
 * @file
 * Dev development override configuration.
 */

use Drupal\Component\Assertion\Handle;

// Active config-split.
$config['config_split.config_split.dev']['status'] = TRUE;

// Trusted hosts.
$settings['trusted_host_patterns'] = isset($settings['trusted_host_patterns']) ? $settings['trusted_host_patterns'] : [];

// Enable error reporting and XDEBUG trace.
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
$config['system.logging']['error_level'] = 'all';
ini_set('xdebug.collect_params', '2');

// Development settings.
// For cached testing, override in your settings.local.php.
$config['system.logging']['error_level'] = 'verbose';
$config['system.performance']['css']['preprocess'] = FALSE;
$config['system.performance']['js']['preprocess'] = FALSE;
$config['system.performance']['cache.page.max_age'] = 0;

// Disable render cache.
$settings['cache']['bins']['render'] = 'cache.backend.null';
$settings['cache']['bins']['dynamic_page_cache'] = 'cache.backend.null';

// Devel settings.
$config['devel.settings']['devel_dumper'] = 'kint';
$config['devel.settings']['error_handlers'][1] = 4;

assert_options(ASSERT_ACTIVE, TRUE);
Handle::register();

/**
 * Enable local development services.
 */
$settings['container_yamls'][] = DRUPAL_ROOT . '/sites/development.services.yml';

/**
 * Show all error messages, with backtrace information.
 *
 * In case the error level could not be fetched from the database, as for
 * example the database connection failed, we rely only on this value.
 */
$config['system.logging']['error_level'] = 'verbose';

/**
 * Enable access to rebuild.php.
 */
$settings['rebuild_access'] = TRUE;

/**
 * Skip file system permissions hardening.
 */
$settings['skip_permissions_hardening'] = TRUE;

if (!function_exists('watchdog')) {

  /**
   * Helper log function.
   */
  function watchdog($message, $tag = NULL) {
    $tag = $tag ? $tag : 'debug';
    \Drupal::logger($tag)->notice($message);
  }

}
