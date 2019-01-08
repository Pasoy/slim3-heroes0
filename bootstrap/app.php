<?php

session_start();

require __DIR__ . '/../vendor/autoload.php';

$app = new \Slim\App(['settings' => require __DIR__ . '/../config/settings.php']);

require __DIR__ . '/../app/container.php';
require __DIR__ . '/../app/routes.php';