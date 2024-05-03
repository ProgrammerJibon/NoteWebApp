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
}elseif(isset($_GET['search'])){
    $_GET['search'] = addslashes($_GET['search']);
    $sql = "SELECT `id` FROM `notes_post` WHERE `caption` LIKE '%$_GET[search]%' AND (`status`='ACTIVE' OR `student_user_id`='$student_info[id]') ORDER BY `notes_post`.`id` DESC";
    echo "Search result for ".$_GET['search'];
}else{
    echo "All notes";
}
?></title>



<div class="notes">
    <?php 
    if($query = @mysqli_query($connect, $sql)){
        if(mysqli_num_rows($query) > 0)
        {
            foreach ($query as $key) {
                $get_post_data = get_post_data($key['id']);
                require "./post_body.php";
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