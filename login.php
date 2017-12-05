<?php

require_once('functions.php');
require_once('data.php');
require_once('users_lots.php');
require_once('userdata.php');

session_start();

//create navigation panel list
$list_menu = '';
foreach ($cat as $key => $value):
    $list_menu .= include_template('nav_list_category.php', ['category' => $value]);
endforeach;

if (isset($_SESSION['user'])) {
    header("Location:/index.php");
    exit;
}
// request method check
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login_data = $_POST;
    $errors = validate_login_data($login_data);
    $page_content = include_template('login.php', ['list_menu' => $list_menu, 'login_data' => $login_data, 'errors' => $errors]);

    if (count($errors) == 0) {
        foreach ($users as $key => $value) {
            //verifies user
            $user_verify = FALSE;
            if ($login_data['email'] == $value['email']) {
                $user_verify = TRUE;
                $user_id = $key;
                break;
            }
        }
        if ($user_verify) {
            $password_verify = (password_verify($login_data['password'], $users[$user_id]['password']));
        } else {
            $errors['email'] = 'Введённого адреса не существует';
        }
        if (!$password_verify) {
            $errors['password'] = 'Введённый пароль не верен';
        } else {
            $_SESSION['user'] = $users[$user_id];
        }
    }

    if ($_SESSION['user']) {
        header("Location:/index.php");
        exit;
    } else {
        $page_content = include_template('login.php', ['list_menu' => $list_menu, 'login_data' => $login_data, 'errors' => $errors]);
        $layout_content = include_template('layout.php', ['page_title' => 'Войти', 'content' => $page_content, 'list_menu' => $list_menu, 'auth_status' => $auth_status]);
        $layout_content = preg_replace('<main class="container">', 'main', $layout_content);
    }
} else {
    $page_content = include_template('login.php', ['list_menu' => $list_menu, 'errors' => $errors]);
    $layout_content = include_template('layout.php', ['page_title' => 'Войти', 'content' => $page_content, 'list_menu' => $list_menu, 'auth_status' => $auth_status]);
    $layout_content = preg_replace('<main class="container">', 'main', $layout_content);
}
print($layout_content);