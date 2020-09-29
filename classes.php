<?php
   
    //if session is not started then start the session
    if(!isset($_SESSION)) {
        session_start();
    }
   
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
    $disabled           = '';
    
    // Set Language variable
    if(isset($_GET['language']) && !empty($_GET['language'])){
        
        $_SESSION['language'] = $_GET['language'];

        if(isset($_SESSION['language']) && $_SESSION['language'] != $_GET['language']){
            echo "<script type='text/javascript'> location.reload(); </script>";
        }
    }
    
    //let's set the language in the session variable
    f_InitSessionVariable();
//    f_InitSessionLanguage();

    //let's set the laguage library
    $language = f_GetSessionLanguage();
    
    f_SetLibraryLanguage($language);
    
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
                background-color: #fff;            
            }
            
            div + .interspace{
                height:30px;
            }
      </style>
   </head>
   <body>
        <header>
            <?php 
            f_DisplayTopMenu();
            ?>
        </header>
        <?php f_DisplaySiteMenu(C_CLASSES,$personid); ?>
        <div id ="container">
            <div id="content-wrap">
                <?php  

                // execute the stored procedure
                $sql = "CALL USP_GetActivityScheduleList(".$personid.",'".$language."')";

                //run the store proc
                $result = mysqli_query($conn, $sql);                        

                if ($result->num_rows > 0) 
                {
                    // should not do the following should use CSS, will fix later
                    echo "<div class='note'>"._STAYINFORMED."</div>";

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

                        // displaying the activity price
                        $detail = "<div style='text-align:right;'>"
                                . "<span class='money'> $".$ActivityPrice."</span>";

                        if($TotalPaidAmount>0){
                            $detail .= "<br/><br/><b>Total Paid:</b> $".$TotalPaidAmount;
                        }        

                        // if not all paid then show the diff to pay
                        if($ActivityPrice <> $TotalPaidAmount && $AlreadyRegistered=='Y'){
                            $AmountDue = $ActivityPrice - $TotalPaidAmount;
                            $detail .= "<br/><span style='color:red;'>Total Due: $".$AmountDue."</span>";
                        }

                        // Is is alreay in the cart?
                        $IsInCart =  f_IsInCart($activityscheduleid);

                        if($IsInCart == 'Y'){
                            $disabled = ' disabled ';
                            $subscribe_buttontext = _INCART;
                            $bottomcss = ' style="background-color:#ffcdab; color:#fff" ';
                        }
                        else
                        { 
                            $disabled = '';
                            $subscribe_buttontext = _SUBSCRIBE;
//                            $bottomcss = ' style="background-color:green; color:#fff" ';
                            $bottomcss = "";
                        }

                        $detail .="</div>";
                        
                        if($AlreadyRegistered=='N'){
                            $detail .="<div>";
                                $detail .="<form role='form' action='cart.php' method='post' id='form1'>";
                                $detail .="<input type='hidden' name='selectedactivity' value='".$activityscheduleid."'></input>"; 
                                $detail .="<button type='submit' name='subscribe' class='button button1' ".$bottomcss." ".$disabled." >".$subscribe_buttontext."</button>";
                                $detail .="</form>";
                            $detail .="</div>";
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
                            $css = "style='background-color:#fff4e3;'";
                            f_ConcatMessage($note,_MSG_ALREADYSUBSCRIBED, $separator = '</br>');
                        }
                        else {
                            $css = "style=''";
                            f_ConcatMessage($note,"", $separator = '');
                        }

                        echo 
                        "<div class='interspace'></div><div id='class".$activityscheduleid."' class='divrow' ".$css.">"
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
            </div><!--end of content-wrap -->
        </div> <!-- /container -->
        <?php echo f_DisplayFooter($language); ?>
    </body>
</html>