<?php
require_once 'includes/core.php';
require_once 'classes/Authentication.php';
require_once 'database/user_database.php';

Authentication::is_auth();


$id = (int)$_GET['id'];
$path = (string)$_GET['path'];



    if(file_exists($path)){
        if(unlink($path)){
            // User_Database::update_path($id,null);
        }   
    }
    User_Database::update_path($id,null);

redirect('users.php');