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
    
    $query = "SELECT * FROM detail WHERE HeroId = :id";
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement->execute(); 
    $status = $statement->fetch();

    $abilityQuery = "SELECT * FROM ability WHERE HeroId = :idAbility";
    $statement2 = $db->prepare($abilityQuery);
    $statement2->bindValue(':idAbility', $id, PDO::PARAM_INT);
    $statement2->execute(); 
    $abilityStatus = $statement2->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Page</title>
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
        <p><strong>Real Name:</strong> <?=$status['RealName']?></p>
        <p><strong>Occupation:</strong> <?=$status['Occupation']?></p>
        <p><strong>Age:</strong> <?=$status['Age']?></p>
        <p><strong>Base Of Operations:</strong> <?=$status['BaseOfOperation']?></p>
        <p><strong>Affiliation:</strong> <?=$status['Affiliation']?></p>
        <h1>Abilities</h1>
        <?php if(!empty($abilityStatus)): ?>
            <?php foreach($abilityStatus as $ability): ?>
                <strong><?=$ability['AbilityName']?></strong>
                <p><strong>Description:</strong> <?=$ability['Description']?></p>
            <?php endforeach?>
        <?php else: ?>
            <p>Ability information unable at the moment.</p>
        <?php endif ?>
    </div>
</body>
</html>