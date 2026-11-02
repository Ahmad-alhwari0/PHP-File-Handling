<?php

$source = __DIR__ . '/config.txt';
$destination = __DIR__ . '/config.bak';

if (!file_exists($source)) {
    die('Error: config.txt does not exist.');
}

if (!rename($source, $destination)) {
    die('Error: Unable to rename the file.');
}

echo 'File renamed to config.bak successfully.';