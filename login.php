<?php

require_once('functions.php');
require_once('data.php');
require_once('users_lots.php');
require_once('userdata.php');

session_start();

$list_menu = '';
foreach ($cat as $key => $value):
    $list_menu .= include_template('nav_list_category.php', ['category' => $value]);
endforeach;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login_data = $_POST;
    $errors = validate_login_data($login_data);
    if (count($errors) != 0) {
        $page_content = include_template('login.php', ['list_menu' => $list_menu, 'login_data' => $login_data, 'errors' => $errors]);
    } else {
        foreach ($users as $value)
            if (strcmp($login_data['email'], $value['email']) == 0) {
                if (!password_verify($login_data['password'], $value['password'])) {
                    $errors['password'] = 'Введённый пароль не верен';
                } else {
                    $user_name = $value['name'];
                    $_SESSION['user'] = $value;
                }
                break;
            } else {
                $errors['email'] = 'Введённого адреса не существует';
            }
        if (count($errors) == 0) {

            header("Location:/index.php");
            exit;
        } else {
            $page_content = include_template('login.php', ['list_menu' => $list_menu, 'login_data' => $login_data, 'errors' => $errors]);
            $layout_content = include_template('layout.php', ['page_title' => 'Войти', 'content' => $page_content, 'list_menu' => $list_menu, 'auth_status' => $auth_status]);
            $layout_content = preg_replace('<main class="container">', 'main', $layout_content);
        }
    }

} else {
    $page_content = include_template('login.php', ['list_menu' => $list_menu, 'errors' => $errors]);
    $layout_content = include_template('layout.php', ['page_title' => 'Войти', 'content' => $page_content, 'list_menu' => $list_menu, 'auth_status' => $auth_status]);
    $layout_content = preg_replace('<main class="container">', 'main', $layout_content);
}


print($layout_content);