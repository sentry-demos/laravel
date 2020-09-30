
### 1. Installing php

* PHP comes prepackged with MacOS
```
$php --version     
PHP 7.3.11 (cli) (built: Apr 17 2020 19:14:14) ( NTS )
Copyright (c) 1997-2018 The PHP Group
Zend Engine v3.3.11, Copyright (c) 1998-2018 Zend Technologies
```

### 2. Installing composer

* Download [composer](https://getcomposer.org/download/) 


If you didn't use the `--install-dir` and the `--filename` options, please:

`mv composer.phar /usr/local/bin/composer`

Or choose whichever location you prefer, perhaps `/usr/bin/`, depending on your PATH.

This is because:
* The dfault name of the binary is `composer.phar` 
* The default installation path is the current directory.


```
$composer --version
Composer version 1.10.13 2020-09-09 11:46:34
```


3.  Installing Laravel
* Laravel install [Docs](https://laravel.com/docs/8.x#installing-laravel) for reference.

`composer global require laravel/installer`


Edit your ~/.bashrc or ~/.zshrc to add:

`export PATH="$PATH:$HOME/.composer/vendor/bin"`

```
$laravel --version 
Laravel Installer 4.0.5
```
