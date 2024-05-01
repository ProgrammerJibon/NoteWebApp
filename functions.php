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


function get_depts(){
    global $connect;
    $result = array();
    if($query = mysqli_query($connect, "SELECT * FROM `department`")){
        foreach($query as $key){
            $result[] = $key;
        }
    }
    return $result;
}

function get_sessions(){
    global $connect;
    $result = array();
    if($query = mysqli_query($connect, "SELECT * FROM `admission_sessions`")){
        foreach($query as $key){
            $result[] = $key;
        }
    }
    return $result;
}
