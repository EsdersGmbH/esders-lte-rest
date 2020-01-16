# Esders LTE Rest

This REST is for your Esders reports upload.

So you can easily upload your reports from an Esders device with lte (or an NGP device via bluetooth to your phone (coming soon)), to your Server.

## Requirement

1. Contract with Esders GmbH to send the LTE data to your server.
2. A web server that can be reached via the internet.

## Configuration

### PHP configuration

Please configure your PHP-Server so it is possible to use the PHP mail function. Than you can get information if the REST doesn't work.

### REST configuration

You can configure this REST in the `config.php`.

|Constant|Description|
|--|--|
|`SERVER_NAME`|The name for this server|
|`FILE_DIR`|The full path of the upload directory. (Your `www-data` user need writing rights)|
|`MAIL_FROM`|The e-mail address that send the error mails.|
|`ERROR_MAIL`|The e-mail address where the e-mail are send to.|
|`LOG_FOLDER`|Log folder for errors and history logs. (Don't change this)|
|`LOGIN_USER`|User to allow use of the REST|
|`LOGIN_PASSWORD`|Hashed password to allow use of the REST|
|`ALLOWED_FILES`|The value is an array with all allowed file fromates for the upload.|
|||

### Safety configuration

Change Group of your folders and files to `www-data` (your apache user)

#### Rights:

|File/Folder|Rights|
|--|--|
|`lib/`|750|
|`lib/error.php`|640|
|`lib/rest.php`|640|
|`logs/`|770|
|`.htaccess`|644|
|`config.php`|640|
|`index.php`|644|
|||

## Infos

You can also send us your desire username and password as well.
To set your desire password hash in the `config.php` you can use the page below.

[https://php-password-hash-online-tool.herokuapp.com/password_hash](https://php-password-hash-online-tool.herokuapp.com/password_hash)