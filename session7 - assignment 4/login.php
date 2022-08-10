<?php
// require_once 'classes/authentication.php';
require_once 'classes/user.php';

if(isset($_POST['submit'])){
    $username = isset($_POST['username'])?$_POST['username']:null;
    $password = isset($_POST['password'])?$_POST['password']:null;        
    (User::login($username,$password))?redirect('dashboard.php'):redirect('index.php');
    
}else{
    header('Location:index.php');
}