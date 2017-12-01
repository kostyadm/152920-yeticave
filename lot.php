<?php

require_once('functions.php');
require_once('users_lots.php');
require_once('data.php');

session_start();
if (isset($_SESSION['user'])){
    $user=$_SESSION['user'];
    $auth_status = include_template('auth_user.php', ['name' => $user['name'], 'avatar' => $user_avatar]);
} else {
    $auth_status = include_template('non_auth_user.php', []);
}

$list_menu = '';
foreach ($cat as $key => $value):
    $list_menu .= include_template('nav_list_category.php', ['category' => $value]);
endforeach;

$id = isset($_GET['id']) ? $_GET['id'] : "";
if ($id >= count($lot_data)) {
    $page_content = include_template('404.php', ['list_menu' => $list_menu]);
} else {
    foreach ($bets as $bet => $row):
        $bets_return .= include_template('bets.php', ['bet' => $row]);
    endforeach;
    $page_content = include_template('lot.php', ['details' => $lot_data[$id], 'bets' => $bets_return, 'time' => $lot_time_remaining]);
}
$layout_content = include_template('layout.php', ['page_title' => 'Главная страница', 'auth_status' => $auth_status, 'content' => $page_content, 'list_menu' => $list_menu]);
$layout_content = preg_replace('<main class="container">', 'main', $layout_content);
print($layout_content);
