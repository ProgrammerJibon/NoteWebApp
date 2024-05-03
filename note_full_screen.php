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

?>
<title>Notes</title>
<form method="post" action="/note_full_screen.php?id=<?php echo $get_post_data['id']; ?>" class="post_form post_item">
    <div class="post_header">

        <div class="post_row">
            <div class="st_name_id">
                <div class="st_name"><?php echo $get_post_data['owner']['student_name']; ?></div>
                <div class="st_id">(<?php echo $get_post_data['owner']['id']; ?>)</div>
            </div>
            <?php
            if ($get_post_data['student_user_id'] == $student_info['id']) {
            ?>
                <div class="owner_options">
                    <button type="submit" name="edit_post" value="<?php echo $get_post_data['id']; ?>">Edit</button>
                    <?php
                    if ($get_post_data['status'] == "ACTIVE") {
                    ?><button type="submit" name="delete_post" value="<?php echo $get_post_data['id']; ?>">Delete</button><?php
                                                                                                                        } elseif ($get_post_data['status'] == "DELETED") {
                                                                                                                            ?><button type="submit" name="active_post" value="<?php echo $get_post_data['id']; ?>">Active</button><?php
                                                                                                                                                                                                                                            } elseif ($get_post_data['status'] == "DRAFT") {
                                                                                                                                                                                                                                                ?><button type="submit" name="active_post" value="<?php echo $get_post_data['id']; ?>">Active</button><?php
                                                                                                                                                                                                                                            }
                                                                                                                                                                                                                                                ?>
                </div>
            <?php
            }
            ?>

        </div>
        <div class="post_row">
            <span class="post_time"><?php echo date("Y-m-d h:i:sA", $get_post_data['post_time']); ?></span>
            <span><?php
                    if ($get_post_data['status'] == "DELETED") {
                        echo "<i style='color: red;'>This post is in trash</i>";
                    } elseif ($get_post_data['status'] == "DRAFT") {
                        echo "<i style='color: red;'>This post is in edit mode</i>";
                    }
                    ?></span>
        </div>
        <hr>


        <div class="post_row">
            <span class="caption_text"><?php echo $get_post_data['caption']; ?></span>
        </div>


        <div class="image_files">
            <?php
            foreach ($get_post_data['files'] as $file) {
                if ($file['status'] == "ACTIVE") {
                    if (str_starts_with($file['file_type'], "image")) { ?>
                        <a class="image" href="/<?php echo $file['file_path']; ?>" target="_blank">
                            <div class="thumb">
                                <img src="/<?php echo $file['file_path']; ?>">
                            </div>

                            <div class="alt_text">
                                <span><?php echo $file['alt_text']; ?></span>
                            </div>
                        </a>
                    <?php
                    }
                }
            }
            foreach ($get_post_data['files'] as $file) {
                if ($file['status'] == "ACTIVE") {
                    if (!str_starts_with($file['file_type'], "image")) {
                    ?>
                        <a class="file" href="/<?php echo $file['file_path']; ?>" target="_blank">
                            <hr>
                            <div class="alt_text">
                                <span><?php echo $file['alt_text']; ?></span>
                            </div>
                            <div class="file_name">
                                <span><?php echo $file['file_name']; ?></span>
                            </div>
                        </a><?php
                    }
                }
            }
            ?>
        </div>
        <hr>

        <div class="viewer_actions post_row">
            <button type="submit" value="<?php echo $get_post_data['id']; ?>" name="like_post">LIKE</button>
            <button type="submit" value="<?php echo $get_post_data['id']; ?>" name="comment_post">Comment</button>
            <button type="submit" value="<?php echo $get_post_data['id']; ?>" name="save_post">Save</button>
        </div>
    </div>
</form>


<?php
require_once("./footer.php");
?>