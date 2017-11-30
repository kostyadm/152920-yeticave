<?php

require_once('functions.php');
require_once('data.php');
require_once('users_lots.php');

$user = user_status($is_auth, $user_name, $user_avatar);

$main_menu = main_categories_menu($cat);
$list_menu = nav_list_menu($cat);
$nav_menu = include_template('nav_list.php', ['list' => $list_menu]);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $page_content.=validate_lot_input($required, $is_number, $dict, $jpg, $errors,$cat, $nav_menu, $lot_data, $bets);

} else {
    $page_content=include_template('add-lot.php', ['cat'=>$cat, 'nav-menu'=>$nav_menu]);
}
$layout_content = include_template('layout.php', ['page_title' => 'Добавление лота', 'auth_user' => $user, 'content' => $page_content, 'auth' => $is_auth, 'name' => $user_name, 'avatar' => $user_avatar, 'nav' => $nav_menu]);
$layout_content = preg_replace('<main class="container">', 'main', $layout_content);
print($layout_content);
