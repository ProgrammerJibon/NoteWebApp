<?php
require_once("./functions.php");
if(!$student_info){
    header("Location:/");
}
if(!isset($_GET['edit_post_id'])){
    if($query = mysqli_query($connect, "SELECT * FROM `notes_post` WHERE `student_user_id` = '$student_info[id]' AND `status` LIKE 'DRAFT' ORDER BY `notes_post`.`post_time` DESC LIMIT 1")){
        if(mysqli_num_rows($query) > 0){
            foreach ($query as $key) {
                header("Location: ?edit_post_id=".$key['id']);
                exit();
            }
        }elseif($query = mysqli_query($connect, "INSERT INTO `notes_post` (`student_user_id`, `caption`, `post_time`, `status`, `dept_id`, `semester`) VALUES ('$student_info[id]', '', '$time', 'DRAFT', '$student_info[dept_id]', '$student_info[current_semester]')")){
            header("Location: ?edit_post_id=".mysqli_insert_id($connect));
            exit();
        }else{
            exit("Unable to create a post");
        }
    }
}
$edit_post_id = addslashes($_GET['edit_post_id']);
$get_post_data = get_post_data($edit_post_id);
if(!$get_post_data){
    header("Location: /");
}
// echoArray($student_info);
$nav_required = true;
$post_error = "";
if(isset($_POST['upload_file'], $_FILES['add_file']['tmp_name'], $_POST['file_caption'], $_POST['main_caption'], $_GET['edit_post_id'])){
    $main_caption = addslashes(strip_tags($_POST['main_caption']));
    $file_caption = addslashes(strip_tags($_POST['file_caption']));
    $edit_post_id = addslashes(($_GET['edit_post_id']));
    $file_name = $_FILES['add_file']['name'];
    $file_type = mime_content_type($_FILES['add_file']['tmp_name']);
    
    if(@mysqli_query($connect, "UPDATE `notes_post` SET `caption` = '$main_caption' WHERE `notes_post`.`id` = '$edit_post_id' AND `student_user_id` = '$student_info[id]'") && $file_path = upload($_FILES['add_file']['tmp_name'])){
        if($query = mysqli_query($connect, "INSERT INTO `post_files` (`note_post_id`, `file_path`, `file_name`, `file_type`, `status`, `alt_text`, `student_user_id`) VALUES ('$edit_post_id', '$file_path', '$file_name', '$file_type', 'ACTIVE', '$file_caption', '$student_info[id]')")){
            header("Location: ?edit_post_id=".$edit_post_id);
            exit();
        }
    }
}
if(isset($_POST['save_post'], $_POST['main_caption'], $_GET['edit_post_id'])){
    $edit_post_id = addslashes(($_GET['edit_post_id']));
    $main_caption = addslashes(strip_tags($_POST['main_caption']));    
    if(@mysqli_query($connect, "UPDATE `notes_post` SET `caption` = '$main_caption' WHERE `notes_post`.`id` = '$edit_post_id' AND `student_user_id` = '$student_info[id]'")){
        header("Location: ?edit_post_id=".$edit_post_id);
        exit();
    }
}
if(isset($_POST['main_caption'], $_GET['edit_post_id'], $_POST['remove_file'])){
    $edit_post_id = addslashes(($_GET['edit_post_id']));
    $remove_file = addslashes(($_POST['remove_file']));
    $main_caption = addslashes(strip_tags($_POST['main_caption']));     
    if(@mysqli_query($connect, "UPDATE `notes_post` SET `caption` = '$main_caption' WHERE `notes_post`.`id` = '$edit_post_id' AND `student_user_id` = '$student_info[id]'")){
        if(@mysqli_query($connect, "UPDATE `post_files` SET `status` = 'REMOVED' WHERE `post_files`.`id` = '$remove_file' AND `student_user_id`='$student_info[id]'")){
            header("Location: ?edit_post_id=".$edit_post_id);
            exit();
        }        
    }
}
if(isset($_POST['submit_post'], $_POST['main_caption'], $_GET['edit_post_id'])){
    $edit_post_id = addslashes(($_GET['edit_post_id']));
    $main_caption = addslashes(strip_tags($_POST['main_caption']));    
    if(@mysqli_query($connect, "UPDATE `notes_post` SET `caption` = '$main_caption', `status` = 'ACTIVE' WHERE `notes_post`.`id` = '$edit_post_id' AND `student_user_id` = '$student_info[id]'")){
        header("Location: /note_full_screen.php?id=".$edit_post_id);
        exit();
    }
}else{
    @mysqli_query($connect, "UPDATE `notes_post` SET `status` = 'DRAFT' WHERE `notes_post`.`id` = '$edit_post_id' AND `student_user_id` = '$student_info[id]'");
}


require_once("./header.php");

?>
<title>Post Note</title>

<form method="post" class="post_form" enctype="multipart/form-data">
    <h1>Edit Post</h1>
    <div class="error-box">
        <span><?php echo $post_error; ?></span>
    </div>    
    <label>
        <div>
            <span>Describe your note</span>
        </div>
        <textarea name="main_caption" placeholder="What's on your mind"><?php echo $get_post_data['caption'] ?> </textarea>
    </label>
    <div class="files">
        <h3>Files</h3>
        <?php
            foreach($get_post_data['files'] as $file){
                if($file['status'] == "ACTIVE"){
                ?>
                <div class="file">
                    <?php
                        if(str_starts_with( $file['file_type'],"image")){
                            ?>
                                <div class="thumb" style="max-width: 100px;">
                                    <img src="/<?php echo $file['file_path']; ?>">
                                </div>
                            <?php
                        }
                    ?>
                    <div class="alt_text">
                        <span><?php echo $file['alt_text']; ?></span>
                    </div>
                    <span><?php echo $file['file_name']; ?></span>
                    <button style="cursor: pointer;" type="submit" name="remove_file" value="<?php echo $file['id']; ?>">X</button>
                    <hr>
                </div>
                <?php
                }
            }
        ?>
    </div>
    <div class="file_upload_area">
        <label>
            <div>
                <span>Add a file</span>
            </div>
            <input type="file" name="add_file"  accept=".pdf, image/*">
        </label>
        <label>
            <div>
                <span>file caption</span>
            </div>
            <textarea  type="text" name="file_caption" placeholder="say something about this file"></textarea>
        </label>
        <label>
            <input type="submit" name="upload_file" value="upload">
        </label>
    </div>
    <div class="submit_buttons">
        <input type="submit" value="save" name="save_post">
        <input type="submit" value="post" name="submit_post">
    </div>
</form>


<?php
require_once("./footer.php");
?>