<div class="side_bar_item">
    <a href="/notes.php">Home</a>
</div>
<div class="side_bar_item">
    <a href="/new_notes.php">Post a new note</a>
</div>
<div class="side_bar_item">
    <a href="/notes.php?show_saved=true">My saved notes</a>
</div>
<div class="side_bar_item">
    <a href="/notes.php?user=<?php echo $student_info['id'];?>">My notes</a>
</div>

<?php
if(isset($student_info['user_type']) && $student_info['user_type'] == "ADMIN"){
    ?>
<div class="side_bar_item">
    <a href="/students.php">List of Students</a>
</div>
<div class="side_bar_item">
    <a href="/options.php">Options</a>
</div>
    <?php
}
?>
<div class="side_bar_item">
    <a href="/logout.php" style="color: red;">Logout</a>
</div>