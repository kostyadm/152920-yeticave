<?php
session_start();
require_once('functions.php');
require_once('init.php');

$sql_cat = 'SELECT id, img_cat, category FROM categories ORDER BY id ASC';
$cat = fetch_data($con, $sql_cat);

//create navigation panel list
$list_menu = '';
foreach ($cat as $value):
    $list_menu .= include_template('nav_list_category.php', ['category' => $value['category']]);
endforeach;


// authentication check
if (!isset($_SESSION['user'])) {
    $page_content = include_template('403.php', ['list_menu' => $list_menu]);
    $auth_status = include_template('non_auth_user.php', []);
}

$user = $_SESSION['user'];
$auth_status = include_template('auth_user.php', ['user_name' => $user['user_name'], 'avatar' => $user['avatar']]);

$cookie_expire = strtotime("+3600 seconds");
$cookie_path = "/";
$my_lots = [];

//cookie check
// includes added lots (name, price, pic_link)
$index = 0;
if (isset($_COOKIE['lots_array'])) {
    $my_lots = json_decode($_COOKIE['lots_array'], TRUE);
    $index = count($my_lots);
}
//cookie check
//id's of items in cart to check offer possibilities on lot page
$index_cart = 0;
if (isset($_COOKIE['cart'])) {
    $cart_list = json_decode($_COOKIE['cart'], TRUE);
    $index_cart = count($cart_list);
}
$sql_lot_data = 'SELECT l.id, l.lot_name, l.starting_price, l.photo, c.category, l.step, l.end_date
                      FROM lot l
                      JOIN categories c
                      ON l.category_id=c.id
                      ORDER BY l.id';
$lot_data = fetch_data($con, $sql_lot_data);
// request method check
if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    foreach ($_POST as $key => $value) {
        $my_lots[$index][$key] = htmlspecialchars($value);
    }

    $sql_max_bet = 'SELECT lot_id, MAX(bet_value) AS \'current_price\' FROM bet WHERE lot_id=' . $my_lots[$index]['lot_id'] . ' GROUP BY lot_id ORDER BY lot_id';
    $max_bet = fetch_array($con, $sql_max_bet);
    $price = $lot_data[$my_lots[$index]['lot_id']]['starting_price'];
    $min_bet = $price + $lot_data[$my_lots[$index]['lot_id']]['step'];
    if ($max_bet['lot_id'] == $lot_data[$my_lots[$index]['lot_id']]['id']) {
        $price = $max_bet['current_price'];
        $min_bet = $price + $lot_data[$my_lots[$index]['lot_id']]['step'];
    }

    //check if bet is big enough
    if ($my_lots[$index]['cost'] < $min_bet && !is_numeric($my_lots[$index]['cost'])) {
        header('Location:/lot.php?id=' . $my_lots[$index]['lot_id'] . '');
        exit;
    }

    foreach ($my_lots as $value) {
        $lot_time_remaining = time_remaining($lot_data[$value['lot_id']]['end_date']);
        $lot_name = $lot_data[$value['lot_id']]['lot_name'];
        $lot_category = $lot_data[$value['lot_id']]['category'];
        $pic_number = $value['lot_id'] + 1;
        $added_lot .= include_template('lot_list_added.php', ['lot_name' => $lot_name, 'cost' => $value['cost'], 'time_remaining' => $lot_time_remaining, 'timestamp' => $value['adding_time'], 'lot_category' => $lot_category, 'pic_number' => $pic_number, 'id' => $value['lot_id']]);
    }

    $new_record = count_records($con, 'bet');
    $user_id = $_SESSION['user']['id'];
    $lot_id = $my_lots[$index]['lot_id'];
    $bet_value = $my_lots[$index]['cost'];

    $sql_add_bet = "INSERT INTO bet (id, user_id,lot_id, reg_date, bet_value)
                    VALUES(".$new_record.",".$user_id.",?,NOW(),?)";
    $stmt = mysqli_prepare($con, $sql_add_bet);
    mysqli_stmt_bind_param($stmt, 'ii', $lot_id, $bet_value);
    $res=mysqli_stmt_execute($stmt);
    if(!$res){
        header('Location: lot.php?id='.$lot_id);
    }

    $added_lots = json_encode($my_lots, TRUE);
    setcookie('lots_array', $added_lots, $cookie_expire, $cookie_path);
    $cart_list[$index_cart] = $my_lots[$index]['lot_id'];
    $in_cart = json_encode($cart_list, TRUE);
    setcookie('cart', $in_cart, $cookie_expire, $cookie_path);
} else {
    foreach ($my_lots as $value) {
        $lot_time_remaining = time_remaining($lot_data[$value['lot_id']]['end_date']);
        $lot_name = $lot_data[$value['lot_id']]['lot_name'];
        $lot_category = $lot_data[$value['lot_id']]['category'];
        $pic_number = $value['lot_id'] + 1;
        $added_lot .= include_template('lot_list_added.php', ['lot_name' => $lot_name, 'cost' => $value['cost'], 'time_remaining' => $lot_time_remaining, 'timestamp' => $value['adding_time'], 'lot_category' => $lot_category, 'pic_number' => $pic_number, 'id' => $value['lot_id']]);
    }
}

$page_content = include_template('my-lots.php', ['list_menu' => $list_menu, 'added_lot' => $added_lot]);


$layout_content = include_template('layout.php', ['page_title' => 'Главная страница', 'auth_status' => $auth_status, 'content' => $page_content, 'list_menu' => $list_menu]);
$layout_content = preg_replace('<main class="container">', 'main', $layout_content);
print($layout_content);