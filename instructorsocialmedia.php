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
    $socialmediaidlist = "";
    $msg = "";
    
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
    
        //The page has been submitted
    if (isset($_POST['socialmediaid']) && !empty($_POST['socialmediaid']) && $personid > 0)
    {
        $posted = true;
        
        $count=count($_POST["socialmediaid"]);
        
//        echo $count;
        
        for($i=0;$i<$count;$i++){
        
            $socialmediaid              = $_POST['socialmediaid'][$i];
            $instructorsocialmediaid    = $_POST['instructorsocialmediaid'][$i];
            $socialmediaurl             = $_POST['socialmediaurl'][$i];
            $display                    = $_POST['display'][$i];
           
            if(strtolower($display)=='oui' || strtolower($display)=='yes'){
                $display = 'Y';  
            }
            else{
                $display = 'N';
            }

            
            // This is an update
            if($instructorsocialmediaid > 0 && $socialmediaid > 0){
                $sqlupdate = "Update instructorsocialmedia"
                        . " set SocialMediaID = $socialmediaid,"
                        . " URL= '$socialmediaurl',"
                        . " ActiveIND = '$display'"
                        . " where InstructorID = $personid"
                        . " and instructorsocialmediaid = $instructorsocialmediaid";
                
//                echo $sqlupdate;
                
//                $result1 = mysql_query($sqlupdate);
                
                if ($conn->query($sqlupdate) === TRUE) 
                {
                    $msg = _MSG_SAVE_SUCCESS; 
                    $savesuccessfull = true;
                } 
                else 
                {
                  $msg = "Error updating record: " . $conn->error;
                  $savesuccessfull = false;
                }   
            }
            
            
            // This is an insert
            if($instructorsocialmediaid ==0 && $socialmediaid > 0 )
            {
                // Must determin if it is an UPDATE or an INSERT
                $sql = "Insert into instructorsocialmedia(SocialMediaID,InstructorID, URL, ActiveIND) "
                        . "VALUES ($socialmediaid, $personid, '$socialmediaurl','$display')";

               if(mysqli_query($conn, $sql)){
//                    echo "Records added successfully.";
                   $smg = _MSG_SAVE_SUCCESS;
                   $savesuccessfull = true;
                } else{
                    $msg = "ERROR: Not able to execute $sql. " . mysqli_error($conn);
                    $savesuccessfull = false;
                }
            }
        }
    }
?>
<html lang = "en">
   <head>
        <title>Yoga</title>
        <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
        <meta http-equiv="Pragma" content="no-cache" />
        <meta http-equiv="Expires" content="0" />
        <link href = "css/base.css" rel = "stylesheet">
        <link href = "font-awesome/css/font-awesome.min.css" rel="stylesheet" >
        <link href = "css/header.css" rel = "stylesheet">
        <script>
            function HideMessage(){
                //setTimeout(function () { document.getElementById('message').style.display='none';}, 9000);
                document.getElementById('message').style.display='none';
            }
            
            function f_switch(){

               document.getElementById('message').style.display='none';
                
                object = this;
                
               if(object.value == '<?php echo _NO;?>' ){
                   object.value = '<?php echo _YES;?>';
                   object.className = 'checked';
               }
               else{
                   object.value = '<?php echo _NO;?>';
                   object.className = 'unchecked';
               }                
            }
        </script>
        <style>
            /*DIV TABLE*/
            
            .container{
                background-color: #fff;
            }

            .divTable{
                display: table;
                width:100%;
                border: 1px solid #999999;
            }
            
            .divTableRow {
                display: table-row;
                height:30px;
            }
            
            .divTableRow:nth-child(even) {
                background-color: #fff4e3;
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
                /*background-color: #fff4e3;*/
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
                margin-top:20px;
            }
                
            button{
                padding-left:10px;
                padding-right:10px;
            }

                
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
                
                
            .leftalign{
                text-align: left;
            }

            .centeralign{
                text-align:center;
            }
            
