<?php

$file = fopen(__DIR__ . '/welcome.txt', 'w');

if ($file === false) {
    die('Unable to create the file.');
}

$result = fwrite($file, 'Welcome to PHP File Handling!');

fclose($file);

if ($result === false) {
    die('Unable to write to the file.');
}

echo 'File created and written successfully.';