<?php
session_start();
require_once 'databaseProperties.php';
$sqlQuery = '';
$url = '';
if (isset($_POST['addText'])){
    $userEmail = strip_tags($_SESSION['userSession']);
    $userEmail = htmlspecialchars($userEmail);
    $text = strip_tags($_POST['userText']);
    $text = htmlspecialchars($text);
    $sqlQuery = "insert into text(userEmail, userText) values('$userEmail','$text')";
    $url = "index.php";
    $connection = new mysqli($host, $dbUser, $dbPassword, $dbName);
    $result = $connection->query($sqlQuery);
}
if($url !=''){
    header("Location: ". $url);
    exit();
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
<div class="single-post">
    <form method="post">
        <input type="text" name="userText"/>
        <button type="submit" name="addText" id="addText">Add text!</button>
    </form>
</div>

</body>
</html>