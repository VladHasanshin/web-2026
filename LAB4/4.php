<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Счастливые билеты</title>
</head>
<body>
    <form method="POST">
        <label>Начальный номер билета:</label>
        <input type="number" id="start" name="start" placeholder="111111" required><br>
        <label>Конечный номер билета:</label>
        <input type="number" id="end" name="end" placeholder="123321" required><br>
        <button type="submit">Найти счастливые билеты</button>
    </form>
    <?php
    
    const range = 999999;

    function getLuckyTickets(int $start, int $end): array {
        $results = [];
        $resultCount = 0;
        if (($end - $start) > range) {
            return []; 
        } else {
            for ($i = $start; $i < $end; $i++) {
                // Извлечение 6 цифр
                $d1 = (int)($i / 100000) % 10;
                $d2 = (int)($i / 10000) % 10;
                $d3 = (int)($i / 1000) % 10;
                $d4 = (int)($i / 100) % 10;
                $d5 = (int)($i / 10) % 10;
                $d6 = $i % 10;
                // Нахождение 1 и 2 тройки
                $sum1 = $d1 + $d2 + $d3;
                $sum2 = $d4 + $d5 + $d6;
                $lucky = ($sum1 == $sum2) ? 1 : 0;
                $ticket = $d1 . $d2 . $d3 . $d4 . $d5 . $d6;
                if ($lucky === 1) {
                    $results[$resultCount] = $ticket;
                    $resultCount = $resultCount + $lucky;    
                }
            }
            return $results;
        }
    }    

    if ((isset($_POST['start'])) and (isset($_POST['end']))) {
        $start = (int)$_POST['start'];
        $end = (int)$_POST['end'];
        $found = 0;
        $luckyTickets = getLuckyTickets($start, $end);
        foreach ($luckyTickets as $ticket) {
            echo $ticket . '<br>';
            $found++;
        } 
        if ($found === 0) {
            echo 'Счастливых билетов не найдено';
        }   
    }
    
    ?> 
</body>
</html>