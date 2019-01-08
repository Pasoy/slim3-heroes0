<?php

$settings = [];

// Slim settings
$settings['displayErrorDetails'] = true;

// Path settings
$settings['root'] = dirname(__DIR__);
$settings['temp'] = $settings['root'] . '/tmp';
$settings['public'] = $settings['root'] . '/public';

// Database settings
$settings['db']['host'] = "localhost";
$settings['db']['user'] = "root";
$settings['db']['pass'] = "";
$settings['db']['dbname'] = "slim3db";

return $settings;