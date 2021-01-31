<?php
require_once('complex.php');

$complex_1 = new Complex(2,5);
$complex_2 = new Complex(6,7);
$complex_3 = new Complex(1,-4.5);

echo $complex_1->complex_text() . ' + ' . $complex_2->complex_text() . ' + ' . $complex_3->complex_text() . "<br>";
$sum_1 = summary($complex_1, $complex_2, $complex_3);
echo $sum_1->complex_text() . "<br>";

echo '///////////' . "<br>";

echo $complex_1->complex_text() . ' - (' . $complex_2->complex_text() . ') - (' . $complex_3->complex_text() . ')' . "<br>";
$sub_1 = subtraction($complex_1, $complex_2, $complex_3);
echo $sub_1->complex_text() . "<br>";

echo '///////////' . "<br>" ;

echo $complex_1->complex_text() . ' + ' . $complex_2->complex_text() . ' - (' . $complex_3->complex_text() . ')' . "<br>";
$mult_1 = multiplication($complex_3, new Complex(-1, 0));
$sum_2 = summary($complex_1, $complex_2, $mult_1);
echo $sum_2->complex_text() . "<br>";

echo '///////////' . "<br>" ;

echo '(' . $complex_1->complex_text() . ') * (' . $complex_2->complex_text() . ')' . "<br>";
$mult_2 = multiplication($complex_1, $complex_2);
echo $mult_2->complex_text() . "<br>";

echo '///////////' . "<br>";

echo '(' . $complex_1->complex_text() . ') * (' . $complex_2->complex_text() . ') * (' . $complex_3->complex_text() . ')' . "<br>";
$mult_3 = multiplication($complex_1, $complex_2, $complex_3);
echo $mult_3->complex_text() . "<br>";

echo '///////////' . "<br>";

echo $complex_3->complex_text() . ' * 4' . "<br>";
$mult_4 = multiplication($complex_3, new Complex(4, 0));
echo $mult_4->complex_text() . "<br>";

echo '///////////' . "<br>";

echo $complex_3->complex_text() . ' * 4i' . "<br>";
$mult_5 = multiplication($complex_3, new Complex(0, 4));
echo $mult_5->complex_text() . "<br>";

echo '///////////' . "<br>";

echo '(' . $complex_1->complex_text() . ') / (' . $complex_2->complex_text() . ')' . "<br>";
$div_1 = division($complex_1, $complex_2);
echo $div_1->complex_text() . "<br>";

echo '///////////' . "<br>";

echo '((' . $complex_1->complex_text() . ') / (' . $complex_2->complex_text() . ')) / (' . $complex_3->complex_text() . ')' . "<br>";
$div_2 = division($complex_1, $complex_2, $complex_3);
echo $div_2->complex_text() . "<br>";

echo '///////////' . "<br>";

echo '(' . $complex_1->complex_text() . ') / 2' . "<br>";
$div_3 = division($complex_1, new Complex(2, 0));
echo $div_3->complex_text() . "<br>";
