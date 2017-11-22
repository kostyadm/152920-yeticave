<?php

require_once ('functions.php');
require_once ('users_lots.php');
require_once ('data.php');

/*if (isset ($_GET['id'])){
$id=$_GET['id'];
if($id>count($_GET['id']) OR $id<0) {
    header("Location: /template/404.php");
}
}
*/
$list_menu = nav_list_menu($cat, $lot_data);
$nav_menu = include_template('nav_list.php',['list'=>$list_menu]);
$lot=print_lot($lot_data, $bets);
$page_content=$nav_menu;
$page_content.=$lot;
$layout_content=include_template('layout.php', ['page_title'=>'Лот', 'nav'=>$nav_menu,'content'=>$page_content, 'auth'=>$is_auth,'name'=>$user_name, 'avatar'=>$user_avatar]);
$layout_content=preg_replace('<main class="container">' , 'main',$layout_content);
print($layout_content);
