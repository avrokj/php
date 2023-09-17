<?php

$fruits = ['apple', 'bear', 'banana'];

$fruits[] = 'orange';

$lastIndex = count($fruits)-1;

echo($fruits[rand(0,3)]);

$i = 1;

while ( $i <= 5) {
    echo "{$i}\n" ;
    $i++;
}