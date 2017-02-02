# Morsum test

### Instalation instructions
+ Run `composer install` to install dependencies
+ Add a new virtualhost (here's an example):
```
<VirtualHost *:80>
        ServerName local.morsum.com
        ServerAlias local.morsum.com

        ServerAdmin webmaster@localhost
        DocumentRoot /var/www/html/morsum/public

        ErrorLog ${APACHE_LOG_DIR}/error.log
        CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
```
+ Run `sudo a2ensite morsum.conf` or the name of the .conf file
+ Restart apache
+ Go to `local.morsum.com`

### Usage
#### Database
+ The DB conection is defined in `App\Config.php` class

DB_HOST = 'my_host'

DB_NAME = 'my_database'

DB_USER = 'my_user'

DB_PASSWORD = 'my_password'

#### Models
+ Models are stored into `App\Models` folder
+ They extend the `Core\Model.php` class
+ The `$table` static property is used to store the table name

#### Controllers
+ Controllers are stored into `App\Controllers` folder
+ They follow a naming convention: Resource + `Controller` (i.e.: `AlbumsController`)
+ They extend the main controller
+ Controller methods follow Laravel's RESTful naming convention (index, create, store, show, edit, update, destroy)

#### Views
+ A third party package is used (Twig)
+ Views have to be stored in the `App\Views` folder

#### Routes
+ Routes are defined in `public/index.php`
+ 2 predefined routes are available to use

`http://local.morsum.com/{Controller}/{Method}`
`http://local.morsum.com/{Controller}/{ResourceId}/{Method}`

+ If you try to access an non-existent Controller / Method, an exception is raised
+ If you try to access a route that has not been defined, an exception is raised

#### Errors
+ If you want to send errors to a log file, set `SHOW_ERRORS = false` in the `App\Config.php` class

#### HTTP Response Codes
+ 200 => When retrieving a resource / resources or deleting one (index, show, destroy)
+ 201 => When a new resource is created (store)
+ 404 => Not found
+ 500 => Internal server error
