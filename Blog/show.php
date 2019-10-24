<?php
    require 'connect.php';

    // Sanitize $_GET['id'] to ensure it's a number.
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    // Build a query using ":id" as a placeholder parameter.
    $query = "SELECT * FROM blog WHERE id = :id";
    $statement = $db->prepare($query);

    // Bind the :id parameter in the query to the previously
    // sanitized $id specifying a type of INT.
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement->execute(); 
    $status = $statement->fetch();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>I copied this too</title>
    <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
    <div id="wrapper">
        <div id="header">
            <h1><a href="index.php">Stung Eye - <?=$status['Title']?></a></h1>
        </div> <!-- END div id="header" -->
        <ul id="menu">
            <li><a href="index.php" >Home</a></li>
            <li><a href="create.php" >New Post</a></li>
        </ul> <!-- END div id="menu" -->
        <div id="all_blogs">
            <div class="blog_post">
                <h2><?=$status['Title']?></h2>
                <p>
                    <small>
                    <?php $date=date_create($status['BlogDate']) ?>
                    <?= date_format($date,"F d, Y, h:m a") ?>
                    <a href="edit.php?id=1032">edit</a>
                    </small>
                </p>
                <div class='blog_content'>
                    <?=$status['Content']?>     
                </div>
            </div>
        </div>
        <div id="footer">
            Copywrong 2018 - No Rights Reserved
        </div> <!-- END div id="footer" -->
    </div> <!-- END div id="wrapper" -->
</body>
</html>