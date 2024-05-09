<?php 

require_once 'functions/connection.php';
require_once 'functions/helpers.php';
require_once 'functions/check_session-user.php';
global $pdo;

if(!isset($_GET['user_id']) && $_GET['user_id'] === ''){
    redirect('auth/login.php');
}

$query = 'SELECT * FROM users WHERE id = ?';
$statement = $pdo->prepare($query);
$statement->execute([$_GET['user_id']]);
$user =$statement->fetch();

if($user === false){
    redirect('auth/login.php');
}


?>
<!DOCTYPE html>
<html lang="fa">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel='stylesheet' href='https://netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css'>
  <link rel="stylesheet" href="<?= asset('assets/css/style_profile.css')?>">
  <style>
    /* Apply RTL styles */
    body {
      direction: rtl;
    }
    .table {
      text-align: right;
    }
    img.img-circle.img-thumbnail.isTooltip {
    height: 350px;
}

  </style>
  <title>پروفایل کاربری</title>
</head>
<body>
  <div class="container bootstrap snippets bootdey ">
    <div class="panel-body inf-content ">
      <div class="row">
        <div class="col-md-4 ">
          <img alt="" style="width:600px;" title="" class="img-circle img-thumbnail isTooltip" src="<?= asset($user->image)?>" data-original-title="کاربر">
          <ul title="Ratings" class="list-inline ratings text-center">
            <li><a href="#"><span class="glyphicon glyphicon-star"></span></a></li>
            <li><a href="#"><span class="glyphicon glyphicon-star"></span></a></li>
            <li><a href="#"><span class="glyphicon glyphicon-star"></span></a></li>
            <li><a href="#"><span class="glyphicon glyphicon-star"></span></a></li>
            <li><a href="#"><span class="glyphicon glyphicon-star"></span></a></li>
          </ul>
        </div>
        <div class="col-md-6">
          <strong>اطلاعات</strong><br>
          <div class="table-responsive">
            <table class="table table-user-information">
              <tbody>
                <tr>
                    <td>
                      <strong>
                        <span class="glyphicon glyphicon-asterisk text-primary"></span>
                        شناسه
                      </strong>
                    </td>
                  <td class="text-primary">
                    <?= $user->id ?>
                  </td>
                </tr>
                <tr>
                    <td>
                      <strong>
                        <span class="glyphicon glyphicon-user text-primary"></span>
                        نام
                      </strong>
                    </td>
                  <td class="text-primary">
                    <?= $user->first_name ?>
                  </td>
                </tr>
                <tr>
                    <td>
                      <strong>
                        <span class="glyphicon glyphicon-cloud text-primary"></span>
                        نام خانوادگی
                      </strong>
                    </td>
                  <td class="text-primary">
                    <?=$user->last_name?>
                  </td>
                </tr>
                <tr>
                    <td>
                      <strong>
                        <span class="glyphicon glyphicon-eye-open text-primary"></span>
                        نقش
                      </strong>
                    </td>
                  <td class="text-primary">
                    <?= $user->type_user?>
                  </td>
                </tr>
                <tr>
                    <td>
                      <strong>
                        <span class="glyphicon glyphicon-envelope text-primary"></span>
                        ایمیل
                      </strong>
                    </td>
                  <td class="text-primary">
                    <?=$user->email?>
                  </td>
                </tr>
                <tr>
                    <td>
                      <strong>
                        <span class="glyphicon glyphicon-calendar text-primary"></span>
                        ایجاد شده در
                      </strong>
                    </td>
                  <td class="text-primary">
                    <?= $user->created_at?>
                  </td>
                </tr>
                <tr>
                    <td>
                      <strong>
                        <span class="glyphicon glyphicon-calendar text-primary"></span>
                        آخرین ویرایش
                      </strong>
                    </td>
                  <td class="text-primary">
                    <?=$user->update_at?>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <br>
          <a href="<?= url('panel/edit.php?user_id='.$user->id)?>" class="btn btn-primary">ویرایش</a>
        </div>
      </div>
    </div>
  </div>
</body>
