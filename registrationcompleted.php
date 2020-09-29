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
    
//    if(isset($_REQUEST['message']) && !empty($_REQUEST['message'])){
//        $msg = $_REQUEST['message'];
//    }
    
    $msg = _MSG_MUSTCONFIRM;
    $msg .= '<br><br><div>'._TOLOGIN.'</div>';
?>
<html lang = "en">
   <head>
      <title><?php echo C_COMPAGNYNAME; ?></title>
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
      
        <div id = "container">
        <h1><?php echo f_GetCompagnyName(); ?></h1>
         <div id="message"><?php echo $msg; ?></div>
        </div>
      
   </body>
   <?php echo f_DisplayFooter($language); ?>
</html>
