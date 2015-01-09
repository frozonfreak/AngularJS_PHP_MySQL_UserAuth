<?php
/**
 * Database config variables
 */
define("DB_STRING","mysql:host=localhost;dbname=user_auth");
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASSWORD", "root");

//Some default config values
define("DEFAULT_EMAIL_VERIFIED", false);
define("DEFAULT_SEND_EMAIL_VERIFICATION", false);
define("DEFAULT_RESET_PASS", true);
define("DEFAULT_USER_ROLE", 1);
define("DEFAULT_SESSION_TIME", 1800);
?>