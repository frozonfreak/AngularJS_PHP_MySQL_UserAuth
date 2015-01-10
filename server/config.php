<?php
/**
 * Database config variables
 */
define("DB_STRING","mysql:host=localhost;dbname=user_auth");
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASSWORD", "root");

//Some default config values
define("DEFAULT_SEND_EMAIL_WELCOME", true);
define("DEFAULT_EMAIL_VERIFIED", false);
define("DEFAULT_SEND_EMAIL_VERIFICATION", false);
define("DEFAULT_RESET_PASS", true);
define("DEFAULT_USER_ROLE", 1);
define("DEFAULT_SESSION_TIME", 1800);
define("DEFAULT_HOST", 'http://localhost/');

define("DEFAULT_SMTP_HOST", 'smtp.gmail.com');
define("DEFAULT_SMTP_USER", 'test@gmail.com');
define("DEFAULT_SMTP_PASSWORD", '1234567890');
?>