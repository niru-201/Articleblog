<?php
    require_once('db/config.php');
    include ('header.php');
    $uname =$_SESSION['username'];
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
<br><br><br><br><br>
 <div id="login">
        <h2 style= "text-align:center">EDITPROFILE</h2>
        <img src="images/user.png" class= "userimg"/>
    
    <br><br><br>
    <form class = "loginform" action="profile.php" method="post">
        <label>Username</label><br>
        <input name="username" type="text" class ="inputval" required/><br>
        <label>Password</label><br>
        <input name="password1" type="password" class ="inputval" required/><br>
        <label>Confirm Password</label><br>
        <input name="conpassword" type="password" class ="inputval" required /><br>
        <input name="submitbtn" type="submit" id="registerbtn" value="Make Changes"/><br>
        <a href ="index.php" ><input type="button" id="backbtn" value ="Back"/></a>  
    </form> 
    <?php
    
    $con = mysqli_connect('localhost','root','','artidb');
    //mysqli_select_db($con, 'userdb');
    
     if(isset($_POST['submitbtn']))
     {
         $username = $_POST['username'];
         $password = $_POST['password1'];
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
             if(($num ==1) && ($uname!=$username))
             {
                 echo '<script type ="text/javascript"> alert("Try another.Username already exists")</script>';
             }
             
            else{
                 //$password = md5($password);
                 $query = "UPDATE userinfo SET username='$username',passwordu='$password' WHERE username ='$uname'";
                 $query_run = mysqli_query($con,$query);

                 if($query_run){
                   echo '<script type="text/javascript"> alert("Changed successfully")</script>';
                   $_SESSION['username'] = $username;
                   header('location:homepage.php');
                 }
                 else
                    echo '<script type="text/javascript">alert(Sorry there seems to be an error try again)</script>';

             }
              
            }  
         }
         else
           echo '<script type="text/javascript">alert(password does not match with confirm password... try again)</script>';
         }
         include ('footer.php');
    ?>      
 </div>
    
</body>
</html>