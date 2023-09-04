<?php
echo "<pre>";
$myData = [
    'first_name' => 'Karel',
    'last_name' => 'Maarma',
    'location' => 'Kuressaare'
];

foreach ( $myData as $key => $value) {
    echo "{$key}: " . "$value" . "\n";
};
echo "</pre>";