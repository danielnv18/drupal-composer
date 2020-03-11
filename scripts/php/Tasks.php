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

    $current_dir = explode('/', $drupalFinder->getComposerRoot());
    $default_project = $current_dir[count($current_dir) - 1];
    $projectName = $this->askDefault("What's the project's name?", $default_project);
    $projectName = preg_replace('/\s+/', '-', strtolower(trim($projectName)));
    $this->say("Project: $projectName");

    $this->taskReplaceInFile($drupalFinder->getComposerRoot() . '/.env.example')
      ->from('drupal-composer')
      ->to($projectName)
      ->run();

    $this->taskReplaceInFile($drupalFinder->getComposerRoot() . '/.lando.yml')
      ->from('drupal-composer')
      ->to($projectName)
      ->run();

    $hash = Crypt::randomBytesBase64(55);
    $this->taskReplaceInFile($drupalFinder->getComposerRoot() . '/.env.example')
      ->from('pleaseChangeThisToADifferentRandomString')
      ->to($hash)
      ->run();
  }

}
