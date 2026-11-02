<?php

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $file = $_FILES['picture'] ?? null;

    if (
        !is_array($file)
        || !isset($file['error'])
        || !is_int($file['error'])
    ) {
        $message = 'Please select an image. The request may be too large.';
    } elseif ($file['error'] !== UPLOAD_ERR_OK) {
        $message = 'Upload failed. Select an image no larger than 2MB.';
    } else {
        $temporaryPath = $file['tmp_name'];
        $size = filesize($temporaryPath);

        $allowedTypes = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png'
        ];

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($temporaryPath);
        $imageInfo = @getimagesize($temporaryPath);

        if ($size === false || $size === 0 || $size > 2 * 1024 * 1024) {
            $message = 'Image size must be between 1 byte and 2MB.';
        } elseif (
            !isset($allowedTypes[$mime])
            || $imageInfo === false
            || $imageInfo['mime'] !== $mime
        ) {
            $message = 'Only JPG and PNG images are allowed.';
        } else {
            $directory = __DIR__ . '/uploads';

            if (!is_dir($directory) && !mkdir($directory, 0755, true)) {
                die('Unable to create uploads directory.');
            }

            $filename = bin2hex(random_bytes(16))
                      . '.' . $allowedTypes[$mime];

            if (move_uploaded_file(
                $temporaryPath,
                $directory . '/' . $filename
            )) {
                $message = 'Image uploaded successfully.';
            } else {
                $message = 'Unable to save the image.';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload Profile Picture</title>
</head>
<body>
    <h1>Upload Profile Picture</h1>

    <p><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></p>

    <form method="POST" action="task5.php"
          enctype="multipart/form-data">

        <label for="picture">JPG or PNG — maximum 2MB</label><br>

        <input type="file" id="picture" name="picture"
               accept="image/jpeg,image/png" required>

        <button type="submit">Upload</button>
    </form>
</body>
</html>
