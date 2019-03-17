
::title :setting up Installing Laravel PHP Framework on Ubuntu 18.04 LTS for Apache services 

::author :neonexxa

::subauthor :neonexxa

::last update :18/3/2019

::project location : https://github.com/neonexxa/calbooking

##### 1 ) Pre-Requisites
Before proceeding with the installation, it's always a good idea to make sure your sources and existing software are updated. 

```Console
sudo apt-get update 
sudo apt-get upgrade
```

For this guide, we will assume that you have a basic server based on Ubuntu running. Before Laravel, we need to install other components that are essential.

#####  2) Installing Apache and PHP 7.2
Next step is to install PHP along with several extra packages that would prove useful if you are going to work with Laravel. 

```
sudo add-apt-repository ppa:ondrej/php
sudo apt-get update
sudo apt-get install apache2 libapache2-mod-php7.2 php7.2 php7.2-xml php7.2-gd php7.2-opcache php7.2-mbstring zip unzip php7.2-zip mysql-server
sudo mysql_secure_installation
sudo apt-get install php7.2-mysql
```

Even though Ubuntu's own repository has PHP, it's better to add a 3rd party repository here because it gets more frequently updated. You can skip that step and stick to Ubuntu's version if that's what you prefer.

During the mysql secure installation, do not remove the root remote login access as it will prevent you from having access to the internal db with external software. 

##### 3) Enabling Services
```
sudo systemctl enable apache2.service
sudo systemctl enable mysql.service
systemctl restart apache2.service
```


##### 4) Varify the database connection using command line, and setup your mysql db
```
mysql -u root -p
CREATE DATABASE laravel;
CREATE USER `user`@`localhost` IDENTIFIED BY 'yourmysqlpassword';
GRANT ALL ON laravel.* TO `user`@`localhost`;
FLUSH PRIVILEGES;
EXIT;
```

##### 5) Installing Laravel
Before we finally delve into it, we also need Git version control to be installed. If you have it installed, you can skip the following step. If you don't have, then you can follow our guide to set it up first.

To install Laravel, we need to install Composer first. It is a tool for dependency management in PHP that allows you to package all the required libraries associated with a package as one. To install Laravel and all its dependencies, Composer is required. It will download and install everything that is required to run Laravel framework. To install Composer, issue the following commands.

```
cd /tmp
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```

The curl command downloads composer.phar package to your /tmp directory. But we would want composer to run globally hence we need to move it to /usr/local/bin/ directory under the name 'composer'. Now we can run composer from anywhere.

##### 6) Getting the Cal Project
To get the Laravel project, move to the public html directory on your system. Since we are on Ubuntu and using Apache, we will clone it in the /var/www/html directory.

```
cd /var/www/html
git clone https://github.com/neonexxa/calbooking.git
```

##### 7) Configuring the project

```
cd calbooking
composer install
php artisan key:generate
sudo chgrp -R www-data /var/www/html/calbooking
sudo chgrp -R www-data storage bootstrap/cache
sudo chmod -R ug+rwx storage bootstrap/cache
cp .env.example .env
nano .env
```

##### 8) Setting up laravel env
Your .env file should look something like below

```
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:cJdOsGHeVzu1B9R7ch6Stx4bMjcfVMSICRac9r+yFEo=
APP_DEBUG=true
APP_URL=http://localhost

LOG_CHANNEL=stack

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=

BROADCAST_DRIVER=log
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_DRIVER=smtp
MAIL_HOST=smtp.mailgun.org
MAIL_PORT=587
MAIL_USERNAME=postmaster@sandbox3b07bee9532941d2a26750badbc77974.mailgun.org
MAIL_PASSWORD=supervisor
MAIL_ENCRYPTION=tls

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=mt1

MIX_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
```

Make sure to set your *APP_KEY* is there, and set your items below to your own config

```
DB_DATABASE -> laravel (since we create the db name *laravel* in step 4)

DB_USERNAME -> (refer to what you set on step 4)

DB_PASSWORD -> (refer to what you set on step 4)
```

Please set below items according to your server setting
```
MAIL_DRIVER,MAIL_HOST,MAIL_PORT,MAIL_USERNAME,MAIL_PASSWORD,MAIL_ENCRYPTION
```

Save and exit
```
Ctrl+key(x), key(y), Enter 
```

##### 9) Setting up the database

```
php artisan migrate
php artisan db:seed
```

##### 10) Config apache service
Now go to the /etc/apache2/sites-available directory and use the following command to create a configuration file for our Laravel install.

```
cd /etc/apache2/sites-available
sudo nano laravel.conf
```

Now add the following content to the file and close it after saving. Replace *yourip* with the domain name pointing to here or your Ip address of your server.

```
<VirtualHost *:80>
    ServerName yourip

    ServerAdmin webmaster@localhost
    DocumentRoot /var/www/html/calbooking/public

    <Directory /var/www/html/calbooking>
        AllowOverride All
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
```

##### 11) Register the config and restart apache service

Now we have to enable this newly created .conf file and disable the default .conf file that is installed with the default Apache install. Also, we need to enable mod_rewrite so that permalinks can function properly.

```
sudo a2dissite 000-default.conf
sudo a2ensite laravel.conf
sudo a2enmod rewrite
sudo service apache2 restart
systemctl restart apache2.service
```
