<?php 


define('BASE' , 'http://localhost/new-project/');

function redirect($url){
    header('location:' . trim(BASE , '/ ') . '/' . trim($url , '/ '));
}
function redirectBack(){
    header('location:' . $_SERVER['HTTP_REFERER']);
}

function asset($file){
    return trim(BASE , ' /') . '/' . trim($file , ' /');
}

function url($dri){
    return trim(BASE , ' /') . '/' . trim($dri , ' /');
}


function dd($var){
    echo'<pre>';
    var_dump($var);
    exit;
}
?>