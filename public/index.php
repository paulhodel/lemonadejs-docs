<?php

// Base folder outside public
chdir(__DIR__ . '/..');

if (file_exists('vendor/autoload.php')) {
    include 'vendor/autoload.php';
}

include 'config.php';

use bossanova\Render\Render;

// Run application
Render::run();
