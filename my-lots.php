<?php
session_start();
require_once('functions.php');
require_once('init.php');

$list_menu = list_menu($con);

// authentication check
if (!isset($_SESSION['user'])) {
    $page_content = include_template('403.php', ['list_menu' => $list_menu]);
    $auth_status = include_template('non_auth_user.php', []);
}

$user = $_SESSION['user'];
$auth_status = include_template('auth_user.php', ['user_name' => $user['user_name'], 'avatar' => $user['avatar']]);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    foreach ($_POST as $key => $value) {
        $user_input[$key] = htmlspecialchars($value);
    }
    $sql_selected_lot = 'SELECT id, starting_price, step FROM lot WHERE id=' . $user_input['lot_id'];
    $selected_lot = fetch_array($con, $sql_selected_lot);

    $min_bet = min_bet ($user_input['lot_id'], $con, $selected_lot);
    $price = $min_bet - $selected_lot['step'];

    //check if bet is big enough
    if ($user_input['cost'] =='' OR $user_input['cost'] < $min_bet OR !is_numeric($user_input['cost'])) {
        header('Location:/lot.php?id=' . $user_input['lot_id'] . '');
        exit;
    }

    /*adding bets to bet */
    $new_record = count_records($con, 'bet');
    $user_id = $_SESSION['user']['id'];
    $lot_id = $user_input['lot_id'];
    $bet_value = intval($user_input['cost']);

    $sql_add_bet = "INSERT INTO bet (id, user_id,lot_id, reg_date, bet_value)
                    VALUES(".$new_record.",".$user_id.",?,NOW(),?)";
    $stmt = mysqli_prepare($con, $sql_add_bet);
    mysqli_stmt_bind_param($stmt, 'ii', $lot_id, $bet_value);
    $res = mysqli_stmt_execute($stmt);


    /*users bets*/
    $added_lot=insert_my_lots($con, $user['id']);

    if (!$res) {
        header('Location: lot.php?id=' . $lot_id);
    }
} else {
    $added_lot=insert_my_lots($con, $user['id']);
}

$page_content = include_template('my-lots.php', ['list_menu' => $list_menu, 'added_lot' => $added_lot]);


$layout_content = include_template('layout.php', ['page_title' => 'Мои ставки', 'auth_status' => $auth_status, 'content' => $page_content, 'list_menu' => $list_menu]);
$layout_content = preg_replace('<main class="container">', 'main', $layout_content);
print($layout_content);