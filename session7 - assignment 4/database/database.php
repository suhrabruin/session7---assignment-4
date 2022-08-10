<?php
class Database{
    
    public static function connect(){
        $server_name = 'localhost';
    $db_user = 'root';
    $db_password = '';
    $db_name = 'session7_assignment4';
    // echo "xxx";die;
        $db_connection = new mysqli($server_name,$db_user,$db_password,$db_name);
        return  $db_connection;
    }
}