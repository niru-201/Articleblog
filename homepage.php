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
    <link rel="stylesheet" href="styles/homepage.css">
    <link rel="stylesheet" href="styles/header.css">
    <!--<link rel="stylesheet" href="styles/loginpage.css">-->
    <title>Yourblog</title>
</head>

<body style="background-color:white">
<br><br><br><br>
    <div id="content">
        <h2 style= "text-align:center;">Trending Articles</h2>
    </div>  
      <?php
  $row="";
  $con = mysqli_connect('localhost','root','','artidb');
  $query = "SELECT * from posts ORDER by artid DESC";
  $result = mysqli_query($con,$query) or die("Query to get blah failed with error:".mysql_error());

  while($row = mysqli_fetch_array($result)) { 
    $string =$row['descrp'];
    $string2 =$row['descrp'];
    $id = $row['artid'];
    $string = strip_tags($string);
    if (strlen($string) > 100) {
    
        // truncate string
        $stringCut = substr($string, 0, 100);
        $endPoint = strrpos($stringCut, ' ');
    
        //if the string doesn't contain any space then it will cut without word basis.
        $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
        //$string .= '... <form method="post"><input class ="btn-readmore" type = "submit" name = "readmore" value="Read More"/></form>';
        $string .= "... <a href='readmore.php?id=".$row['artid']."' class ='btn-readmore' id='demo' alt='Read More'>ReadMore</a>";
    }  
    $sql = "SELECT * from postimages_tbl where images_id='$id'";
    $result1 = mysqli_query($con,$sql);
    $row1 = mysqli_fetch_array($result1);
    $image = $row1['images_path'];
    $image_src = 'upload/'.$image;
    echo "<div id='display' style ='background-color: rgb(124, 231, 222);'><hr><img  style = 'background-color:white; margin-left:38%' class ='imagedisp' width='350px' height='250px' src='".$image_src."' >";
    echo  "<h2 style = 'text-align:center; background-color: rgb(124, 231, 222);' class='title' >".$row['title']."</h2><h3 style = 'text-align:center; font-size:normal; background-color: rgb(124, 231, 222);' class='timei'>By&nbsp;".$row['username']."&nbsp;&nbsp;&nbsp;&nbsp;".$row['datecr']."</h3>";
    echo "<p style = 'text-align:center;  font-size:20px;' class='descrp'>".$string."</p><hr></div>";
}
  mysqli_close($con);
?>
<?php
    include ('footer.php');
?>
</body>
</html>
    
