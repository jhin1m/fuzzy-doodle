<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylor@laravel.com>
 */

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

// This file allows us to emulate Apache's "mod_rewrite" functionality from the
// built-in PHP web server. This provides a convenient way to test a Laravel
// application without having installed a "real" web server software here.
if ($uri !== '/' && file_exists(__DIR__ . '/public' . $uri)) {
    return false;
}



if (defined('LARAVEL_START')) {
    return;
}


if (version_compare(phpversion(), "8.1", "<=")) {
    exit("Error: You must have PHP version 8.1 or greater to run W3LaraAdmin");
}


require_once __DIR__ . '/public/index.php';
