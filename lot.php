<?php

require_once('functions.php');
require_once('init.php');

session_start();

$list_menu = list_menu($con);


$auth_status = include_template('non_auth_user.php', []);
$do_offer = '';

//checks, if item's id is set
$id = isset($_GET['id']) ? intval($_GET['id']) : "";

$sql_lot_data = '
      SELECT l.id, l.lot_name,l.description, l.starting_price, l.photo, c.category, l.category_id, l.end_date, l.step
      FROM lot l
      JOIN categories c
      ON l.category_id=c.id
      WHERE l.id=' . $id;
$result = mysqli_query($con, $sql_lot_data);
$lot_data = mysqli_fetch_array($result, MYSQLI_ASSOC);

$sql_bet = 'SELECT u.user_name, b.bet_value, b.reg_date
            FROM bet b
            JOIN users u
            ON b.user_id=u.id
            WHERE b.lot_id=' . $id . '
            ORDER BY b.bet_value DESC';
$bet = fetch_data($con, $sql_bet);

$sql_max_bet = 'SELECT lot_id, MAX(bet_value) AS \'current_price\' FROM bet WHERE lot_id=' . $id . ' GROUP BY lot_id ORDER BY lot_id';
$max_bet = fetch_array($con, $sql_max_bet);

$price = $lot_data['starting_price'];
$min_bet = $price + $lot_data['step'];

if ($max_bet['lot_id'] == $lot_data['id']) {
    $price = $max_bet['current_price'];
    $min_bet = $price + $lot_data['step'];
}
// authentication check
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    $auth_status = include_template('auth_user.php', ['user_name' => $user['user_name'], 'avatar' => $user['avatar']]);

    //checks, if there are any bets made by user
    $sql_users_bets='SELECT lot_id FROM bet WHERE user_id='.$user['id'];
    $in_cart = fetch_data($con, $sql_users_bets);

    $lot_time_remaining = time_remaining($lot_data['end_date']);
    $do_offer = include_template('offer.php', ['price' => $price, 'min_bet' => $min_bet, 'id' => $lot_data['id']]);
    //checks, if there are any bets made by user for this item
    if (count($in_cart) > 0) {
        foreach ($in_cart as $value) {
            //compares items with bets
            if ($id == $value['lot_id']) {
                $do_offer = '';
                break;
            } else {
                $do_offer = include_template('offer.php', ['price' => $price, 'min_bet' => $min_bet, 'id' => $lot_data['id']]);
            }
        }
    }
}

//checks, if chosen item's id is valid
if ($id >= count_records($con, 'lot')) {
    $page_content = include_template('404.php', ['list_menu' => $list_menu]);
} else {

    $sql_bets_count = "SELECT COUNT(id) AS 'records' FROM bet WHERE lot_id=" . $id;
    $records_count = fetch_data($con, $sql_bets_count);
    $bets_count = $records_count[0]['records'];
    $lot_time_remaining = time_remaining($lot_data['end_date']);
    if ($bet) {
        foreach ($bet as $bets) {
            $bets_return .= include_template('bets.php', ['bet' => $bets]);
        }
    }

    $page_content = include_template('lot.php', ['lot_data' => $lot_data, 'number' => $bets_count, 'price' => $price, 'min_bet' => $min_bet, 'bets' => $bets_return, 'list_menu' => $list_menu, 'time' => $lot_time_remaining, 'do_offer' => $do_offer]);
}

$layout_content = include_template('layout.php', ['page_title' => $lot_data['lot_name'], 'auth_status' => $auth_status, 'content' => $page_content, 'list_menu' => $list_menu]);
$layout_content = preg_replace('<main class="container">', 'main', $layout_content);
print($layout_content);
