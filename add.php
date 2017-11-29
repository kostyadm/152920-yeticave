<?php

require_once('functions.php');
require_once('data.php');
require_once('users_lots.php');

$user = user_status($is_auth, $user_name, $user_avatar);

$main_menu = main_categories_menu($cat);
$list_menu = nav_list_menu($cat, $lot_data);
$nav_menu = include_template('nav_list.php', ['list' => $list_menu]);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $post_data = $_POST;

    validate_lot_input($required, $rules, $dict, $jpg);


} else {
    $page_content = include_template('add-lot.php', ['post_data' => $post_data, 'gif' => $gif]);
    $layout_content = include_template('layout.php', ['page_title' => 'Добавление лота', 'auth_user' => $user, 'content' => $page_content, 'auth' => $is_auth, 'name' => $user_name, 'avatar' => $user_avatar, 'nav' => $nav_menu]);
    $layout_content = preg_replace('<main class="container">', 'main', $layout_content);
    print($layout_content);
}
