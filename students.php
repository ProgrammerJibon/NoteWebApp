<?php
require_once("./functions.php");
if (!$student_info) {
    header("Location:/");
}

if(isset($_REQUEST['unban_user'])){
    $target_id = addslashes($_REQUEST['unban_user']);
    if(@mysqli_query($connect, "UPDATE `students` SET `status` = 'ACTIVE' WHERE `students`.`id` = '$target_id'")){
        header("Location: /students.php");
        exit;
    }
}
if(isset($_REQUEST['ban_user'])){
    $target_id = addslashes($_REQUEST['ban_user']);
    if(@mysqli_query($connect, "UPDATE `students` SET `status` = 'BAN' WHERE `students`.`id` = '$target_id'")){
        header("Location: /students.php");
        exit;
    }
}

$nav_required = true;
require_once("./header.php");
if (isset($student_info['user_type']) && $student_info['user_type'] == "ADMIN") {
    if ($query = @mysqli_query($connect, "SELECT * FROM `students` ORDER BY `students`.`id` ASC")) {
?>
<title>Students</title>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Semester</th>
                    <th>Phone Number</th>
                    <th>Status</th>
                    <th>Type</th>
                    <th>Action</th>
                </tr>
            </thead><?php
                    foreach ($query as $key) { ?>
                    <tr>
                        <td><?php echo $key['id']; ?></td>
                        <td><?php echo $key['student_name']; ?></td>
                        <td><?php echo $key['current_semester']; ?></td>
                        <td><?php echo $key['phone_number']; ?></td>
                        <td><?php echo $key['status']; ?></td>
                        <td><?php echo $key['user_type']; ?></td>
                        <td><?php
                        if($key['status'] == "BAN"){
                            echo "<a href=\"?unban_user=$key[id]\">ACTIVE</a>";
                        }elseif($key['status'] == "ACTIVE"){
                            echo "<a href=\"?ban_user=$key[id]\">BAN</a>";
                        }
                        ?><br><a href="?reset_pass=<?php echo $key['id']; ?>">Reset Password</a></td>
                    </tr>
            <?php   } ?>
        </table>
<?php
    }
}
require_once("./footer.php");
?>