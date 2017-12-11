<?php

require_once('functions.php');
require_once('init.php');

session_start();

$sql_user = 'SELECT id, email, password, avatar, user_name FROM users';
$users = fetch_data($con, $sql_user);

$list_menu = list_menu($con);

if (isset($_SESSION['user'])) {
    header("Location:/index.php");
    exit;
}
// request method check
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST as $key => $value) {
        $login_data[$key] = htmlspecialchars($value);
    }
    $errors = validate_input_data($login_data);

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
            $password_verify = password_verify($login_data['password'], $users[$user_id]['password']);
        } else {
            $errors['email'] = 'Введённого адреса не существует';
        }
        if (!$password_verify) {
            $errors['password'] = 'Введённый пароль не верен';
        } else {
            $_SESSION['user'] = $users[$user_id];
            header("Location:/index.php");
            exit;
        }
        $page_content = include_template('login.php', ['list_menu' => $list_menu, 'login_data' => $login_data, 'errors' => $errors]);
    } else {
        $page_content = include_template('login.php', ['list_menu' => $list_menu, 'login_data' => $login_data, 'errors' => $errors]);
    }
} else {
    $page_content = include_template('login.php', ['list_menu' => $list_menu]);
}
$layout_content = include_template('layout.php', ['page_title' => 'Войти', 'content' => $page_content, 'list_menu' => $list_menu, 'auth_status' => $auth_status]);
$layout_content = preg_replace('<main class="container">', 'main', $layout_content);
print($layout_content);