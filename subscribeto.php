<?php
   
//   //if session is not started then start the session
    if(!isset($_SESSION)) {
        session_start();
   }
   
    //   $_SESSION["CartCount"] ++;

    // uncomment to debug _SESSION values 
    //print_r($_SESSION);
  
    //include files
    require 'includes\config.php';
    include 'includes\library.php';
    include 'includes\constant.php';
    
    if (isset($_SESSION["personid"]) && !empty($_SESSION['personid']))
    {
        $personid = $_SESSION['personid']; 
    }
    else
    {
        $personid = 0;
    }

    //let's set the language in the session variable
    $language = f_SetSessionLanguage();
    
    $css                = "";
    $note               = "";
    $detail             = "";
    $ActivityPrice      = 0.00;
    $TotalPaidAmount    = 0.00;
    $AmountDue          = 0.00;
    $AlreadyRegistered  = 'N';
    $AlreadyStarted     = 'N';
    $Location           = "";
    $RowNumber          = 0;
    $IsInCart           = false;
    $disabled            = '';

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
        <link href = "font-awesome/css/font-awesome.min.css" rel="stylesheet" >
        <link href = "css/header.css" rel = "stylesheet">
        <style>
            /*need to overrite the width as the default is too small*/
            .divHeader, .divCell{
                width:300px;
            } 
            .divHeader{
                height:34px;
            }
            .divcell{
                line-height: 20px;
                /*height:124px;*/
                border:none;
            }
           .divcell:first-child {
                width:140px !important;
            }
            
            strong{font-size: 16px;}
            
            .divRow{
                border: 1px solid #4caf50;
                background-color: #4caf501c;
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
            <?php
            // Display only when not login.
            if ($personid == 0){
                f_DisplaySiteMenu(C_CLASSES);
            }
            
            if ($personid > 0)
            {    

                $sql = "SELECT PersonID, firstname, lastname, password FROM person where PersonID = ".$personid;
                $result = $conn->query($sql);
                
                if ($result->num_rows > 0) 
                {
                                      
                    // output data of each row
                    while($row = $result->fetch_assoc()) 
                    {                       
                        echo "<div id=''>";
                        ?>
                        <div class="topnav">
                         
                          <a class="active"><?php echo _MENUCLASSES; ?></a>
                          <a href="schedule.php"><?php echo _MENUSCHEDULE; ?></a>
                          <a href="profile.php"><?php echo _MENUPROFILE; ?></a>
                        </div>

                        <?php
                        //echo '</br><h3>'._WELCOME." ".$row["firstname"]. " " . $row["lastname"]. "</h3><br></div>";
                    }

                }
            }    
            // execute the stored procedure
            $sql = "CALL USP_GetActivityScheduleList(".$personid.",'".$language."')";

            //run the store proc
            $result = mysqli_query($conn, $sql);                        

            if ($result->num_rows > 0) 
            {
                // should not do the following should use CSS, will fix later
                echo "</br></br></br>";

                //display table header
                echo "<div id='horaire' class='divTable'>";


                // output data of each row
                while ($row = mysqli_fetch_array($result)){ 

                    //resetting value at every row
                    $note               ="";
                    $ActivityPrice      = $row["ActivityPrice"];
                    $TotalPaidAmount    = $row["TotalPaidAmount"];
                    $AlreadyRegistered  = $row["AlreadyRegistered"];
                    $AlreadyStarted     = $row["AlreadyStarted"];
                    $Location           = $row["Location"];
                    $activityscheduleid = $row["activityscheduleid"];
                    $image              = $row["image"];
                    $RowNumber ++;
                    
                    $IsInCart =  f_IsInCart($activityscheduleid);
                    
                    if($IsInCart==true){
                        $disabled = 'disabled style="color:red"';
                        
                    }
                    else
                    { $disabled = '';}
                    
//                    echo  $disabled;

                    if($ActivityPrice > 0){
                        $detail = "<div style='text-align:right;'><span style='font-size:20px; color:green; font-weight:900'> $".$ActivityPrice."</span>";
                    }

                    if($TotalPaidAmount>0){
                        $detail .= "<br/><br/><b>Total Paid:</b> $".$TotalPaidAmount;
                    }        

                    if($ActivityPrice <> $TotalPaidAmount && $AlreadyRegistered=='Y'){
                        $AmountDue = $ActivityPrice - $TotalPaidAmount;
                        $detail .= "<br/><span style='color:red'>Total Due: $".$AmountDue."</span>";
                    }
                    else
                    {
                        $detail .="<form role='form' action='payments.php' method='post' id='form1'>";
                        $detail .="<input type='hidden' name='selectedactivity' value='".$activityscheduleid."'></input>";
                        $detail .="<button type='submit' name='subscribe' ".$disabled." class='button button1' style='padding: 10px 32px; margin-left: 30px;'>"._REGISTER."</button>";
                        $detail .="</div></form>";
                    }
                    
                    if ($AlreadyStarted=='Y'){
                        $AlreadyStartedChecked = "checked";
                        $note = '<span style="color:red">'._COL_ALREADYSTARTED."</span>";
                    }
                    else{
                        $AlreadyStartedChecked = "";
                        $note = "";
                    }

                    if($AlreadyRegistered=='Y'){
                        $css = "style='background-color:#EBEBEB;'";
                        f_ConcatMessage($note,_MSG_ALREADYSUBSCRIBED, $separator = '</br>');
                    }
                    else {
                        $css = "style=''";
                        f_ConcatMessage($note,"", $separator = '');
                    }
                    echo 
                    "<br/><div class='divrow' ".$css.">"
                        ."<div class='divcell'>" 
                            .$note."<br/><img src='images/".$image."' style='width:140px; height:120px'>"
                        ."</div>"                              
                        ."<div class='divcell'>" 
                            . $row["ScheduleDescription"].'<br/><br/><b>Location:</b> '.$Location
                        ."</div>"                                       
                        ."<div class='divcell'>" 
                            . $detail
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
        ?>
        </div> <!-- /container -->
    </body>
</html>