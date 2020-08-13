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
    <link rel="stylesheet" href="styles/header.css">
    <link rel="stylesheet" href="styles/dashboard.css">
    <title>Yourblog</title>
</head>
<body style="background-color:white">
<br><br><br><br>
<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    echo '<script type="text/javascript"> alert("'.$id.'")</script>'; 
}
$row="";
  $con = mysqli_connect('localhost','root','','artidb');
  $query = "SELECT * from userinfo WHERE userid = '$id'";
  $result = mysqli_query($con,$query);
  $row = mysqli_fetch_array($result);
  $usename = $row['username'];
  $followers = $row['followers'];
  $articleno =$row['articleno'];
  $followingno=$row['followingno'];
  $followingno1=$_SESSION['followingno'];
  ?>

 <p style="font-size:24px; text-align:center; font-weight:bold">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $usename; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Articles:<?php echo $articleno; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Followers:<?php echo $followers; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Following:<?php echo $followingno; ?></p>
 <?php
 $row="";
 $no =1;
 $con = mysqli_connect('localhost','root','','artidb');
 $query = "SELECT * from posts where username ='$usename' ORDER by artid DESC ";
 $result = mysqli_query($con,$query);
 echo "<form method='post' action='search.php'><input name='followbtn' style ='margin-left:47%' type='submit'id='viewbtn' value='FOLLOW'/><br>";
echo "</form><h2 style='text-align: center;'>Posts</h2><table>"  ;
    echo     "<thead style='background-color:rgb(124, 231, 222);' >";
       echo   "<th>S No.</th>";
        echo   "<th>Title</th>";
        echo   "<th style='text-align: center;' colspan='1'>Action</th>";
        echo "</thead>";
       echo  "<tbody>";
       echo "<form action='search.php' name = 'manage' method='post' enctype='multipart/form-data'>";
 while($row = mysqli_fetch_array($result)){ 
   $time = $row['timei'];
   $artid = $row['artid'];
   $string =$row['descrp'];
    $title =$row['title'];
    $id = $row['artid'];
   $string2 =$row['descrp'];
   $string = strip_tags($string);
   $string2= strip_tags($string2);
   if (strlen($string) > 20) {
   
       // truncate string
       $stringCut = substr($string, 0, 100);
       $endPoint = strrpos($stringCut, ' ');
   
       //if the string doesn't contain any space then it will cut without word basis.
       $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
   }  
   echo    "<tr class='rec'>";
   echo "<td>".$no."</td>";
   echo   "<td>".$row['title']."</td><td>";
     echo   "<a href='readmore.php?id=".$row['artid']."' alt='view'><input name='viewbtn' type='button' id='viewbtn' value='VIEW'/></a><br>";
     echo "</td></tr></form>";
     $no++;
 }
     echo "</tbody>";
     echo "</table>";    
     if(isset($_POST['followbtn'])){
        $followers++;
        $followingno1++;
        $query = "INSERT INTO  tbl_follow(sender_id,receiver_id) VALUES('$uname','$searchuser')";
        $result = mysqli_query($con,$query);
        $query1 = "UPDATE userinfo SET followers= '$followers' WHERE username='$searchuser'";
        $result1 = mysqli_query($con,$query1);
        $query2 = "UPDATE  userinfo SET followingno= '$followingno1' WHERE username='$uname'";
        $result2 = mysqli_query($con,$query2);
        $_SESSION['followingno']=$followingno1;
        if($result && $result1 && $result2){
           echo '<script type="text/javascript"> alert("Following successfully")</script>';
        }
        else
          echo '<script type="text/javascript"> alert("Following error")</script>';
    } 
?> 

<?php
include ('footer.php');
?>
</body>
</html>