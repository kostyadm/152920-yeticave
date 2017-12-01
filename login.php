<?php

require_once('functions.php');
require_once('data.php');
require_once('users_lots.php');
require_once('userdata.php');

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
                $user_name = $value['name'];
                if (!password_verify($login_data['password'], $value['password'])) {
                    $errors['password'] = 'Введённый пароль не верен';
                }
                break;
            } else {
                $errors['email'] = 'Введённого адреса не существует';
            }
        if (count($errors) == 0) {
            $auth_status = include_template('auth_user.php', ['name' => $user_name, 'avatar' => $user_avatar]);

            $main_menu = '';
            foreach ($cat as $key => $value):
                $main_menu .= include_template('main_menu_category.php', ['key' => $key, 'name' => $value]);
            endforeach;

            if (isset($_GET['category'])) {
                $chosen_category = $_GET['category'];
                foreach ($lot_data as $key => $val) {
                    if ($cat[$chosen_category] == $lot_data[$key]["category"]) {
                        $lots_list .= include_template('item_lot.php', ['lot_data' => $val, 'key' => $key, 'time' => $lot_time_remaining]);
                    }
                }
            } else {
                foreach ($lot_data as $key => $val):
                    $lots_list .= include_template('item_lot.php', ['lot_data' => $val, 'key' => $key, 'time' => $lot_time_remaining]);
                endforeach;
            }
            $page_content .= include_template('index.php', ['main_menu' => $main_menu, 'lots_list' => $lots_list]);
            $layout_content = include_template('layout.php', ['page_title' => 'Войти', 'content' => $page_content, 'list_menu' => $list_menu, 'auth_status' => $auth_status]);
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