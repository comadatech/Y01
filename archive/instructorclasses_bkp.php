<?php

/* 
 * This is page template, all page shoud start with the followin php and some basic 
 * HTML as display on this page.
 */
   
    //if session is not started then start the session
    /* 1. Start Session */
    if(!isset($_SESSION)) {
        session_start();
    }
   
    /* 2. include files*/
    require 'includes\config.php';
    include 'includes\library.php';
    include 'includes\constant.php';
    
    /* 3. Declare variabled and set default values*/
    $previousactivityid = 0;

    /* 4.If the user click on language link then switch language */
    if(isset($_GET['language']) && !empty($_GET['language'])){
        
        $_SESSION['language'] = $_GET['language'];

        if(isset($_SESSION['language']) && $_SESSION['language'] != $_GET['language']){
            echo "<script type='text/javascript'> location.reload(); </script>";
        }
    }
    
    /* 5.let's set the language in the session variable*/
    f_InitSessionLanguage();

    /* 6. Get the session language*/
    $language = f_GetSessionLanguage();
    
    /* 7.let's set the laguage library */
    f_SetLibraryLanguage($language);
    
    /* 8.Start the activity pool*/
    f_SetSessionActivity();
    
    /* 9. Get the personid*/
    $personid = f_GetPersonID();

?>
<html lang = "en">
   <head>
        <title>Yoga</title>
        <link href = "css/base.css" rel = "stylesheet">
        <link href = "css/divtable.css" rel = "stylesheet">
        <link href = "font-awesome/css/font-awesome.min.css" rel="stylesheet" >
        <link href = "css/header.css" rel = "stylesheet">
        <style>
           .grid-container {
               height:100%;
                display: grid;
                grid-template-columns: 1fr 1fr 1fr 1fr;
                grid-template-rows: 50px max-content auto 130px;
                gap: 1px 1px;
                grid-template-areas:
                  "header header header header"
                  "menu menu menu menu"
                  "detail detail detail detail"
                  "footer footer footer footer";
              }

              header { grid-area: header; }

              .menu { grid-area: menu; }

              .detail { 
                  grid-area: detail; 
              }

              footer { 
                  grid-area: footer; 
                  background-color: #ddd;
              }
              
              /*DIV TABLE*/
              
              .divTable{
                  /*display: block;*/
              }
              
              .divcell > .divrow{
                  border:1px solid black;
              }
              
              .divcell{
                  border:none;
              }
              
              .divHeader{
                  border:none;
              }

        </style>
   </head>
   <body>
        <div class ="grid-container">
            <header>
                <?php f_DisplayTopMenu(); ?>
            </header>
            <div class='menu'>
                <?php f_DisplaySiteMenu(C_CLASSES,$personid); ?>
            </div>
            <div class="detail">
                <?php
                    $sql = "CALL USP_GetInstructorScheduleList(".$personid.",'".$language."')";

                    $result = mysqli_query($conn, $sql);
                ?>
                <div class="space_height_30"></div>
                <div id='horaire' class='divTable'>
                    
                    <?php
                        echo 
                         "<div class='divrow'>"             
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
                        
                        while ($row = mysqli_fetch_array($result)){
                            
                            $activityid = $row["ActivityID"];
                            
                            if($activityid != $previousactivityid)
                            {
                                echo "<div  class='divrow' style='display:flex'>"
                                    ."<div class='divcell'>" 
                                        . $row["ActivityName"]
                                    ."</div>"
                                    ."<div class='divcell'>" 
                                        .$row["StartDate"]
                                    ."</div>"                                        
                                     ."<div class='divcell'>" 
                                        .$row["StartTime"]
                                    ."</div>"                                        
                                     ."<div class='divcell'>" 
                                        .$row["LocationName"]
                                    ."</div>"                                        
                                ."</div>";  
                                
                                echo "<div class='divrow' style='display:flex'>"
                                    ."<div class='divcell'>" 
                                        ._COL_STUDENT.": ".$row["Student"]
                                    ."</div>"
                                ."</div>";                                
                            }
                            else
                            {
                                echo "<div class='divrow' style='display:flex'>"
                                    ."<div class='divcell'>" 
                                        ._COL_STUDENT.": ".$row["Student"]
                                    ."</div>"
                                ."</div>";
                            }
                            $previousactivityid = $activityid;
                        }
                    ?>
                </div>
            </div>
            <footer>
                <?php echo f_DisplayFooter($language); ?>
            </footer>
        </div> <!-- /grid-container -->
        
    </body>
</html>