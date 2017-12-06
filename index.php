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
    $sql_cat = 'SELECT id, img_cat, category FROM categories ORDER BY id ASC';
    $cat_result = mysqli_query($con, $sql_cat);
    $cat = mysqli_fetch_all($cat_result, MYSQLI_ASSOC);

    $sql_lot_data = '
      SELECT l.id, l.lot_name, l.starting_price, l.photo, c.category, l.category_id, l.end_date
      FROM lot l
      JOIN categories c
      ON l.category_id=c.id';
    $lot_data_result = mysqli_query($con, $sql_lot_data);
    $lot_data = mysqli_fetch_all($lot_data_result, MYSQLI_ASSOC);

    $sql_max_bet = 'SELECT MAX(bet_value) AS \'current_price\', lot_id FROM bet GROUP BY lot_id ORDER BY lot_id';
    $max_bet_result = mysqli_query($con, $sql_max_bet);
    $max_bet = mysqli_fetch_all($max_bet_result, MYSQLI_ASSOC);
}

$main_menu = '';
foreach ($cat as $value):
    $main_menu .= include_template('main_menu_category.php', ['key' => $value['id'], 'img_cat' => $value['img_cat'], 'category' => $value['category']]);
endforeach;

$list_menu = '';
foreach ($cat as $key => $value):
    $list_menu .= include_template('nav_list_category.php', ['category' => $value['category']]);
endforeach;

if (isset($_GET['category'])) {
    $chosen_category = $_GET['category'];
    foreach ($lot_data as $value) {
        $lot_time_remaining =time_remaining($value['end_date']);
        if ($chosen_category == $value['category_id']) {
            $price = $value['starting_price'];
            foreach ($max_bet as $val) {
                if ($val['lot_id'] == $value['id']) {
                    $price = $val['current_price'];
                }
            }
            $lots_list .= include_template('item_lot.php', ['category' => $value['category'], 'photo' => $value['photo'], 'lot_name' => $value['lot_name'], 'price' => $price, 'time' => $lot_time_remaining]);
        }
    }
} else {
    foreach ($lot_data as $value) {
        $lot_time_remaining =time_remaining($value['end_date']);
        $price = $value['starting_price'];
        foreach ($max_bet as $val) {
            if ($val['lot_id'] == $value['id']) {
                $price = $val['current_price'];
            }
        }
        $lots_list .= include_template('item_lot.php', ['category' => $value['category'], 'photo' => $value['photo'], 'lot_name' => $value['lot_name'], 'price' => $price, 'time' => $lot_time_remaining]);
    }
}
$page_content = include_template('index.php', ['main_menu' => $main_menu, 'lots_list' => $lots_list]);
$layout_content = include_template('layout.php', ['page_title' => 'Главная страница', 'auth_status' => $auth_status, 'content' => $page_content, 'list_menu' => $list_menu]);
print($layout_content);
