<?php

$file = fopen(__DIR__ . '/fruits.txt', 'r');

if ($file === false) {
    die('Unable to open fruits.txt.');
}

echo '<ul>';

while (($line = fgets($file)) !== false) {
    echo '<li>' . htmlspecialchars(trim($line), ENT_QUOTES, 'UTF-8') . '</li>';
}

echo '</ul>';

fclose($file);
