<?php

$lot_data = [
    ["lot_name" => "2014 Rossignol District Snowboard", "category" => "Доски и лыжи", "price" => 10999, "pic-link" => 'img/lot-1.jpg'],
    ["lot_name" => "DC Ply Mens 2016/2017 Snowboard", "category" => "Доски и лыжи", "price" => 159999, "pic-link" => 'img/lot-2.jpg'],
    ["lot_name" => "Крепления Union Contact Pro 2015 года пазмер L/XL", "category" => "Крепления", "price" => 8000, "pic-link" => 'img/lot-3.jpg'],
    ["lot_name" => "Ботинки для сноуборда DC Mutiny Charocal", "category" => "Ботинки", "price" => 10999, "pic-link" => 'img/lot-4.jpg'],
    ["lot_name" => "Куртка для сноуборда DC Mutiny Charocal", "category" => "Одежда", "price" => 7500, "pic-link" => 'img/lot-5.jpg'],
    ["lot_name" => "Маска Oakley Canopy", "category" => "Разное", "price" => 5400, "pic-link" => "img/lot-6.jpg"]
];

// ставки пользователей, которыми надо заполнить таблицу
$bets = [
    ['user_name' => 'Иван', 'price' => 11500, 'ts' => strtotime('-' . rand(1, 50) . ' minute')],
    ['user_name' => 'Константин', 'price' => 11000, 'ts' => strtotime('-' . rand(1, 18) . ' hour')],
    ['user_name' => 'Евгений', 'price' => 10500, 'ts' => strtotime('-' . rand(25, 50) . ' hour')],
    ['user_name' => 'Семён', 'price' => 10000, 'ts' => strtotime('last week')]
];
