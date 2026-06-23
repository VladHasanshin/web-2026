<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Цифру в слово</title>
</head>
<body>
    <form method="POST">
        <label>Введите дату:</label>
        <input type="text" name="date" id="date" required>
        <button type="submit">Узнать знак зодиака</button>
    </form>
    <?php

    function getZodiacSign(int $day, int $month): string {
        $zodiacData = [
        1  => [20, 'Козерог', 'Водолей'],
        2  => [19, 'Водолей', 'Рыбы'],
        3  => [20, 'Рыбы', 'Овен'],
        4  => [20, 'Овен', 'Телец'],
        5  => [21, 'Телец', 'Близнецы'],
        6  => [21, 'Близнецы', 'Рак'],
        7  => [22, 'Рак', 'Лев'],
        8  => [21, 'Лев', 'Дева'],
        9  => [23, 'Дева', 'Весы'],
        10 => [23, 'Весы', 'Скорпион'],
        11 => [22, 'Скорпион', 'Стрелец'],
        12 => [22, 'Стрелец', 'Козерог']
        ];
        $limitDay = $zodiacData[$month][0];
        $indexOffset = ($day > $limitDay) ? 1 : 0;
        return $zodiacData[$month][1 + $indexOffset];
    }

    if (isset($_POST['date'])) {
        $date = $_POST['date'];
        $numbers = [];
        $currentNum = 0;
        $hasDigit = false;
        $i = 0;
        while (isset($date[$i])) {
            $char = $date[$i];
            if ($char >= '0' && $char <= '9') {
                $currentNum = $currentNum * 10 + (int)$char;
                $hasDigit = true;
            } elseif ($hasDigit) {
                $numbers[] = $currentNum;
                $currentNum = 0;
                $hasDigit = false;
            }
            $i++;
        }
        // Добавляем последнее число, если строка закончилась цифрой
        if ($hasDigit) {
            $numbers[] = $currentNum;
        }
        $day = 0;
        $month = 0;
        if (isset($numbers[0]) && isset($numbers[1]) && isset($numbers[2])) {
            $num1 = $numbers[0];
            $num2 = $numbers[1];
            $num3 = $numbers[2];
            $year = 0; 
            $rem1 = 0; 
            $rem2 = 0;
            if ($num1 >= 31) { 
                $year = $num1; 
                $rem1 = $num2; 
                $rem2 = $num3; 
            } elseif ($num2 >= 31) { 
                $year = $num2; 
                $rem1 = $num1; 
                $rem2 = $num3; 
            } elseif ($num3 >= 31) { 
                $year = $num3; 
                $rem1 = $num1; 
                $rem2 = $num2; 
            } else {
                // Русский формат
                $day = $num1;
                $month = $num2;
                $year = $num3; 
            }
            // Если год найден явно, распределяем день и месяц
            if ($year !== 0) {
                if ($rem1 > 12) {
                    $day = $rem1;
                    $month = $rem2;
                } elseif ($rem2 > 12) {
                    $day = $rem2;
                    $month = $rem1;
                } else {
                    // ДД.ММ
                    $day = $rem1;
                    $month = $rem2;
                }
            }
        }
        if ($month >= 1 && $month <= 12 && $day >= 1 && $day <= 31) {
            $result = getZodiacSign($day, $month);
            echo "Ваш знак зодиака: $result";
        } else {
            echo 'Не удалось корректно определить дату';
        }
    }
    
    ?> 
</body>
</html>