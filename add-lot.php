<?php

require_once('functions.php');
require_once('init.php');

$sql_cat = 'SELECT id, img_cat, category FROM categories ORDER BY id ASC';
$cat = fetch_data($con, $sql_cat);

//create navigation panel list
$list_menu = '';
foreach ($cat as $value){
    $list_menu .= include_template('nav_list_category.php', ['category' => $value['category']]);
}

session_start();
$page_content = include_template('403.php', ['list_menu' => $list_menu]);
$auth_status = include_template('non_auth_user.php', []);

if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    $auth_status = include_template('auth_user.php', ['user_name' => $user['user_name'], 'avatar' => $user['avatar']]);
    $page_content = include_template('add-lot.php', ['cat' => $cat, 'list_menu' => $list_menu]);
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $added_data = $_POST;
    /*эти массивы можно здесь оставить?*/
    $required = ['lot_name', 'category', 'message', 'lot-rate', 'lot-step', 'lot-date'];
    $dict = ['lot_name' => 'Наименование', 'category' => 'Категория', 'message' => 'Описание', 'lot-rate' => 'Начальная цена', 'lot-step' => 'Шаг ставки', 'lot-date' => 'Дата окончания торгов', 'email' => 'email', 'password' => 'Пароль'];
    $number = ['lot-rate', 'lot-step'];
    $errors = validate_lot_input($added_data, $required, $dict, $number);

    $jpg = [];
    if (isset($_FILES["lot_photo"]['name'])) {
        $photo_upload = $_FILES["lot_photo"]['name'];
        $tmp_name = $_FILES['lot_photo']['tmp_name'];
        $jpg = validate_picture($photo_upload, $tmp_name);
    }
    if (isset($jpg['error'])) {
        $picture_errors = $jpg['error'];
    }
    $picture = '';
    if (isset($jpg['path'])) {
        $picture = $jpg['path'];
    }

    if ($errors) {
        $page_content = include_template('add-lot.php', ['added_data' => $added_data, 'jpg' => $jpg, 'errors' => $errors, 'cat' => $cat, 'list_menu' => $list_menu, 'picture_errors' => $picture_errors]);
    } else {
        $new_record = count_records($con, 'lot');
        $category_id = get_id($added_data['category'], $cat);
        $add_lot_name = $added_data['lot_name'];
        $description = $added_data['message'];
        $starting_price = $added_data['lot-rate'];
        $end_date = date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $added_data['lot-date'])));
        $step = $added_data['lot-step'];
        $sql_add_lot = "INSERT INTO lot (id, user_id, category_id, creation_date, lot_name, description, photo, starting_price, step, end_date)
                        VALUES(" . $new_record . "," . $user['id'] . ",?,NOW(),?,?,?,?,?,?)";
        $stmt = mysqli_prepare($con, $sql_add_lot);
        mysqli_stmt_bind_param($stmt, 'isssiis', $category_id, $add_lot_name, $description, $picture, $starting_price, $step, $end_date);
        $res = mysqli_stmt_execute($stmt);
        if ($res) {
            $lot_id = count_records($con, 'lot') - 1;
            header('Location: lot.php?id=' . $lot_id);
        } else {
            $page_content = include_template('error.php', ['error' => mysqli_error($con)]);
        }
    }
}

$layout_content = include_template('layout.php', ['page_title' => 'Главная страница', 'auth_status' => $auth_status, 'content' => $page_content, 'list_menu' => $list_menu]);
$layout_content = preg_replace('<main class="container">', 'main', $layout_content);
print($layout_content);
