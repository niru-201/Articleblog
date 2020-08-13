<?php
    require_once('db/config.php');
    include ('header.php');
    $uname = $_SESSION['username'];
    //session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YOURBLOG</title>
    <link rel="stylesheet" href ="styles/create.css">
    <script src="ckeditor/ckeditor/ckeditor.js" ></script>
    <script src="//cdn.ckeditor.com/4.11.1/standard/ckeditor.js"></script>
</head>
<body style="background-color:white">
 <div id="mains">
     <br><br><br><br>
        <h2 style= "text-align:center">NEW ARTICLE</h2>
         
        <form class ="articleform" action="create.php" name = "article" method="post" enctype="multipart/form-data">
            <label>Title</label><br>
            <input type="text" name="title" class="inputval" required /><br>
            <label>Select image to upload:</label><br>
            <input type='file' class ="file" name='file' required /><br>
            <label>
            <input type='checkbox' value='Upload' name='but_upload'/>Upload</label><br>
            <label>Body</label><br>
            <textarea class='ckeditor' name='descrp' style='font-size:20px;' ></textarea><br>
            <label>
              <input type="checkbox" name="publish" /> Publish
            </label><br>
            <a href = "dashboard.php"><input name="submitbtn" type="submit" id="confirmbtn" value="SUBMIT"/></a>
            <input name="resetbtn" type="reset" id="confirmbtn" value="RESET"/><br>
            <a href ="homepage.php" ><input type="button" id="backbtn" value ="Back"/></a>  
          
        </form>

 </div> 
</body>   
    <?php
   $con = mysqli_connect('localhost','root','','artidb');
   function dataready($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
} 
 
      if(isset($_POST['submitbtn'])){
         
          if(isset($_POST['but_upload']) && isset($_POST['submitbtn'])){
            $datecr = date('Y-m-d');
  
            $name = $_FILES['file']['name'];
            $target_dir = "upload/";
            $target_file = $target_dir . basename($_FILES["file"]["name"]);
          
            // Select file type
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
          
            // Valid file extensions
            $extensions_arr = array("jpg","jpeg","png","gif");
          
            // Check extension
            if( in_array($imageFileType,$extensions_arr) ){
           
               // Insert record
               $query = "INSERT INTO images_tbl(images_path,submission_date) values('".$name."','".$datecr."')";
               mysqli_query($con,$query);
            
               // Upload file
               move_uploaded_file($_FILES['file']['tmp_name'],$target_dir.$name);
          
            }
      }
      createdata();
    }
  function createdata(){
    $con = mysqli_connect('localhost','root','','artidb');
    $articleno = $_SESSION['articleno'];
   $title = $_POST['title'];
   $datecr = date('Y-m-d');
   $uname = $_SESSION['username'];
   $descrp = dataready($_POST['descrp']);
   $descrp = html_entity_decode($descrp);
   if($title&&$descrp){
       $sql = "INSERT INTO articlecreated(username,title,timei,datecr,descrp) VALUES('".$uname."','".$title."',now(),'".$datecr."','".$descrp."')";
       if(mysqli_query($con,$sql)){
        echo'<script type="text/javascript">
        alert("Submitted successfully")</script>';
       }
       else{
        echo'<script type="text/javascript">
        alert("error in submitting")</script>';
       }
   }
   else{
    echo'<script type="text/javascript">
     alert("provide all info")</script>';
   }
  } 
?> 
<?php
  $con = mysqli_connect('localhost','root','','artidb');
   $articleno = $_SESSION['articleno'];
   if(isset($_POST['submitbtn'])){
     if(isset($_POST['publish'])){
     $articleno++; 
    $title = $_POST['title'];
   $datecr = date('Y-m-d');
   $descrp = dataready($_POST['descrp']);
   $descrp = html_entity_decode($descrp);

    if($title&&$descrp){
        $sql = "INSERT INTO posts(username,title,timei,datecr,descrp) VALUES('".$uname."','".$title."',now(),'".$datecr."','".$descrp."')";
        $sql2= "UPDATE userinfo SET articleno = '$articleno' WHERE username='$uname'";
        if(mysqli_query($con,$sql))
           { echo'<script type="text/javascript">
            alert("Published successfully")</script>';
            $_SESSION['articleno']=$articleno;
            if(mysqli_query($con,$sql2))
            {echo'<script type="text/javascript">
            alert("Articleno updated")</script>';}
            else
                echo "error in updating articleno";   
           }
        
        else{
            echo "error in inserting";
        }
    }
    else{
        echo'<script type="text/javascript">
        alert("provide all info")</script>';  
    }

  
  if(isset($_POST['but_upload']) && isset($_POST['publish'])){
    $datecr = date('Y-m-d');
   $name = $_FILES['file']['name'];
    $target_dir = "upload/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
  
    // Select file type
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  
    // Valid file extensions
    $extensions_arr = array("jpg","jpeg","png","gif");
  
    // Check extension
    if( in_array($imageFileType,$extensions_arr) ){
   
       // Insert record
       $query = "INSERT INTO postimages_tbl(images_path,submission_date) values('".$name."','".$datecr."')";
       mysqli_query($con,$query);
    
       // Upload file
       move_uploaded_file($_FILES['file']['tmp_name'],$target_dir.$name);
  
    }
  } 
}
     }
  
   include ('footer.php');
   ?>
</html>