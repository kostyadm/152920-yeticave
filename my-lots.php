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
    $sql_max_bet = 'SELECT lot_id, MAX(bet_value) AS \'current_price\' FROM bet WHERE lot_id=' . $user_input['lot_id'] . ' GROUP BY lot_id ORDER BY lot_id';
    $max_bet = fetch_array($con, $sql_max_bet);
    $price = $selected_lot['starting_price'];
    $min_bet = $price + $selected_lot['step'];

    if ($max_bet['lot_id'] == $selected_lot['id']) {
        $price = $max_bet['current_price'];
        $min_bet = $price + $selected_lot['step'];
    }

    //check if bet is big enough
    if ($user_input['cost'] < $min_bet OR !is_numeric($user_input['cost'])) {
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
    $sql_my_lots = 'SELECT l.id, l.photo, l.lot_name, l.starting_price, c.category,l.step, l.end_date, b.bet_value, b.reg_date
                    FROM lot l
                    JOIN categories c ON c.id=l.category_id
                    JOIN bet b ON l.id=b.lot_id
                    WHERE b.user_id=' . $user['id'];
    $my_lots = fetch_data($con, $sql_my_lots);

    foreach ($my_lots as $value) {
        $lot_time_remaining = time_remaining($value['end_date']);
        $lot_name = $value['lot_name'];
        $lot_category = $value['category'];
        $photo= $value['photo'];
        $added_lot .= include_template('lot_list_added.php', ['lot_name' => $lot_name, 'cost' => $value['bet_value'], 'time_remaining' => $lot_time_remaining, 'timestamp' => strtotime($value['reg_date']), 'lot_category' => $lot_category, 'photo' => $photo, 'id' => $value['id']]);
    }

    if (!$res) {
        header('Location: lot.php?id=' . $lot_id);
    }
} else {
    $sql_my_lots = 'SELECT l.id, l.photo, l.lot_name, l.starting_price, c.category,l.step, l.end_date, b.bet_value, b.reg_date
                    FROM lot l
                    JOIN categories c ON c.id=l.category_id
                    JOIN bet b ON l.id=b.lot_id
                    WHERE b.user_id=' . $user['id'];
    $my_lots = fetch_data($con, $sql_my_lots);

    foreach ($my_lots as $value) {
        $lot_time_remaining = time_remaining($value['end_date']);
        $lot_name = $value['lot_name'];
        $lot_category = $value['category'];
        $photo= $value['photo'];
        $added_lot .= include_template('lot_list_added.php', ['lot_name' => $lot_name, 'cost' => $value['bet_value'], 'time_remaining' => $lot_time_remaining, 'timestamp' => strtotime($value['reg_date']), 'lot_category' => $lot_category, 'photo' => $photo, 'id' => $value['id']]);
    }
}

$page_content = include_template('my-lots.php', ['list_menu' => $list_menu, 'added_lot' => $added_lot]);


$layout_content = include_template('layout.php', ['page_title' => 'Мои ставки', 'auth_status' => $auth_status, 'content' => $page_content, 'list_menu' => $list_menu]);
$layout_content = preg_replace('<main class="container">', 'main', $layout_content);
print($layout_content);