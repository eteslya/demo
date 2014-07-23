<?php
// Start a fresh session
if (!isset($_SESSION)) {
	session_start();
}
if(!isset($_SESSION['init'])) {
	session_regenerate_id();
	$_SESSION['init'] = true;
}

if (!defined('YES')) define('YES', true, true);
if (!defined('NO')) define('NO', false, true);

/**
 * Database Configuration
 * ----------------------
 * Just fill out the information below. I have supplied some default
 * values for you (Eg. localhost, root, root, secure_login). Only change
 * these values. You can find this information from your host.
 *
 * Have you setup your database? With this project you will find a file
 * named database.sql YOU MUST! install this before this application will work. To
 * find out more information on installing/importing the database.sql file with phpMyAdmin visit
 * this link: http://assets.webassist.com/how-tos/importing_sql.pdf
 */
if (!defined('DB_HOST')) define('DB_HOST', 'localhost');
if (!defined('DB_USER')) define('DB_USER', 'root');
if (!defined('DB_PASS')) define('DB_PASS', 'root');
if (!defined('DB_NAME')) define('DB_NAME', 'simple_secure_login');

/**
 * Application Configuration
 * -------------------------
 * Just some configuration, I have filled out all the defaults. But of course this
 * is yours now so just chang them to suit your needs.
 */
if (!defined('NUMBER_OF_ATTEMPTS')) define('NUMBER_OF_ATTEMPTS', 6);

// REMEMBER TRAILING SLASH >> /
if (!defined('DOMAIN_NAME')) define('DOMAIN_NAME', 'http://localhost/secure-login-original/');

if (!defined('LOGIN_LOCATION')) define('LOGIN_LOCATION', DOMAIN_NAME . 'login.php');

if (!defined('SITE_NAME')) define('SITE_NAME', 'SSLv3.4');
if (!defined('EMAIL_EXT')) define('EMAIL_EXT', 'phpcodemonkey.com');
if (!defined('APP_VERSION')) define('APP_VERSION', '3.4');

// Default redirect, if no redirect is supplied in the
// settings where should it default to?
if (!defined('DEFAULT_REDIRECT')) define('DEFAULT_REDIRECT', 'protected.php');

/**
 * SALT
 *
 * Enter a random string of text, this can be anything see
 * below for an example I have used. Once you have picked one
 * DO NOT CHANGE IT!! If someone has registered and you change
 * this they will not be able to login, they will have to reset
 * their password.
 */
if (!defined('SALT')) define('SALT', 'R4nd0m4$sStR1n6');

/**
 * Messages
 * ------------
 * Custom messages throughout the application. Where you see
 * certain placeholders for example {{username}} you can put this
 * anywhere in the text for example:
 *
 * Sorry but {{username}} is currently in use. (This would look something like)
 * Sorry but JonnoTheBonno is currently in use.
 */
// This will be shown if a person tries some sneaky cross
// site request attack.
if ( !defined('CSRF_FAILURE') ) define('CSRF_FAILURE',"
  CSRF Error: You don't have permissions!
");

// This will be shown when a user fails to enter a
// username and password on login.
if ( !defined('USERNAME_AND_PASSWORD') ) define('USERNAME_AND_PASSWORD',"
  Please enter your username and password!
");

// This will be shown if the user has entered incorrect login details.
if ( !defined('WORNG_LOGIN_DETAILS') ) define('WORNG_LOGIN_DETAILS',"
  Incorrect username and or password!
");

// This is called when the user does not supply an email address.
if ( !defined('NO_EMAIL_ADDRESS') ) define('NO_EMAIL_ADDRESS',"
  Please supply a valid email address!
");

// When the user does not enter their details for the register page.
if ( !defined('REGISTER_FAIL_NO_DETAILS') ) define('REGISTER_FAIL_NO_DETAILS',"
  All fields are required, please check and try again!
");

// When the user enters the wrong captcha.
if ( !defined('INVALID_CAPTCHA') ) define('INVALID_CAPTCHA',"
  Incorrect CAPTCHA, please try again!
");

// When the user enters a username in use.
if ( !defined('USERNAME_IN_USE') ) define('USERNAME_IN_USE',"
  {{username}} is currently in use, choose another!
");

// When the user enters a username in use.
if ( !defined('EMAIL_IN_USE') ) define('EMAIL_IN_USE',"
  {{email}} is currently in use, choose another!
");

// When the user enters an invalid email address
if ( !defined('INVALID_EMAIL_ADDRESS') ) define('INVALID_EMAIL_ADDRESS',"
  {{email}} is invalid!
");

// When the user requested a new password and the email they entered
// was not found in the database.
if ( !defined('REQUEST_NEW_PASSWORD_FAILURE') ) define('REQUEST_NEW_PASSWORD_FAILURE',"
  {{email}} has not been found in the database.
");

// When the user has requested a new password.
if ( !defined('REQUEST_NEW_PASSWORD_SUCCESS') ) define('REQUEST_NEW_PASSWORD_SUCCESS',"
  Success, check your email for further instructions.
");

// When the user has updated their profile.
if ( !defined('USER_PROFILE_UPDATED') ) define('USER_PROFILE_UPDATED',"
  {{username}}'s profile has been updated.
");

// When the user has been deleted.
if ( !defined('USER_HAS_BEEN_DELETED') ) define('USER_HAS_BEEN_DELETED',"
  User has been successfully removed.
");

// When the user has registered successfully.
if ( !defined('REGISTER_SUCCESS') ) define('REGISTER_SUCCESS',"
  Welcome {{username}}, please check your email.
");

// When the user fails to register.
if ( !defined('REGISTER_FAIL') ) define('REGISTER_FAIL',"
  Something went wrong, please try again.
");

// When a users account is deleted.
if ( !defined('ACCOUNT_DELETED') ) define('ACCOUNT_DELETED', "
  Account successfully removed.
");

 /**
  * PHP Settings
  * ------------
  * Just some PHP settings, change these to suit your needs
  * or leave them at default.
  *
  * !IMPORTANT - When going into production mode you might want to change the E_ALL to 0.
  */
 date_default_timezone_set('GMT');
 error_reporting(E_ALL); // When in production change E_ALL to 0