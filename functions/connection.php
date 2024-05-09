<?php 
global $pdo;


try{
    $options = [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION , PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_OBJ];
    $pdo = new pdo('mysql:host=localhost;dbname=new_projct' , 'root' ,'',$options);
    return($pdo);
}catch(PDOException $e){
    echo 'error' . $e->getMessage();
}


?>