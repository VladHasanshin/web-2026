<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Факториал</title>
</head>
<body>
    <form method="POST">
        <label>Введите число:</label>
        <input type="number" id="n" name="n" placeholder="1" required>
        <button type="submit">Вычислить факториал</button>
    </form>
    <?php

    function factorial(int $n) {
        if ($n <= 1) {
            return 1;
        }
        return $n * factorial($n - 1);
    }

    if (isset($_POST['n'])) {
        $number = (int)$_POST['n'];
        if ($number >= 0 and $number <= 20) {
            $result = factorial($number);
            echo "Факториал $number = $result";
        } elseif ($number > 20) {
            echo 'Результат слишком большой';
        } else {
            echo 'Некоректные данные';
        }
    }
    
    ?> 
</body>
</html>