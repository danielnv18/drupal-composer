<?php

use DrupalFinder\DrupalFinder;
use Drupal\Component\Utility\Crypt;
use Robo\Tasks as RoboTasks;

/**
 * Class Tasks.
 */
class Tasks extends RoboTasks {

  /**
   * Project setup task.
   */
  public function setup() {
    $drupalFinder = new DrupalFinder();
    $drupalFinder->locateRoot(getcwd());
    $composerRoot = $drupalFinder->getComposerRoot();

    // Get current dir name.
    $current_dir = explode('/', $composerRoot);
    $default_project = $current_dir[count($current_dir) - 1];

    // Ask for the project name.
    $projectName = $this->askDefault("What's the project's name?", $default_project);
    $projectName = preg_replace('/\s+/', '-', strtolower(trim($projectName)));

    // Replace drupal-composer with the project name.
    $this->taskReplaceInFile($composerRoot . '/.env.example')
      ->from('drupal-composer')
      ->to($projectName)
      ->run();

    $this->taskReplaceInFile($composerRoot . '/.lando.yml')
      ->from('drupal-composer')
      ->to($projectName)
      ->run();

    $this->taskReplaceInFile($composerRoot . '/drush/sites/self.site.yml')
      ->from('drupal-composer')
      ->to($projectName)
      ->run();

    // Generate a hash.
    $hash = Crypt::randomBytesBase64(55);
    $this->taskReplaceInFile($composerRoot . '/.env.example')
      ->from('pleaseChangeThisToADifferentRandomString')
      ->to($hash)
      ->run();

    // Copy env file.
    copy($composerRoot . '/.env.example', $composerRoot . '/.env');
  }

}
