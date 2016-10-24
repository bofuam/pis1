<?php
session_start();
require_once 'databaseProperties.php';
$sqlQuery = '';
$url = '';
if(isset($_POST['delete'])){
    $sqlQuery = ("Delete from users where userEmail ='".  $_POST['email']."'" );
    $url = $_SESSION['userSession'] == $_POST['userEmail'] ? "logout.php" : "userPanel.php";
}

else if(isset($_POST['makeAdmin'])){
    $sqlQuery = ("Update users set role='admin' where userEmail ='".  $_POST['email']."'" );
    $url = "userPanel.php";
}
else{
    $sqlQuery = "select * from users";
}
$connection = new mysqli($host, $dbUser, $dbPassword, $dbName);
    $result = $connection->query($sqlQuery);
if($url !=''){
    header("Location: ". $url);
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
<div id="up-bar">
    <div id="up-bar-right">
        <a href="logout.php">Logout</a>
    </div>
</div>
<?php
if(!isset($_SESSION['admin']) || $_SESSION['admin'] != "admin") {
    header("Location: index.php");
    exit();
}
    while($user = $result -> fetch_assoc()){
        echo "<div class ='single-user'>";
        echo "name" . $user['userName'] . " | ";
        echo $user['role'] == 'admin' ? "Administrator" : "Zwykly user";
        echo "<form method'post'>";
        echo "<input type ='hidden' name='email' value='" . $user['userEmail'] . "'/>";
        echo "<input type='submit' name='delete' value='delete user'/>";
        echo "</form> ";

        echo "<form method='post'>\n";
        echo "<input type='hidden' name='email' value='".$user['userEmail'] . "'/>\n";
        echo "<input type='submit' name='makeAdmin' value='make admin'/>\n";
        echo "</form>";
        echo "<div style='clear :both;'></div>";
        echo "</div>";
        echo "<br/><br/>";
    }

?>
</body>
</html>
