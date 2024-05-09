<?php 

require_once '../functions/connection.php';
require_once '../functions/helpers.php';
require_once '../functions/check_session-user.php';
global $pdo;


$query = 'SELECT * FROM new_projct.users WHERE id=?';
        $statment = $pdo->prepare($query);
        $statment->execute([$_GET['user_id']]);
        $user = $statment->fetch();

        if($user === false){
            if($_SESSION['user']){
                redirect('auth/login.php');
            }elseif($_SESSION['admin']){
            redirect('panel');
            }
        }

            // if($_SESSION['user']){
            //     redirect('index-user.php?user_id='.$user->id);
            // }elseif($_SESSION['admin']){
            // redirect('panel');
            // }

if(isset($_POST['cancel'])){
    if($_SESSION['user']){
        redirect('index-user.php?user_id='.$user->id);
    }elseif($_SESSION['admin']){
    redirect('panel');
    }
}

if(isset($_POST['first_name'])AND $_POST['first_name'] !== ''
AND isset($_POST['last_name'])AND $_POST['last_name'] !== ''
AND isset($_POST['email'])AND $_POST['email'] !==''){

    if(isset($_FILES['image'])AND $_FILES['image']['name'] !== ''){
        $allowedMimes = ['png' , 'jpeg' , 'jpg' , 'gif'];


        $basePath = dirname(__DIR__);
        if(!in_array($imageMime, $allowedMimes)){
            if($_SESSION['admin']){
                redirect('panel');
            }elseif($_SESSION['user']){
            redirect('index-user.php?user_id='.$user->id);
            }
        }
        $imageMime = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

        if(file_exists($basePath . $user->image)){
            unlink($basePath . $user->image);
        }

        $image = '/assets/image/' . date("Y_m_d_H_i_s") . '.' . $imageMime ;

        $image_upload = move_uploaded_file($_FILES['image']['tmp_name'] ,$basePath .$image);

        if($user !== false AND $image_upload !== false){
            
        

        $query = 'UPDATE new_projct.users SET image = ? , first_name = ? , last_name=? ,email = ? , update_at = NOW() WHERE id=?';
        $statment = $pdo->prepare($query);
        $statment->execute([$image , $_POST['first_name'],$_POST['last_name'],$_POST['email'],$_GET['user_id']]);
    }
        
    }else{
        if($user !== false){
            $query = 'UPDATE new_projct.users SET first_name = ? , last_name=? ,email = ? , update_at = NOW() WHERE id=?';
            $statment = $pdo->prepare($query);
            $statment->execute([$_POST['first_name'],$_POST['last_name'],$_POST['email'],$_GET['user_id']]);
            if($_SESSION['admin']){
                redirect('panel');
            }elseif($_SESSION['user']){
            redirect('index-user.php?user_id='.$user->id);
            }
        }

    }
}
    
        
   
    

 












        
        
        



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' href='https://netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css'>
    <link rel='stylesheet' href='../assets/css/style_edit.csss'>
    <title>Document</title>
</head>
<body>
    <style>
        body{
            background-color: #f5f6fa;
        }

        img {
    border-radius: 100px;
    box-shadow: 0 0 10px 5px #686868;
    margin-top: 29px;
}
    .col-xl-3.col-lg-3.col-md-12.col-sm-12.col-12 {
    text-align: center !important; 
    border-radius: 20px;
    background-color: white;
    margin-top: 20px;
}
    .col-xl-12.col-lg-12.col-md-12.col-sm-12.col-12 {
    margin-top: 30px !important; 


}
p {
    font-size: 10px;
}
.card-body  {
    background-color: white;
    border-radius: 20px;
    padding: 0 20px 20px 20px;
}
.row.gutters {
    margin-top: 20px;
    
}

    </style> 
    <div class="container">
        <div class="row gutters">
        <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12 ">
        <div class="card h-100">
            <div  class="card-body">
                <div class="account-settings">
                    <div class="user-profile">
                        <div class="user-avatar">
                            <img src="<?= asset($user->image)?>" alt="Maxwell Admin" width="200px" height="200px">
                        </div>
                        <h5 class="user-name"><?= $user->first_name . ' ' . $user->last_name?></h5>
                        <h6 class="user-email"><?= $user->email?></h6>
                    </div>
                    <div class="about">
                        <h5>About</h5>
                        <p>I'm Yuki. Full Stack Designer I enjoy creating user-centric, delightful and human experiences.</p>
                    </div>
                </div>
            </div>
        </div>
        </div>
        
        <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
        <div class="card h-100">
            <div class="card-body">
                <div class="row gutters">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <h6 class="mb-2 text-primary">Personal Details</h6>
                    </div>
                    <form action="<?= url('panel/edit.php?user_id='. $user->id)?>" method="post" enctype="multipart/form-data">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                            
                            <label for="website">first name</label>
                            <input type="text" name="first_name" class="form-control" id="website" value="<?= $user->first_name?>">
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label for="phone">last name</label>
                            <input type="text" name="last_name" class="form-control" id="phone" value="<?= $user->last_name?>">
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <label for="eMail">Email</label>
                            <input type="email" name="email"  class="form-control" id="eMail" value="<?= $user->email?>">
                        <div class="form-group">
                            
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <label for="image">profile</label>
                            <input type="file" class="form-control" name="image" id="image">
                        <div class="form-group">
                            
                        </div>
                    </div>
                    
                </div>
                <div class="row gutters">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="text-right">
                            
                            <button type="submit" id="submit" name="submit" class="btn btn-primary">Update</button>
                            <button type="submit" id="submit" name="cancel" class="btn btn-secondary">Cancel</button>
                        </div>
                    </div>
                </div>
                </form>
                
            </div>
        </div>
        </div>
        </div>
        </div>
        
        
                        
</body>
</html>