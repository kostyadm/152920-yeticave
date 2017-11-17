<?php
function include_template($path_to_file, $args=array()){
    if(file_exists(path_to_file)){
        ob_start();
        print ($path_to_file);
        $result=ob_get_clean();
    }else{
        $result='';
    }
    return $result;
}
?>
