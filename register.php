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