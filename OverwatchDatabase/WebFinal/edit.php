<?php
    session_start();
    require('connect.php');
    if (!isset($_SESSION['username'])) {
        $_SESSION['msg'] = "You must log in first";
        header('location: login.php');
    }
    if (isset($_GET['logout'])) {
        session_destroy();
        unset($_SESSION['username']);
        header("location: index.php");
    }

    $id = filter_input(INPUT_GET, 'HeroId', FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM hero WHERE HeroId = :id";
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement->execute(); 
    $status = $statement->Fetch();

    $detailQuery = "SELECT * FROM detail WHERE HeroId = :id";
    $statement2 = $db->prepare($detailQuery);
    $statement2->bindValue(':id', $id, PDO::PARAM_INT);
    $statement2->execute(); 
    $detailStatus = $statement2->Fetch();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Edit</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container">
        <img src="images/overwatch.png" alt="Overwatch">
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
        <form action="process.php" class="form-horizontal" action="/action_page.php" method='post' enctype='multipart/form-data'>
            <div class="form-group">
                <label class="control-label col-sm-2" for="name">Hero Name:</label>
                <div class="col-sm-10">
                    <input class="form-control" placeholder="Hero Name" name="name" value="<?=$status['Name']?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="role">Role:</label>
                <div class="col-sm-10">
                    <input class="form-control" placeholder="Role" name="role" value="<?=$status['Role']?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="realName">Real Name:</label>
                <div class="col-sm-10">
                    <input class="form-control" placeholder="Real Name" name="realName" value="<?=$detailStatus['RealName']?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="occupation">Occupation:</label>
                <div class="col-sm-10">
                    <input class="form-control" placeholder="Occupation" name="occupation" value="<?=$detailStatus['Occupation']?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="age">Age:</label>
                <div class="col-sm-10">
                    <input class="form-control" placeholder="Age" name="age" value="<?=$detailStatus['Age']?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="base">Base Of Operations:</label>
                <div class="col-sm-10">
                    <input class="form-control" placeholder="Base Of Operations" name="base"value="<?=$detailStatus['BaseOfOperation']?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="affiliation">Affiliation:</label>
                <div class="col-sm-10">
                    <input class="form-control" placeholder="Affiliation" name="affiliation" value="<?=$detailStatus['Affiliation']?>">
                </div>
            </div>
            <div class="form-group">
                <label for="image" class="control-label col-sm-2">Image Filename:</label>
                <?php if ($status['Image'] == '.png' or $status['Image'] == '') :?>
                    <input type="file" name="image" id="image">
                <?php else :?>
                    <div class="col-sm-10">
                        <?php $var = $status['Image'] . ".png"?>
                        <img src=<?="images/".$var?> height="90" width="100">
                    </div>
                    <label for="imagedel" class="control-label col-sm-2">Delete Image:</label>
                    <div class="col-sm-10">
                        <input type="checkbox" name="imagedel" value="imagedel">
                    </div>
                <?php endif ?>
            </div>
            <div class="form-group">        
                <div class="col-sm-offset-2 col-sm-10">
                    <input type="hidden" name="id" value="<?=$status['HeroId']?>" />
                    <input class="btn btn-default" type="submit" name="command" value="Update" />
                    <input class="btn btn-default" type="submit" name="command" value="Delete" onclick="return confirm('Are you sure you wish to delete this post?')" />
                </div>
            </div>
        </form>
    </div>
</body>
</html>