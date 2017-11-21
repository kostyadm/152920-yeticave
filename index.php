<?php

require_once ('functions.php');
require_once ('data.php');

$page_content=include_template('index.php', ['cat'=>$cat, 'ads'=>$ads, 'time'=>$lot_time_remaining]);
$layout_content=include_template('layout.php', ['page_title'=>'Главная стараница','content'=>$page_content, 'auth'=>$is_auth,'name'=>$user_name, 'avatar'=>$user_avatar]);
print($layout_content);
?>
