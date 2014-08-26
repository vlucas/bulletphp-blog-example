<?php
// PHP 5.4+ built-in webserver - existing static assets should return false
if(php_sapi_name() === 'cli-server') {
    $filename = __DIR__.preg_replace('#(\?.*)$#', '', $_SERVER['REQUEST_URI']);
    if(is_file($filename)) {
        return false;
    }
}

define('BULLET_ROOT', dirname(__DIR__));
define('BULLET_APP_ROOT', BULLET_ROOT . '/app/');
define('BULLET_SRC_ROOT', BULLET_APP_ROOT . '/src/');

// Composer Autoloader
$loader = require BULLET_ROOT . '/vendor/autoload.php';
$request = new Bullet\Request();

// ENV globals
if(defined('PHPUNIT_RUN')) {
    define('BULLET_ENV', 'testing');
} else {
    define('BULLET_ENV', $request->env('BULLET_ENV', 'development'));
}

// Load required environment variables from .env in development
if(BULLET_ENV == 'development') {
    Dotenv::load(dirname(__DIR__));
}
Dotenv::required('DATABASE_URL');

// Bullet App
$app = new Bullet\App(require BULLET_APP_ROOT . 'config.php');

// Common include
require BULLET_APP_ROOT . '/common.php';

// Require all paths/routes
$routesDir = BULLET_APP_ROOT . '/routes/';
require $routesDir . 'index.php';
require $routesDir . 'posts.php';


$app->path('test', function() {
    var_dump($_SERVER);
});

// CLI routes
if($request->isCli()) {
    require $routesDir . 'db.php';
}

// Response
echo $app->run($request);

