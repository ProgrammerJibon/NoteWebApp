<?php 
require_once("./functions.php");

unset($_SESSION['student_id']);
header("Location: /");
exit();