# Drupal Composer

[![Build Status](https://travis-ci.org/danielnv18/drupal-composer.svg?branch=master)](https://travis-ci.org/danielnv18/drupal-composer)

This project template provides a starter kit for managing your site dependencies
with. This is meant as a starting point. Change things as need it.

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development purposes.

### Prerequisites

In order to create a new project, you will need to have install:

* PHP 7.3 or up (this is only for creating the project)
* Composer
* Lando

### Installing

Replace `project-name` with the name of the folder or the proj ect

```
composer create-project drupal-settings/drupal-composer project-name
```

In order to start the project run:

```
lando start
```

This will install your Drupal project. If there are any configuration files available, it will install Drupal with those
configurations.

## Built With

* [Drupal](https://www.drupal.org/) - The web framework used.
* [Composer](https://getcomposer.org/) - Dependency Management.
* [Lando](https://lando.dev/) -  local development environment tool built on Docker container technology.

## Contributing

Please read [CONTRIBUTING.md](CONTRIBUTING.md) for details on our code of conduct, and the process for submitting pull requests to us.

## Versioning

We use [SemVer](http://semver.org/) for versioning. For the versions available, see the [tags on this repository](https://github.com/danielnv18/drupal-composer/releases).

## Authors

* **Daniel Noyola** - *Initial work* - [danielnv18](https://github.com/danielnv18)

See also the list of [contributors](https://github.com/danielnv18/drupal-composer/graphs/contributors) who participated in this project.

## License

This project is licensed under the GNU v2.0 License - see the [LICENSE.md](LICENSE.md) file for details

## Acknowledgments

* Inspiration: [drupal-composer/drupal-project](https://github.com/drupal-composer/drupal-project)
