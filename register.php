<?php 
require_once("./functions.php");

if($student_info){
    header("Location:/");
}

$login_error = "";
$student_id = "";
$student_name = "";
$student_phone = "";
$student_semester = 3;
$student_dept = get_depts()[0]['id'];
$student_session = get_sessions()[0]['id'];



if(isset($_POST['register'], $_POST['student_name'], $_POST['student_id'], $_POST['dept_id'],$_POST['session_id'],$_POST['current_semester'],$_POST['phone_number'],$_POST['pass'])){    
    if($_POST['student_name'] == ""){
        $login_error .= "student name is empty<br>";
    }else{
        $student_name = addslashes(strip_tags($_POST['student_name']));
    }
    if($_POST['student_id'] == ""){
        $login_error .= "student id is empty<br>";
    }else{
        $student_id = addslashes(strip_tags($_POST['student_id']));
    }
    if($_POST['dept_id'] == ""){
        $login_error .= "dept is empty<br>";
    }else{
        $dept_id = addslashes(strip_tags($_POST['dept_id']));
    }
    if($_POST['session_id'] == ""){
        $login_error .= "session is empty<br>";
    }else{
        $session_id = addslashes(strip_tags($_POST['session_id']));
    }
    if($_POST['current_semester'] == ""){
        $login_error .= "current semester is empty<br>";
    }else{
        $current_semester = addslashes(strip_tags($_POST['current_semester']));
    }
    if(mb_strlen($_POST['phone_number']) == 11){
        $login_error .= "phone number is invalid<br>";
    }else{
        $phone_number = addslashes(strip_tags($_POST['phone_number']));
    }
    if($_POST['pass'] == ""){
        $login_error .= "password is empty<br>";
    }else{
        $password = hash_pass($_POST['pass']);
    }

    if($login_error == ""){
        $_POST['student_id'] = addslashes($_POST['student_id']);

        $_POST['password'] = hash_pass($_POST['password']);
        if(!student_info($_POST['student_id'])){
            if($query = @mysqli_query($connect, "INSERT INTO `students` (`id`,`student_name`, `dept_id`, `session_id`, `current_semester`, `account_creation_time`, `phone_number`, `password`, `status`) VALUES ('$student_id','$student_name',  '$dept_id', '$session_id', '$current_semester', '0', '$phone_number', '$password', 'ACTIVE')")){
                $_SESSION['student_id'] = mysqli_insert_id($connect);
                header("Location:/");
                exit();
            }
        }
        
    }

}else{
    $login_error .= "Please use form<br>";
}




?>


<form method="post">
    <div>
        <h1>Register Page</h1>
    </div>
    <div>
        <p>
            <?php echo $login_error;?>
        </p>
    </div>
    <div>
        <label>
            <span>Student Id</span>
            <input type="text" value="<?php echo $student_id; ?>" autofocus name="student_id">
        </label>
    </div>
    <div>
        <label>
            <span>Student Name</span>
            <input type="text" value="<?php echo $student_name; ?>" autofocus name="student_name">
        </label>
    </div>
    <div>
        <label>
            <span>Student phone</span>
            <input type="tel" maxlength="11" minlength="11"  value="<?php echo $student_phone; ?>" autofocus name="phone_number">
        </label>
    </div>
    <div>
        <label>
            <span>Student Semester</span>
            <select name="current_semester">
                <option value="3" <?php if($student_semester == 3) echo "selected" ?> >3rd</option>
                <option value="4" <?php if($student_semester == 4) echo "selected" ?> >4th</option>
            </select>
        </label>
    </div>
    <div>
        <label>
            <span>Student Department</span>
            <select name="dept_id">
                <?php 
                foreach(get_depts() as $key){
                    ?>
                    <option value="<?php echo $key['id'] ?>" <?php if($student_dept == $key['id']) echo "selected" ?> ><?php echo strtoupper($key['dept_short_name']). " - " . $key['dept_full_name'] ?></option>
                    <?php
                }
                ?>
            </select>
        </label>
    </div>
    <div>
        <label>
            <span>Student Admission Session</span>
            <select name="session_id">
                <?php 
                foreach(get_sessions() as $key){
                    ?>
                    <option value="<?php echo $key['id'] ?>" <?php if($student_session == $key['id']) echo "selected" ?> ><?php echo strtoupper($key['session_name']). " " . $key['session_year'] ?></option>
                    <?php
                }
                ?>
            </select>
        </label>
    </div>
    <div>
        <label>
            <span>Password</span>
            <input type="password" name="pass">
        </label>
    </div>
    <div>
        <input type="submit" name="register" value="Register">
    </div>
    <div>
        <span>Already have an account yet?</span>
        <a href="/login.php">Register</a>
    </div>
</form>