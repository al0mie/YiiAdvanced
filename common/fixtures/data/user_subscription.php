<?php

$faker = Faker\Factory::create();

$data = [];

$i = 100;

while(--$i) {
    $data[] = [
        'user_id' => $i,
        'end_date' => 1488769197
    ];

}

return $data;