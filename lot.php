<?php

require_once ('functions.php');
require_once ('users_lots.php');
require_once ('data.php');

$id=$_GET['id'] ??  null;
if($id>=count($lot_data)) {
    http_response_code(404);
}else{

$user=user_status($is_auth, $user_name, $user_avatar);

$list_menu = nav_list_menu($cat);
$nav_menu = include_template('nav_list.php',['list'=>$list_menu]);
$page_content=$nav_menu;

$lot=print_lot($lot_data, $bets);
$page_content.=$lot;

$layout_content=include_template('layout.php', ['page_title'=>'Лот','auth_user' =>$user, 'nav'=>$nav_menu,'content'=>$page_content, 'auth'=>$is_auth,'name'=>$user_name, 'avatar'=>$user_avatar]);
$layout_content=preg_replace('<main class="container">' , 'main',$layout_content);}
print($layout_content);
