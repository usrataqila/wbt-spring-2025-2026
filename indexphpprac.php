<?php
$length = 10;
$width = 5;

$area = $length * $width;
$perimeter = 2 * ($length + $width);

echo "1. Area and Perimeter of Rectangle<br>";
echo "Length = " . $length . "<br>";
echo "Width = " . $width . "<br>";
echo "Area = " . $area . "<br>";
echo "Perimeter = " . $perimeter . "<br><br>";


$amount = 1000;
$vat = $amount * 0.15;

echo "2. VAT Calculation<br>";
echo "Amount = " . $amount . "<br>";
echo "VAT (15%) = " . $vat . "<br><br>";


$number = 7;

echo "3. Odd or Even<br>";
if ($number % 2 == 0) {
    echo $number . " is Even";
} else {
    echo $number . " is Odd";
}
echo "<br><br>";


$a = 15;
$b = 25;
$c = 20;

echo "4. Largest Number<br>";
if ($a >= $b && $a >= $c) {
    echo "Largest number is: " . $a;
} elseif ($b >= $a && $b >= $c) {
    echo "Largest number is: " . $b;
} else {
    echo "Largest number is: " . $c;
}
echo "<br><br>";


echo "5. Odd Numbers from 10 to 100<br>";
for ($i = 10; $i <= 100; $i++) {
    if ($i % 2 != 0) {
        echo $i . " ";
    }
}
echo "<br><br>";


$array = array(10, 20, 30, 40, 50);
$search = 30;
$found = false;

echo "6. Search Element in Array<br>";

for ($i = 0; $i < count($array); $i++) {
    if ($array[$i] == $search) {
        $found = true;
        break;
    }
}

if ($found) {
    echo $search . " found in array";
} else {
    echo $search . " not found in array";
}
echo "<br><br>";


echo "7. Shapes<br>";

for ($i = 1; $i <= 3; $i++) {
    for ($j = 1; $j <= $i; $j++) {
        echo "* ";
    }
    echo "<br>";
}

echo "<br>";

for ($i = 3; $i >= 1; $i--) {
    for ($j = 1; $j <= $i; $j++) {
        echo $j . " ";
    }
    echo "<br>";
}

echo "<br>";

$char = 'A';

for ($i = 1; $i <= 3; $i++) {
    for ($j = 1; $j <= $i; $j++) {
        echo $char . " ";
        $char++;
    }
    echo "<br>";
}
?>