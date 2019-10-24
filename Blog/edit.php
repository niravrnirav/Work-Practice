<?php
    require 'connect.php';
    require 'authentication.php';

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
    echo $status['Title'];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Stung Eye - Edit Post Wootly Grins</title>
    <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
    <div id="wrapper">
        <div id="header">
            <h1><a href="index.php">Stung Eye - Edit Post</a></h1>
        </div> <!-- END div id="header" -->
        <ul id="menu">
            <li><a href="index.php" >Home</a></li>
            <li><a href="create.php" >New Post</a></li>
        </ul> <!-- END div id="menu" -->
        <div id="all_blogs">
            <form action="process_post.php" method="post">
                <fieldset>
                    <legend>Edit Blog Post</legend>
                    <p>
                        <label for="title">Title</label>
                        <input name="title" id="title" value="<?=$status['Title']?>" />
                    </p>
                    <p>
                        <label for="content">Content</label>
                        <textarea name="content" id="content"><?=$status['Content']?></textarea>
                    </p>
                    <p>
                        <input type="hidden" name="id" value="<?=$status['id']?>" />
                        <input type="submit" name="command" value="Update" />
                        <input type="submit" name="command" value="Delete" onclick="return confirm('Are you sure you wish to delete this post?')" />
                    </p>
                </fieldset>
            </form>
        </div>
        <div id="footer">
            Copywrong 2018 - No Rights Reserved
        </div> <!-- END div id="footer" -->
    </div> <!-- END div id="wrapper" -->
</body>
</html>