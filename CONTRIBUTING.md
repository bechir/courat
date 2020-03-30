# Contributions Are Welcome!

COURAT is an open source project. Contributions made by the community are welcome.
Please don't hesitate, send us your ideas, code reviews, pull requests and feature requests to help us improve this project.

## Quick Guide

* [Fork](https://help.github.com/articles/fork-a-repo/) the repo.
* [Checkout](https://git-scm.com/docs/git-checkout) the branch you want to make changes on:
  * If you are fixing a bug or typo, improving tests or for any small tweak: the lowest branch where the changes can be applied. Once your Pull Request is accepted, the changes will get merged up to highest branches.
* Install dependencies: `composer install`.
* Create a new branch, e.g. `feature-foo` or `bugfix-bar`.
* Make changes.
* If you are adding functionality or fixing a bug - it is better to add a test!
* Check if it tests pass: `./vendor/bin/phpunit`.
* Fix project itself: `php ./vendor/bin/php-cs-fixer fix`.

## Opening a [Pull Request](https://help.github.com/articles/about-pull-requests/)

You can do some things to increase the chance that your Pull Request is accepted the first time:

* Submit one Pull Request per fix or feature.
* If your changes are not up to date, [rebase](https://git-scm.com/docs/git-rebase) your branch onto the parent branch.
* Follow the conventions used in the project.
* Remember about tests and documentation.
* Don't bump version.

## Project's Standards
* [PSR-1: Basic Coding Standard](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-1-basic-coding-standard.md)
* [PSR-2: Coding Style Guide](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md)
* [PSR-4: Autoloading Standard](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md)
* [PSR-5: PHPDoc (draft)](https://github.com/phpDocumentor/fig-standards/blob/master/proposed/phpdoc.md)
* [Symfony Coding Standards](https://symfony.com/doc/current/contributing/code/standards.html)

## Any contributions you make will be under the MIT Software License
In short, when you submit code changes, your submissions are understood to be under the same [MIT License](http://choosealicense.com/licenses/mit/) that covers the project.
Feel free to contact the maintainers if that's a concern.
