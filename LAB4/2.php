<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Цифру в слово</title>
</head>
<body>
    <form method="POST">
        <label>Введите цифру от 0 до 9:</label>
        <input type="number" name="digit" id="digit" required>
        <button type="submit">Преобразовать в слово</button>
    </form>
    <?php

    function digitToWord(int $num): string {
        switch($num) {
            case 0:
                return 'Ноль';
            case 1:
                return 'Один';
            case 2:
                return 'Два';
            case 3:
                return 'Три';
            case 4:
                return 'Четыре';
            case 5:
                return 'Пять';
            case 6:
                return 'Шесть';
            case 7:
                return 'Семь';
            case 8:
                return 'Восемь';
            case 9:
                return 'Девять';   
        }  
    } 
    
    if (isset($_POST['digit'])) {
        $digit = (int)$_POST['digit'];
        if ($digit >= 0 && $digit <= 9) {
            echo digitToWord($digit);
        } else {
            echo 'Введено некоректное значение';
        }
    }
    
    ?> 
</body>
</html>