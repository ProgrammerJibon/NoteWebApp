<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php
if(isset($nav_required) && $nav_required == true){
    require_once("./navbar.php");
    ?>
    <main>
        <section class="sidebar">
            <?php 
            require ("./sidebar_items.php");
            ?>
        </section>
        <section class="content">
    <?php
}

?>