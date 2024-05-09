<?php 

require_once '../functions/connection.php';
require_once '../functions/helpers.php';
require_once '../functions/check_session-admin.php';
global $pdo;


if(isset($_GET['user_id'])&& $_GET['user_id'] !== ''){

$query = 'SELECT * FROM new_projct.users WHERE id=?';
        $statment = $pdo->prepare($query);
        $statment->execute([$_GET['user_id']]);
        $user = $statment->fetch();

$basePath = dirname(__DIR__);

if(file_exists($basePath . $user->image)){
    unlink($basePath . $user->image);
}


$query = 'DELETE FROM new_projct.users WHERE id=?';
        $statment = $pdo->prepare($query);
        $statment->execute([$_GET['user_id']]);

        
}
redirect('panel');