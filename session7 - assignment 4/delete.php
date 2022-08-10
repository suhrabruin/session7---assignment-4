<?php
require_once 'includes/core.php';
require_once 'database/user_database.php';

Authentication::is_auth();

$id = (int)$_GET['id'];
if($user = User_Database::find_user_by_id($id)){   
    $user->delete();
}else{
    set_message("error","User not found!");
}
redirect('users.php');