<?php
require_once("./functions.php");
if (!$student_info) {
    header("Location:/");
}

$nav_required = true;
require_once("./header.php");
if (isset($student_info['user_type']) && $student_info['user_type'] == "ADMIN") {
    if ($query = @mysqli_query($connect, "SELECT * FROM `students` ORDER BY `students`.`id` ASC")) {
?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Semester</th>
                    <th>Phone Number</th>
                    <th>Status</th>
                    <th>Type</th>
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
                    </tr>
            <?php   } ?>
        </table>
<?php
    }
}
require_once("./footer.php");
?>