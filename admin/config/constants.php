<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

defined('ROOT_URL') || define('ROOT_URL', 'http://localhost/blog_app/');
defined('DB_HOST') || define('DB_HOST', 'localhost');
defined('DB_USER') || define('DB_USER', 'daniel');
defined('DB_PASS') || define('DB_PASS', 'Admin.1234');
defined('DB_NAME') || define('DB_NAME', 'blog_app');
