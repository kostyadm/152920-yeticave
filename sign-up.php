<?php

require_once('functions.php');
require_once('init.php');

session_start();
if (isset($_SESSION['user'])) {
    header("Location:/index.php");
    exit;
}
$sql_cat = 'SELECT id, img_cat, category FROM categories ORDER BY id ASC';
$cat = fetch_data($con, $sql_cat);
//create navigation panel list
$list_menu = '';
foreach ($cat as $value):
    $list_menu .= include_template('nav_list_category.php', ['category' => $value['category']]);
endforeach;
$page_content = include_template('sign-up.php', ['list_menu' => $list_menu]);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sign_up_data = [];
    foreach ($_POST as $key => $value) {
        $sign_up_data[$key] = htmlspecialchars($value);
    }
    $errors = validate_input_data($sign_up_data);

    $sql_user = 'SELECT email FROM users';
    $users = fetch_data($con, $sql_user);
    foreach ($users as $value) {
        //verifies user
        $user_verify = FALSE;
        if ($sign_up_data['email'] == $value['email']) {
            $errors['email'] = 'Введённый адрес уже занят';
            break;
        }
    }
    $jpg = [];
    if (isset($_FILES["avatar"]['name'])) {
        $photo_upload = $_FILES["avatar"]['name'];
        $tmp_name = $_FILES["avatar"]['tmp_name'];
        $jpg = validate_picture($photo_upload, $tmp_name);
    }

    $picture='';
    if (isset($jpg['path'])) {
        $picture = $jpg['path'];
    }

    if (count($errors) != 0) {
        $page_content = include_template('sign-up.php', ['list_menu' => $list_menu, 'errors' => $errors, 'sign_up_data' => $sign_up_data]);
    } else {
        $new_record = count_records($con, 'users');
        $email = $sign_up_data['email'];
        $user_name = $sign_up_data['name'];
        $password = password_hash($sign_up_data['password'], PASSWORD_DEFAULT);
        $contacts = $sign_up_data['message'];;
        $sql_add_user = "INSERT INTO users (id, registration_date, email, user_name, password, avatar, contacts)
                        VALUES(" . $new_record . ",NOW(),?,?,?,?,?)";
        $stmt = mysqli_prepare($con, $sql_add_user);
        mysqli_stmt_bind_param($stmt, 'sssss', $email, $user_name, $password, $picture, $contacts);
        $res = mysqli_stmt_execute($stmt);
        if ($res) {
            header('Location: login.php');
        } else {
            $page_content = include_template('error.php', ['error' => mysqli_error($con)]);

        }
    }
}

$layout_content = include_template('layout.php', ['page_title' => 'Регистрация', 'content' => $page_content, 'list_menu' => $list_menu]);
$layout_content = preg_replace('<main class="container">', 'main', $layout_content);
print($layout_content);