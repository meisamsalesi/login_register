<?php 

session_start();

if(!isset($_SESSION['user']) && !isset($_SESSION['admin'])){
redirect('auth/login.php');



}
?>