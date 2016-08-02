MenulogApplication
==================

Introduction
------------
This is a simple application using the ZF2 MVC layer and module
systems. This application is meant to be used as a small restaurant search and their products display.

Installation
------------

System Requirement
------------------
PHP >= 5.6
Redis >= 2.3

Using Composer
----------------------------
The recommended way to get a working copy of this project is to clone the repository
and use `composer` to install dependencies command:
    cd menulog
    curl -s https://getcomposer.org/installer | php
    php composer.phar install

### Apache Setup

To setup apache, setup a virtual host to point to the public/ directory of the
project and you should be ready to go! It should look something like below:

    <VirtualHost *:80>
        ServerName menulog.localhost
        DocumentRoot /path/to/menulog/public
        SetEnv APPLICATION_ENV "development"
        <Directory /path/to/menulog/public>
            DirectoryIndex index.php
            AllowOverride All
            Order allow,deny
            Allow from all
        </Directory>
    </VirtualHost>


PHPUnit test CodeCoverage
-------------------------

https://travis-ci.org/xu-tony/menulog

 Summary:
  Classes:  0.00% (0/13)
  Methods: 30.43% (21/69)
  Lines:   29.80% (104/349)

\Menulog\Mapper::JeApi
  Methods:  42.86% ( 3/ 7)   Lines:  36.71% ( 58/158)

\Menulog\Model::Image
  Methods:  33.33% ( 1/ 3)   Lines:  50.00% (  2/  4)

\Menulog\Model::Menu
  Methods:  22.22% ( 2/ 9)   Lines:  17.39% (  4/ 23)

\Menulog\Model::Product
  Methods:   7.69% ( 1/13)   Lines:   8.00% (  2/ 25)

\Menulog\Model::ProductCategory
  Methods:  28.57% ( 2/ 7)   Lines:  21.05% (  4/ 19)

\Menulog\Model::Restaurant
  Methods:  52.94% ( 9/17)   Lines:  44.74% ( 17/ 38)

\Menulog\Service::RestaurantsService
  Methods:  60.00% ( 3/ 5)   Lines:  58.62% ( 17/ 29)
