<!DOCTYPE html>
<html lang="en">
<?php
    require_once('db/config.php');
    include ('header.php');
    $uname = $_SESSION['username'];
    //session_start();
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/dashboard.css">
</head>    


<body>
    <br><br><br>
    <?php 
    
    $row="";
    $con = mysqli_connect('localhost','root','','artidb');
    $query = "SELECT * from userinfo WHERE username ='$uname'";
    $result = mysqli_query($con,$query);
    $row = mysqli_fetch_array($result);
    $followers = $row['followers'];
    $articleno =$row['articleno'];
    $followingno=$row['followingno'];
    $_SESSION['followers'] =$followers ;
    $_SESSION['articleno']=$articleno ;
    $_SESSION['followingno']=$followingno ;
    ?>
    <p style="font-size:24px; text-align:center; font-weight:bold">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $uname; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Articles:<?php echo $articleno; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Followers:<?php echo $followers; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Following:<?php echo $followingno; ?></p>

<?php
  $row="";
  $no =1;
  $con = mysqli_connect('localhost','root','','artidb');
  $query = "SELECT * from articlecreated where username ='$uname' ORDER by artid DESC ";
  $result = mysqli_query($con,$query);
  echo "<h2 style='text-align: center;'>Manage Posts</h2>";
     echo   "<table>";
     echo     "<thead style='background-color:rgb(124, 231, 222);' >";
        echo   "<th>S No.</th>";
         echo   "<th>Title</th>";
         echo   "<th style='text-align: center;' colspan='4'>Action</th>";
         echo "</thead>";
        echo  "<tbody>";
        echo "<form action='dashboard.php' name = 'manage' method='post' enctype='multipart/form-data'>";
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
    echo   "<td>".$row['title']."</td>";
      echo "<td>";
      echo   "<a href='readmore.php?id=".$row['artid']."' alt='view'><input name='viewbtn' type='button' id='viewbtn' value='VIEW'/></a><br>";
      echo "</td>";
      echo "<td>";
      echo   "<input name='editbtn' type='submit' id='editbtn' value='EDIT'/></a><br>";
      echo "</td>";
      echo "<td>";
      echo  "<input name='deletebtn' type='submit' id='deletebtn' value='DELETE'/><br>" ;
      echo  "</td>";
      echo "<td>";
      echo "<input name='publishbtn' type='submit' id='publishbtn' value='PUBLISH'/>";
      echo "</td>";
      echo "</tr>";
      echo "</form>";
      $no++;
  if(isset($_POST['editbtn'])){
 echo" <form class ='articleform' style = 'text-align:center;' action='dashboard.php' name = 'article' method='post' enctype='multipart/form-data'>";
  echo  "<label>TITLE</label><br>";
   echo "<input type='text' name='title' class='inputval' value = '".$row['title']."'/><br>";
   echo "<label>Body</label><br>";
   echo "<textarea class='ckeditor' type='text' name='descrp' style='font-size:16px;'>".$string2."</textarea><br>";
   echo "<input name='submiteditbtn' type='submit' id='viewbtn' value='SUBMIT'/><br>";
   echo "<input name='backeditbtn' type='submit' id='viewbtn' value='BACK'/>";  
  echo "</form>";
  if(isset($_POST['submiteditbtn'])){
    $title = $_POST['title'];
   $datecr = date('Y-m-d');
   $descrp = dataready($_POST['descrp']);
   $descrp = html_entity_decode($descrp);
   $artid = $row['artid'];
 
    if($title&&$descrp){
        
        $sql = "UPDATE posts SET title = '$title', timei = now(),datecr = '$datecr',descrp='$descrp' WHERE title ='$title'";
        $sql1 = "UPDATE articlecreated SET title = '$title', timei = now(),datecr = '$datecr',descrp='$descrp' WHERE artid ='$artid'";
        if(mysqli_query($con,$sql)|| mysqli_query($con,$sql)){
            echo "record updated";
        }
        else{
            echo "error in inserting";
        }
    }
    else{
        echo "provide all info";
    }
    header('location:dashboard.php');
  }
  if(isset($_POST['backeditbtn'])){
    header('location:dashboard.php');
  }
  }
  if(isset($_POST['deletebtn'])){
     $articleno = $_SESSION['articleno'];
     $sql = "SELECT * from postimages_tbl where images_id='$id'";
     $result1 = mysqli_query($con,$sql);
     $row1 = mysqli_fetch_array($result1);
     $image = $row1['images_path'];
     $articleno--; 
      $sql="DELETE FROM articlecreated WHERE title='$title'";
      $sql1="DELETE FROM posts WHERE title='$title'";
      $sql2="DELETE FROM images_tbl WHERE images_path='$image'";
      $sql3="DELETE FROM postimages_tbl WHERE images_path='$image'";
      $sql4 ="UPDATE userinfo SET articleno='$articleno' WHERE username ='$uname'";
      if((mysqli_query($con,$sql)&& mysqli_query($con,$sql1)&& mysqli_query($con,$sql4))||(mysqli_query($con,$sql2) && mysqli_query($con,$sql3)) ){
          echo "<script type ='text/javascript'>alert('deleted successfully')</script>";
          $_SESSION['articleno']=$articleno;
          header('location:dashboard.php');
      }
      else
      echo "<script type ='text/javascript'>alert('error in deleting')</script>";
  }
  if(isset($_POST['publishbtn'])){
    $query = "SELECT * from posts where timei = '$time'";
    $result = mysqli_query($con, $query);
    $num = mysqli_num_rows($result);
    if(!$result){
        die(mysqli_error($con));
    }
    else{
    if($num >0)
    {
        echo '<script type ="text/javascript"> alert("already published")</script>';
         break;
    }
    else{
        $title = $_POST['title'];
       $datecr = date('Y-m-d');
       $descrp = dataready($_POST['descrp']);
       $descrp = html_entity_decode($descrp);
     
        if($title&&$descrp){
            $articleno = $_SESSION['articleno'];
            $articleno++; 
            $sql = "INSERT INTO posts(username,title,timei,datecr,descrp) VALUES('".$uname."','".$title."',now(),'".$datecr."','".$descrp."')";
            $sql2= "UPDATE userinfo SET articleno = '$articleno' WHERE username='$uname'";
            if(mysqli_query($con,$sql)){
                echo "record inserted";
                if(mysqli_query($con,$sql2))
                  {echo "articleno updated";
                   $_SESSION['articleno']=$articleno;
                }
                else
                    echo "error in updating articleno";
            }
            else{
                echo "error in inserting";
            }
        }
        else{
            echo "provide all info";
        }
    }
  }
}
  }
  
  echo "</tbody>";
  echo "</table>";  
 function dataready($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
} 
  mysqli_close($con);
 include ('footer.php'); 
?>
</body>
</html>