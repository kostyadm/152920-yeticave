<?php

require_once('functions.php');
require_once('data.php');
require_once('users_lots.php');
require_once('init.php');

$list_menu = '';
foreach ($cat as $key => $value):
    $list_menu .= include_template('nav_list_category.php', ['category' => $value]);
endforeach;

session_start();
$page_content = include_template('403.php', ['list_menu' => $list_menu]);
$auth_status = include_template('non_auth_user.php', []);

if (isset($_SESSION['user'])){
    $user=$_SESSION['user'];
    $auth_status = include_template('auth_user.php', ['user_name' => $user['user-name'], 'avatar' => $user_avatar]);

    $page_content = include_template('add-lot.php', ['cat' => $cat, 'list_menu' => $list_menu]);
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $added_data = $_POST;
        $errors = validate_lot_input($added_data, $required, $dict, $is_number);

        $jpg=[];
        if (isset($_FILES["lot_photo"]['name'])) {
            $photo_upload=$_FILES["lot_photo"]['name'];
            $jpg = validate_picture($photo_upload);
        }
        $page_content = include_template('add-lot.php', ['added_data' => $added_data, 'jpg' => $jpg, 'errors' => $errors, 'cat' => $cat, 'list_menu' => $list_menu, 'picture_errors' => $picture_errors]);
        if (count($errors) == 0) {
            foreach ($bets as $bet) {
                $bets_return .= include_template('bets.php', ['bet' => $bet]);
            }
            $page_content = include_template('lot.php', ['added_data' => $added_data, 'jpg' => $jpg, 'bets' => $bets_return]);
        }
    }

}
$layout_content = include_template('layout.php', ['page_title' => 'Главная страница', 'auth_status' => $auth_status, 'content' => $page_content, 'list_menu' => $list_menu]);
$layout_content = preg_replace('<main class="container">', 'main', $layout_content);
print($layout_content);
