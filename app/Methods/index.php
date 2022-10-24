<?php

// This file used to add global method from other file in app/Methods directory
// To add method:
// 1. Create New File
// 2. Create the method there
// You can see example in app/Methods/example.php

$files = glob(dirname(__FILE__) . "/*.php");

foreach ($files as $file) {
    $path_parts = pathinfo($file);
    if (!in_array($path_parts['basename'], array('.', '..', 'index.php'))) {
        include  $path_parts['basename'];
    }
};
