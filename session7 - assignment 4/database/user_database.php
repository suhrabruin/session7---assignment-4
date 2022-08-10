<?php
require_once 'includes/core.php';
require_once 'database/database.php';

class User_Database{
    private static $file_name= "database\users.txt";
    protected static $users_array;
    // private static $db_connection = Database::connect(); 
    public function __construct(){
        // if(self::$db_connection==null){
        //     self::$db_connection = Database::connect(); 
        // }
    }

    private static function initialize(){
        $user1 = new User();
        $user1->id = 1;
        $user1->name = 'suhrab';
        $user1->age=38;
        $user1->email='suhrab.ruin@gmail.com';
        $user1->username='suhrab';
        $user1->password='';
        $user1->image_path=get_default_path(); 
        $users = array($user1);
        File_Handle::write_file(self::$file_name,serialize($users));
    }


    private static function fill_user_object($data){
        $user = new User();
            $user->id= $data['id'];
            $user->name = $data['name'];
            $user->age = $data['age'];
            $user->username = $data['username'];
            $user->email = $data['email'];        
            $user->image_path = $data['image_path'];
            return $user;
    }

    public static function find_user($username,$password){
        $db_connection = Database::connect();
        $sql = 'SELECT * FROM `users` WHERE `username`="'.$username.'" AND `password`="'.$password.'"';        
        
        $result = $db_connection->query($sql);
        if($data = $result->fetch_all(MYSQLI_ASSOC)){            
            $data = $data[0];
            $user = self::fill_user_object($data);
            return $user;
        }        
        return null;
    }

    public static function get_users(){                
        $db_connection = Database::connect();
        $sql_query = 'SELECT * FROM users';
        $result = $db_connection->query($sql_query);
        $items = $result->fetch_all(MYSQLI_ASSOC);        
        $users = array();
        foreach($items as $data){
            $user = self::fill_user_object($data);            
            array_push($users,$user);
        }    
        return $users;    
    }

    function add_user($user){
        $db_connection = Database::connect();
        $sql = 'INSERT INTO Users (`name`, `age`, `username`, `email`, `password`, `image_path`) 
        VALUES ("'.$user->name.'",
         "'.$user->age.'", 
         "'.$user->username.'", 
         "'.$user->email.'", 
         "'.$user->password.'", 
         "'.$user->image_path.'")';
        
        if ($db_connection->query($sql) === TRUE) {
          $last_id = $db_connection->insert_id;
          set_message('success','New user added successfully.');
          return $last_id;
        } else {
            set_message('error','Error: ' . $sql . '<br>' . $db_connection->error);
            return false;
        }
    }

    public static function update_path($id,$path){
        $db_connection = Database::connect();        

        $sql = 'UPDATE users SET                  
        `image_path` ="'.$path.'"
        WHERE `id`= '.$id;        
        
        if ($db_connection->query($sql) === TRUE) {
          $last_id = $conn->insert_id;
          set_message('success','Updated successfully.');
          return $last_id;
        } else {
            set_message('error','Error: ' . $sql . '<br>' . $db_connection->error);
            return false;
        }
    }

    public static function find_user_by_id($id){
        $db_connection = Database::connect();
        $sql_query = 'SELECT * FROM users Where `id`='.$id;        
        $result = $db_connection->query($sql_query);
        if($data = $result->fetch_all(MYSQLI_ASSOC)){            
            $data = $data[0];
            $user = self::fill_user_object($data);
            return $user;
        } 

        return $user;   
    }

    public static function edit_user($user){
        $db_connection = Database::connect();        

        $sql = 'UPDATE users SET 
        `name` = "'.$user->name.'",
        `age` = "'.$user->age.'", 
        `username` ="'.$user->username.'", 
        `email` ="'.$user->email.'",         
        `image_path` ="'.$user->image_path.'"
        WHERE `id`= '.$user->id;        
        
        if ($db_connection->query($sql) === TRUE) {
          $last_id = $conn->insert_id;
          set_message('success','Updated successfully.');
          return $last_id;
        } else {
            set_message('error','Error: ' . $sql . '<br>' . $db_connection->error);
            return false;
        }
    }

    public static function delete_user($id){    
        if($id==1){
            set_message('error','Do not delete first record');
            return false;
        }
        $db_connection = Database::connect();        
        $sql = 'DELETE FROM users WHERE `id`= '.$id;
        if ($db_connection->query($sql) === TRUE) {          
          set_message('success','User deleted successfully.');
          return true;
        } else {
            set_message('error','Error: ' . $sql . '<br>' . $db_connection->error);
            return false;
        }
    }
}