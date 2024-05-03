<?php
require_once("./functions.php");
if(!$student_info){
    header("Location:/");
}

$nav_required = true;
require_once("./header.php");

?>
<title><?php
$sql = "SELECT `id` FROM `notes_post` WHERE (`status`='ACTIVE') ORDER BY RAND() LIMIT 20";
if(isset($_GET['show_saved'])){
    $sql = "SELECT `note_post_id` AS `id` FROM `saved_post` WHERE `student_user_id` = '$student_info[id]'";
    echo "Saved Notes";
}elseif(isset($_GET['user'])){
    $_GET['user'] = addslashes($_GET['user']);
    $sql = "SELECT `id` FROM `notes_post` WHERE `student_user_id` = '$_GET[user]' AND (`status`='ACTIVE' OR `student_user_id`='$student_info[id]') ORDER BY `notes_post`.`id` DESC";
    echo "Notes of User";
}elseif(isset($_GET['dept_id'])){
    $_GET['dept_id'] = addslashes($_GET['dept_id']);
    $sql = "SELECT `id` FROM `notes_post` WHERE `dept_id` = '$_GET[dept_id]' AND (`status`='ACTIVE' OR `student_user_id`='$student_info[id]') ORDER BY `notes_post`.`id` DESC";
    echo "Department wise notes";
}elseif(isset($_GET['semester'])){
    $_GET['semester'] = addslashes($_GET['semester']);
    $sql = "SELECT `id` FROM `notes_post` WHERE `semester` = '$_GET[semester]' AND (`status`='ACTIVE' OR `student_user_id`='$student_info[id]') ORDER BY `notes_post`.`id` DESC";
    echo "Semester wise notes";
}elseif(isset($_GET['search'])){
    $_GET['search'] = addslashes($_GET['search']);
    $sql = "SELECT `id` FROM `notes_post` WHERE `caption` LIKE '%$_GET[search]%' AND (`status`='ACTIVE' OR `student_user_id`='$student_info[id]') ORDER BY `notes_post`.`id` DESC";
    echo "Search result for ".$_GET['search'];
}else{
    echo "All notes";
}
?></title>



<div class="notes">
    <div class="post_row" style="margin-top: 64px; justify-content: center;">
        <span>Semester: </span>
        <?php 
            for($i = 1; $i <= 8; $i++){
                echo "<a style='padding: 4px 8px;' href='/notes.php?semester=$i'>$i</a>";
            }
        ?>
    </div>
    <div class="post_row" style="margin-top: 8px; justify-content: center;">
        <span>Department: </span>
        <?php 
            foreach(get_depts() as $dep){
                echo "<a style='padding: 4px 8px;' href='/notes.php?dept_id=$dep[id]'>$dep[dept_full_name]</a>";
            }
        ?>
    </div>
    <?php 
    if($query = @mysqli_query($connect, $sql)){
        if(mysqli_num_rows($query) > 0)
        {
            foreach ($query as $key) {
                $get_post_data = get_post_data($key['id']);
                require ("./post_body.php");
            }
        }else
        {
            echo "<h1>No notes here</h1>";
        }
        
    }
    ?>
</div>




<?php
require_once("./footer.php");
?>