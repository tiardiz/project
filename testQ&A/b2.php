<?php
function getMinCoins(int $amount) {
    $coins = [100, 50, 20, 10, 5, 2, 1];
    $result = [];

    foreach ($coins as $coin) {
        if ($amount >= $coin) {
            $count = intdiv($amount, $coin); 
            $result[$coin] = $count;
            $amount -= $coin * $count;
        }
    }

    return $result;
}

// Пример:
$amount = 381;
$change = getMinCoins($amount);

foreach ($change as $coin => $count) {
    echo "$coin коп: $count шт." . PHP_EOL;
}
