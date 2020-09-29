<?php

   //if session is not started then start the session
    if(!isset($_SESSION)) {
        session_start();
   }

    //include files
    require 'includes\config.php';
    include 'includes\library.php';
    include 'includes\constant.php'; 
   
    /* If user click on language then change language 
    * by calling this page again but changing the session language
    */
    if(isset($_GET['language']) && !empty($_GET['language'])){
        
        $_SESSION['language'] = $_GET['language'];

        if(isset($_SESSION['language']) && $_SESSION['language'] != $_GET['language']){
            echo "<script type='text/javascript'> location.reload(); </script>";
        }
    }
   
    f_InitSessionVariable();
//    f_InitSessionLanguage();
    
    $language = f_GetSessionLanguage();
   
    f_SetLibraryLanguage($language);
    
    // Set the session activity
    f_SetSessionActivity(); 
    
    f_SetSessionActivity();
    
    $personid = f_GetPersonID();
    
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
        <script>
            
            function displayhidepass(){
                
                var i, x, bottontext;
                
                x = document.getElementsByClassName("hidepass");
                
                if(x.length>0){ 
                    
                    for (i = 0; i < x.length; i++) {
                                              
                        if(x[i].style.visibility == "collapse")
                        {
                            x[i].style.visibility  = "visible";
                            //bottontext = 'Hide pass classes';
                            bottontext = '<?php echo _HIDEPASSCLASSES; ?>';
                        }
                        else
                        {
                            x[i].style.visibility  = "collapse"; 
                            bottontext = '<?php echo _SHOWPASSCLASSES; ?>';
                        }
                        
                        document.getElementById('hiddisplaybutton').innerHTML = bottontext;
                    }
                }
            }     
        </script>
      
        <style>
            /*need to overrite the width as the default is too small*/
            .divHeader, .divCell{
                width:180px;
            } 
            
            .hidepass{
                background-color:#fff4e3; 
                visibility:visible;
                height:0px;
            }
                    
            .showpass{
                background-color:#FFF; 
                visibility:visible;
                height:30px;
             }      
             .button{
                 /*height:30px;*/
                 padding:4px;
                 float:left;
                 padding-left:20px;
                 padding-right:20px;
             }
             
            .subtitle::before{
                content:'\f29a';
                font-family: "FontAwesome";
                font-size:1em;
                padding-right: 10px;
            }
        </style>
   </head>
   <!-- must call the function on load, do not remove-->
   <body onload="displayhidepass();">
        <header>
            <?php 
            f_DisplayTopMenu();
            ?>
        </header>
        <?php echo f_DisplaySiteMenu(C_SCHEDULE, $personid); ?>
        <div id = "container">
            <div class="space_height_30"></div>
            <div class='subtitle'><?php echo _SCHEDULE; ?></div>
            <div id="content-wrap">
            <div id='horaire' class='divTable'>
                <button id='hiddisplaybutton' class='button' onclick="displayhidepass();">Show pass classes</button>
                <div class='space_height_30'></div>
            <?php 
            if ($personid > 0 )
            {

                // Let's display the complete scedule
                // execute the stored procedure
                $sql = "CALL USP_GetPersonSchedule(".$personid.",'".$language."')";

                //run the store proc
                $result = mysqli_query($conn, $sql);
                
               //echo date("m");

                //display table header
                echo 
//                "<div id='horaire' class='divTable'>"
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

                    //loop the result set
                    while ($row = mysqli_fetch_array($result)){
                        
                        //this is to dim the activity that it passed
                        if(date($row["Date"]) < date('Y-m-d', time())) {
                            $statetime = "hidepass";
                        }
                        else
                        {
                            $statetime = "showpass";
                        }
                        
                        // table content
                        echo 
                        "<div  class='divrow ".$statetime."'>"
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