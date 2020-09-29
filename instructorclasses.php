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
    $phonenumber        = '';
    $dateofbirth        = '';

    /* 4.If the user click on language link then switch language */
    if(isset($_GET['language']) && !empty($_GET['language'])){
        
        $_SESSION['language'] = $_GET['language'];

        if(isset($_SESSION['language']) && $_SESSION['language'] != $_GET['language']){
            echo "<script type='text/javascript'> location.reload(); </script>";
        }
    }
    
    /* 5.let's set the language in the session variable*/
    f_InitSessionVariable();

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
                display: table;
                width:fit-content;
                border: 1px solid #999999;
            }
            
            .divTableRow {
                display: table-row;
            }
 
                
            .divTableHead {
                /*border-top: 1px solid #999999;*/
                display: table-cell;
                padding: 13px 10px;
                text-align:left;
                font-size:1rem;
                height:40px;
            }                

            .divTableCell {
                border-top: 1px solid #999999;
                border-bottom: 1px solid #999999;
                display: table-cell;
                padding: 6px;
                padding-top: 8px;
                text-align: left;
                background-color: #fff4e3;
                font-weight: 600;
            }
                
            .divstudent{
                 width: 100%; 
                text-align: left;
                /* padding-left: 60px; */
                /* border: 1px solid red; */
                display: list-item;
                list-style-type:none;
                margin-left: 50px;
                margin-bottom: 10px;
                margin-top:10px;
                display:none;
            }
                
            .divstudentname{
                font-size:1rem;
                margin-bottom:6px;
            }
                
            .divstudentname::before{
                content:'\f2c0';
                font-family: "FontAwesome";
                /*vertical-align: middle;*/
                margin-right:6px;
            }
                
            .studentage{
                font-size:.6rem;
            }

