<?php

$filename = $_GET['file'] ?? '';

if (
    !is_string($filename)
    || !preg_match('/\A[a-zA-Z0-9_-]+\.(pdf|txt|csv)\z/i', $filename)
) {
    die('Invalid filename.');
}

$directory = realpath(__DIR__ . '/downloads');

if ($directory === false) {
    die('Downloads directory does not exist.');
}

$candidate = $directory . DIRECTORY_SEPARATOR . $filename;

// رفض الروابط الرمزية
if (is_link($candidate)) {
    die('Symbolic links are not allowed.');
}

$path = realpath($candidate);

if ($path === false || !is_file($path)) {
    die('File not found.');
}

// لازم يكون الملف مباشرة داخل downloads
if (dirname($path) !== $directory) {
    die('Access denied.');
}

if (!unlink($path)) {
    die('Unable to delete the file.');
}

echo 'Report deleted successfully.';
