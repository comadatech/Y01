<?php

   //if session is not started then start the session
    if(!isset($_SESSION)) {
        session_start();
   }

    //include files
    require 'includes\config.php';
    include 'includes\library.php';
    include 'includes\constant.php'; 
   
    //let's set the labguage in the session variable
    $language = f_SetSessionLanguage();
    
    //let's set the laguage library
    f_SetLibraryLanguage($language);
    
    // Set the session activity
    f_SetSessionActivity(); 
    
    // Declare variable
   $passactivitystyle = "";
   
?>

<html lang = "en">
   
   <head>
      <title>Yoga</title>
      <link href = "css/base.css" rel = "stylesheet">
      <link href = "css/divtable.css" rel = "stylesheet">
        <link href = "font-awesome/css/font-awesome.min.css" rel="stylesheet" >
        <link href = "css/header.css" rel = "stylesheet">      
      <style>
            /*need to overrite the width as the default is too small*/
            .divHeader, .divCell{
                width:180px;
            } 
      </style>
   </head>
   <body>
        <header>
            <?php 
            f_DisplayHeader();
            ?>
        </header>
        <div id = "container">
            <div id="content-wrap">
            <?php 
            if ($_SESSION['personid'] > 0 )
            {
                
                // get and set personid
                if ($_SESSION['personid'] > 0 ) {
                    $personID = $_SESSION['personid'];
                }      
                ?>
                <div class="topnav">
                  <a href="subscribeto.php"><?php echo _MENUCLASSES; ?></a>
                  <a href="" class="active"><?php echo _MENUSCHEDULE; ?></a>
                  <a href="profile.php"><?php echo _MENUPROFILE; ?></a>
                </div>
                </br></br>
                <?php
                  
                // Let's display the complete scedule
                // execute the stored procedure
                $sql = "CALL USP_GetPersonScedule(".$personID.",'".$language."')";

                //run the store proc
                $result = mysqli_query($conn, $sql);

                //display table header
                echo 
                "<div id='horaire' class='divTable'>"
                    . "<div class='divrow'>"
                        ."<div class='divHeader'>" 
                            . _COL_ACTIVITYNAME
                        ."</div>"
                        ."<div class='divHeader'>" 
                            . "Date"
                        ."</div>"                                    
                        ."<div class='divHeader'>" 
                            . _COL_TIME
                        ."</div>"
                        ."<div class='divHeader'>" 
                            ._COL_LOCATION
                        ."</div>"                                        
                    ."</div>";                               

                    //loop the result set
                    while ($row = mysqli_fetch_array($result)){
                        
                        //this is to dim the activity that it passed
                        if(date($row["Date"]) < date('Y-m-d', time())) {
                            $passactivitystylerow = " style='background-color:#EBEBEB; ' ";
                        }
                        else
                        {
                            $passactivitystylerow = "";
                        }
                        
                        // table content
                        echo 
                        "<div class='divrow' ".$passactivitystylerow.">"
                            ."<div class='divcell'>" 
                                . $row["ActivityName"]
                            ."</div>"
                            ."<div class='divcell'>" 
                                .$row["ActivityDate"]
                            ."</div>"                                        
                             ."<div class='divcell'>" 
                                .$row["StartTime"]
                            ."</div>"                                        
                             ."<div class='divcell'>" 
                                .$row["LocationName"]
                            ."</div>"                                        
                        ."</div>";                               

                    }                                   
            }    
        ?>
        </div>
        </div> <!-- /container -->
    </body>
    
</html>