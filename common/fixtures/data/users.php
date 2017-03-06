<?php

$faker = Faker\Factory::create();

$data = [];
$i = 100;

while(--$i) {
    
    $data[] = [
        'login' => $faker->userName,
        'password' => $faker->password(6),
        'email' => $faker->safeEmail,
        'name' => $faker->firstName,
        'surname' => $faker->lastName,
        'middle_name' => $faker->domainName
    ];
}

return $data;
