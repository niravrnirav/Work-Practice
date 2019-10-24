<?php

    //Filters input data
    $titleSan = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
    $ContentSan = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_SPECIAL_CHARS);
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

    //Bunch of if statements
    //If delete button is clicked, it will delete the post and redirects user to index page
    //If title or content is empty it will redirect the guest to error page
    //If update button is clicked, it will update the database and redirect user to index page
    //If create button is clicked, it will create a new entry in database
    if ($_POST['command'] == "Delete") {
        require('connect.php');

        $query = "DELETE FROM blog WHERE id = :id";
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();

        header("Location: index.php");
        exit;

    } 
    elseif(empty($titleSan) or empty($ContentSan)){
        
        header("Location: error.php");
        exit;
    }
    elseif ($_POST['command'] == "Update")
    {
        require('connect.php');
        $query = "UPDATE blog SET Title = :title, Content = :content WHERE id = :id";
        $statement = $db->prepare($query);
        $statement->bindValue(':title', $titleSan);
        $statement->bindValue(':content', $ContentSan);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        
        header("Location: index.php");
        exit;
    }
    elseif($_POST['command'] == "Create")
    {
        require('connect.php');
        $query = "INSERT INTO blog (Title, Content, BlogDate) values (:title, :content, now())";
        $statement = $db->prepare($query);
        $statement->bindValue(':title', $titleSan);
        $statement->bindValue(':content', $ContentSan);
        $statement->execute();

        header("Location: index.php");
        exit;
    }
?>