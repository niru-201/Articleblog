<?php
    require 'db/config.php';
    session_start();
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
        <h2 style= "text-align:center">REGISTER</h2>
        <img src="images/user.png" class= "userimg"/>
    

    <form class = "loginform" action="register.php" method="post">
        <label>Username</label><br>
        <input name="username" type="text" class ="inputval" required/><br>
        <label>Password</label><br>
        <input name="password" type="password" class ="inputval" required/><br>
        <label>Confirm Password</label><br>
        <input name="conpassword" type="password" class ="inputval" required /><br>
        <input name="submitbtn" type="submit" id="registerbtn" value="REGISTER"/><br>
        <a href ="index.php" ><input type="button" id="backbtn" value ="Back"/></a>  
    </form> 
    <?php
    $con = mysqli_connect('localhost','root','','artidb');
    
     if(isset($_POST['submitbtn']))
     {
         $username = $_POST['username'];
         $password = $_POST['password'];
         $conpassword = $_POST['conpassword'];

         if($password==$conpassword)
         {
             $query = "SELECT * from userinfo where username = '$username'";
             $result = mysqli_query($con, $query);
             $num = mysqli_num_rows($result);
             if(!$result){
                 die(mysqli_error($con));
             }
             else{
             if($num ==1)
             {
                 echo '<script type ="text/javascript"> alert("Try another.Username already exists")</script>';
             }
             
            else{
                 //$password = md5($password);
                 $query = "INSERT into userinfo(username, passwordu,articleno,followers,followingno) values('$username','$password','0','0','0')";
                 $query_run = mysqli_query($con,$query);

                 if($query_run){
                   echo '<script type="text/javascript"> alert("Registered successfully")</script>';
                   $_SESSION['username'] = $username;
                   $_SESSION['articleno'] = 0;
                   $_SESSION['followers'] = 0;
                   $_SESSION['followingno'] = 0;
                   header('location:index.php');

                 }
                 else
                    echo '<script type="text/javascript">alert(Sorry there seems to be an error try again)</script>';

             }
              
            }  
         }
         else
           echo '<script type="text/javascript">alert(password does not match with confirm password... try again)</script>';

     }
    ?>      
 </div>
    
</body>
</html>