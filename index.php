<?php
require_once('functions.php');

$is_auth = (bool) rand(0, 1);

$user_name = 'Константин';
$user_avatar = 'img/user.jpg';

// устанавливаем часовой пояс в Московское время
date_default_timezone_set('Europe/Moscow');

// записать в эту переменную оставшееся время в этом формате (ЧЧ:ММ)
$lot_time_remaining = "00:00";

// временная метка для полночи следующего дня
$tomorrow = strtotime('today midnight');

// временная метка для настоящего времени
$now = strtotime('now');

// далее нужно вычислить оставшееся время до начала следующих суток и записать его в переменную $lot_time_remaining
$lot_time_remaining = gmdate("H:i", $tomorrow - $now);

$cat=array("boards"=>"Доски и лыжи", "attachment"=>"Крепления", "boots"=>"Ботинки", "clothing"=>"Одежда", "tools"=>"Инструменты", "other"=>"Разное");

$ads = array(
    array("name"=> "2014 Rossignol District Snowboard", "category"=>"Доски и лыжи", "price"=>10999, "pic-link"=>'img/lot-1.jpg'),
    array("name"=>"DC Ply Mens 2016/2017 Snowboard", "category"=>"Доски и лыжи", "price"=>159999, "pic-link"=>'img/lot-2.jpg'),
    array("name"=>"Крепления Union Contact Pro 2015 года пазмер L/XL", "category"=>"Крепления", "price"=>8000, "pic-link"=>'img/lot-3.jpg'),
    array("name"=>"Ботинки для сноуборда DC Mutiny Charocal", "category"=>"Ботинки", "price"=>10999, "pic-link"=>'img/lot-4.jpg'),
    array("name"=>"Куртка для сноуборда DC Mutiny Charocal", "category"=>"Одежда", "price"=>7500, "pic-link"=>'img/lot-5.jpg'),
    array("name"=>"Маска Oakley Canopy", "category"=>"Разное", "price"=>5400, "pic-link"=>"img/lot-6.jpg")
);

function sort_ads(){
    global $ads, $b, $lot_time_remaining;
    foreach ($ads as $i=>$val) {
        if ($b != $ads[$i]["category"]) {
            continue;
        }
        else {
            print("
                <li class=\"lots__item lot\">
                    <div class=\"lot__image\">
                        <img src=\"" . $ads[$i]['pic-link'] . "\"  width='350' height='260' alt=" . $ads[$i]['category'] . ">
                    </div>
                    <div class='lot__info'>
                        <span class='lot__category'>" . $ads[$i]['category'] . "</span>
                        <h3 class=\"lot__title\"><a class=\"text-link\" href=\"lot.html\">" . $ads[$i]['name'] . "</a></h3>
                        <div class='lot__state'>
                            <div class='lot__rate'>
                                <span class='lot__amount'> Стартовая цена </span>
                                <span class='lot__cost'>" . $ads[$i]['price'] . "<b class='rub'>р</b> </span>
                            </div>
                            <div class='lot__timer timer'>
                               " .$lot_time_remaining. "
                            </div>
                        </div>
                    </div>
                <li>
                ");
        }


    }
}
$page_content=include_template('templates/index.php', ['cat'=>$cat]);
$layout_content=include_template('templates/layout.php', ['page_title'=>'Стаф для катки',
'content'=> $page_content]);
?>
