<?php
    //Since this is the main page, let's ensure that there is no session started
    if(isset($_SESSION)) {
        session_destroy();
        session_end();
   }

   ob_start();
   
   //if session is not started then start the session
//    if(!isset($_SESSION)) {
        session_start();
//   }

   //include files
   require 'includes\config.php';
   include 'includes\library.php';
   include 'includes\constant.php';
   
  // Set Language variable
    if(isset($_GET['language']) && !empty($_GET['language'])){
        
        $_SESSION['language'] = $_GET['language'];

        if(isset($_SESSION['language']) && $_SESSION['language'] != $_GET['language']){
            echo "<script type='text/javascript'> location.reload(); </script>";
        }
    }

    // Include Language file
    if(isset($_SESSION['language'])){
        include "lang_".$_SESSION['language'].".php";
        $language = $_SESSION['language'];
    }
    else
    {
        //not set up them set to default English
        include "lang_eng.php";
        $language = "Eng";
        $_SESSION['language'] = "Eng";
    }
   // error_reporting(E_ALL);
   // ini_set("display_errors", 1);
?>

<html lang = "en">
   <head>
      <title>Yoga</title>
      <link href = "css/base.css" rel = "stylesheet">
      <link href = "css/divtable.css" rel = "stylesheet">
      <link href = "css/form.css" rel = "stylesheet">
      <style>
          #login{text-align: center}
          
          .col-75{text-align:left}
          .col-25{text-align:right}

      </style>
   </head>
   <body>
       <div id="language"><?php echo _LANGUAGE?></div>
        <div id = "logincontainer">
            <!--<img src="bj.jpg" style="width:10%; height:auto"/>-->
            <h1><?php echo f_GetCompagnyName(); ?></h1> 
            <div id = "login">
                <h4 class = "form-signin-heading"></h4>    
                <form class = "form-signin" role = "form" action = "<?php echo 'validatelogin.php';?>" method = "post" id="form1">

                    <legend style="text-align: center"><?php echo _LOGINTITLE ?></legend>
                    <div class="row">
                        <div class="col-25">
                            <label><?php echo _LABEL_USERNAME?></label>
                        </div>
                        <div class="col-75">
                            <input type = "text" name = "username" title="<?php echo _LABEL_USERNAME_TT?>" required autofocus>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label><?php echo _LABEL_PASSWORD ?></label>
                        </div>
                        <div class="col-75">
                            <input type = "password" name = "password"  required>
                        </div>                  
                    </div>
                    <div class="row">                   
                        <div class="col-100">
                            <button type = "submit" name = "login" class="button button1"><?php echo _LOGIN?></button>
                        </div>
                    </div>
                    <div class="row">                   
                        <div class="col-100">
                            <div><?php echo _FORGOTPASSWORD; ?></div>
                        </div>
                    </div>                     
                    <div class="row">                   
                        <div class="col-100">
                            <div><?php echo _NOTREGISTERED; ?></div>
                        </div>
                    </div>                
                </form>
            </div>   
        </div> <!-- /container -->
        <?php echo f_DisplayFooter($language); ?>
    </body>
</html>