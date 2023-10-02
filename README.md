# PHP XML-RPC Client for OpenSPP

This project is a PHP-based Odoo client designed to interact with an OpenSPP Odoo server using XML-RPC. It provides functionalities to perform read and search_read operations on different Odoo models.

## Dependencies

- PHP >= 7.1
- [laminas/laminas-xmlrpc](https://docs.laminas.dev/laminas-xmlrpc/) ^2.9
- [laminas/laminas-http](https://docs.laminas.dev/laminas-http/) ^2.12

These dependencies can be installed using Composer.

## Configuration

Configure the client by editing the `config.php` file with the appropriate values:

- `$url`: The URL of the Odoo server.
- `$database`: The database to connect to.
- `$user`: The username to use for authentication.
- `$password`: The password to use for authentication.

## Running the Application

1. Run `composer install`.
2. Edit the `config.php` file.
3. To execute the application, deploy it on a web server that supports PHP, such as NGINX or Apache HTTPD Server, and then access the `apiclient.php` file through a web browser.

> Please ensure that the XML-RPC interface is enabled in your Odoo configuration for the proper functioning of this project.

## Compatibility

This application has been tested and verified on PHP 8.2.0, and it is expected to be compatible with versions of PHP 7.1 and above.
