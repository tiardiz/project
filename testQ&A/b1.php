<?php
$array = [];

for ($i = 0; $i < 1000; $i++) {
    $array[] = rand(1, 1000);
}
foreach ($array as $value) {
    if ($value % 3 === 0 && $value % 5 === 0) {
        echo "$value: foo bar\n";
    } elseif ($value % 3 === 0) {
        echo "$value: foo\n";
    } elseif ($value % 5 === 0) {
        echo "$value: bar\n";
    } else {
        echo $value . "\n";
    }
}
?>
