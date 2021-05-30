![GitHub](https://img.shields.io/github/license/mashape/apistatus.svg) [![Build Status](https://travis-ci.com/rand0mdev/courat.svg?token=PJbraSespqsJKtHsBMT2&branch=master)](https://travis-ci.com/rand0mdev/courat) [![CodeFactor](https://www.codefactor.io/repository/github/rand0mdev/courat/badge)](https://www.codefactor.io/repository/github/rand0mdev/courat) 

# Online courses website for Mauritanians

### Built on top of [Symfony 4][1]
### The user interface is built with [Bootstrap 4][2]

![GitHub](https://raw.githubusercontent.com/rand0mdev/courat/master/docs/images/home_fr.png)
![GitHub](https://raw.githubusercontent.com/rand0mdev/courat/master/docs/images/home_ar.png)

Online Demo
-----------
[Visit the website][7]

Requirements
------------

- PHP 7.2.9 or higher;
- PDO-SQLite PHP extension enabled;
- And the [usual Symfony application requirements][3].

Installation
------------

1. Donwload git (see https://git-scm.com/downloads)
2. Install Composer (see http://getcomposer.org/download)

2. Clone the project via [Git][4]

   ```
   $ git clone https://github.com/rand0mdev/courat.git
   $ cd courat
   $ composer install
   ```
   
Usage
-----
There's no need to configure anything to run the application. If you have
[installed Symfony][5], run this command and access the application in your
browser at the given URL (<https://localhost:8000> by default):
   ```
   $ cd courat/
   $ symfony serve
   ```
If you don't have the Symfony binary installed, run `php -S localhost:8000 -t public/`
to use the built-in PHP web server or [configure a web server][6] like Nginx or
Apache to run the application.

Tests
-----

Execute this command to run tests:

```bash
$ cd courat/
$ ./bin/phpunit
```

Contributing
------------
Contributions Are Welcome! Please see [how to contribute page][8] for more details.

[1]: https://symfony.com/
[2]: https://getbootstrap.com
[3]: https://symfony.com/doc/current/reference/requirements.html
[4]: https://git-scm.com/docs/git-clone
[5]: https://symfony.com/download
[6]: https://symfony.com/doc/current/cookbook/configuration/web_server_configuration.html
[7]: https://courat.rimacademy.net
[8]: https://github.com/rand0mdev/courat/blob/master/CONTRIBUTING.md
