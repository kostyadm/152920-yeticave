<?php
function include_template($filename, $args=array()){
    if (file_exists ($filename)) {
        ob_start();
        print($filename);
        $result=ob_get_clean();
    }else{
        $result='';
    }
    return $result;
}
?>
