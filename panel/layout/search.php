<?php

require_once '../../functions/connection.php';
require_once '../../functions/helpers.php';
require_once '../../functions/check_session-admin.php';
global $pdo;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">


    <title>Contact List - Bootdey.com</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://netdna.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= asset('assets/fontawesome/css/fontawesome.css') ?>" rel="stylesheet" />
    <link href="<?= asset('assets/fontawesome/css/brands.css') ?>" rel="stylesheet" />
    <link href="<?= asset('assets/fontawesome/css/solid.css') ?>" rel="stylesheet" />
</head>

<body>
    <style>
        img.thumb-lg.img-circle.bx-s {
            box-shadow: 0 0 10px 0px black;
        }

        .panel-body.p-t-10 {
            border: 1px solid #f0f0f0;
            border-radius: 20px;
        }
    </style>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <div class="container bootstrap snippets bootdey">

        <form action="<?= url('panel/layout/search.php') ?>" method="post">

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body p-t-0">
                            <div class="input-group">
                                <input type="text" id="example-input1-group2" name="search" class="form-control"
                                    value="<?= $_POST['search']?>">
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-effect-ripple btn-primary"><i
                                            class="fa fa-search"></i></button>

                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>


        <div class="row">
            <?php
            if (!isset($_POST['search']) && $_POST['search'] === '') {
                redirect('panle');
            }
            $search = $_POST['search'];
            $query = 'SELECT * FROM users WHERE first_name like ? or last_name like ? or email like ? ';
            $statment = $pdo->prepare($query);
            $statment->execute(["%$search%", "%$search%", "%$search%"]);
            $users = $statment->fetchAll();
            foreach ($users as $user) {
                ?>
                <div class="col-sm-6">
                    <div class="panel">
                        <div class="panel-body p-t-10">
                            <div class="media-main">
                                <a class="pull-left" href="#">
                                    <img class="thumb-lg img-circle bx-s" src="<?= asset($user->image) ?>" width="100px"
                                        height="100px" alt>
                                </a>
                                <div class="pull-right btn-group-sm">
                                    <a href="<?= url('panel/edit.php?user_id=' . $user->id) ?>"
                                        class="btn btn-success tooltips" data-placement="top" data-toggle="tooltip"
                                        data-original-title="Edit">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <a href="<?= url('panel/delete.php?user_id=' . $user->id) ?>"
                                        class="btn btn-danger tooltips" data-placement="top" data-toggle="tooltip"
                                        data-original-title="Delete">
                                        <i class="fa fa-close"></i>
                                    </a>
                                    <a href="<?= url('index-user.php?user_id=') . $user->id ?>"
                                        class="btn btn-danger tooltips" data-placement="top" data-toggle="tooltip"
                                        data-original-title="Delete">
                                        <i class="fa-regular fa-user" style="color: #ffffff;"></i>
                                    </a>
                                </div>
                                <div class="info">
                                    <h4><?= $user->first_name . ' ' . $user->last_name ?></h4>
                                    <p class="text-muted"><?= $user->email ?></p>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <hr>
                            <ul class="social-links list-inline p-b-10">
                                <li>
                                    <a title data-placement="top" data-toggle="tooltip" class="tooltips" href="#"
                                        data-original-title="Facebook"><i class="fa fa-facebook"></i></a>
                                </li>
                                <li>
                                    <a title data-placement="top" data-toggle="tooltip" class="tooltips" href="#"
                                        data-original-title="Twitter"><i class="fa fa-twitter"></i></a>
                                </li>
                                <li>
                                    <a title data-placement="top" data-toggle="tooltip" class="tooltips" href="#"
                                        data-original-title="LinkedIn"><i class="fa fa-linkedin"></i></a>
                                </li>
                                <li>
                                    <a title data-placement="top" data-toggle="tooltip" class="tooltips" href="#"
                                        data-original-title="Skype"><i class="fa fa-skype"></i></a>
                                </li>
                                <li>
                                    <a title data-placement="top" data-toggle="tooltip" class="tooltips" href="#"
                                        data-original-title="Message"><i class="fa fa-envelope-o"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <script src="js.js"></script>
</body>

</html>