<?php

$directory = __DIR__;
$archiveDirectory = $directory . '/archives';

if (!is_dir($archiveDirectory)) {
    if (!mkdir($archiveDirectory, 0755, true)) {
        die('Unable to create archives directory.');
    }
}

$files = scandir($directory);

if ($files === false) {
    die('Unable to scan the directory.');
}

$count = 0;

foreach ($files as $filename) {
    $source = $directory . '/' . $filename;

    if (
        is_file($source)
        && strtolower(pathinfo($filename, PATHINFO_EXTENSION)) === 'log'
    ) {
        $destination = $archiveDirectory . '/' . $filename;

        if (!copy($source, $destination)) {
            die('Unable to copy a log file.');
        }

        $count++;
    }
}

echo "Copied $count log file(s) to archives.";