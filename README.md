# Open Source online courses website for Mauritanians

## Built on top of [Symfony 4][1].
## The user interface is built with [Bootstrap 4][2].

![GitHub](https://raw.githubusercontent.com/rand0mdev/rim-edu/master/docs/images/home-screenshot.ar.png)
![GitHub](https://raw.githubusercontent.com/rand0mdev/rim-edu/master/docs/images/home-screenshot.fr.png)

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

1. Install Composer (see http://getcomposer.org/download)

2. Create new project via [Composer][4]

   ```
   $ composer create-project rand0mdev/rim-edu rim-edu.local
   $ composer install
   ```
   
Usage
-----
There's no need to configure anything to run the application. If you have
[installed Symfony][5], run this command and access the application in your
browser at the given URL (<https://localhost:8000> by default):
   ```
   $ cd rim-edu.local/
   $ symfony serve
   ```
If you don't have the Symfony binary installed, run `php -S localhost:8000 -t public/`
to use the built-in PHP web server or [configure a web server][6] like Nginx or
Apache to run the application.

Tests
-----

Execute this command to run tests:

```bash
$ cd rim-edu.local/
$ ./bin/phpunit
```

[1]: https://symfony.com/
[2]: https://getbootstrap.com
[3]: https://symfony.com/doc/current/reference/requirements.html
[4]: https://getcomposer.org/doc/03-cli.md#create-project
[5]: https://symfony.com/download
[6]: https://symfony.com/doc/current/cookbook/configuration/web_server_configuration.html
[7]: http://rim-edu.herokuapp.com
