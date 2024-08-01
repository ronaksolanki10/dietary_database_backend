<?php

/**
 * Main entry point for the application.
 * 
 * Sets up CORS headers, loads environment variables,
 * and starts the router.
 */

require_once './vendor/autoload.php';
require_once './routes/api.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

use Dotenv\Dotenv;
use Pecee\SimpleRouter\SimpleRouter as Router;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

Router::start();