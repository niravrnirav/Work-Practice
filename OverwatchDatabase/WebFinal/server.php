<?php
session_start();
require('connect.php');

$username = "";
$email    = "";
$errors = array(); 


// REGISTER USER
if (isset($_POST['reg_user'])) {
    // receive all input values from the form
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password_1 = filter_input(INPUT_POST, 'password_1', FILTER_SANITIZE_SPECIAL_CHARS);
    $password_2 = filter_input(INPUT_POST, 'password_2', FILTER_SANITIZE_SPECIAL_CHARS);

    // form validation: ensure that the form is correctly filled ...
    // by adding (array_push()) corresponding error unto $errors array
    if (empty($username)) { 
        array_push($errors, "Username is required"); 
    }
    if (empty($email)) { 
        array_push($errors, "Email is required"); 
    }
    if (empty($password_1)) { 
        array_push($errors, "Password is required"); 
    }
    if ($password_1 != $password_2) {
        array_push($errors, "The two passwords do not match");
    }

    // first check the database to make sure 
    // a user does not already exist with the same username and/or email
    $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
    $statement = $db->prepare($user_check_query);
    $statement->execute();
    $user = $statement->fetch();

    if ($user) { // if user exists
        if ($user['username'] === $username) {
        array_push($errors, "Username already exists");
        }

        if ($user['email'] === $email) {
        array_push($errors, "email already exists");
        }
    }

    // Register user if there are no errors in the form
    if (count($errors) == 0) {
        $password = password_hash($password_1, PASSWORD_DEFAULT);//encrypt the password before saving in the database

        $query = "INSERT INTO users (username, email, password) VALUES(:username, :email, :pass)";
        $statement = $db->prepare($query);
        $statement->bindValue(':username', $username);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':pass', $password);
        $statement->execute();
        
        $_SESSION['username'] = $username;
        $_SESSION['success'] = "You are now logged in";
        header('location: index.php');
    }
}


// LOGIN USER
if (isset($_POST['login_user'])) {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);

    if (empty($username)) {
        array_push($errors, "Username is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }

    if (count($errors) == 0) {
        $query = "SELECT * FROM users WHERE username='$username'";
        $statement = $db->prepare($query);
        $statement->execute();
        $results = $statement->fetch();
        if ($results['username'] == $username and password_verify($password, $results['password']) ){ 
            $_SESSION['username'] = $username;
            $_SESSION['success'] = "You are now logged in";
            header('location: index.php');
        } else {
            echo "test";
            $test = (password_verify($password, $results['password']))? "1" : "2";
            echo $test;
            echo "<br>";
            print_r($results);
            echo $password;
            echo "<br>";
            echo $results['username'];
            array_push($errors, "Wrong username/password combination");
        }
    }
}

?>