<?php
session_start();
require_once('functions.php');
require_once('users_lots.php');
require_once('data.php');

//create navigation panel list
foreach ($cat as $key => $value):
    $list_menu .= include_template('nav_list_category.php', ['category' => $value]);
endforeach;

$page_content = include_template('403.php', ['list_menu' => $list_menu]);
$auth_status = include_template('non_auth_user.php', []);

// authentication check
if (isset($_SESSION['user'])){
    $user=$_SESSION['user'];
    $auth_status = include_template('auth_user.php', ['user_name' => $user['user-name'], 'avatar' => $user_avatar]);

    $cookie_expire = strtotime("+3600 seconds");
    $cookie_path = "/";

    $my_lots = [];

    //cookie check
    $index = 0;
    if (isset($_COOKIE['lots_array'])) {
        $my_lots = json_decode($_COOKIE['lots_array'], TRUE);
        $index = count($my_lots);
    }
    //cookie check
    $index_cart = 0;
    if (isset($_COOKIE['cart'])) {
        $cart_list = json_decode($_COOKIE['cart'], TRUE);
        $index_cart = count($cart_list);
    }
    // request method check
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        foreach ($_POST as $key =>$value){
            $my_lots[$index][$key] = htmlspecialchars($value);
        }
        $my_lots[$index] = $_POST;
        if(!minimum_bet_value($my_lots[$index]['cost'], 12000)){
            header('Location:/lot.php?id='.$my_lots[$index]['lot_id'].'');
            exit;
        }
        $added_lots = json_encode($my_lots, TRUE);
        setcookie('lots_array', $added_lots, $cookie_expire, $cookie_path);

        $cart_list[$index_cart] = $_POST['lot_id'];
        $in_cart = json_encode($cart_list, TRUE);
        setcookie('cart', $in_cart, $cookie_expire, $cookie_path);

        foreach ($my_lots as $value) {
            $lot_name = $lot_data[$value['lot_id']]['lot_name'];
            $lot_category = $lot_data[$value['lot_id']]['category'];
            $pic_number = $value['lot_id'] + 1;
            $added_lot .= include_template('lot_list_added.php', ['lot_name' => $lot_name, 'cost' => $value['cost'], 'time_remaining' => $lot_time_remaining, 'timestamp' => $value['adding_time'], 'lot_category' => $lot_category, 'pic_number' => $pic_number, 'id' => $value['lot_id']]);
        }
    } else {
        foreach ($my_lots as $value) {
            $lot_name = $lot_data[$value['lot_id']]['lot_name'];
            $lot_category = $lot_data[$value['lot_id']]['category'];
            $pic_number = $value['lot_id'] + 1;
            $added_lot .= include_template('lot_list_added.php', ['lot_name' => $lot_name, 'cost' => $value['cost'], 'time_remaining' => $lot_time_remaining, 'timestamp' => $value['adding_time'], 'lot_category' => $lot_category, 'pic_number' => $pic_number, 'id' => $value['lot_id']]);
        }
    }

    $page_content = include_template('my-lots.php', ['list_menu' => $list_menu, 'added_lot' => $added_lot]);

}
$layout_content = include_template('layout.php', ['page_title' => 'Главная страница', 'auth_status' => $auth_status, 'content' => $page_content, 'list_menu' => $list_menu]);
$layout_content = preg_replace('<main class="container">', 'main', $layout_content);
print($layout_content);