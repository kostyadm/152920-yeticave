<?php

$lot_data = array(
    array("name"=> "2014 Rossignol District Snowboard", "category"=>"Доски и лыжи", "price"=>10999, "pic-link"=>'img/lot-1.jpg'),
    array("name"=>"DC Ply Mens 2016/2017 Snowboard", "category"=>"Доски и лыжи", "price"=>159999, "pic-link"=>'img/lot-2.jpg'),
    array("name"=>"Крепления Union Contact Pro 2015 года пазмер L/XL", "category"=>"Крепления", "price"=>8000, "pic-link"=>'img/lot-3.jpg'),
    array("name"=>"Ботинки для сноуборда DC Mutiny Charocal", "category"=>"Ботинки", "price"=>10999, "pic-link"=>'img/lot-4.jpg'),
    array("name"=>"Куртка для сноуборда DC Mutiny Charocal", "category"=>"Одежда", "price"=>7500, "pic-link"=>'img/lot-5.jpg'),
    array("name"=>"Маска Oakley Canopy", "category"=>"Разное", "price"=>5400, "pic-link"=>"img/lot-6.jpg")
);

// ставки пользователей, которыми надо заполнить таблицу
$bets = array(
    array('name' => 'Иван', 'price' => 11500, 'ts' => strtotime('-' . rand(1, 50) .' minute')),
    array('name' => 'Константин', 'price' => 11000, 'ts' => strtotime('-' . rand(1, 18) .' hour')),
    array('name' => 'Евгений', 'price' => 10500, 'ts' => strtotime('-' . rand(25, 50) .' hour')),
    array('name' => 'Семён', 'price' => 10000, 'ts' => strtotime('last week'))
);
