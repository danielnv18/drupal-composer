# Coding Standards
Coding standards are a set of guidelines, best practices, programming styles and conventions that developers adhere to 
when writing source code for this project.

> Info taken from this [article](https://www.lullabot.com/articles/how-enforce-drupal-coding-standards-git) from [Lullabot](https://www.lullabot.com)
Provides set of libraries to easily setup code quality checks based on [GrumPHP](https://github.com/phpro/grumphp) for Drupal module/theme/profile.

## Drupal
This project impose Drupal code standard using GrumPHP.

### Whitelist a code
If you have an special situation where a peace of code need to be ignore:
```php
<?php
// @codingStandardsIgnoreLine
$honeyBadger = new HoneyBadger();

// Or on the same line.
$honeyBadger = new HoneyBadger(); // @codingStandardsIgnoreLine

// Or a code Block
// @codingStandardsIgnoreStart
$honeyBadger = new HoneyBadger();
if ($honeyBadger.cares()) throw new Exception();
// @codingStandardsIgnoreEnd
```
or an entire file
```php
<?php
// @codingStandardsIgnoreFile
class HoneyBadger {
  public function cares() { return FALSE; }
}
```

### GrumPHP doesn't do anything?
GrumPHP pre-commit script only checks your added/changed files for violations, not all the code in your project. 
Generally, this is a good thing, as you don’t want to fix unrelated code in your pull request. But if you do want to run
a complete check of all the code in the repository or a specific directory, you can use your code editor to generate a 
report or one of these command-line tools:
```bash
php vendor/bin/grumphp run
```
