<?php
    session_start();

    if(isset($_SESSION["username"]))
    {
        
    }
    else
    {
      header("location: ../login.php");
    }

    $pageNames = array("Home", "Community", "Donate", "Notifications", "Dashboard");
        $pages = array("home", "community", "donate", "notifications", "dashboard");
        $icons = array("home", "community", "donate", "notifications", "dashboard");
    $pageTitle = "";


    include("../db_info.php");
    $pdoConnect = new PDO("mysql:host=$db_host;dbname=$db_name", $db_username, $db_password);
    $pdoConnect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdoQuery = "SELECT * FROM users_tb WHERE username = '".$_SESSION["username"]."'";
    $pdoResult = $pdoConnect->query($pdoQuery);
    while($row = $pdoResult->fetch(PDO::FETCH_ASSOC)){
        $_SESSION["accountType"] = $row["accountType"];
        $_SESSION["isVerified"] = $row["isVerified"];
    }

    if($_SESSION["accountType"] == "admin")
    {
        $pageNames = array("Dashboard", "User Posts", "Reported Posts", "Community", "Donation");
        $pages = array("dashboard", "home", "reported-posts", "community", "donate");
        $icons = array("dashboard", "userposts", "report", "community", "donate");
    }
    elseif($_SESSION["accountType"] == "mod")
    {
        $pageNames = array("dashboard", "User Posts", "Community", "Donate", "Notifications");
        $pages = array("Dashboard", "home","community", "donate", "notifications");
        $icons = array("Dashboard", "userposts","community", "donate", "notifications");
    }
    elseif($_SESSION["accountType"] == "user") 
    {
        $pageNames = array("Home", "Community", "Donate", "Menu");
        $pages = array("home", "community", "donate", "dashboard");
        $icons = array("home", "community", "donate", "dashboard");
    }




    function current_page_title($page){
        global $pages, $pageNames, $pageTitle;
        for($i = 0; $i < count($pages); $i++){
            if($page == $pages[$i]){ 
                return $pageNames[$i];
            }
        }       
    }
    function navbar_landscape($page) { 
        global $pages, $pageNames, $pageTitle, $icons; ?>


        <div class="title-bar">
            <img src="../images/com/logo.png" alt="paw logo" class="title-bar__logo">
            <h2 class="title-bar__title">ComPawnion</h2>


            <div class="tablet-nav">
                <?php
                    for($i = 0; $i < count($pages); $i++){ ?>
                        <?php if($page == $pages[$i]){ 
                            $pageTitle = $pageNames[$i];?>
                            <a href=<?php echo $pages[$i].".php"; ?>  class="tablet-nav__item__icon tablet-nav-icon-selected">
                        <?php } else { ?>
                            <a href=<?php echo $pages[$i].".php"; ?>  class="tablet-nav__item__icon tablet-nav-icon-default">
                        <?php } ?>
                            <?php include("../icons/".$icons[$i]."-icon.php") ?>
                            </a>
                    <?php } ?>
                    
                <div class="tablet-nav__item__underline-div">

                <?php
                    for($i = 0; $i < count($pages); $i++){
                        if($page == $pages[$i]){ ?>
                            <div class="tablet-nav-underline tablet-nav-selected"></div>
                        <?php } else { ?>
                            <div class="tablet-nav-underline"></div>
                        <?php } 
                    } ?>

                </div>
            </div>
        </div>


        <div class="side-nav">
            <div class="side-nav__user">
                <div class="side-nav__user__avatar" style="background: url('../database/profile_images/<?php echo $_SESSION['username'] ?>.png'); background-size: cover; border: 2px solid var(--accent-color);" ></div>
                <!-- <div class="side-nav__user__avatar" style="background: url('images/default/admin.png'); background-size: cover; border: 2px solid #818DFF;" ></div> -->
                <!-- <div class="side-nav__user__avatar"></div> -->
                <!-- <img class="side-nav__user__avatar" src="images/icons-color/default_user_ldpi.png" alt="paw logo"> -->
                <?php
                include("../db_info.php");
                $pdoConnect = new PDO("mysql:host=$db_host;dbname=$db_name", $db_username, $db_password);
                $pdoConnect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $pdoQuery = 'SELECT * FROM users_tb where username = "'.$_SESSION['username'].'"';
                    $pdoResult = $pdoConnect->query($pdoQuery);
                    while($row = $pdoResult->fetch(PDO::FETCH_ASSOC)){?>
                        <h2 class="side-nav__user__name"><?php echo $row["fullname"] ?></h2>
                    <?php }

                ?>
                
                <!-- <h2 class="side-nav__user__name">gab</h2> -->
            </div>
            <div class="side-nav__item-group">
            <?php
                for($i = 0; $i < count($pages); $i++){ ?>
                    <?php if($page == $pages[$i]){ ?>
                        <a href=<?php echo $pages[$i].".php"; ?> class="side-nav__item side-nav__item-selected">
                            <div class="selected-bar"></div>
                            <div class="side-nav__item__icon side-nav-icon-selected">
                    <?php } else { ?>
                        <a href=<?php echo $pages[$i].".php"; ?> class="side-nav__item side-nav__item-default">
                            <div class="side-nav__item__icon side-nav-icon-default">
                    <?php } ?>
                        <?php include("../icons/".$icons[$i]."-icon.php") ?>
                        </div>
                    
                    <?php if($page == $pages[$i]){ ?>
                        <p class="side-nav__item__text side-nav-selected"><?php echo $pageNames[$i] ?></p>
                    <?php } else { ?>
                        <p class="side-nav__item__text side-nav-default"><?php echo $pageNames[$i] ?></p>
                    <?php } ?>
                    </a>
                <?php } ?>

            </div>
            <div class="logout-btn">
                <a href="../logout.php" class="side-nav__item side-nav__item-default">
                    <div class="side-nav__item__icon side-nav-icon-default">
                        <?php include("../icons/logout-icon.php") ?>
                    </div>
                    <p class="side-nav__item__text side-nav-default">Logout</p>
                </a>
            </div>

        </div>
    <?php }

    function navbar_mobile($page) { 
        global $pages, $pageNames, $icons; ?>
        <div class="mobile-title-bar">
            <img src="../images/com/logo.png" alt="paw logo" class="mobile-title-bar__logo">
            <h2 class="mobile-title-bar__title">ComPawnion</h2>
        </div>

        <div class="mobile-nav">

        <?php
            for($i = 0; $i < count($pages); $i++){
                if($page == $pages[$i]){ ?>
                    <a href=<?php echo $pages[$i].".php"; ?>  class="mobile-nav__item__icon mobile-nav-icon-selected">
                <?php } else { ?>
                    <a href=<?php echo $pages[$i].".php"; ?>  class="mobile-nav__item__icon mobile-nav-icon-default">
                <?php } ?>
                <?php include("../icons/".$icons[$i]."-icon.php") ?>
                </a>
            <?php } ?>

            
            <div class="mobile-nav__item__underline-div">
            <?php
                for($i = 0; $i < count($pages); $i++){
                    if($page == $pages[$i]){ ?>
                        <div class="mobile-nav-underline mobile-nav-selected"></div>
                    <?php } else { ?>
                        <div class="mobile-nav-underline"></div>
                    <?php } 
                } ?>
            </div>
        </div>
    <?php }
?>