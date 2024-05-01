<?php
require_once "./functions.php";

// echoArray(login("12221059", "1234"));
// echo hash_pass("1234");
// echoArray(student_info(12221059));

$p = array(
    'student_id' => 5,
    'student_name' => 'Jibon',
    'dept_id' => 1,
    'session_id' => 1,
    'current_semester' => 4,
    'account_creation_time' => 0,
    'phone_number' => 1600301810,
    'password' => '1234s',
    'status' => 'ACTIVE',
    'user_type' => 'ADMIN'
);
// echoArray(register($p));

if(!$student_info){
    $student_session = 1;
    

    header("Location:/login.php");
    exit();
}else{
    echo "Logged in";
    echoArray($student_info);
}