<?php

require_once('functions.php');
require_once('data.php');
require_once('users_lots.php');


if ($is_auth) {
    $auth_status = include_template('auth_user.php', ['name' => $user_name, 'avatar' => $user_avatar]);
} else {
    $auth_status = include_template('non_auth_user.php', []);
}

$main_menu = '';
foreach ($cat as $key => $value):
    $main_menu .= include_template('main_menu_category.php', ['key' => $key, 'name' => $value]);
endforeach;

$list_menu = '';
foreach ($cat as $key => $value):
    $list_menu .= include_template('nav_list_category.php', ['category' => $value]);
endforeach;

if (isset($_GET['category'])) {
    $chosen_category = $_GET['category'];
    foreach ($lot_data as $key => $val) {
        if ($cat[$chosen_category] == $lot_data[$key]["category"]) {
            $lots_list .= include_template('item_lot.php', ['lot_data' => $val, 'key' => $key, 'time' => $lot_time_remaining]);
        }
    }
} else {
    foreach ($lot_data as $key => $val):
        $lots_list .= include_template('item_lot.php', ['lot_data' => $val, 'key' => $key, 'time' => $lot_time_remaining]);
    endforeach;
}
$page_content = include_template('index.php', ['main_menu' => $main_menu, 'lots_list' => $lots_list]);
$layout_content = include_template('layout.php', ['page_title' => 'Главная страница', 'auth_status' => $auth_status, 'content' => $page_content, 'list_menu' => $list_menu]);
print($layout_content);
