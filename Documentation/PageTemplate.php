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

?>
<html lang = "en">
   <head>
        <title>Yoga</title>
        <link href = "css/base.css" rel = "stylesheet">
        <link href = "css/divtable.css" rel = "stylesheet">
        <link href = "font-awesome/css/font-awesome.min.css" rel="stylesheet" >
        <link href = "css/header.css" rel = "stylesheet">
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
            </div><!--end of content-wrap -->
        </div> <!-- /container -->
        <?php echo f_DisplayFooter($language); ?>
    </body>
</html>