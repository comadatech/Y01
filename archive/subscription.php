<?php
   
//   //if session is not started then start the session
    if(!isset($_SESSION)) {
        session_start();
   }
   
    // uncomment to debug _SESSION values 
    //print_r($_SESSION);
  
    //include files
    require 'includes\config.php';
    include 'includes\library.php';
    include 'includes\constant.php';

    //let's set the labguage in the session variable
    $language = f_InitSessionLanguage();
    
    //let's set the laguage library
    f_SetLibraryLanguage($language);
    
    // Set the session activity
    f_SetSessionActivity(); 

?>

<html lang = "en">
   
   <head>
      <title>Yoga</title>
      <link href = "css/base.css" rel = "stylesheet">
      <link href = "css/divtable.css" rel = "stylesheet">
   </head>
   <body>
        <h1><?php echo f_GetCompagnyName(); ?></h1>
        <div id = "container">
            <?php
            
            //echo $_SESSION["personid"];
            
            if (isset($_SESSION["personid"]) && !empty($_SESSION['personid']))
            {
                $personid = $_SESSION['personid'];     

                $sql = "SELECT PersonID, firstname, lastname, password FROM person where PersonID = ".$personid;
                $result = $conn->query($sql);
                
                if ($result->num_rows > 0) 
                {
                                      
                    // output data of each row
                    while($row = $result->fetch_assoc()) 
                    {                       
                        echo "<div id=''>";
                        echo "<h2>"._SUBSCRIPTION."</h2>";
                        ?>
                        <div class="topnav">
                          <a class="active" href="#home"><?php echo _MENU_SUBSCRIPTION; ?></a>
                          <a href="subscribeto.php"><?php echo _MENUSUBSCRIBETO; ?></a>
                          <a href="schedule.php"><?php echo _MENU_SCHEDULE; ?></a>
                          <a href="myaccount.php"><?php echo _MENU_ACCOUNT; ?></a>
                          <a href="index.php"><?php echo _MENU_LOGOUT; ?></a>
                        </div>

                        <?php
                        echo '</br><h3>'._WELCOME." ".$row["firstname"]. " " . $row["lastname"]. "</h3><br></div>";
                    }


                    // execute the stored procedure
                    $sql = "CALL USP_GetPersonSubscription(".$personid.",'".$language."')";

                    //run the store proc
                    $result = mysqli_query($conn, $sql);                        

                    if ($result->num_rows > 0) 
                    {
                        echo _SUBCRIBRED_TO."</br></br></br>";

                        //display table header
                        echo 
                        "<div id='horaire' class='divTable'>"
                            . "<div class='divrow'>"
                                ."<div class='divHeader'>" 
                                    . _COL_ACTIVITYNAME
                                ."</div>"
                                ."<div class='divHeader'>" 
                                    ._COL_REGISTEREDDATE
                                ."</div>"                                     
                                ."<div class='divHeader'>" 
                                    ._COL_STARTDATE
                                ."</div>"                                        
                                ."<div class='divHeader'>" 
                                    ._COL_ENDDATE
                                ."</div>" 
                                ."<div class='divHeader'>" 
                                    ._COL_STARTTIME
                                ."</div>" 
                            ."</div>";                      

                        // output data of each row
                        while ($row = mysqli_fetch_array($result)){ 
                        //while($row = $resultSchedule->fetch_assoc()) 
                            // table content
                            echo 
                            "<div class='divrow'>"
                                ."<div class='divcell'>" 
                                    . $row["ActivityName".$language]
                                ."</div>"
                                ."<div class='divcell'>" 
                                    .$row["RegistrationDate"]
                                ."</div>"                                         
                                ."<div class='divcell'>" 
                                    .$row["StartDate"]
                                ."</div>"                                        
                                ."<div class='divcell'>" 
                                    .$row["EndDate"]
                                ."</div>"
                                ."<div class='divcell'>" 
                                    .$row["StartTime"]
                                ."</div>"
                            ."</div>";    
                        }
                        // table closure
                        echo "</div>";
                    }
                    else
                    {
                        echo "<div id='horaire'></br>"._NOACTIVIIES."<br></div>";
                    }
                } 
                else
                {
                    // set language library since the user cannot connect to database to get his/her language
                    if(isset($_SESSION['lang'])){
                        include 'includes/lang_'.$_SESSION['lang'].'.php'; 
                        echo "<div id='horaire'></br>"._WRONGPASSWORD."</div>";
                    }
                }                  
            }    
        ?>
        </div> <!-- /container -->
    </body>
</html>