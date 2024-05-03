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

function upload($tmp_file, $type = false){
    if(!$tmp_file){
        return false;
    }
    $mime_file_type = explode("/", mime_content_type($tmp_file));
    $result = false;
    if($type == false || $type == $mime_file_type[0]){
        $file_path = "uploads/".date("Y/M/");
        if (!file_exists($file_path)) {
            mkdir($file_path, 0777, true);
        }
        $file_name = $file_path.$mime_file_type[0]."-".time()."-".rand().".".$mime_file_type[1];
        if(move_uploaded_file($tmp_file, $file_name)){
            $result = $file_name;
        }
    }
    return $result;
}

function get_post_data($post_id){
    global $connect, $student_info;
    $post_id = addslashes($post_id);
    $result = false;
    $showIfActiveOrNot = "";
    if($query = @mysqli_query($connect, "SELECT * FROM `notes_post` WHERE `id` = '$post_id'  AND (`status`='ACTIVE' OR  `student_user_id`='$student_info[id]' ) ORDER BY `post_time` DESC LIMIT 1")){
        foreach($query as $key){
            $key['files'] = array();
            $key['liked'] = false;
            $key['saved'] = false;
            $key['likes'] = 0;
            $key['owner'] = student_info($key['student_user_id']);
            if($file_query = @mysqli_query($connect, "SELECT * FROM `post_files` WHERE `note_post_id` = '$post_id'")){
                foreach ($file_query as $file_key) {
                    $key['files'][] = $file_key;
                }
            }
            if($like_query = @mysqli_query($connect, "SELECT * FROM `post_likes` WHERE `student_user_id` LIKE '$student_info[id]' AND `note_post_id` LIKE '$post_id'"))
            {
                $key['liked'] = @mysqli_num_rows($like_query) > 0;
            }
            if($like_query = @mysqli_query($connect, "SELECT * FROM `post_likes` WHERE `note_post_id` LIKE '$post_id'"))
            {
                $key['likes'] = @mysqli_num_rows($like_query);
            }
            if($like_query = @mysqli_query($connect, "SELECT * FROM `saved_post` WHERE `student_user_id` LIKE '$student_info[id]' AND `note_post_id` LIKE '$post_id'"))
            {
                $key['saved'] = @mysqli_num_rows($like_query) > 0;
            }
            $result = $key;
        }
    }
    return $result;
}





