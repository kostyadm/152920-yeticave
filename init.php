<?php

require_once('functions.php');

$con = mysqli_connect('localhost', 'root', '', 'yeticave');
mysqli_set_charset($con, "utf8");

if ($con == false) {
    $error = 'Ошибка подключения: ' . mysqli_connect_error();
    $page_content = include_template('error.php', ['error' => $error]);
    $layout_content = include_template('layout.php', ['page_title' => 'Войти', 'content' => $page_content, 'list_menu' => $list_menu, 'auth_status' => $auth_status]);
    $layout_content = preg_replace('<main class="container">', 'main', $layout_content);
    print($layout_content);
    exit;
}