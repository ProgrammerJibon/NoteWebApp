<?php
require_once("./functions.php");
if(!$student_info){
    header("Location:/");
}

if(!isset($_GET['edit_post_id'])){
    if($query = mysqli_query($connect, "INSERT INTO `notes_post` (`student_user_id`, `caption`, `post_time`, `status`, `dept_id`, `semester`) VALUES ('$student_info[id]', '', '$time', 'DRAFT', '$student_info[dept_id]', '$student_info[current_semester]')")){
        header("Location: ?edit_post_id=".mysqli_insert_id($connect));
        exit();
    }else{
        exit("Unable to create a post");
    }
}
// echoArray($student_info);
$nav_required = true;
require_once("./header.php");

?>
<title>Post Note</title>

<form method="post">
    <label>
        <div>
            <span>Describe your note</span>
        </div>
        <textarea name="caption" placeholder="What's on your mind"></textarea>
    </label>
    <label>
        
    </label>
</form>


<?php
require_once("./footer.php");
?>