<?php

    //Since this is the main page, let's ensure that there is no session started
//    if(isset($_SESSION)) {
//        session_destroy();
//        session_end();
//   }

   //if session is not started then start the session
    if(!isset($_SESSION)) {
        session_start();
   }
   
   //include files
   require 'includes\config.php';
   include 'includes\library.php';
   include 'includes\constant.php';
   
    $msg                = "";
    $captcha            = false;
    $username           = "";
    $password           = ""; 
    $retypepassword     = "";    
    $firstname          = "";
    $lastname           = "";
    $email              = "";

    // Set Language variable
    if(isset($_GET['language']) && !empty($_GET['language'])){
        
        $_SESSION['language'] = $_GET['language'];

        if(isset($_SESSION['language']) && $_SESSION['language'] != $_GET['language']){
            echo "<script type='text/javascript'> location.reload(); </script>";
        }
    }

    // Include Language file
    if(isset($_SESSION['language'])){
        include "includes/lang_".$_SESSION['language'].".php";
        $language = $_SESSION['language'];
    }
    else
    {
        //not set up them set to default English
        include "includes/lang_eng.php";
        $language = "eng";
        $_SESSION['language'] = "eng";
    }

    //lets get the data and validate the new registration
    if (isset($_POST['username']) && !empty($_POST['username']) && !empty($_POST['password']))
    {
        $username           = $_POST['username'];
        $password           = $_POST['password']; 
        $retypepassword     = $_POST['retypepassword'];    
        $firstname          = $_POST['firstname'];
        $lastname           = $_POST['lastname'];
        $email              = $_POST['email'];
        
        // does username already exists?
        if (f_IsUserNameExists($username, $conn)){
            // does username already exist. Note that we can do this with ajax later
            // if username already exists lets diplay a message and ask for new username
            $msg = "User name ".$username." already exists.  Please use a different user name.";
        }
        else
        {
            // get all posted values 
            // Escape user inputs for security
            // might also add more filtering using filter_input or data sanitize 
            
            $username           = $conn -> real_escape_string($_POST['username']);
            
            $password           = $conn -> real_escape_string($password);
            $retypepassword     = $conn -> real_escape_string($retypepassword);    
            $firstname          = $conn -> real_escape_string($firstname);
            $lastname           = $conn -> real_escape_string($lastname);
            $email              = $conn -> real_escape_string($email);
            
            //lets remove the HTML in the input, to filter out unwanted HTML
            $username           = strip_tags($username);
            $firstname          = strip_tags($firstname);
            $lastname           = strip_tags($lastname);
            $email              = strip_tags($email);
            
            //Escape all other output with htmlspecialchars() and be mindful of the 2nd and 3rd parameters here.
            $username           = htmlspecialchars($username);
            $firstname          = htmlspecialchars($firstname);
            $lastname           = htmlspecialchars($lastname);
            $email              = htmlspecialchars($email);
            
            //google Captcha
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['recaptcha_response'])) {

                // Build POST request:
                $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
                $recaptcha_secret = C_SECRET_KEY;
                $recaptcha_response = $_POST['recaptcha_response'];

                // Make and decode POST request:
                $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
                $recaptcha = json_decode($recaptcha);

                if (isset($recaptcha->success) AND $recaptcha->success==true) {
                    // everything is ok!
                    $captcha = true;
                } else {
                    // echo "failure";die();
                    $captcha = false;
                    echo '<script type="text/javascript"> window.location.href = "index.php" </script>';
                }

                // uncomment the next line to see rcaptcha values
                // print_r($recaptcha);
            }
            
            // must add more validation. ex. email format, username lenght...
            // Validate data
            //----- need to validate username, will do later
            $ispasswordnotnull          = f_ValidateNotNull(_LABEL_NEWPASSWORD,$password, $msg);
            $isretypepasswordnotnull    = f_ValidateNotNull(_LABEL_RETYPENEWPASSWORD,$retypepassword, $msg);
            $validatepassword           = f_ValidateNewPassword($password, $msg);
            $validemail                 = f_ValidateEmail($email, $msg);
            $validfirstname             = f_ValidateFirstName($firstname, $msg);
            $validlastname              = f_ValidateLastName($lastname, $msg);

            if($password <> $retypepassword){
                f_ConcatMessage($msg,_MSG_WRONGRETYPEPASSWORD,"</br>");
                $validatepassword = false;
            }

            // will need to have username validate also
            if($ispasswordnotnull && $isretypepasswordnotnull && $validatepassword && $validemail 
                    && $validfirstname && $validlastname && $captcha)
            {    
                if ($conn->connect_error) 
                {
                  die("Connection failed: " . $conn->connect_error." Please report tis message to us.");
                }

                //lets hash the password first
                $hashpassword = password_hash($password,PASSWORD_DEFAULT);
                
                $sql = "INSERT INTO person (firstname, lastname, username, email, password, persontypeid) "
                        . "VALUES ('$firstname','$lastname','$username','$email', '$hashpassword',".C_PERSONTYPE_CUSTOMER.")";
                
                if(mysqli_query($conn, $sql)){
                    $personID = mysqli_insert_id($conn);
                    
                    //$msg = "Records added successfully. Person ID is".$personID;
                    
                    // Must send email with confirmation number
                    //$msg = wordwrap($msg,70);
                    echo '<script type="text/javascript"> window.location.href = "registrationcompleted.php" </script>';
//                    mail("root@localhost.com","Registration confirmation",$msg);
                    
                } else{
                    $msg = "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
                }
                
                $result = $conn->query($sql);

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
        <link href = "font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <link href = "css/header.css" rel = "stylesheet">
        <style>
            #login{text-align: center}

            .col-75{text-align:left}
            .col-25{text-align:right}

            .fa.field{
                padding: 6px;
                border: 1px solid black;
                border-radius: 4px;
                margin-left: 10px;
            }

            #helptext{
                border:1px solid green;
                padding:10px;
                background-color:#D7F4D8;
                position: fixed;
                height: auto;
                width:300px;
                box-shadow: 5px 10px 8px #888888;
                text-align: left;
                margin-left: 20%;
                margin-right: 20%;
            }
            
            #logincontainer{
                text-align: center;
                border: 4px solid green;
                padding: 10px;
                border-radius: 22px;
                width: 800px;
                margin-left:auto;
                margin-right: auto;   
                margin-top:30px;
            }
        </style>
        <script src="https://www.google.com/recaptcha/api.js?render=<?php echo C_SITE_KEY; ?>"></script>
        <script>

            function HideMessage(){
                //setTimeout(function () { document.getElementById('message').style.display='none';}, 9000);
                document.getElementById('message').style.display='none';
            }
        
            function showhide(object, object2) {
            
                var x = document.getElementById(object);
                var n = object;
            
                if (x.type === "password") {
                    x.type = "text";
                    document.getElementById(object2.id).className = "fa fa-eye-slash"; 

                    if(n == 'retypepassword'){
                        document.getElementById(object2.id).title = "<?php echo _TLABEL_HIDERETYPEPASSWORD; ?>";    
                    }
                    if(n == 'password'){
                        document.getElementById(object2.id).title = "<?php echo _TLABEL_HIDEPASSWORD; ?>";    
                    }                
                } 
                else 
                {
                    x.type = "password";
                    document.getElementById(object2.id).className = "fa fa-eye"; 

                    if(n == 'retypepassword'){
                        document.getElementById(object2.id).title = "<?php echo _TLABEL_SHOWRETYPEPASSWORD; ?>";    
                    }
                    if(n == 'password'){
                        document.getElementById(object2.id).title = "<?php echo _TLABEL_SHOWPASSWORD; ?>";    
                    }      
                }
            }        
        
            function help(){
                if (document.getElementById('helptext').style.display=='block'){
                    document.getElementById('helptext').style.display='none';
                }
                else
                {
                    document.getElementById('helptext').style.display='block';
                }
            }
      </script>      
    </head>
   <body>
        <header>
        <?php 
            f_DisplayHeader();
        ?>
        </header>
       <?php echo f_DisplaySiteMenu(C_REGISTER); ?>
        <div id = "logincontainer">
            <div id = "login">
                <!--<h4 class = "form-signin-heading"></h4>-->
                <form action="" method="POST">
                    <h2 style="text-align: center"><?php echo _REGISTERTITLE ?></h2>
                    <div><?php echo _MSG_REGCONFIRMATION; ?></div>
                    <?php 
                    echo $msg;
                    $title      = _TIPS;
                    $helptext   = _MSG_PASSWORDREQUIREMENTS;

                    f_PopupMessage($title, $helptext);

                    ?>
                    <div class="row">
                        <div class="col-25">
                            <label><?php echo _LABEL_FIRSTNAME?></label>
                        </div>
                        <div class="col-75">
                            <input type = "text" name = "firstname" value="<?php echo $firstname; ?>" title="<?php echo _TLABEL_FIRSTNAME; ?>" required autofocus>
                        </div>
                    </div>     
                    <div class="row">
                        <div class="col-25">
                            <label><?php echo _LABEL_LASTNAME?></label>
                        </div>
                        <div class="col-75">
                            <input type = "text" name = "lastname" value="<?php echo $lastname; ?>" title="<?php echo _TLABEL_LASTNAME; ?>" required>
                        </div>
                    </div>                       
                    <div class="row">
                        <div class="col-25">
                            <label><?php echo _LABEL_USERNAME?></label>
                        </div>
                        <div class="col-75">
                            <input type = "text" name = "username" value="<?php echo $username; ?>" title="<?php echo _TLABEL_USERNAME; ?>" required autofocus>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label style="padding: 12px 0 12px 0;"><?php echo _LABEL_PASSWORD ?></label><i id="helpbutton" class="fa fa-info-circle field" style ="border:none; margin-left: 0px;" onclick="help();"></i>
                        </div>
                        <div class="col-75">
                            <input type = "password" id="password" name = "password" title="<?php echo _TLABEL_PASSWORD; ?>" required  placeholder="">
                            <i id="passwordbutton" class="fa fa-eye field" onclick="showhide('password',this);" title="<?php echo _TLABEL_SHOWPASSWORD; ?>"></i>
                            
                        </div>                  
                    </div>
                    <div class="row">
                      <div class="col-25">
                        <label for="retypepassword"><?php echo _LABEL_RETYPENEWPASSWORD; ?></label>
                      </div>
                      <div class="col-75">
                          <input type="password" id="retypepassword"  name="retypepassword" title="<?php echo _TLABEL_RETYPEPASSWORD; ?>" required>
                          <i id="retypepasswordbutton" class="fa fa-eye field" onclick="showhide('retypepassword',this);" title="<?php echo _TLABEL_SHOWRETYPEPASSWORD; ?>"></i>
                         
                      </div>
                    </div> 
                    <div class="row">
                        <div class="col-25">
                            <label><?php echo _LABEL_EMAIL?></label>
                        </div>
                        <div class="col-75">
                            <input type = "text" name = "email" value="<?php echo $email; ?>" title="<?php echo _TLABEL_EMAIL; ?>" required>
                        </div>
                    </div>                      
                    <div class="row">                   
                        <div class="col-100">
                            <button type = "submit" name = "register" class="button button1"><?php echo _REGISTER?></button>
                            <input type="hidden" name="recaptcha_response" id="recaptchaResponse" required>
                        </div>
                    </div>   
                     <div class="row">                   
                        <div class="col-100">
                            <P><?php echo _ALREADYREGISTER; ?></P>
                        </div>
                    </div>                     
                </form>
                <script>
                    grecaptcha.ready(function () {
                        grecaptcha.execute('<?php echo C_SITE_KEY; ?>', { action: 'contact' }).then(function (token) {
                            var recaptchaResponse = document.getElementById('recaptchaResponse');
                            recaptchaResponse.value = token;
                            console.log(token);
                        });
                    });
                </script>
                
            </div>   
        </div> <!-- container -->
        <?php echo f_DisplayFooter($language); ?>
    </body>
</html>