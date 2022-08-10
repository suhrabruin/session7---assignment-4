<?php
require_once 'includes/core.php';
require_once 'database/user_database.php';

Authentication::is_auth();

if(isset($_POST['upload'])){
    $id = (int)$_POST['user_id'];
    $user = User_Database::find_user_by_id($id);    
    $user->upload_profile_image($_FILES['profile_image']);
    User_Database::edit_user($user);

    redirect('profile.php');

}else{    
    set_message('error','Invalid Action!');        
    redirect('dashboard.php');
}