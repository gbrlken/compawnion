<?php
    $currentPage = "reported-posts";
    require_once("../components/navbars.php");
    include_once("../components/custom-input.php")
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compawnion - <?php echo current_page_title($currentPage) ?></title>
    <link rel="shortcut icon" type="image/jpg" href="../images/com/logo_ldpi.png"/>
    <link rel="stylesheet" href="../styles/page-styles/reported-posts.css">
    <link rel="stylesheet" href="../styles/index.css">
</head>
<body>
    
    <?php
        require_once("../components/navbars.php");
        navbar_landscape($currentPage);
    ?>
    
    <?php
        if($_SESSION["accountType"] == "user"){?>
            <div class="add-post-btn">
                <div class="add-symbol">
                    <?php include("../icons/add-icon.php") ?>
                </div>
            </div>
        <?php } else { ?>
            <div class="add-post-btn" style="display: none;">
                <div class="add-symbol">
                    <?php include("../icons/add-icon.php") ?>
                </div>
            </div>
        <?php }
    ?>



    <div class="main">
        <p class="admin-pass-text" style="display: none;"><?php echo $_SESSION['password']; ?></p>
        <p class="account-type-text" style="display: none;"><?php echo $_SESSION['accountType']; ?></p>
        <div id="top"></div>
        <?php navbar_mobile($currentPage); ?>

        <div class="main__title-div">
            <h2 class="main__title-div__text" id="page-title"><?php echo $pageTitle; ?></h2>
        </div>

        <div class="main__post">
            <?php //include_once("../user_home-content.php") ?>
            <?php
                include("../db_info.php");
                $post = array();
            
                $dsn = "mysql:host=$host;dbname=$db_name";
            
                $pdo = new PDO($dsn, $user, $password);
            
                $qry = $pdo->query("CREATE DATABASE if not exists $db_name");
            
                $post_query = $pdo->query("SELECT posts_tb.id, posts_tb.imageLink, posts_tb.petName, posts_tb.petClass, posts_tb.petBreed, posts_tb.petSex, posts_tb.petAge, posts_tb.petDesc, posts_tb.reason, posts_tb.reports, users_tb.fullname, users_tb.contact, users_tb.email, users_tb.fullname, users_tb.telegram, users_tb.twitter, users_tb.facebook, users_tb.username
                FROM posts_tb
                INNER JOIN users_tb ON posts_tb.username = users_tb.username
                WHERE posts_tb.reports > 0
                ORDER BY posts_tb.reports DESC;");
                
                while($row = $post_query->fetch(PDO::FETCH_ASSOC)){
                    array_push($post, $row);
                    extract($row);

                    $pdoQuery = "SELECT * FROM reported_posts_tb WHERE reportedBy = BINARY '".$_SESSION['username']."' AND postId = ".$id;
                    $pdoResult = $pdo->prepare($pdoQuery);
                    $pdoResult->execute();
                
                    $postRepCount = $pdoResult->rowCount();
                    ?>
                    
                    <div class="card-stationary post" id="post_<?php echo $id ?>">
                        <!-- <a href='delete-post.php?id='.$id;?>delete</a> -->
                        <div class="post__image-holder">
                            <img class="post__image" src="../<?php echo $imageLink ?>" alt="">
                            
                        </div>
                        <div class="post-container">
                            <div class="post__content-holder">
                                <div class="post__title-holder">
                                    <h2 class="post-title"><?php echo $petName ?></h2>
                                </div>
                                <div class="post__info-holder">
                                    <h3 class="pet__info red">
                                        <br>Number of Reports: <em class="red"><?php echo $reports ?></em>
                                    </h3>
                                    <h3 class="post__info-title red">
                                        Reported by:
                                    </h3>
                                    <h3 class="post__info-content red">
                                        <?php
                                            $qry = $pdo->query("SELECT reportedBy FROM reported_posts_tb where postID = ".$id);
                                            $reportedBys = array();
                                            while($row = $qry->fetch(PDO::FETCH_ASSOC)){
                                                array_push($reportedBys, $row);
                                            }
                                            if(sizeof($reportedBys) == 1){
                                                echo $reportedBys[0]['reportedBy'];
                                            } else {
                                                for($i=0;$i<sizeof($reportedBys) - 1;$i++){
                                                    echo $reportedBys[$i]['reportedBy'].", ";
                                                }
                                                echo end(end($reportedBys));
                                            }
                                            
                                        ?>
                                    </h3>
                                </div>
                            </div>
                        </div>
                       
                        <div class="action-buttons">
                        <?php
                            if($username == $_SESSION['username'] || $_SESSION['accountType'] == "admin"){ ?>
                                <div class="button report-btn del">
                                    <div class="report-btn__icon del">
                                        <?php include("../icons/delete-icon.php") ?>
                                    </div>
                                </div>
                                <div class="button report-btn rep" style="display: none;">
                                </div>

                            <?php } else{ ?>
                                <div class="button report-btn rep" <?php if($postRepCount > 0){ echo 'style="pointer-events: none;"'; } ?>>
                                    <div class="report-btn__icon <?php if($postRepCount > 0){ echo 'report-used'; } ?>">
                                        <?php include("../icons/report-icon.php") ?>
                                    </div>
                                </div>
                                <div class="button report-btn del" style="display: none;">
                                </div>
                            <?php }
                        ?>
                            <div class="button adopt-btn show-adopt-modal">
                                <!-- <h2 class="adopt-btn__text">Adopt</h2> -->
                                <div class="adopt-btn__icon">
                                    <?php include("../icons/info-icon.php") ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="deletepost-modal">
                        <div class="deletepost-modal-card">
                            <div class="deletepost-modal-content">
                                <h2 class="deletepost-message">
                                    Delete rehoming post for</br><br>
                                    <em id="deletepost-name"><?php echo $petName ?></em>
                                </h2>
                            </div>
                            <?php
                                if($_SESSION['accountType'] == "admin"){
                                    custom_input("password", "admin-pass", "admin-pass".$id, "Admin Password", TRUE, "100"); ?>
                                    <?php 
                                }
                            ?>


                            <div class="deletepost-modal-action-btn">
                                <div class="deletepost-modal-close-btn negative button">
                                    <p class="button-text">Cancel</p>
                                </div>
                                <a class="deletepost-modal-close-btn positive button" href="rep-delete-post.php?id=<?php echo $id ?>">
                                    <p class="button-text">Delete</p>
                                </a>
                            </div>

                        </div>                  
                    </div>

                    
                    <div class="reportpost-modal">
                        <div class="reportpost-modal-card">
                            <div class="reportpost-modal-content">
                                <h2 class="reportpost-message">
                                    Report this post for</br><br>
                                    <em id="reportpost-name">Violation/Spam</em>
                                </h2>
                            </div>


                            <div class="reportpost-modal-action-btn">
                                <div class="reportpost-modal-close-btn negative button">
                                    <p class="button-text">Cancel</p>
                                </div>
                                <a class="reportpost-modal-close-btn positive button" href="rep-report-post.php?id=<?php echo $id ?>&reporter=<?php echo $_SESSION['username'] ?>">
                                    <p class="button-text">Report</p>
                                </a>
                            </div>

                        </div>
                    </div>

                
                    
            <?php } ?>
            <div class="end-space" style="height: 3rem"></div>
        </div>

        
    </div>

    <?php for($i = 0; $i < sizeof($post); $i++){ ?>
        
        <div class="adopt-modal">
            <div class="modal-card">
                <div class="modal-card-header">
                    <div class="modal-image-holder">
                        <img class="modal-image" src="../<?php echo $post[$i]["imageLink"]; ?>" alt="">
                        <h2 class="modal-name"><?php echo $post[$i]["petName"]; ?></h2>
                    </div>
                </div>
                <div class="modal-content-container">
                    <div class="var-info-container">
                        <div class="var-name">
                            Owner: 
                        </div>
                        <div class="var-value">
                            <em class="var-value"><?php echo $post[$i]["fullname"]; ?></em>
                        </div>
                    </div>
                    <div class="var-info-container">
                        <div class="var-name">
                            Username: 
                        </div>
                        <div class="var-value">
                            <em class="var-value"><?php echo $post[$i]["username"]; ?></em>
                        </div>
                    </div>
                    
                                    <h3 class="pet__info">
                                        <br>Classification: <em><?php echo $petClass ?></em>
                                    </h3>
                                    <h3 class="pet__info">
                                        Breed: <em><?php echo $petBreed ?></em>
                                    </h3>
                                    <h3 class="pet__info">
                                        Sex: <em><?php echo $petSex ?></em>
                                    </h3>
                                    <h3 class="pet__info">
                                        Age: <em><?php echo $petAge ?></em>
                                    </h3>
                                    <h3 class="post__info-title">
                                        Other Descriptions:
                                    </h3>
                                    <h3 class="post__info-content">
                                        <?php echo $petDesc ?>
                                    </h3>
                                    <h3 class="post__info-title">
                                        Reason for rehoming:
                                    </h3>
                                    <h3 class="post__info-content">
                                        <?php echo $reason ?>
                                    </h3>
                </div>
                
                <div class="modal-close-btn button">
                    <div class="close-btn-icon"><?php include("../icons/add-icon.php") ?></div>
                </div>
            </div>
            <div class="modal-image-overlay"></div>
        </div>


    <?php } ?>

    <div class="addpost-modal">
        <form action="../upload.php" method="POST" enctype="multipart/form-data">
        <div class="addpost-modal-card">
            <div class="modal-card__top">
                <div class="close-addpostmodal-btn">
                    <?php include("../icons/add-icon.php") ?>
                </div>
            </div>
            <div class="addpost-modal-container">
                <div class="addpost-modal-image-container">
                    <input type="file" name="file" id="post-image-file" accept="image/*" hidden>
                    <div class="addpost-modal-image empty">
                        <img src="../images/empty-image1.png" alt=" " class="addpost-image">
                    </div>
                    <div class="change-image-btn button txt-btn">
                        <p class="change-image-btn-text txt-btn-text">Upload Image</p>
                    </div>
                </div>
                <div class="addpost-modal-content-input small">
                        <?php 
                            custom_input("text", "pet-name", "pet-name", "Pet's Name", TRUE, "25");
                            custom_input("text", "pet-class", "pet-class", "Classification", TRUE, "25");
                            custom_input("text", "pet-breed", "pet-breed", "Breed", TRUE, "25");
                            custom_input("text", "pet-sex", "pet-sex", "Sex", TRUE, "6");
                            custom_input("text", "pet-age", "pet-age", "Age", TRUE, "30");
                        ?>
                </div>
                <div class="addpost-modal-content-input">
                        <?php include_once("../components/custom-input.php") ?>
                        <?php 
                            custom_textarea("other-desc", "other-desc", "7.1rem", "50", "4", "64", "Other Descriptions", TRUE);
                            custom_textarea("reason", "reason", "7.2rem", "50", "4", "64", "Reason for rehoming", TRUE);
                            custom_input("text", "pet-loc", "pet-loc", "Location (City)", FALSE, "30");
                            custom_input_script();
                        ?>
                </div>
            </div>
            <div class="modal-actions">
                <button type="submit" name="post-pet" id="post-pet" class="button">Post</button>
            </div>
        </div>

        </form>
    </div>
    <?php include_once("../components/toast.php") ?>
    <script src="../js/reported-posts.js"></script>
</body>
</html>