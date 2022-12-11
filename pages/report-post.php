<?php
    include("../db_info.php");

    $pdoConnect = new PDO("mysql:host=$db_host;dbname=$db_name", $db_username, $db_password);
    $pdoConnect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $post_query = $pdoConnect->query("SELECT * FROM posts_tb WHERE id = '".$_GET['id']."'");
    while($row = $post_query->fetch(PDO::FETCH_ASSOC)){
        // unlink("../".$row['imageLink']);
    }

    $pdoQuery = "UPDATE posts_tb SET reports = reports + 1 where id =".$_GET['id'];
    $pdoResult = $pdoConnect->prepare($pdoQuery);
    $pdoResult->execute();
    $pdoConnect->query('INSERT INTO reported_posts_tb(postId, reportedBy) VALUES ("'.$_GET['id'].'", "'.$_GET['reporter'].'")');
                    
    header('location: home.php#post_'.$_GET['id']);
    $pdoConnect = null;
?>