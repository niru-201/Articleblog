<?php
  session_start();
  require_once('db/config.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YourBlog</title>
    <link rel="stylesheet" href ="styles/loginpage.css">
</head>
<body style="background-color:white">
 <div id="login">
        <h2 style= "text-align:center">LOGIN</h2>
        <img src="images/user.png" class= "userimg"/>
    

    <form class = "loginform" action="index.php" method="post">
        <label>Username</label><br>
        <input name= "uname" type="text" class ="inputval" required /><br>
        <label>Password</label><br>
        <input name = "pword" type="password" class ="inputval" required/><br>  
        <input name = "login" type="submit" id="loginbtn" value="LOGIN"/><br>
        <p>Are you new?Then register</p>
        <a href="register.php"><input type="button" id="registerbtn" value ="REGISTER"/></a>   
    </form>  
    <?php
     $con = mysqli_connect('localhost','root','','artidb');
    if(isset($_POST['login']))
    {
        $username = $_POST['uname'];
        $password = $_POST['pword'];
        $query = "SELECT * from userinfo where username = '$username' AND passwordu = '$password'";
        $result = mysqli_query($con,$query);
        if($result){
        if(mysqli_num_rows($result)>0)
        {
           $_SESSION['username'] = $username;
           $row="";
           $query = "SELECT * from userinfo WHERE username ='$uname'";
           $result = mysqli_query($con,$query);
           $row = mysqli_fetch_array($result);
           $followers = $row['followers'];
           $articleno =$row['articleno'];
           $followingno=$row['followingno'];
           $_SESSION['followers'] =$followers ;
           $_SESSION['articleno']=$articleno ;
           $_SESSION['followingno']=$followingno ;
           header('location:homepage.php');
        }
        else{
            echo'<script type ="text/javascript">alert("Invalid credentials")</script>';
        }
    }
}
    ?>     
 </div>
    
</body>
</html>