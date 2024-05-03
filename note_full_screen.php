<?php
require_once("./functions.php");
if (!$student_info && !isset($_GET['id'])) {
    header("Location:/");
}

$nav_required = true;
require_once("./header.php");

$post_id = $_GET['id'];
$get_post_data = get_post_data($post_id);

if (!$get_post_data) {
    header("Location: /");
}

if (isset($_POST['edit_post'])) {
    header("Location: /new_notes.php?edit_post_id=" . $_POST['edit_post']);
    exit;
}
if (isset($_POST['delete_post'])) {
    if (@mysqli_query($connect, "UPDATE `notes_post` SET `status` = 'DELETED' WHERE `notes_post`.`id` = '$post_id'"))
        header("Refresh: 0");
    exit;
}
if (isset($_POST['active_post'])) {
    if (@mysqli_query($connect, "UPDATE `notes_post` SET `status` = 'ACTIVE' WHERE `notes_post`.`id` = '$post_id'"))
        header("Refresh: 0");
    exit;
}
if (isset($_POST['like_post'])) {
    if($get_post_data['liked'] && @mysqli_query($connect, "DELETE FROM `post_likes` WHERE `post_likes`.`student_user_id` = '$student_info[id]' AND `post_likes`.`note_post_id` = '$get_post_data[id]'")){
        header("Refresh: 0");
        exit;
    }elseif (@mysqli_query($connect, "INSERT INTO `post_likes` (`student_user_id`, `note_post_id`, `liked_time`) VALUES ('$student_info[id]', '$get_post_data[id]', '$time')")) {
        header("Refresh: 0");
        exit;
    }
}
if (isset($_POST['save_post'])) {
    if($get_post_data['saved'] && @mysqli_query($connect, "DELETE FROM `saved_post` WHERE `saved_post`.`student_user_id` = '$student_info[id]' AND `saved_post`.`note_post_id` = '$get_post_data[id]'")){
        header("Refresh: 0");
        exit;
    }elseif (@mysqli_query($connect, "INSERT INTO `saved_post` (`student_user_id`, `note_post_id`, `saved_time`) VALUES ('$student_info[id]', '$get_post_data[id]', '$time')")) {
        header("Refresh: 0");
        exit;
    }
}

?>
<title><?php echo mb_substr($get_post_data['caption'], 0, 32); ?></title>

<?php 
require_once "./post_body.php";

?>


<?php
require_once("./footer.php");
?>