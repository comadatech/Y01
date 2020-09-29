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
    
    $personid = f_GetPersonID();
   
  
    // Declare variables
    $msg            = "";
    $posted         = false;
    $competencyfra  = "";
    $competencyeng  = "";
    $biofra         = "";
    $bioeng         = "";
    $persontypename = f_GetPersonInfo($personid, $language, 'PersonTypeName');
    $savesuccessfull = false;
    
    if ($personid == 0){
        //no personid from session? we should not go anywhere exept go back to login page 
        echo '<script type="text/javascript"> window.location.href = "index.php" </script>';
    }
   
    //The page has been submitted
    if (isset($_POST['personid']) && !empty($_POST['personid']))
    {
        $posted = true;
       
        // get all posted values 
        $competencyfra  = mysqli_real_escape_string($conn, $_POST['competencyfra']);
        $competencyeng  = mysqli_real_escape_string($conn, $_POST['competencyeng']);
//        $biofra         = mysqli_real_escape_string($conn, $_POST['biofra']);
        $biofra         = $_POST['biofra'];
//        $bioeng         = mysqli_real_escape_string($conn, $_POST['bioeng']);
        $bioeng         = $_POST['bioeng'];
        
        //lets remove the HTML in the input, to filter out unwanted HTML
        $competencyfra  = strip_tags($competencyfra);
        $competencyeng  = strip_tags($competencyeng);
        $biofra         = strip_tags($biofra);
        $bioeng         = strip_tags($bioeng);

        //Escape all other output with htmlspecialchars() and be mindful of the 2nd and 3rd parameters here.
        $competencyfra  = htmlspecialchars($competencyfra);
        $competencyeng  = htmlspecialchars($competencyeng);
        $biofra         = htmlspecialchars($biofra);
        $bioeng         = htmlspecialchars($bioeng);
    
        //Must create function to validate data
        $is_competencyfra_notnull = f_ValidateNotNull(_LABEL_COMPETENCY_FR,$competencyfra, $msg);
        $is_competencyeng_notnull = f_ValidateNotNull(_LABEL_COMPETENCY_EN,$competencyeng, $msg);
        $is_biofra_notnull        = f_ValidateNotNull(_LABEL_BIO_FR,$biofra, $msg);
        $is_bioeng_notnull        = f_ValidateNotNull(_LABEL_BIO_EN,$bioeng, $msg);

        if($is_competencyfra_notnull && $is_competencyeng_notnull && $is_biofra_notnull && $is_bioeng_notnull){
            
            
            if ($conn->connect_error) 
            {
              die("Connection failed: " . $conn->connect_error);
            }          

            // let's update the data with the post values
            $sql = "UPDATE instructor SET CompetencyFra='".$competencyfra."'"
                    .", CompetencyEng = '".$competencyeng."'"
                    .", BioFra = '".$biofra."'"
                    .", BioEng = '".$bioeng."'"
                    ." WHERE personid=".$personid;
            
//            echo $sql;

            if ($conn->query($sql) === TRUE) 
            {
                $msg = _MSG_SAVE_SUCCESS; 
                //let set the language again in case it has been updated
                $_SESSION['lang'] = $language;
                $savesuccessfull = true;
            } 
            else 
            {
              $msg = "Error updating record: " . $conn->error;
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
        <link href = "css/divtable.css" rel = "stylesheet">
        <link href = "css/form.css" rel = "stylesheet">      
        <link href = "font-awesome/css/font-awesome.min.css" rel="stylesheet" >
        <link href = "css/header.css" rel = "stylesheet"> 
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />-->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>        
        <script>
            function HideMessage(){
                //setTimeout(function () { document.getElementById('message').style.display='none';}, 9000);
                document.getElementById('message').style.display='none';
            }

            $(document).ready(function()
            {
                $(document).on('change', '#file', function()
                {
                    var name = document.getElementById("file").files[0].name;
                    var form_data = new FormData();
                    var ext = name.split('.').pop().toLowerCase();

                    if(jQuery.inArray(ext, ['jpg']) == -1) 
                    {
                        alert("Invalid Image File");
                    }
                    else
                    {
                       var oFReader = new FileReader();
                       oFReader.readAsDataURL(document.getElementById("file").files[0]);

                       var f = document.getElementById("file").files[0];
//                       var fsize = f.size||f.fileSize;
//
                       //      if(fsize > 2000000)
                       //      {
                       //       alert("Image File Size is very big");
                       //      }
                       //      
                       //      else
                       //      {
                       
                        form_data.append("file", document.getElementById('file').files[0]);
                        $.ajax(
                        {
                           url:"upload.php",
                           method:"POST",
                           data: form_data,
                           contentType: false,
                           cache: false,
                           processData: false,
                           beforeSend:function()
                           {
                            $('#uploaded_image').html("<label class='text-success'>Image Uploading...</label>");
                           },   
                           success:function(data)
                           {
                               $('#uploaded_image').html(data);
                           }
                        });
                    }
                });
            });            
        </script>
        <style>
            /*this is needed here even if it is already in base.css, bug with firefox.*/
            .subcontainer {
                border-radius: 5px;
                background-color: #fff;
                padding: 20px;
                text-align: left;
                width: 800px;
                margin-left:auto;
                margin-right: auto;
                /*border:1px solid #CCCCCC;*/
                margin-bottom:30px;
            }
            
           .img-thumbnail {
                /*display: inline-block;*/
                /*max-width: 100%;*/
                height: auto;
                padding: 4px;
                /*line-height: 1.42857143;*/
                background-color: #fff;
                border: 1px solid #ddd;
                border-radius: 4px;
                -webkit-transition: all .2s ease-in-out;
                -o-transition: all .2s ease-in-out;
                /*transition: all .2s ease-in-out;*/
            }
            
            .img-thumbnail{
                height:280px;
/*                float:left;*/
            }
            
            .selectapicture{
                margin-top: 20px;
                margin-bottom: 20px;
            }
            
            .custom-file-input{
                /*color:transparent;*/
                padding-left:10px;
                padding-right:10px;
            }

            .file_img{
                width:0px;
            }
            
            .subtitle::before{
                content:'\f0a3';
                font-family: "FontAwesome";
                font-size:1em;
                padding-right: 10px;
            }       
            
            /*Do not move this code to base.css or other css files it will break */
            input[type='text']:read-only{
                background-color: #eee;
            }
            
        </style>
    </head>
    <body>
        <header>
            <?php 
            f_DisplayTopMenu();
            ?>
        </header>
        <?php echo f_DisplaySiteMenu(0, $personid); ?>
        <div id ="container">
            <?php            
            if ($_SESSION["personid"] > 0 && !$posted)
//            if ($_SESSION["personid"] > 0)
            {             
                $sql = "SELECT person.personid, UserName"
                        . " ,if('".$language."'='fra',persontype.PersonTypeNameFra, persontype.PersonTypeNameEng) as PersonTypeName"
                        . " ,instructor.CompetencyFra"
                        . " ,instructor.CompetencyEng"
                        . " ,BioFra"
                        . " ,BioEng"
                        . " ,Picture"
                        . " FROM person "
                        . " left join persontype"
                        . " on person.persontypeid = persontype.persontypeid"
                        . " left join instructor"
                        . " on person.personid = instructor.PersonID"
                        . " where person.personid = ".$personid;
                $result = $conn->query($sql);
                
                if ($result->num_rows > 0) 
                {
                    // output data of each row
                    while($row = $result->fetch_assoc()) 
                    {                       
                        $username           = $row['UserName'];
                        $competencyfra      = $row['CompetencyFra'];
                        $competencyeng      = $row['CompetencyEng'];
                        $biofra             = $row['BioFra'];
                        $bioeng             = $row['BioEng'];
                        $persontypename     = $row['PersonTypeName'];
                        $picture            = $row['Picture'];
                    }  
                }
            }
            if (strlen($msg) > 0){
                if($savesuccessfull){
                    echo f_DisplayMessage($msg, 'info');
                }
                else
                {
                    echo f_DisplayMessage($msg, 'warning');
                }
            } 
            ?>
            <div class='space_height_30'></div>
            <div class="subcontainer">
                <div class='subtitle'><?php echo _PROFILE; ?></div>
                <form method="post" action="" enctype="multipart/form-data" id="myform">
                    <div class="row">
                        <div class="col-100">
                          <!--<label for="picture"></label>-->
                            <span id="uploaded_image">
                                <img src="instructorspicture/instructor_<?php echo $personid; ?>.jpg?time()" id="img" class="img-thumbnail">
                                <!--echo '<img src="'.$location.'?'.time().'" class="img-thumbnail" id="img" />';-->
                            </span>
                            <p class="selectapicture"><?php echo _CHANGEPICTURE_PRE; ?>  
                                <input type="button" id="loadFileXml" value="<?php echo _HERE; ?>" onclick="document.getElementById('file').click();" class="custom-file-input" />
                                <input type="file" id="file" name="file" class="file_img"/>    
                                <?php 
                                    echo _CHANGEPICTURE_POST;
                                    echo "<p>"._WAITTOREFRESH."</p>";
                                ?>
                            </p>
                            <br/>                            
                        </div>
<!--                        <div>
                        </div>-->
                    </div>                     
                </form>
                <form action="profile.php" method="post" id="form1">
                    
                    <div class="row">
                      <div class="col-25">
                          <label for="personid"><?php echo _LABEL_PERSONID; ?></label>
                      </div>
                      <div class="col-75">
                          <input type="text" id="personid" name="personid" readonly  value="<?php echo $personid.'-'.$persontypename; ?>">
                      </div>
                    </div>                                   
<!--                    <div class="row">
                      <div class="col-25">
                        <label for="username"><?php echo _LABEL_USERNAME; ?></label>
                      </div>
                      <div class="col-75">
                          <input type="text" id="username" name="username" readonly value="<?php echo $username; ?>">
                      </div>
                    </div>            -->
                    
                    <div class="row">
                        <div class="col-25">
                          <label for="competencyfra"><?php echo _LABEL_COMPETENCY_FR; ?></label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="competencyfra" name="competencyfra" value="<?php echo $competencyfra; ?>">
                        </div>
                    </div>  
                    
                    <div class="row">
                        <div class="col-25">
                            <label for="competencyeng"><?php echo _LABEL_COMPETENCY_EN; ?></label>
                        </div>
                        <div class="col-75">
                              <input type="text" id="competencyeng" name="competencyeng" value="<?php echo $competencyeng; ?>">
                        </div>
                    </div>     
                    <div class="row">
                        <div class="col-25">
                            <label for="biofra"><?php echo _LABEL_BIO_FR; ?></label>
                        </div>
                        <div class="col-75">
                              <textarea id="biofra" name="biofra" rows="4" cols="50"><?php echo $biofra; ?></textarea>
                        </div>
                    </div>                      
                    <div class="row">
                        <div class="col-25">
                            <label for="bioeng"><?php echo _LABEL_BIO_EN; ?></label>
                        </div>
                        <div class="col-75">
                            <textarea id="bioeng" name="bioeng" rows="4" cols="50"><?php echo $bioeng; ?></textarea>
                        </div>
                    </div>                     
                    <div class="buttonright">
<!--                      <input type="submit" value="Submit">-->
                      <button type = "submit" value="Submit" class="button button1"><?php echo _SAVE ?></button>
                    </div>
                </form>
            </div><!-- /subcontainer -->
        </div> <!-- /container -->
        <?php echo f_DisplayFooter($language); ?>
    </body>
</html>