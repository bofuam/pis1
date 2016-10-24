<?php
session_start();
require_once 'databaseProperties.php';

if (isset($_SESSION['userSession'])!="") {
    header("Location: index.php");
    exit;
}

if (isset($_POST['btn-login'])) {

    $email = strip_tags($_POST['email']);
    $pass = strip_tags($_POST['pass']);

    $connection = new mysqli($host, $dbUser, $dbPassword, $dbName);

    $sqlQuery = ("SELECT  userEmail, userPassword, role FROM users WHERE userEmail='$email'");
    $result = $connection->query($sqlQuery);
    $row=$result->fetch_assoc();

    echo $pass;
    echo $row['userPassword'];
    echo password_verify($pass, $row['userPassword']);
    if (password_verify($pass, $row['userPassword'])) {
        $_SESSION['userSession'] = $row['userEmail'];
        if($row['role']=='admin'){
            header("Location: admin.php");
            $_SESSION['admin'] = 'admin';
        }else{
            header("Location: index.php");
        }
    } else {
        $msg = "<div class='alert alert-danger'>
     <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Invalid User
      or Password!
    </div>";
    }

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Coding Cage - Login & Registration System</title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
    <link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body>

<div class="signin-form">
<div class="signin-form">

    <div class="container">


        <form class="form-signin" method="post" id="login-form">

            <h2 class="form-signin-heading">Sign In.</h2><hr />

            <?php
            if(isset($msg)){
                echo $msg;
            }
            ?>

            <div class="form-group">
                <input type="email" class="form-control" placeholder="Email address" name="email" required />
                <span id="check-e"></span>
            </div>

            <div class="form-group">
                <input type="password" class="form-control" placeholder="Password" name="pass" required />
            </div>

            <hr />

            <div class="form-group">
                <button type="submit" class="btn btn-default" name="btn-login" id="btn-login">
                    <span class="glyphicon glyphicon-log-in"></span> &nbsp; Sign In
                </button>

                <a href="register.php" class="btn btn-default" style="float:right;">Sign UP Here</a>

            </div>



        </form>

    </div>

</div>

</body>
</html>