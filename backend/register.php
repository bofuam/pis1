<?php
ob_start();
session_start();
if( isset($_SESSION['user'])!="" ){
    header("Location: index.php");
}
require_once 'databaseProperties.php';

$checkIfOk = false;

if ( isset($_POST['btn-signup']) ) {

    $name = trim($_POST['name']);
    $name = strip_tags($name);
    $name = htmlspecialchars($name);

    $email = trim($_POST['email']);
    $email = strip_tags($email);
    $email = htmlspecialchars($email);

    $pass = trim($_POST['pass']);
    $pass = strip_tags($pass);
    $pass = htmlspecialchars($pass);

    $connection = new mysqli($host, $user, $pass, $name );
    if (empty($name)) {
        $checkIfOk = true;
        $nameError = "Please enter your full name.";
    }

        $sqlQuery = "SELECT userEmail FROM users WHERE userEmail='$email'";
        $result = $connection -> query($sqlQuery);
        $count = mysql_num_rows($result);
        if($count!=0){
            $checkIfOk = true;
            $emailError = "Provided Email is already in use.";
        }

    if (empty($pass)){
        $checkIfOk = true;
        $passError = "Please enter password.";
    }

    if( !$checkIfOk ) {

        $sqlQuery = "INSERT INTO users(userName,userEmail,userPassword, role) VALUES('$name','$email','$pass', 'user')";
        $result = $connection -> query($sqlQuery);

        if ($result) {
            unset($name);
            unset($email);
            unset($pass);
        } else {
            header("Location: register.php");
        }
    }
}
?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Coding Cage - Login & Registration System</title>
        <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css"  />
        <link rel="stylesheet" href="style.css" type="text/css" />
    </head>
    <body>

    <div class="container">

        <div id="login-form">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">

                <div class="col-md-12">

                    <div class="form-group">
                        <h2 class="">Sign Up.</h2>
                    </div>

                    <div class="form-group">
                        <hr />
                    </div>

                    <?php
                    if ( isset($errMSG) ) {

                        ?>
                        <div class="form-group">
                            <div class="alert alert-<?php echo ($errTyp=="success") ? "success" : $errTyp; ?>">
                                <span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                            </div>
                        </div>
                        <?php
                    }
                    ?>

                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                            <input type="text" name="name" class="form-control" placeholder="Enter Name" maxlength="50"  />
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
                            <input type="email" name="email" class="form-control" placeholder="Enter Your Email" maxlength="40"  />
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                            <input type="password" name="pass" class="form-control" placeholder="Enter Password" maxlength="15" />
                        </div>
                    </div>

                    <div class="form-group">
                        <hr />
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-block btn-primary" name="btn-signup">Sign Up</button>
                    </div>

                    <div class="form-group">
                        <hr />
                    </div>

                    <div class="form-group">
                        <a href="login.php">Sign in Here...</a>
                    </div>

                </div>

            </form>
        </div>

    </div>

    </body>
    </html>
<?php ob_end_flush(); ?>