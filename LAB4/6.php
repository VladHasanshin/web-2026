<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Обратная польская запись</title>
</head>
<body>
    <form method="POST">
        <label>Введите выражение</label>
        <input type="text" id="exp" name="exp" placeholder="8 9 + 1 7 - *" required>
        <button type="submit">Вычислить</button>
    </form>
    <?php

    function calcExpression(string $exp): int {
        $stack = [];
        $p = -1;
        for ($i = 0; isset($exp[$i]); $i++) {
            $char = $exp[$i];
            if ($char === ' ') {
                continue;
            }
            if ($char >= '0' && $char <= '9') {
                $p++;
                $stack[$p] = (int)$char;
            } elseif ($char === '+' || $char === '-' || $char === '*') {
                $b = $stack[$p];
                $p--;
                $a = $stack[$p];
                $p--;
                $res = 0;
                if ($char === '+') {
                    $res = $a + $b;
                } elseif ($char === '-') {
                    $res = $a - $b;
                } elseif ($char === '*')  {
                    $res = $a * $b;
                }
                $p++;
                $stack[$p] = $res;
            }
        }        
        return $stack[0];
    }

    if (isset($_POST['exp'])) {
        $expression = $_POST['exp'];
        $result = calcExpression($expression);
        echo "Ответ: $result";  
    }
    
    ?> 
</body>
</html>