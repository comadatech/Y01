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
   
    f_SetSessionActivity();
    
    $personid = f_GetPersonID();
  
    $msg = "";
       
    // Page has been submitted
    if (isset($_POST['personid']) && !empty($_POST['personid']))
    {
        // get all posted values 
        $oldpassword        = $_POST['oldpassword'];
        $newpassword        = $_POST['newpassword'];
        $retypepassword     = $_POST['retypepassword'];    
        
        //Validate data
        $isdoldpasswordnotnull      = f_ValidateNotNull(_LABEL_OLDPASSWORD,$oldpassword, $msg);
        $isnewpasswordnotnull       = f_ValidateNotNull(_LABEL_NEWPASSWORD,$newpassword, $msg);
        $isretypepasswordnotnull    = f_ValidateNotNull(_LABEL_RETYPENEWPASSWORD,$retypepassword, $msg);
        $validatenewpassword        = f_ValidateNewPassword($newpassword, $msg);
        
        if($newpassword <> $retypepassword){
            f_ConcatMessage($msg,_MSG_WRONGRETYPEPASSWORD,"</br>");
            $validatenewpassword = false;
        }
        
        if($isdoldpasswordnotnull && $isnewpasswordnotnull && $isretypepasswordnotnull && $validatenewpassword )
        {    
            if ($conn->connect_error) 
            {
              die("Connection failed: " . $conn->connect_error);
            }

            //Is Old password is true?
            $sql = "SELECT PersonID, password FROM person where personid = ".$personid;
            $result = $conn->query($sql);

            if ($result->num_rows > 0) 
            {                              
                // output data of each row
                while($row = $result->fetch_assoc()) 
                {
                    if (password_verify($oldpassword, $row['password'])) {
                       // OLD password is successfull let's change the password</div>";

                        $hashpassword = password_hash($newpassword,PASSWORD_DEFAULT);

                        $sql = "Update person set password = '".$hashpassword."' where personid = ".$personid;

                        if ($conn->query($sql) === TRUE) {
                            $msg = _MSG_SAVE_SUCCESS;      
                        } else {
                          $msg = "Error updating record: " . $conn->error;
                        }    
                    }
                    else
                    {
                        f_ConcatMessage($msg, _MSG_INVALIDOLDPASSWORD,"</br>");

                    }
                }
            } 
        }
    }
?>
<html lang = "en">
   <head>
      <title>Yoga</title>
      <link href = "css/base.css" rel = "stylesheet">
      <link href = "css/divtable.css" rel = "stylesheet">
      <link href = "css/form.css" rel = "stylesheet">
      <link href = "font-awesome/css/font-awesome.min.css" rel="stylesheet" >
      <link href = "css/header.css" rel = "stylesheet">     
      <script>
          
        function HideMessage(){
            //setTimeout(function () { document.getElementById('message').style.display='none';}, 9000);
            document.getElementById('message').style.display='none';
        }
        
        function showhide(object, object2) {
          var x = document.getElementById(object);
          if (x.type === "password") {
            x.type = "text";
            document.getElementById(object2.id).className = "fa fa-eye-slash"; 
                    
          } else {
            x.type = "password";
            document.getElementById(object2.id).className = "fa fa-eye"; 
          }
        }        
      </script>
      <style>
        .fa.field{
                padding: 6px;
                border: 1px solid black;
                border-radius: 4px;
                margin-left: 10px;
        }
        
        .subtitle::before{
            content:'\f084';
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
       <?php echo f_DisplaySiteMenu(C_PASSWORDCHG, $personid); ?>
        <div id = "container">
            <div class='subtitle'><?php echo _PASSWORDCHANGE; ?></div>
            <div id=''>
            <?php 
                if (strlen($msg) > 0){
                    echo f_DisplayMessage($msg, 'warning');
                } 
            ?>
            <br/>
            <div class="subcontainer">
                <form action="passwordchg.php" method="post" id="form1">
                <div class="row">
                  <div class="col-25">
                  </div>
                  <div class="col-75">
                      <input type="text" id="personid" name="personid" hidden value="<?php echo $personid; ?>">
                  </div>
                </div>                                 
  
                <div class="row">
                  <div class="col-25">
                    <label for="oldpassword"><?php echo _LABEL_OLDPASSWORD; ?></label>
                  </div>
                  <div class="col-75">
                      <input type="password" id="oldpassword" onclick="HideMessage();" name="oldpassword"><i id="oldpasswordbutton" class="fa fa-eye field" onclick="showhide('oldpassword',this);"></i>
                  </div>
                </div>     
                <div class="row">
                  <div class="col-25">
                    <label for="newpassword"><?php echo _LABEL_NEWPASSWORD; ?></label>
                  </div>
                  <div class="col-75">
                      <input type="password" id="newpassword" onclick="HideMessage();" name="newpassword"><i id="newpasswordbutton" class="fa fa-eye field" onclick="showhide('newpassword',this);"></i>
                  </div>
                </div>           
                <div class="row">
                  <div class="col-25">
                    <label for="retypepassword"><?php echo _LABEL_RETYPENEWPASSWORD; ?></label>
                  </div>
                  <div class="col-75">
                      <input type="password" id="retypepassword" onclick="HideMessage();" name="retypepassword"><i id="retypepasswordbutton" class="fa fa-eye field" onclick="showhide('retypepassword',this);"></i>
                  </div>
                </div>                                   
                <div class="row" style="text-align: right">
                    <!--<br/>-->
                  <!--<input type="submit" value="Submit" class="button button1">-->
                  <button type = "submit" value="Submit" class="button button1"><?php echo _SAVE ?></button>
                </div>
              </form>
            </div>
        </div> <!-- /container -->
    </body>
</html>