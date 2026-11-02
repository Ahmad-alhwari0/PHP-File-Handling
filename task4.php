<?php

date_default_timezone_set('Asia/Amman');

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $entry = $_POST['entry'] ?? '';
    $entry = is_string($entry) ? trim($entry) : '';

    if ($entry === '') {
        $message = 'Please enter a message.';
    } else {
        $entry = str_replace(["\r\n", "\r", "\n"], ' ', $entry);

        $line = '[' . date('Y-m-d H:i:s') . '] '
              . $entry . PHP_EOL;

        $result = file_put_contents(
            __DIR__ . '/guestbook.txt',
            $line,
            FILE_APPEND | LOCK_EX
        );

        if ($result === false) {
            $message = 'Unable to save your message.';
        } else {
            header('Location: task4.php?saved=1');
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Guestbook</title>
</head>
<body>
    <h1>Guestbook</h1>

    <?php if (($_GET['saved'] ?? '') === '1'): ?>
        <p>Message saved successfully.</p>
    <?php endif; ?>

    <p><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></p>

    <form method="POST" action="task4.php">
        <label for="entry">Your message</label><br>
        <textarea id="entry" name="entry"
                  rows="5" cols="40" required></textarea><br>

        <button type="submit">Submit</button>
    </form>
</body>
</html>
