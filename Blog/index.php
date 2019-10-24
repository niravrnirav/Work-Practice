<?php 
    require('connect.php');

    //Select query that gets 5 most recent posts
    $select_query = 'SELECT * FROM blog ORDER BY BlogDate desc limit 5';

    //query execution
    $statement = $db->prepare($select_query);
    $statement->execute();

    //collects all the data from the database
    $status = $statement->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>I copied your html</title>
    <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
    <div id="wrapper">
            <div id="header">
                <h1><a href="index.php">Stung Eye - Index</a></h1>
            </div> <!-- END div id="header" -->
        <ul id="menu">
            <li><a href="index.php" class='active'>Home</a></li>
            <li><a href="create.php" >New Post</a></li>
        </ul> <!-- END div id="menu" -->

        <div id="all_blogs">

            <!-- Runs a loop and prints 5 most receipt comments in HTML -->
            <?php foreach ($status as $query) : ?>
                <div class="blog_post">
                    <h2><a href="show.php?id=<?=$query['id']?>"><?= $query['Title'] ?></a></h2>
                    <p>
                        <small>
                            <?php $date=date_create($query['BlogDate']) ?>
                            <?= date_format($date,"F d, Y, h:m a") ?> 
                            <a href="edit.php?id=<?=$query['id']?>">edit</a>
                        </small>
                    </p>
                    <div class='blog_content'>
                        <?php if (strlen($query['Content']) > 200) : ?>      
                            <p><?= substr($query['Content'], 0, 201) ?>...<a href="show.php?id=<?=$query['id']?>">Read more</a></p>
                            
                        <?php else : ?>
                            <p><?= $query['Content'] ?></p>
                            
                        <?php endif ?>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
        <div id="footer">
            Copywrong 2018 - No Rights Reserved
        </div> <!-- END div id="footer" -->
    </div>
</body>
</html>
