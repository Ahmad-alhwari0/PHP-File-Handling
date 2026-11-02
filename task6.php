<?php

$file = fopen(__DIR__ . '/employees.csv', 'r');

if ($file === false) {
    die('Unable to open employees.csv.');
}

$headers = fgetcsv($file, 0, ',', '"', '');

if ($headers === false) {
    fclose($file);
    die('The CSV file is empty.');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Employees</title>
</head>
<body>
    <h1>Employees</h1>

    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <?php foreach ($headers as $header): ?>
                    <th>
                        <?= htmlspecialchars(
                            $header ?? '',
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>
                    </th>
                <?php endforeach; ?>
            </tr>
        </thead>

        <tbody>
            <?php while (($row = fgetcsv($file, 0, ',', '"', '')) !== false): ?>
                <?php if ($row === [null]) continue; ?>

                <tr>
                    <?php foreach ($row as $cell): ?>
                        <td>
                            <?= htmlspecialchars(
                                $cell ?? '',
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </td>
                    <?php endforeach; ?>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>

<?php fclose($file); ?>