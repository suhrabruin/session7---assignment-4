<?php

require_once 'session.php';
require_once 'includes/core.php';
require_once 'database/user_database.php';

class User{

    public static function is_login(){
        return Session::isset('login');
    }
    public static function login($username,$password){
        $found_user = User_Database::find_user($username,$password);      
        if($found_user){                      
            Session::set_session('auth_user',$found_user);
            Session::set_session('login',true);
            return true;            
        }else{
            set_message('error','Invalid Username or Password');            
            return false;
        }
    }

    public static function logout(){        
        Session::destroy_session('login');
        redirect('index.php');
    }
    public static function get_auth_user(){
        return Session::get_session('auth_user');
    }

    public function upload_profile_image($file){        
        $old_path = $this->image_path;        
        $this->image_path = '';

        if(isset($file['tmp_name']) && !empty($file['tmp_name'])){            
            $extension = substr($file['name'],strpos($file['name'],".")+1);
            $this->image_path = get_default_path().$this->username.".".$extension;
            File_Handle::delete($old_path);
            if(!File_Handle::upload($file,$this->image_path)){
                $this->image_path = '';
            }
        }else{
            set_message('error','unable to upload file (upload_profile_image)');
            return false;
        }
    }

    public function save(){        
        if(!isset($this->id)){            
            return User_Database::add_user($this);
        }else{
            return User_Database::edit_user($this);
        }
    }

    public function delete(){
        $profile_image = $this->image_path;
        if(User_Database::delete_user($this->id)){
            return File_Handle::delete($profile_image);
        }
    }

}