<?php 
    include('server.php') 
?>
<!DOCTYPE html>
<html>
<head>
    <title>Registration</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <style type="text/css">
        .username-available-msg, .username-taken-msg {
            display: none;
        }
    </style>
    
</head>
<body>
    <div class="header">
        <h2>Register</h2>
    </div>
    <!-- <div class="username-available-msg alert alert-primary" role="alert">
        Username is available. Please continue to fill out this lovely form.
    </div>
    <div class="username-taken-msg alert alert-danger" role="alert">
        Sorry this username is taken. Please choose a different username.
    </div> -->
    <form class="reglog" method="post" action="register.php">
        <?php include('errors.php'); ?>
        <div class="username-available-msg alert alert-primary input-group" role="alert" style="color:black">
            Username is available.
        </div>
        <div class="username-taken-msg alert alert-danger input-group" role="alert"  style="color:black">
            Sorry this username is taken.
        </div>
        <div class="input-group">
            <label for="inputUsername" id="regLabel">Username</label>
            <input id="inputUsername" type="text" name="username" value="<?php echo $username; ?>">
        </div>
        <div class="input-group">
            <label id="regLabel">Email</label>
            <input type="email" name="email" value="<?php echo $email; ?>">
        </div>
        <div class="input-group">
            <label id="regLabel">Password</label>
            <input type="password" name="password_1">
        </div>
        <div class="input-group">
            <label id="regLabel">Confirm password</label>
            <input type="password" name="password_2">
        </div>
        <div class="input-group">
            <button type="submit" class="btn" name="reg_user">Register</button>
        </div>
        <p id="regLabel">
            Already a member? <a href="login.php">Sign in</a>
        </p>
    </form>
    <script src="javascript/main.js"></script>
</body>
</html>