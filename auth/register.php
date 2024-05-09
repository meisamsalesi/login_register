
<?php 

require_once '../functions/connection.php';
require_once '../functions/helpers.php';
session_start();
global $pdo;


$error = '';

if(isset($_POST['first_name'])&& $_POST['first_name'] !== ''
&& isset($_POST['last_name'])&& $_POST['last_name'] !== ''
&& isset($_POST['password'])&& $_POST['password'] !== ''
&& isset($_POST['confirm_password'])&& $_POST['confirm_password'] !== ''
&& isset($_POST['email'])&& $_POST['email'] !==''
&& isset($_POST['type_user'])&& $_POST['type_user'] !==''
&& isset($_POST['neme_f'])&& $_POST['neme_f'] !==''){

    $query = 'SELECT * FROM new_projct.users WHERE  email = ?';
    $statement = $pdo->prepare($query);
    $statement->execute([$_POST['email']]);
    $user = $statement->fetch();
    
    if(strlen($_POST['password']) > 5){
      if($_POST['password'] === $_POST['confirm_password']){
        
        if(isset($_FILES['profile_image']) && $_FILES['profile_image']['name'] !== ''){

    
    

    
    $allowedMimes = ['png' , 'jpeg' , 'jpg' , 'gif'];
        
    $imageMime = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
        
    $basePath = dirname(__DIR__);
    if(!in_array($imageMime, $allowedMimes)){
        redirect('auth/register.php');
    }

    $image = '/assets/image/' . date("Y_m_d_H_i_s") . '.' . $imageMime ;

    $image_upload = move_uploaded_file($_FILES['profile_image']['tmp_name'] ,$basePath .$image);
    if($user === false && $image_upload !== false){

        $query = 'INSERT INTO new_projct.users SET first_name = ? , last_name = ? , password = ? , email=? ,type_user =? ,image = ?, created_at = NOW();';
        $statement = $pdo->prepare($query);
        $password = password_hash($_POST['password'] , PASSWORD_DEFAULT);
        $statement->execute([$_POST['first_name'],$_POST['last_name'],$password,$_POST['email'],$_POST['type_user'] ,$image] );
        
        $error = 'ثبت نام با موفقیت انجام شد';
        // redirect('auth/login.php');
}

    
    
    
}else{
   
  if($user === false){
      $query = 'INSERT INTO users SET first_name = ? , last_name = ? , password = ? , email=? ,type_user =?, created_at = NOW();';
      $statement = $pdo->prepare($query);
      $password = password_hash($_POST['password'] , PASSWORD_DEFAULT);
      $statement->execute([$_POST['first_name'],$_POST['last_name'],$password,$_POST['email'],$_POST['type_user']]);

      redirect('auth/login.php');
  }else{
      $error = 'این کابر قبلا ثبت نام کرده است';
  }
}

}else{
  $error = 'پسورد با تکرار ان برابر نیست';
 }

}else{
  {
    $error = 'باید بیشتر از 5 کاراکتر باشد';
}
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
  <title>فرم ثبت نام با انتخاب نوع کاربر و آپلود عکس - Bootdey.com</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/css/style_sing.css" rel="stylesheet">
  <style>
    body {
      direction: rtl;
    }
    div {
    text-align: center;
    }
    #login{
        border: 1px solid #d3d3d3;
        width: 60px;
        margin-right: 45%;
        border-radius: 20px;
        padding-bottom: 10px;
        background-color: #5a99ee;
    }
    #login a{
        text-decoration: none;
        color: #ffff;
    }

  </style>
</head>
<body>
  <div class="container">
    <form action="<?= url('auth/register.php')?>" method="post" enctype="multipart/form-data">
      <div class="row justify-content-md-center">
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
          <div class="login-screen">
            <div class="login-box">
                    <small class="text-danger">
                        <?php if($error != ''){ echo $error;} ?>
                    </small>
              <a href="" class="login-logo">
                <img src="//ssl.gstatic.com/accounts/ui/logo_2x.png" alt="Bootdey bootstrap snippets bootdey">
              </a>
              <div class="row gutters">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                  <div class="form-group">
                    <select class="form-control" name="type_user" required>
                      <option  value="user">کاربر عادی</option>
                      <option value="admin">مدیر</option>
                    </select>
                  </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                  <div class="form-group">
                    <input type="text" class="form-control" name="first_name" placeholder="نام" >
                  </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                  <div class="form-group">
                    <input type="text" class="form-control" name="last_name" placeholder="نام خانوادگی" required>
                  </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                  <div class="form-group">
                    <input type="email" class="form-control" name="email" placeholder="ایمیل" required>
                  </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                  <div class="form-group">
                    <input type="password" class="form-control" name="password" placeholder="رمز عبور" required>
                  </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                  <div class="form-group">
                    <input type="password" class="form-control" name="confirm_password" placeholder="تایید رمز عبور" required>
                  </div>
                </div>
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                  <div class="form-group">
                    <label for="profile_image">تصویر پروفایل (اختیاری):</label>
                    <input type="file" class="form-control" id="profile_image" name="profile_image" accept="image/*">
                  </div>
                </div>
              </div>
              <div class="actions clearfix">
                <button type="submit" class="btn btn-primary btn-block">ثبت نام</button>
              </div>
              <div id="login">
              <a  href="<?= url('auth/login.php')?>">ورود</a>
              </div>
              <div class="row gutters">
