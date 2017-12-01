<?php

require_once('functions.php');
require_once('data.php');
require_once('users_lots.php');

if ($is_auth) {
    $auth_status = include_template('auth_user.php', ['name' => $user_name, 'avatar' => $user_avatar]);
} else {
    $auth_status = include_template('non_auth_user.php', []);
}

$list_menu = '';
foreach ($cat as $key => $value):
    $list_menu .= include_template('nav_list_category.php', ['category' => $value]);
endforeach;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $post_data = $_POST;
    $errors = validate_lot_input($post_data, $required, $dict, $is_number);

    if (isset($_FILES['lot_photo']['name'])) {
        $tmp_name = $_FILES['lot_photo']['tmp_name'];
        $path = $_FILES['lot_photo']['name'];
        $jpg = validate_picture($tmp_name, $path);
    } else {
        $jpg['error'] = 'Вы не загрузили файл';
    }

    if (count($errors) == 0) {
        foreach ($bets as $bet => $row):
            $bets_return .= include_template('bets.php', ['bet' => $row]);
        endforeach;
        $page_content = include_template('lot.php', ['post_data' => $post_data, 'jpg' => $jpg, 'bets' => $bets_return]);
    } else {
        $page_content = include_template('add-lot.php', ['post_data' => $post_data, 'jpg' => $jpg, 'errors' => $errors, 'cat' => $cat, 'list_menu' => $list_menu, 'picture_errors' => $picture_errors]);
    }
} else {
    $page_content = include_template('add-lot.php', ['cat' => $cat, 'list_menu' => $list_menu]);
}
$layout_content = include_template('layout.php', ['page_title' => 'Главная страница', 'auth_status' => $auth_status, 'content' => $page_content, 'list_menu' => $list_menu]);
$layout_content = preg_replace('<main class="container">', 'main', $layout_content);
print($layout_content);
