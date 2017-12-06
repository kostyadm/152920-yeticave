<?php

require_once('functions.php');
require_once('users_lots.php');
require_once('init.php');

session_start();
$auth_status = include_template('non_auth_user.php', []);
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    $auth_status = include_template('auth_user.php', ['user_name' => $user['user-name'], 'avatar' => $user_avatar]);
}

if ($con) {
    $sql_cat = 'SELECT id, category FROM categories ORDER BY id ASC';
    $result = mysqli_query($con, $sql_cat);
    $cat = mysqli_fetch_all($result, MYSQLI_ASSOC);

}

$main_menu = '';
foreach ($cat as $key => $value):
    $main_menu .= include_template('main_menu_category.php', ['key' => $value['id'], 'category' => $value['category']]);
endforeach;

$list_menu = '';
foreach ($cat as $key => $value):
    $list_menu .= include_template('nav_list_category.php', ['category' => $value['category']]);
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
