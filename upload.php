<?php

   //if session is not started then start the session
    if(!isset($_SESSION)) {
        session_start();
   }
   
    //include files
    include 'includes\library.php';
    
    $instructorid = f_GetPersonID();
    
//upload.php
if($_FILES["file"]["name"] != '')
{
    $test = explode('.', $_FILES["file"]["name"]);
    $ext = end($test);
    //$name = rand(100, 999) . '.' . $ext;

    $name= 'instructor_'.$instructorid. '.'. $ext;
    $location = './instructorspicture/' . $name;  
    move_uploaded_file($_FILES["file"]["tmp_name"], $location);

    echo '<img src="'.$location.'?'.time().'" class="img-thumbnail" id="img" />';
} 
?>