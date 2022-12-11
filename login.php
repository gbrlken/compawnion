<?php
    session_start();

    if(isset($_SESSION["username"]))
    {
        header("location: pages/home.php");
    }

    include_once("db_info.php");
    $warning = "";


    try {
        $pdoConnect = new PDO("mysql:host=$db_host;dbname=$db_name", $db_username, $db_password);
        $pdoConnect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if(isset($_POST["login"])){
            if(empty($_POST["username"]) || empty($_POST["password"])){
                $warning = 'All fields are required';
            } 
            else{
                $pdoQuery = "SELECT * FROM users_tb WHERE username = BINARY :username AND password = BINARY :password";
                $pdoResult = $pdoConnect->prepare($pdoQuery);
                $pdoResult->execute(
                    array(
                        'username' => $_POST["username"],
                        'password' => $_POST["password"]
                    )
                );
                
                $count = $pdoResult->rowCount();
                
                if($count > 0)
                {
                    $_SESSION["username"] = $_POST["username"];
                    $_SESSION["password"] = $_POST["password"];

                    $pdoQuery = "SELECT * FROM users_tb WHERE username = '".$_SESSION["username"]."'";
                    $pdoRes = $pdoConnect->query($pdoQuery);
                    while($row = $pdoRes->fetch(PDO::FETCH_ASSOC)){
                        $_SESSION["accountType"] = $row["accountType"];
                        $_SESSION["isVerified"] = $row["isVerified"];
                    }
                    if($_SESSION["accountType"] == "admin" || $_SESSION["accountType"] == "mod"){
                        header("location: pages/dashboard.php");
                    } elseif($_SESSION["accountType"] == "user"){
                        header("location: pages/home.php");
                    }
                    // $warning = $_SESSION["accountType"];
                    // header("location: pages/home.php");
                }
                else
                {
                    $warning = 'Incorrect Credentials';
                }
            }
        }

        if(isset($_POST["signup"])){
                $pdoQuery = 'INSERT INTO users_tb(username, password, fullname, contact, email, telegram, twitter, facebook, accountType, isVerified, verifiedAt) VALUES ("'.$_POST["signup-username"].'", "'.$_POST["signup-password"].'", "'.$_POST["signup-displayname"].'", "'.$_POST["signup-contact"].'", "'.$_POST["signup-email"].'", "'.$_POST["signup-telegram"].'", "'.$_POST["signup-twitter"].'", "'.$_POST["signup-facebook"].'", "user", "false", "")';
                $pdoConnect->query($pdoQuery);
                
                $pdoQuery = "SELECT * FROM users_tb WHERE username = :username AND password = :password";
                $pdoResult = $pdoConnect->prepare($pdoQuery);
                $pdoResult->execute(
                    array(
                        'username' => $_POST["signup-username"],
                        'password' => $_POST["signup-password"]
                    )
                );
                
                $count = $pdoResult->rowCount();
                
                if($count > 0)
                {
                    $_SESSION["username"] = $_POST["signup-username"];
                    header("location: pages/home.php");
                }
        }
    }

    catch (PDOException $exc) {
        $pdoConnect = new PDO("mysql:host=$db_host", $db_username, $db_password);
        $pdoConnect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdoConnect->query("CREATE DATABASE if not exists $db_name");
        $pdoConnect->query("USE $db_name");
        $pdoConnect->query("CREATE TABLE users_tb (id int AUTO_INCREMENT NOT NULL, username varchar(100) NOT NULL, password varchar(100) NOT NULL, fullname varchar(100) NOT NULL, contact varchar(16), email varchar(100), telegram varchar(100), twitter varchar(100), facebook varchar(100), accountType varchar(10), isVerified varchar(7), verifiedAt varchar(100), PRIMARY KEY (id))");
        
        $pdoConnect->query("CREATE TABLE posts_tb (id int AUTO_INCREMENT NOT NULL, username varchar(100) NOT NULL, imageLink varchar(1000), petName varchar(70), petClass varchar(70), petBreed varchar(70), petSex varchar(70), petAge varchar(70), petDesc varchar(70), reason varchar(70), reports int, PRIMARY KEY (id))");
        $pdoConnect->query("CREATE TABLE reported_posts_tb (id int AUTO_INCREMENT NOT NULL, postId int, reportedBy varchar(100), PRIMARY KEY (id))");


        $pdoConnect->query('INSERT INTO users_tb(username, password, fullname, contact, email, telegram, twitter, facebook, accountType, isVerified, verifiedAt) VALUES ("admin", "admin", "Admin", "0", "no@email.com", "na", "na", "na", "admin", "true", NOW())');
        $pdoConnect = new PDO("mysql:host=$db_host;dbname=$db_name", $db_username, $db_password);
        $pdoConnect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // echo $exc->getMessage(); 
    }

    $pdoQuery = 'SELECT * FROM users_tb';
    $pdoResult = $pdoConnect->query($pdoQuery);
    while($row = $pdoResult->fetch(PDO::FETCH_ASSOC)){
        echo '<p class="username-list" style="display: none;">'.$row['username'].'</p>';
        echo '<p class="email-list" style="display: none;">'.$row['email'].'</p>';
    }    



    // $_SESSION["username"] = "";
    // try {
    //     $connect = new PDO("mysql:host=$host; dbname:=$database", $username, $password);
    //     $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //     if(isset($_POST["login"])){
    //         if(empty($_POST["username_input"]) || empty($_POST["password_input"])){
    //             $message = "asdas";
    //         } else {
    //             $query = "SELECT * FROM users_tb WHERE username = :username_input AND password = :password_input";
    //             $statement = $connect->prepare($query);
    //             $statement->execute(
    //                 array(
    //                     'username_input' => $_POST["username_input"],
    //                     'password_input' => $_POST["password_input"]
    //                 )
    //             );
    //             $count = $statement->rowCount();
    //             if($count > 0){
    //                 $_SESSION["username"] = $_POST["username_input"];
    //                 header("location:home.php");
    //             }
    //             else {

    //             }
    //         }
    //     }
    // }


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compawnion - Login</title>
    <link rel="shortcut icon" type="image/jpg" href="images/com/logo_ldpi.png"/>
    <link rel="stylesheet" href="styles/index.css">
    <link rel="stylesheet" href="styles/page-styles/login.css">