/*            .checked input[type='text'], select, button{
                height:30px;
            }*/
            
             input[type='text'], select, .checked button{
                height:30px;
            }            
            

            
            .checked{
                border:1px solid black;
                border-radius:20px;
                width:60px;
                background-color:#addaff;
                text-align: center;
                cursor: pointer;
                box-shadow: 5px 5px 5px rgba(163, 160, 163, 0.8) inset; 
                -webkit-box-shadow: 5px 5px 5px rgba(163, 160, 163, 0.8) inset; 
                -moz-box-shadow: 5px 5px 5px rgba(163, 160, 163, 0.8) inset; 
            }
            
            .unchecked{
                border:1px solid black;
                border-radius:20px;
                width:60px;
                background-color:#c3c3c3;
                text-align: center;
                cursor: pointer;
                box-shadow: 5px 5px 5px rgba(163, 160, 163, 0.8)  ; 
                -webkit-box-shadow: 5px 5px 5px rgba(163, 160, 163, 0.8)  ; 
                -moz-box-shadow: 5px 5px 5px rgba(163, 160, 163, 0.8)  ; 
            }
            
            textarea:focus, input:focus{
                outline: none;
            }
            
            .subtitle::before{
                content:'\f0c1';
                font-family: "FontAwesome";
                font-size:1em;
                padding-right: 10px;
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
        <div class="container">
            <?php
            if (strlen($msg) > 0){
                if($savesuccessfull){
                    echo f_DisplayMessage($msg, 'info');
                }
                else
                {
                    echo f_DisplayMessage($msg, 'warning');
                }
            } 
            else
            {
                //this is needed here otherwise the yes and no button will not work on frsh retreieve of page
                echo "<div id='message'></div>";
            }
            ?>
            <div class="subtitle"><?php echo _INSTRUCTORSOCIAL; ?></div>
            <div id="" class="subcontainer">
                <form method="post" action="" enctype="multipart/form-data" id="myform">
                    <div id='horaire' class='divTable'>
                        <div class="divTableHeading">
                        <?php
                            echo 
                             "<div class='divTableRow'>"             
                                ."<div class='divTableHead'>" 
                                ."</div>"
                                ."<div class='divTableHead'>" 
                                    ._COL_SOCIALMEDIANAME
                                ."</div>"
                                ."<div class='divTableHead'>" 
                                    ._COL_SOCIALMEDIAURL
                                ."</div>"                                   
                                ."<div class='divTableHead' style='text-align:center'>" 
                                    ._COL_ACTIVEIND
                                ."</div>"                                    
                                ."<div class='divTableHead'>" 
                                    .""
                                ."</div>"    
                            ."</div>"; 
                        echo "</div>"; /*end of divTableHeading*/
                        echo "<div class='divTableBody'>";
                        //lets display the rows from the database
                        
                            $sqlmediarow = "select InstructorSocialMediaID"
                                            .",instructorsocialmedia.SocialMediaID"
                                            .",InstructorID"
                                            .",URL"
                                            .",instructorsocialmedia.ActiveIND"
                                            .",SocialMediaName"
                                            .",SocialMediaSmallIcon"
                                            .",SocialMediaLargeIcon"
                                            .",FontAwesomeCode"
                                            ." from instructorsocialmedia"
                                            ." left join socialmedia"
                                            ." on instructorsocialmedia.SocialMediaID = socialmedia.SocialMediaID"
                                            ." where (instructorsocialmedia.DeactivatedByUserID is null or instructorsocialmedia.DeactivatedByUserID = 0)"
                                            ." and InstructorID = $personid";
                        
                            $result = $conn->query($sqlmediarow);
                
                            if ($result->num_rows > 0) 
                            {
                                // output data of each row
                                while($row = $result->fetch_assoc()) 
                                {   
                                    $instructorsocialmediaid    = $row['InstructorSocialMediaID'];
                                    $socialmedianame            = $row['SocialMediaName'];
                                    $socialmediaid              = $row['SocialMediaID'];
                                    $url                        = $row['URL'];
                                    $activeind                  = $row['ActiveIND'];
                                    
                                    //this will remove the ones already added from the dropdown list
                                    if(strlen($socialmediaidlist)>0){
                                       $socialmediaidlist .= ",".$socialmediaid; 
                                    }
                                    else
                                    {
                                       $socialmediaidlist = $socialmediaid;  
                                    }
                                    
                                    if($activeind=='Y'){
                                        $activeind = _YES;
                                        $class = "class='checked'";
                                    }
                                    else
                                    {
                                        $activeind  = _NO;
                                        $class = "class='unchecked'";
                                    }
                                    
                                    echo "<div  class='divTableRow'>"
                                        ."<div class='divTableCell leftalign'>" 
                                            ."<input type='hidden' name='instructorsocialmediaid[]'  value='$instructorsocialmediaid'>"
                                        ."</div>"
                                        ."<div class='divTableCell leftalign'>" 
                                            .$socialmedianame
                                            ."<input type='hidden' name='socialmediaid[]' value='$socialmediaid'>"
                                        ."</div>"
                                        ."<div class='divTableCell leftalign'>" 
                                            ."<input type='text' style='width:500px' name='socialmediaurl[]' value='$url' onclick='HideMessage();'>"
                                        ."</div>"  
                                        ."<div class='divTableCell centeralign'>"
                                            ."<input type='text' $class name='display[]' value='$activeind' onclick='f_switch.call(this)' readonly>"
                                        ."</div>"
                                        ."<div class='divTableCell centeralign'>" 
//                                            ."<button style='button' value='modify'>Save</button>"
                                        ."</div>"
                                ."</div>";
                                }
                            }
                        
                            $activeind = _YES;
                            $class = " class='checked' ";
                                
                            //Let's add a new row for inserting a new social media link
                            echo "<div  class='divTableRow'>"
                                    ."<div class='divTableCell leftalign'>" 
                                            ."<input type='hidden' name='instructorsocialmediaid[]' value='0'></input>"
                                        ."</div>"
                                    ."<div class='divTableCell leftalign'>" 
                                        .f_GetSocialMediaList($socialmediaidlist)
                                    ."</div>"
                                    ."<div class='divTableCell leftalign'>" 
                                        ."<input type='text' style='width:500px' name='socialmediaurl[]'></input>"
                                    ."</div>"  
                                    ."<div class='divTableCell centeralign'>" 
                                        ."<input type='text' $class name='display[]' value='$activeind' onclick='f_switch.call(this)' readonly></input>"
                                    ."</div>"
                                    ."<div class='divTableCell leftalign'>" 
//                                        ."<button style='button' value='Save'>Save</button>"
//                                        ."<button type='submit' name='Submit' value='Submit' class='button button1'>"._SAVE."</button>"
                                    ."</div>"
                            ."</div>"
                        . "</div>"
                    . "</div>";
                    
                    echo "<div class='buttonright'>";
                    echo "<button type='submit' name='Submit' value='Submit' class='button button1'>"._SAVE."</button>";
                    echo "</div>"
            ?>  
                </form>
            </div><!--end of content-wrap -->
        </div> <!-- /container -->
        <?php echo f_DisplayFooter($language); ?>
    </body>
</html>