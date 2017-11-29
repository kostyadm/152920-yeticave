<?php
$is_auth = (bool) rand(0, 1);
$user_name = 'Константин';
$user_avatar = 'img/user.jpg';

$cat=array("boards"=>"Доски и лыжи", "attachment"=>"Крепления", "boots"=>"Ботинки", "clothing"=>"Одежда", "tools"=>"Инструменты", "other"=>"Разное");


/*lot input data validation*/

$required = ['lot-name', 'category', 'message', 'lot-rate', 'lot-step', 'lot-date'];
$dict = ['lot-name'=>'Наименование', 'category'=>'Категория', 'message'=>'Описание', 'lot-rate'=>'Начальная цена', 'lot-step'=>'Шаг ставки', 'lot-date'=>'Дата окончания торгов'];
$rules =['lot-rate'=>'validate_number', 'lot-step'=>'validate_number'];
$errors=[];
$jpg=[];