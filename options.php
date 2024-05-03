<?php
require_once("./functions.php");
if (!$student_info) {
    header("Location:/");
}

$nav_required = true;
if(isset($_GET['delete_session'])){
    if(@mysqli_query($connect, "DELETE FROM admission_sessions WHERE `admission_sessions`.`id` = '$_GET[delete_session]'")){
        header("Location: ?deleted=true");
        exit();
    }
}
if(isset($_POST['add_sess'], $_POST['sname'], $_POST['syear']) && !is_empty( $_POST['sname'], $_POST['syear'])){
    if(@mysqli_query($connect, "INSERT INTO `admission_sessions` (`session_name`, `session_year`) VALUES ('$_POST[sname]', '$_POST[syear]')")){
        header("Refresh: 0");
        exit();
    }
}
if(isset($_GET['delete_dept'])){
    if(@mysqli_query($connect, "DELETE FROM department WHERE `department`.`id` =  '$_GET[delete_dept]'")){
        header("Location: ?deleted=true");
        exit();
    }
}
if(isset($_POST['add_dept'], $_POST['dept_fname'], $_POST['dept_sname']) && !is_empty( $_POST['dept_fname'], $_POST['dept_sname'])){
    if(@mysqli_query($connect, "INSERT INTO `department` (`dept_full_name`, `dept_short_name`) VALUES ('$_POST[dept_fname]', '$_POST[dept_sname]')")){
        header("Refresh: 0");
        exit();
    }
}
require_once("./header.php");
if (isset($student_info['user_type']) && $student_info['user_type'] == "ADMIN") {
    ?>
    <div class="site_options">
    <br>
        <form method="post" class="post_form">
            <h3>Add Department</h3>
            <label>
                <div>Full Name of Deparment</div>
                <input required type="text" name="dept_fname">
            </label>
            <label>
                <div>Short Name of Deparment</div>
                <input required type="text" name="dept_sname">
            </label>
            <label>
                <input required type="submit" name="add_dept" value="Add Department">
            </label>
        </form>
        <h1>Departments</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Department Full Name</th>
                    <th>Department Short Name</th>
                    <th>Active</th>
                </tr>
            </thead><?php
                    foreach (get_depts() as $key) { ?>
                    <tr>
                        <td><?php echo $key['id']; ?></td>
                        <td><?php echo $key['dept_full_name']; ?></td>
                        <td><?php echo $key['dept_short_name']; ?></td>
                        <td><a href="?delete_dept=<?php echo $key['id']; ?>">Delete</a></td>
                    </tr>
            <?php   } ?>
        </table>
        <br>
        <form method="post" class="post_form">
            <h3>Add Admission Session</h3>
            <label>
                <div>Session Name</div>
                <input required type="text" name="sname">
            </label>
            <label>
                <div>Session Year</div>
                <input required type="text" name="syear">
            </label>
            <label>
                <input required type="submit" name="add_sess" value="Add Session">
            </label>
        </form>
        <h1>Admission Sessions</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>session name</th>
                    <th>session year</th>
                    <th>Action</th>
                </tr>
            </thead><?php
                    foreach (get_sessions() as $key) { ?>
                    <tr>
                        <td><?php echo $key['id']; ?></td>
                        <td><?php echo $key['session_name']; ?></td>
                        <td><?php echo $key['session_year']; ?></td>
                        <td><a href="?delete_session=<?php echo $key['id']; ?>">Delete</a></td>
                    </tr>
            <?php   } ?>
        </table>
        <br>
    </div>
    <?php
    
    
}
require_once("./footer.php");
?>