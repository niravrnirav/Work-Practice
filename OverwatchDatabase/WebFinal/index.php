<?php 
    session_start(); 

    /*if (!isset($_SESSION['username'])) {
        $_SESSION['msg'] = "You must log in first";
        header('location: login.php');
    }*/
    if (isset($_GET['logout'])) {
        session_destroy();
        unset($_SESSION['username']);
        header("location: index.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Overwatch CMS</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container">
        <a href="index.php"><img src="images/overwatch.png" alt="Overwatch"></a>
        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <div class="navbar-header">
                <a class="navbar-brand" href="index.php">Overwatch</a>
                </div>
                <ul class="nav navbar-nav">
                    <li class="active"><a href="index.php">Home</a></li>
                    <li><a href="characterList.php">Characters</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <?php  if (isset($_SESSION['username'])) : ?>
                        <li><a href="index.php">Welcome <strong><?=$_SESSION['username']?></strong>, <?=$_SESSION['success']?></a></li>
                        <li><a href="index.php?logout='1'" style="color: red;">logout</a></li>
                    <?php else: ?>
                        <li><a href="register.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
                        <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                    <?php endif ?>
                </ul>
            </div>
        </nav> 
        <div>
            <p>This site contains information about the playable heroes in Overwatch. If you are a user, you can view all the detailed information about each hero.</p>
        </div>
        <div class="footer-margin">
            <footer>
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <span class="logo"><img src="images/logo.png" height="100" width="170" alt="logo"></span>
                        </div>
                        <div>
                            <ul class="menu">   
                                <li>Web Dev Final Project - Overwatch CMS</li>
                            </ul>
                        </div>
                    </div> 
                </div>
            </footer>
        </div>
    </div>
</body>
</html>