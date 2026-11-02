<?php

$file = fopen(__DIR__ . '/counter.txt', 'c+');

if ($file === false) {
    die('Unable to open counter.txt.');
}

if (!flock($file, LOCK_EX)) {
    fclose($file);
    die('Unable to lock the file.');
}

try {
    rewind($file);
    $content = stream_get_contents($file);

    if ($content === false) {
        throw new RuntimeException('Unable to read the counter.');
    }

    $count = (int) trim($content);
    $count++;

    rewind($file);

    if (!ftruncate($file, 0)) {
        throw new RuntimeException('Unable to clear the counter.');
    }

    $text = (string) $count;

    if (fwrite($file, $text) !== strlen($text)) {
        throw new RuntimeException('Unable to save the counter.');
    }

    if (!fflush($file)) {
        throw new RuntimeException('Unable to flush the counter.');
    }
} finally {
    flock($file, LOCK_UN);
    fclose($file);
}

echo "Page visits: $count";