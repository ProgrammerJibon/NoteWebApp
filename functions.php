<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

date_default_timezone_set("Asia/Dhaka");
$time = time();
session_start();



$connect = connect();
$student_info = isset($_SESSION['student_id'])?student_info($_SESSION['student_id']):false;

function connect(){
    $DB_HOST = "localhost";
	$DB_USER = "root";
	$DB_PASS = '';
	$DB_NAME = "pbl_project_moumi_jessy";

    $CONNECT = @mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
    if(!$CONNECT){
        header("$_SERVER[SERVER_PROTOCOL] 500 DB Connection failed!");
        exit();
    }
    mysqli_set_charset($CONNECT,"utf8");
    return $CONNECT;
}

function echoArray($value) {
    echo "<pre>";
    print_r($value);
    echo "</pre>";
}

function hash_pass($pass){
    return md5(sha1($pass));
}

function student_info($student_id){
    global $connect;
    $result = false;
    $student_id = addslashes($student_id);
    if($query = @mysqli_query($connect, "SELECT * FROM `students` WHERE `id` = '$student_id' LIMIT 1")){
        foreach($query as $key){
            $result = $key;
            break;
        }
    }
    return $result;
}

function login($student_id, $student_password){
    global $connect;

}

function register($p){
    global $connect, $student_info;
    $result = false;
    //
    if(isset($p['student_name'], $p['student_id'], $p['dept_id'],$p['session_id'],$p['current_semester'],$p['phone_number'],$p['password'],$p['user_type']) && ($student_info == false || (isset($student_info['user_type']) && $student_info['user_type'] == "ADMIN"))){
        $p['student_id'] = addslashes($p['student_id']);
        if((isset($student_info['user_type']) && $student_info['user_type'] == "ADMIN")){
            $p['user_type'] = addslashes($p['user_type']);
        }else{
            $p['user_type'] = "STUDENT";
        }
        $p['password'] = hash_pass($p['password']);
        if(!student_info($p['student_id'])){
            if($query = @mysqli_query($connect, "INSERT INTO `students` (`id`,`student_name`, `dept_id`, `session_id`, `current_semester`, `account_creation_time`, `phone_number`, `password`, `status`, `user_type`) VALUES ('$p[student_id]','$p[student_name]',  '$p[dept_id]', '$p[session_id]', '$p[current_semester]', '0', '$p[phone_number]', '$p[password]', 'ACTIVE', '$p[user_type]')")){
                $_SESSION['student_id'] = mysqli_insert_id($connect);
                $result = $query;
            }
        }
        
    }
    return $result;
}