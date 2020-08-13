<?php
require_once('db/config.php');
session_start();
$uname = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/header.css">
    <title>Yourblog</title>
</head>

<body>
    <div id="slideout-menu">
        <ul>
            <li>
                <a href="homepage.php">Home</a>
            </li>
            <li>
                <a href="create.php">Create Article</a>
            </li>
            <li>
                <a href="dashboard.php">Dashboard</a>
            </li>
            <li>

                <button class = "dropbtn"><h3><?php echo $uname ?></h3><i class = "fa fa-caret-down"></i></button>
                <div class="dropdown-content">
                    <form action ="header.php" method = "post">
                        <input id = "logoutbtn" name = "logout" type = "submit" value ="Logout"/><br>
                     </form> 
                     <form action ="header.php" method = "post">
                        <input id = "logoutbtn" name = "changeprofile" type = "submit" value ="Editprofile"/><br>
                     </form>   
                </div>
            </li>
            <li>
              <form action ="header.php" method = "post">   
                 <input type="text" name = "search"/> 
                 <a href="search.php?id=<?php searchfunc()?>"><input type="button" name="submit" value="Search"/></a>  
              </form>  
            </li>  
        </ul> 
    </div>   

                    <?php
                       function searchfunc(){
                        $con = mysqli_connect("localhost","root","","artidb");
                         if(isset($_POST['sumbit']) && isset($_POST['search'])){
                         
                         $name = htmlspecialchars($_POST['search']);
                         $name = mysql_real_escape_string($name);
                        if (mysqli_connect_error())
                          {
                            echo "<script type ='text/javascript'>Failed to connect to MySQL:</script>";
                          }
                        $query =  "SELECT * FROM userinfo WHERE username like '%".$name."%'";
                        $result = mysqli_query($con,$query);
                         while($row = mysqli_fetch_array($result)){
                            $searchuser= $row['username'];
                            echo '<script type ="text/javascript">alert("'.$searchuser.'")</script>';
                          
                        $num = mysqli_num_rows($result);
                        $id = $row['userid'];}
                        if($num==0) {
                          echo '<script type ="text/javascript">alert("No such user found")</script>';
                          header('location:homepage.php');
                        }
                        else{
                            $row = mysqli_fetch_array($result);
                            $searchuser= $row['username'];
                            return $id;
                        }
                    }
                }
                ?>
    <?php
      if(isset($_POST['logout']))
        {
            session_destroy();
            header('location:index.php');

        }
        if(isset($_POST['changeprofile']))
        {
            header('location:profile.php');

        } 
       ?> 
    <nav>
        <div id="logo-img">
            <a href="#">
                <img src="images/logo.png" alt="Logo">
            </a>
        </div>
        <div id="menu-icon">
            <i class="fas fa-bars"></i>
        </div>
        <ul>
            <li>
                <a href="homepage.php">Home</a>
            </li>
            <li>
                <a href="create.php">Create an article</a>
            </li>
            <li>
                <a href="dashboard.php">Dashboard</a>
            </li>
            <li class = "dropdown">
                <button class = "dropbtn"><h3><?php echo $uname ?></h3><i class = "fa fa-caret-down"></i></button>
                <div class="dropdown-content">
                    <form action ="header.php" method = "post">
                        <input id = "logoutbtn" name = "logout" type = "submit" value ="Logout"/><br>
                        <input id = "logoutbtn" name = "changeprofile" type = "submit" value ="Editprofile"/><br>
                     </form>    
                </div> 
            </li>
            <li>
                <div id="search-icon">
                    <i class="fas fa-search"></i>
                    <form action ="header.php" method = "post">
                     <input type="text" name="search" placeholder="Search Here">
                     <a href="search.php?id=<?php searchfunc()?>"><input type="button" name="submit" value="Search"></a>
                    </form>
                </div> 
            </li>  
        </ul>
    </nav>        
    <?php
      if(isset($_POST['logout']))
        {
            session_destroy();
            header('location:index.php');

        }
      if(isset($_POST['changeprofile']))
        {
            header('location:profile.php');

        } 
       ?> 
</body>
</html>        