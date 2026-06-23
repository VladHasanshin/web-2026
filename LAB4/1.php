<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Високосный год</title>
</head>
<body>
    <form method="POST">
        <label>Введите год от 0 до 30000:</label>
        <input type="number" name="year" id="year" required>
        <button type="submit">Проверить</button>
    </form>
    <?php

    if (isset($_POST['year'])) {
        $isLeap = false;
        $year = (int)$_POST['year'];
        if ($year > 0 && $year <= 30000) {
            if ($year % 4 === 0 && $year % 100 !== 0 || $year % 400 === 0) {
                $isLeap = true;
            }
            $result = ($isLeap) ? 'YES' : 'NO';
            echo $result; 
        } else {
            echo 'Введите число от 1 до 30000';
        }
    }

    ?>
</body>
</html>