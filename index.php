<?php

require_once('functions.php');
require_once('init.php');

session_start();
$auth_status = include_template('non_auth_user.php', []);
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    $auth_status = include_template('auth_user.php', ['user_name' => $user['user_name'], 'avatar' => $user['avatar']]);
}
/* collecting data from db*/
$sql_cat = 'SELECT id, img_cat, category FROM categories ORDER BY id ASC';
$cat = fetch_data($con, $sql_cat);

$sql_max_bet = 'SELECT MAX(bet_value) AS \'current_price\', lot_id FROM bet GROUP BY lot_id ORDER BY lot_id';
$max_bet = fetch_data($con, $sql_max_bet);

$main_menu = '';
$list_menu = '';
foreach ($cat as $value) {
    $main_menu .= include_template('main_menu_category.php', ['key' => $value['id'], 'img_cat' => $value['img_cat'], 'category' => $value['category']]);
    $list_menu .= include_template('nav_list_category.php', ['category' => $value['category']]);
}

$cur_page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$limit = 3;
$sql_pag = 'SELECT COUNT(*) AS cnt FROM lot';
$items_count = fetch_array($con, $sql_pag);
$pages_count = ceil(($items_count['cnt']) / $limit);
if ($cur_page == 0 OR $cur_page > $pages_count) {
    $cur_page = 1;
}
$offset = ($cur_page - 1) * $limit;
$pages = range(1, $pages_count);

foreach ($pages as $page) {
    $pagination .= include_template('pagination.php', ['page' => $page, 'cur_page' => $cur_page]);
}

$sql_lot_data = '
      SELECT l.id, l.lot_name, l.starting_price, l.photo, c.category, l.category_id, l.end_date
      FROM lot l
      JOIN categories c
      ON l.category_id=c.id
      LIMIT ' . $limit . '
      OFFSET ' . $offset;
$result = mysqli_query($con, $sql_lot_data);

$lot_data = mysqli_fetch_all($result, MYSQLI_ASSOC);

foreach ($lot_data as $value) {
    $lot_time_remaining = time_remaining($value['end_date']);
    $price = $value['starting_price'];
    foreach ($max_bet as $val) {
        if ($val['lot_id'] == $value['id']) {
            $price = $val['current_price'];
        }
    }
    $lots_list .= include_template('item_lot.php', ['lot_data' => $value, 'price' => $price, 'time' => $lot_time_remaining]);
}

$page_content = include_template('index.php', ['main_menu' => $main_menu, 'lots_list' => $lots_list, 'pagination' => $pagination, 'cur_page' => $cur_page]);
$layout_content = include_template('layout.php', ['page_title' => 'Главная страница', 'auth_status' => $auth_status, 'content' => $page_content, 'list_menu' => $list_menu]);
print($layout_content);
