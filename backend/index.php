<?php
session_start();
require_once 'databaseProperties.php';
$sqlQuery = '';
$url = '';

if(isset($_POST['delete'])){
    $sqlQuery = "delete from text where userEmail='". $_POST['email']. "'" ;
    $url = "index.php";

}else {
    $sqlQuery = "select * from text";
}
$connection = new mysqli($host, $dbUser, $dbPassword, $dbName);
    $result = $connection->query($sqlQuery);
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
    <a href="addText.php">Add new text!</a>
<?php
    while($text = $result->fetch_assoc()){
        echo "<div class='single-post'>";
        echo "user email: " . $text['userEmail'] . " | ";
        echo $text['userText'];
        if(isset($_SESSION['admin'])){
            echo "<form method='post'>\n";
            echo "<input type ='hidden' name='email' value='" .$text['userEmail'] . "'/>";
            echo "<input type='submit' name='delete' value='delete text'/>\n";
            echo "</form>";
        }
        echo "<div style='clear :both;'></div>";
        echo "</div>";
        echo "<br/><br/>";
    }
?>
</body>
</html>