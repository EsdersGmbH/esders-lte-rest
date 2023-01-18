# Esders LTE Rest

With the help of this REST API it is possible to receive measurement data from Esders Connect. After your measurement has been uploaded to Esders Connect, this is possible via an Esders device with LTE or via the [Esders Connect App](#esders-connect-app), our server will send the measurement data to your REST.

## Requirements

1. A contract with Esders GmbH to send the measurement data to your server.
2. A web server that is publicly accessible.

## Configuration

### PHP configuration

It's recommended to enable PHP mail functionality on your server. This will give you information in the event of an error, if the REST is not working properly.

### REST configuration

The REST API can be configured via the `config.php` file.

|Constant|Description|
|--|--|
|`SERVER_NAME`|The name for this server|
|`FILE_DIR`|The full path of the upload directory. (Your `www-data` user needs write permissions)|
|`MAIL_FROM`|The sender e-mail address.|
|`ERROR_MAIL`|The email address of the recipient.|
|`LOG_FOLDER`|Log folder for errors and history logs. (Do not change this)|
|`LOGIN_USER`|Username for the client|
|`LOGIN_PASSWORD`|Password for the client (This password must be hashed using the PHP `password_hash` function.)|
|`ALLOWED_FILES`|An array of allowed files that are allowed to be uploaded. (Please note that the desired format must be allowed to ensure a smooth process.)|

### Safety configuration

Change the group of your folders and files to `www-data` (your apache user)

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

## Infos

If you change the username or password, it is necessary that you inform us about it, otherwise it will not be possible to upload the measurement data to your server.

To hash the password you can use [this](https://phppasswordhash.com/) website.

# Esders Connect App

Get the app on all major platforms.

[<img src="images/google-play-badge.svg" alt="Google Play Store" width="200">](https://play.google.com/store/apps/details?id=de.esders.esdersconnect) [<img src="images/app_store.svg" alt="Google Play Store" width="180">](https://apps.apple.com/de/app/esders-connect/id1569801606) [<img src="images/windows.svg" alt="Google Play Store" width="180">](https://update.esders.org/ESD_ConnectPC/setupconnect.exe)