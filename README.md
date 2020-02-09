# Drupal Composer

[![Build Status][build-status-master]][build-url]

This project template provides a starter kit for managing your site dependencies
with and it is inspired by [this project][drupal-composer]. This is meant as a
starting point. Change things as need it.

## Create Project
```bash
composer create-project drupal-settings/drupal-composer project-name
```
Replace `project-name` with the name of the folder or the project

## Quick start
In order to start the project run:
```bash
lando start
```
This will install your Drupal project. If there are any configuration files available, it will install
Drupal with those configurations.

[drupal-composer]: https://github.com/drupal-composer/drupal-project
[build-status-master]: https://travis-ci.org/danielnv18/drupal-composer.svg?branch=master
[build-url]: https://travis-ci.org/danielnv18/drupal-composer.svg?branch=master
