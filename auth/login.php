<?php 

require_once '../functions/connection.php';
require_once '../functions/helpers.php';
global $pdo;
$error = '';
session_start();


if(isset($_SESSION['user'] )or isset($_SESSION['admin'])){
    unset($_SESSION['user']);
    unset($_SESSION['admin']);
}
if(isset($_POST['email'])&& $_POST['email'] !== ''
&& isset($_POST['password'])&& $_POST['password'] !== ''){
    $query = 'SELECT * FROM users WHERE email = ?';
$statement = $pdo->prepare($query);
$statement->execute([$_POST['email']]);
$user =$statement->fetch();


if($user !== false){
    if(password_verify($_POST['password'] , $user->password)){
        if($user->type_user === 'user'){
            $_SESSION['user'] = $user->id;
        }else{
            $_SESSION['admin'] = $user->id;
        }
        
        if($user->type_user === 'user'){
            redirect('index-user.php?user_id='.$user->id);
        }else{
        redirect('index-admin.php?user_id='.$user->id);
        }
    }else{
        $error = 'پسورد اشتباه است';
    }


}else{
    $error = 'حساب کاربری موجود نمیباشد';
}

}else{
    if(!empty($_POST)){
    $error = 'همه فیلد ها اجباری هستند';
}
}




?>



<!DOCTYPE html>
<html lang="fa">
<head>
<meta charset="utf-8">


<title>فرم ورود با Modal در بوت استرپ - Bootdey.com</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet">
<link href="<?= asset('assets/css/style_login.css')?>" rel="stylesheet">

<style>
  body {
    direction: rtl;

  }
  .modal-content {
    margin-top: 100px;
}
</style>
</head>
<body>

<div id="loginModal" class="modal show" tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<h1 class="text-center">ورود</h1> 
<small class="text-danger">
    <?php if($error != ''){ echo $error;} ?>
    </small> 
</div>
<div class="modal-body">

    <form action="<?= url('auth/login.php')?>" class="form col-md-12 center-block" method="post">
        <div class="form-group">
            <input type="text" class="form-control input-lg" name="email" placeholder="ایمیل">  </div>
        <div class="form-group">
            <input type="password" class="form-control input-lg" name="password" placeholder="رمز عبور">  </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-lg btn-block">ورود</button> 
             <span class="pull-left"><a href="<?= url('auth/register.php')?>">ثبت نام</a></span>
             <span><a href="#">نیاز به کمک؟</a></span> 
        </div>
    </form>

</div>
<div class="modal-footer">
<div class="col-md-12 accordion2"> 
     <a href="<?= url('auth/register.php')?>" class="btn" data-dismiss="modal" aria-hidden="true">لغو</a> 
     </div>
</div>
</div>
</div>
</div>
<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="https://netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
<script type="text/javascript"></script>
</body>
</html>
