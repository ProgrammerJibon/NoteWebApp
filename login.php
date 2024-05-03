<?php
require_once("./functions.php");

if($student_info){
    header("Location:/");
}


require_once("./header.php");

$login_error = "";
$student_id = "";

if(isset($_POST['login'], $_POST['student_id'], $_POST['pass'])){
    if($_POST['student_id'] == ""){
        $login_error .= "Empty student id<br>";
    }
    if ($_POST['pass'] == "") {
        $login_error .= "Empty password<br>";
    }
    if($login_error == ""){
        $student_id = addslashes($_POST['student_id']);
        $pass = hash_pass($_POST['pass']);
        if($query = mysqli_query($connect, "SELECT * FROM `students` WHERE `id` = '$student_id' LIMIT 1")){
            if(mysqli_num_rows($query) > 0){
                foreach($query as $key){
                    if($key['password'] == $pass){
                        $_SESSION['student_id'] = $student_id;
                        header("Location:/");
                        exit();
                    }else{
                        $login_error .= "Wrong Password<br>";
                    }
                }
            }else{
                $login_error .= "Student id not found<br>";
            }
        }
    }
}
?>
<form method="post" class="post_form">
    <div>
        <h1>Login Page</h1>
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
            <span>Password</span>
            <input type="password" name="pass">
        </label>
    </div>
    <div>
        <input type="submit" name="login" value="login">
    </div>
    <div>
        <span>Don't have an account yet?</span>
        <a href="/register.php">Register</a>
    </div>
</form>

<?php 
require_once("./footer.php");
?>