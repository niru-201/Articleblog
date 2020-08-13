<?php

function createdb(){
$servername = "localhost";
$usename = "root";
$pword = "";  
$dbname = "artidb";

$con = mysqli_connect($servername, $usename, $pword);

    // Check Connection
    if (!$con){
        die("Connection Failed : " . mysqli_connect_error());
        echo "conerror";
    }
$sql1 = "CREATE DATABASE IF NOT EXISTS $dbname";
if(mysqli_query($con,$sql1)){
    $con = mysqli_connect($servername,$usename,$pword,$dbname);
    //echo "db ceated";
    $sql2 = "CREATE TABLE IF NOT EXISTS userinfo(
        userid INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(24) NOT NULL,
        passwordu VARCHAR(24) NOT NULL,
        articleno INT(11) NOT NULL,
        followers INT(11) NOT NULL,
        followingno INT(11)
    )";
    if(mysqli_query($con,$sql2)){
       //echo "usert created";
    }   
    else
       { echo "error in creating table user";    
       }   
    $sql3="CREATE TABLE IF NOT EXISTS articlecreated(
        username VARCHAR(24) NOT NULL ,
        artid INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(75) NOT NULL,
        timei TIME NOT NULL,
        datecr DATE,
        descrp VARCHAR(70000)
    )";
    
    if(mysqli_query($con,$sql3)){

    }
       // echo "created invitt";
    else
        echo "error in creating table articlecreated";  

    $sql4= "CREATE TABLE IF NOT EXISTS images_tbl(
        images_id INT NOT NULL AUTO_INCREMENT,
        images_path VARCHAR(200) NOT NULL,
        submission_date DATE,
        PRIMARY KEY (images_id)
     )";  
     if(mysqli_query($con,$sql4)){

     }
     //echo "created imgtbl";
     else
     echo "error in creating table images_tbl";

     $sql5="CREATE TABLE IF NOT EXISTS posts(
        username VARCHAR(24) NOT NULL ,
        artid INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(75) NOT NULL,
        timei TIME NOT NULL,
        datecr DATE,
        descrp VARCHAR(70000)
    )";
    
    if(mysqli_query($con,$sql5)){

    }
       // echo "created invitt";
    else
        echo "error in creating table articlecreated";  

    $sql6= "CREATE TABLE IF NOT EXISTS postimages_tbl(
        images_id INT NOT NULL AUTO_INCREMENT,
        images_path VARCHAR(200) NOT NULL,
        submission_date DATE,
        PRIMARY KEY (images_id)
     )";  
     if(mysqli_query($con,$sql6)){

     }
     //echo "created imgtbl";
     else
     echo "error in creating table images_tbl";
     $sql7 = "CREATE TABLE IF NOT EXISTS tbl_follow(
        follow_id int(11) NOT NULL AUTO_INCREMENT,
        sender_id int(11) NOT NULL,
        receiver_id int(11) NOT NULL,
        PRIMARY KEY (follow_id)
      )"; 
     if(mysqli_query($con,$sql7)){

    }
    //echo "created imgtbl";
    else
    echo "error in creating table tbl_follow";
}
else
       echo "error".mysqli_error($con);      

       //mysql_close($con); 
}
createdb();
?>