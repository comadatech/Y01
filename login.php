<?php
    //Since this is the main page, let's ensure that there is no session started
    if(isset($_SESSION)) {
        session_unset();
        session_destroy();
        session_end();
   }

/*
 * There should be no session work on this page
 * todo remove all session code since it should only start on validatelogin.php
 */
   
    session_start();

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
    
?>
<html lang = "en">
   <head>
        <title>Yoga</title>
        <link href = "css/base.css" rel = "stylesheet">
        <link href = "css/divtable.css" rel = "stylesheet">
        <link href = "css/form.css" rel = "stylesheet">
        <link href = "font-awesome/css/font-awesome.min.css" rel="stylesheet" >
        <link href = "css/header.css" rel = "stylesheet">
        <style>
/*            #login{text-align: center}*/
            #login{
                text-align: center;
                margin-left:16%;
                margin-right:16%;
            }
          
            .col-75{text-align:left}
            .col-25{text-align:right}
        </style>
   </head>
   <body>
        <header>
        <?php 
            f_DisplayTopMenu();
        ?>
        </header>
        <?php echo f_DisplaySiteMenu(); ?>
<!--       <div id="main">-->
            <div id="container">
                <div id="subcontainer">
                    <form class = "form-signin" role = "form" action = "validatelogin.php" method = "post" id="form1">
                        <div class="subtitle"><?php echo _LOGIN ?></div>
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
        <!--</div>-->
        <?php echo f_DisplayFooter($language); ?>
    </body>
</html>