/*                .divstudenttitle{
                    text-align: left;
                    border: none;
                    margin-left: 30px; 
                    font-weight: 700;
                    margin-top: 10px;
                    font-size: 1rem;
                }*/
                
            .divTableHeading {
                    background-color: #EEE;
                    display: table-header-group;
                    font-weight: bold;
            }
            
            .divTableFoot {
                    background-color: #EEE;
                    display: table-footer-group;
                    font-weight: bold;
            }
            
            .divTableBody {
                    display: table-row-group;
            }
                
            .divDetail{
                font-weight:600;
                padding-right:10px;
                margin-left:30px;
            }
                
            .leftalign{
                text-align: left;
            }

            .centeralign{
                text-align:center;
            }
            
            .alreadystarted{
                color:red;
                font-size:.7rem;
            }
            
            .upcoming{
                color:green;
                font-size:.7rem;  
            }
            
            input[type=checkbox] {
                display: none;
            }
            
            .displaystudent:checked ~ .divTable .divTableBody .divstudent {
                display: list-item;
           }

            input[type=checkbox] ~ label {
                /*position:relative;*/
                background: #fff4e3;
                /*height: 50px;*/
                /*color: #fff;*/
                padding: 16px;
                display: block;
                border-bottom: 1px solid #ffcdab;
                text-decoration: underline;
                cursor:pointer;
            }
            
            .subtitle::before{
                content:'\f073';
                font-family: "FontAwesome";
                font-size:1em;
                padding-right: 10px;
            }
            
        </style>
   </head>
   <body>
        <div class ="grid-container">
            <header>
                <?php f_DisplayTopMenu(); ?>
            </header>
            <div class='menu'>
                <?php f_DisplaySiteMenu(C_INSTRUCTORCLASSES,$personid); ?>
            </div>
            <div class="detail">
                <?php
                    $sql = "CALL USP_GetInstructorScheduleList(".$personid.",'".$language."')";

                    $result = mysqli_query($conn, $sql);
                    
                    $rowcount = mysqli_num_rows($result);
                    
                    if($rowcount == 0){
                        echo "<div class='space_height_30'></div>";
                        echo "<div class='message info'>"._MSG_NOCLASSES."</div>";
                        echo "</div>"; /*detail*/
                        echo "</div>"; /*grid-container*/                        
                        echo "<footer>";
                        echo f_DisplayFooter($language);
                        echo "</footer>";

                        die();
                    }
                ?>
                    <input id="toggle" type="checkbox" name="displaystudent" class="displaystudent"></input>
                    <label class="toggletext" for="toggle"><?php echo _SHOWHIDESTUDENT; ?></label> 
                <div class="space_height_30"></div>
                
                <div class='subtitle'><?php echo _MYCLASSES; ?></div>
                <!--<span class="container">-->
  
                <!--</span>-->
                    <div id='horaire' class='divTable'>
                        <div class="divTableHeading">
                        <?php
                            echo 
                             "<div class='divTableRow'>"             
                                ."<div class='divTableHead'>" 
                                    ._COL_ACTIVITYNAME
                                ."</div>"
                                ."<div class='divTableHead'>" 
                                    ._COL_DAY
                                ."</div>"                                   
                                ."<div class='divTableHead'>" 
                                    ._COL_TIME
                                ."</div>"
                                ."<div class='divTableHead'>" 
                                    ._COL_FREQUENCY
                                ."</div>" 
                                ."<div class='divTableHead'>" 
                                    ._COL_STARTDATE
                                ."</div>"  
                                ."<div class='divTableHead'>" 
                                    ._COL_ENDDATE
                                ."</div>"  
                                ."<div class='divTableHead'>" 
                                    ._COL_LOCATION
                                ."</div>"                                        
                            ."</div>"; 
                        echo "</div>"; /*end of divTableHeading*/
                        echo "<div class='divTableBody'>";
                        while ($row = mysqli_fetch_array($result)){
                            
                            $activityid         = $row["ActivityID"];
                            $PhoneNumber        = $row["PhoneNumber"];
                            $Email              = "<a href='mailto:".$row["Email"]."'>".$row["Email"]."</a>";

                            $starttime          = $row["StartTime"];
                            $starttime          = substr($starttime,0,5);
                            
                            $startdate          = $row['StartDate'];
                            $enddate            = $row["EndDate"];
                            $scheduletypename   = $row["ScheduleTypeName"];
                            $scheduledayname    = $row['ScheduleDayName'];
                            $activityname       = $row["ActivityName"];
                            $locationname       = $row["LocationName"];
                            
//                            echo $startdate.'<br>';
//                            echo date("Y-m-d");
                            
                            if($startdate<date("Y-m-d")){
                                $activityname = $activityname.'<span class="alreadystarted"> ('._COL_ALREADYSTARTED.')</span>';
                            }
                            
                            if($startdate>date("Y-m-d")){
                                $activityname = $activityname.'<span class="upcoming"> ('._UPCOMING.')</span>';
                            }                            
                            
                            $dateofbirth = $row["DateOfBirth"];
                            
                            if(strlen($dateofbirth)>0){
                                $newdateofbirth = new DateTime($dateofbirth); 
                                $today = new DateTime();
                                $age =$newdateofbirth->diff($today)->format("%y");
                                $student = "<div class='divstudentname'>".$row["Student"].' <span class="studentage">('.$age.")</span></div>";
                            }
                            else
                            {
                                $student = "<div class='divstudentname'>".$row["Student"]."</div>";
                            }


                            if(strlen($PhoneNumber) > 0){
                                $PhoneNumber = "<div><span><span class='divDetail'>Tel.:</span>".$PhoneNumber."</div>";
                            }
                            
                            if(strlen($Email) > 0){
                                $Email = "<span class='divDetail'>Email:</span>".$Email;
                            }                            
                            
                            if($activityid != $previousactivityid)
                            {
                                echo "<div  class='divTableRow'>"
                                    ."<div class='divTableCell leftalign'>" 
                                        .$activityname
                                    ."</div>"
                                     ."<div class='divTableCell leftalign'>" 
                                        .$scheduledayname
                                    ."</div>"  
                                     ."<div class='divTableCell centeralign'>" 
                                        .$starttime
                                    ."</div>"  
                                    ."<div class='divTableCell leftalign'>" 
                                        .$scheduletypename
                                    ."</div>"  
                                    ."<div class='divTableCell centeralign'>" 
                                        .$startdate
                                    ."</div>"                                                                              
                                    ."<div class='divTableCell centeralign'>" 
                                        .$enddate
                                    ."</div>" 
                                    ."<div class='divTableCell leftalign'>" 
                                        .$locationname
                                    ."</div>"                                        
                                ."</div>";  
                                
//                                echo "<div class='divTableRow'>"
//                                    ."<div class='divstudenttitle'>" 
//                                        ._COL_STUDENT."</br></br>"
//                                    ."</div>"
//                                ."</div>";                                   
                                
                                echo "<div class='divTableRow'>"
                                    ."<div class='divstudent'>" 
                                        .$student.$PhoneNumber.$Email
                                    ."</div>"
                                ."</div>";                                
                            }
                            else
                            {
                                echo "<div class='divTableRow'>"
                                    ."<div class='divstudent'>" 
                                        .$student.$PhoneNumber.$Email
                                    ."</div>"
                                ."</div>";
                            }
                            $previousactivityid = $activityid;
                        }
                        echo "</div>"; /* end of divTableBody*/
                    ?>
                </div>
            </div>
            <footer>
                <?php echo f_DisplayFooter($language); ?>
            </footer>
        </div> <!-- /grid-container -->
    </body>
</html>