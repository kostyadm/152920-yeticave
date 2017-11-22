<?php

require_once ('functions.php');
require_once ('data.php');
require_once ('users_lots.php');

$user=user_status($is_auth, $user_name, $user_avatar);

$main_menu=main_categories_menu($cat);
$list_menu = nav_list_menu($cat, $lot_data);
$nav_menu = include_template('nav_list.php',['list'=>$list_menu]);

if (isset($_GET['category'])){
    $chosen_category=$_GET['category'];
    $lots_list=sort_lots($lot_data, $cat, $chosen_category,$lot_time_remaining);
}else{
    $lots_list=list_lots($lot_data,$lot_time_remaining);
}
$page_content=include_template('index.php', ['cat'=>$cat, 'lot_data'=>$lot_data, 'time'=>$lot_time_remaining,'main_menu'=>$main_menu, 'lots_list'=>$lots_list]);
$layout_content=include_template('layout.php', ['page_title'=>'Главная страница','auth_user' =>$user,'content'=>$page_content, 'auth'=>$is_auth,'name'=>$user_name, 'avatar'=>$user_avatar, 'nav'=>$nav_menu]);
print($layout_content);
