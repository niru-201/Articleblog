<?php
//session_start();
require_once('db/config.php');
include ('header.php');
$uname = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/create.css">
    <title>Yourblog</title>
</head>
<body style="background-color:white">
<br><br><br><br>
<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}
$row="";
  $con = mysqli_connect('localhost','root','','artidb');
  $query = "SELECT * from posts WHERE artid = '$id'";
  $result = mysqli_query($con,$query) or die("Query to get blah failed with error:".mysql_error());
  $row = mysqli_fetch_array($result);
  $string = $row['descrp'];
  $sql = "SELECT * from postimages_tbl where images_id='$id'";
    $result1 = mysqli_query($con,$sql);
    $row1 = mysqli_fetch_array($result1);
    $image = $row1['images_path'];
    $image_src = 'upload/'.$image;
    echo "<div id='display'><hr><img class ='imagedisp' style ='margin-left:38%' width='350px' height='250px' src='".$image_src."' >";
    echo  "<h2 style = 'text-align:center; background-color: rgb(124, 231, 222);' class='title' >".$row['title']."</h2><h3 style = 'text-align:center; font-size:normal; background-color: rgb(124, 231, 222);' class='timei'>By&nbsp;".$row['username']."&nbsp;&nbsp;&nbsp;&nbsp;".$row['datecr']."</h3>";
    echo "<p style = 'text-align:center; font-size:20px;' class='descrp'>".$string."</p>";
    echo "<a href='homepage.php'><input type='button' id='backbtn' value ='Back'/></a><hr></div>";   
mysqli_close($con);

?> 
</body>
<?php
include ('footer.php');
?>
</html>