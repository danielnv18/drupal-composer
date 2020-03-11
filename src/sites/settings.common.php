<?php

/**
 * @file
 * Common site settings.
 */

/**
 * Load environment.
 */
$env = getenv('ENVIRONMENT');

/**
 * Salt for one-time login links, cancel links, form tokens, etc.
 *
 * This variable will be set to a random value by the installer. All one-time
 * login links will be invalidated if the value is changed. Note that if your
 * site is deployed on a cluster of web servers, you must ensure that this
 * variable has the same value on each server.
 *
 * For enhanced security, you may set this variable to the contents of a file
 * outside your document root; you should also ensure that this file is not
 * stored with backups of your database.
 */
$settings['hash_salt'] = getenv('SALT');

/**
 * Location of the site configuration files.
 *
 * The $config_directories array specifies the location of file system
 * directories used for configuration data.
 */
$config_directories[CONFIG_SYNC_DIRECTORY] = __DIR__ . '/../config/default';

/**
 * Private file path.
 *
 * A local file system path where private files will be stored. This directory
 * must be absolute, outside of the Drupal installation directory and not
 * accessible over the web.
 *
 * Note: Caches need to be cleared when this value is changed to make the
 * private:// stream wrapper available to the system.
 *
 * See https://www.drupal.org/documentation/modules/file for more information
 * about securing private files.
 */
$settings['file_private_path'] = $app_root . '/../private';

/**
 * Disable all config splits by default. Each env settings should define it.
 */
$config['config_split.config_split.dev']['status'] = FALSE;
$config['config_split.config_split.prod']['status'] = FALSE;

/**
 * Load specific environment settings and services.
 */
$servicesFile = $app_root . '/' . $site_path . '/services/services.' . $env . '.yml';
$settingsFile = $app_root . '/' . $site_path . '/settings/settings.' . $env . '.php';
if (file_exists($servicesFile)) {
  $settings['container_yamls'][] = $servicesFile;
}
if (file_exists($settingsFile))
{
  include $settingsFile;
}

$settings['config_exclude_modules'] = ['devel'];

/**
 * Database settings.
 *
 * The $databases array specifies the database connection or
 * connections that Drupal may use.  Drupal is able to connect
 * to multiple databases, including multiple types of databases,
 * during the same request.
 */
$databases['default']['default'] = [
  'database' => getenv('DATABASE_NAME'),
  'username' => getenv('DATABASE_USER'),
  'password' => getenv('DATABASE_PASSWORD'),
  'prefix' => '',
  'host' => getenv('DATABASE_HOST'),
  'port' => getenv('DATABASE_PORT'),
  'namespace' => 'Drupal\\Core\\Database\\Driver\\mysql',
  'driver' => 'mysql',
];

/**
 * Load local development override configuration, if available.
 *
 * Use settings.local.php to override variables on secondary (staging,
 * development, etc) installations of this site. Typically used to disable
 * caching, JavaScript/CSS compression, re-routing of outgoing emails, and
 * other things that should not happen on development and testing sites.
 */
if (file_exists(__DIR__ . '/settings.local.php')) {
  include __DIR__ . '/settings.local.php';;
}
