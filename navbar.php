<nav>
    <div class="nav_logo">
        <img src="https://ugvcse.com/assets/img/logo.png" alt="" srcset="">
    </div>
    <form method="get" class="search_bar">
        <input type="search" name="search" value="<?php echo isset($_GET['search'])?$_GET['search']:"" ?>" placeholder="Search..." required>
        <!-- <input type="submit" value="search"> -->
    </form>
    <div class="open_side_bar_icon">
        <img src="/hamburger.svg">
    </div>
</nav>