</head>
<body>
    <main>
        <div class="bg-color"></div>
        <div class="logo-container">
            <img class="logo" alt="">
        </div>
        <div class="login-container">
            <div class="message-container">
                <h2 class="message-title">Login to <em>Compawnion</em></h2>
            </div>
            <div class="warning">
                <p class="warning-text"><?php echo $warning ?></p>
            </div>
            <div class="form-container">
                <form method="post">
                    <div class="modern-textbox username">
                        <input class="modern-text-input" type="text" name="username" id="username-input" required placeholder=" ">
                        <p class="placeholder" value="hello">Username</p>
                    </div>
                    <div class="modern-textbox password">
                        <div class="password-input-container">
                            <input class="modern-text-input" type="password" name="password" id="password-input" required placeholder=" ">
                            <p class="placeholder">Password</p>
                        </div>
                        <img class="password-toggle-icon" src="images/icons-mono/show-pw.png" alt="">
                    </div>
                    <div class="text-action-links">
                        <p class="action-link">Forgot Password?</p>
                        <!-- <p class="action-link password-toggle">Show</p> -->
                    </div>
                    <!-- <div class="text-button login-btn"> -->
                        <input type="submit" value="Login" name="login" class="text-button login-btn">
                    <!-- </div> -->
                </form>
                <div class="text-button register-btn">
                    <h2>Sign Up</h2>
                </div>
            </div>
        </div>
    </main>
    <div class="signup-modal">
            <div class="modal-card">
                <div class="modal-card__top">
                    <div class="close-btn">
                        <?php include("icons/add-icon.php") ?>
                    </div>
                </div>
                <div class="modal-title">
                    <h2 class="modal-title-text">Register to <em>Compawnion</em></h2>
                </div>

                <form class="signup" method="post">
                <div class="modal-body">
                    
                    <div class="modal-body__sec left">


                        <?php
                            function signup_input($type, $suffix, $placeholder, $required){?>
                                <div class="modern-textbox signup-input-div signup-<?php echo $suffix; ?>">
                                    <input class="modern-text-input signup-input" 
                                            type="<?php echo $type; ?>" 
                                            name="signup-<?php echo $suffix; ?>" 
                                            id="signup-<?php echo $suffix; ?>" 
                                            <?php if($required){echo 'required';} ?>
                                            placeholder=" ">
                                    <p class="placeholder <?php echo $suffix ?>"><?php echo $placeholder; ?></p>
                                </div>
                            <?php }

                            signup_input("text", "displayname", "Display Name", TRUE);
                            signup_input("text", "username", "Username", TRUE);
                            signup_input("email", "email", "Email", TRUE);
                            signup_input("password", "password", "Password", TRUE);
                            signup_input("password", "confirm-password", "Confirm Password", TRUE);

                        ?>

                        
                    </div>
                    <div class="modal-body__sec right">
                        <?php
                            signup_input("text", "contact", "Contact Number", TRUE);
                            signup_input("text", "telegram", "Telegram Username", FALSE);
                            signup_input("text", "twitter", "Twitter Username", FALSE);
                            signup_input("text", "facebook", "Facebook Username", FALSE);
                        ?>

                    </div>

                </div>
                <input type="submit" value="Register" name="signup" class="text-button signup-btn">
                </form>



                


            </div>
        </div>
    <script src="js/login.js"></script>
</body>
</html>