<?php

namespace DrupalComposer\composer;

use Composer\Script\Event;
use Composer\Semver\Comparator;
use DrupalFinder\DrupalFinder;
use Drupal\Component\Utility\Crypt;

/**
 * Project Create script.
 */
class ScriptHandler {

  /**
   * Project setup event.
   *
   * @param \Composer\Script\Event $event
   *   Composer event object.
   */
  public static function setupProject(Event $event) {
    $io = $event->getIO();

    $drupalFinder = new DrupalFinder();
    $drupalFinder->locateRoot(getcwd());

    $current_dir = explode('/', $drupalFinder->getComposerRoot());
    $default_project = $current_dir[count($current_dir) - 1];
    $project = $io->ask("What's the project's name? [{$default_project}]: ", $default_project);
    $save_project = preg_replace('/\s+/', '-', strtolower(trim($project)));

    exec(
      "sed -i \"s+drupal-composer+{$save_project}+g\" " . $drupalFinder->getComposerRoot() . "/.env.example"
    );
    exec(
      "sed -i \"s+drupal-composer+{$save_project}+g\" " . $drupalFinder->getComposerRoot() . "/.lando.yml"
    );

    $hash = Crypt::randomBytesBase64(55);
    exec(
      "sed -i \"s+pleaseChangeThisToADifferentRandomString+{$hash}+g\" " . $drupalFinder->getComposerRoot() . "/.env.example"
    );
  }

  /**
   * Checks if the installed version of Composer is compatible.
   *
   * Composer 1.0.0 and higher consider a `composer install` without having a
   * lock file present as equal to `composer update`. We do not ship with a lock
   * file to avoid merge conflicts downstream, meaning that if a project is
   * installed with an older version of Composer the scaffolding of Drupal will
   * not be triggered. We check this here instead of in drupal-scaffold to be
   * able to give immediate feedback to the end user, rather than failing the
   * installation after going through the lengthy process of compiling and
   * downloading the Composer dependencies.
   *
   * @see https://github.com/composer/composer/pull/5035
   */
  public static function checkComposerVersion(Event $event) {
    $composer = $event->getComposer();
    $io = $event->getIO();

    $version = $composer::VERSION;

    // The dev-channel of composer uses the git revision as version number,
    // try to the branch alias instead.
    if (preg_match('/^[0-9a-f]{40}$/i', $version)) {
      $version = $composer::BRANCH_ALIAS_VERSION;
    }

    // If Composer is installed through git we have no easy way to determine if
    // it is new enough, just display a warning.
    if ($version === '@package_version@' || $version === '@package_branch_alias_version@') {
      $io->writeError('<warning>You are running a development version of Composer. If you experience problems, please update Composer to the latest stable version.</warning>');
    }
    elseif (Comparator::lessThan($version, '1.0.0')) {
      $io->writeError('<error>Drupal-project requires Composer version 1.0.0 or higher. Please update your Composer before continuing</error>.');
      exit(1);
    }
  }

}
