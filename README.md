# Shouty

Shouty is a social networking application for short physical distances.
When someone shouts, only people within 1000m can hear it.

Shouty doesn't exist yet - you will implement it yourself!

That is, if you're attending a BDD/Cucumber/Behat course.

## Agenda

### Get the code

Git:

    git clone https://github.com/cucumber-ltd/shouty.php.git

Subversion:

    svn checkout https://github.com/cucumber-ltd/shouty.php/trunk shouty.php

Or simply [download](https://github.com/cucumber-ltd/shouty.php/releases) a zip or tarball.

### Set up environment

* Open a shell
* Go into the shouty directory: `cd shouty.php`
* Install [Composer](https://getcomposer.org/) - a package manager for PHP
* Get dependencies: `composer install` or `./composer.phar install` if you did a local install
* Run the tests: `./test-all`

#### Troubleshooting

You might get this error:

```
Fatal error: Maximum function nesting level of '100' reached, aborting!
```

In that case, you need to add the following to your `php.ini` file:

```
xdebug.max_nesting_level = 1000
```

If Behat is not giving you errors, you might want to verify that your `php.ini`
file has this:

```
error_reporting = E_ALL | E_STRICT
display_errors = On
```

