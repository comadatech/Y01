<?php
/*
 * There should be no session work on this page
 * todo remove all session code since it should only start on validatelogin.php
 */
   
    session_start();
    
    //if no session then lets start the session
    if(!isset($_SESSION["personid"]) or $_SESSION["personid"]<0){
        $_SESSION["personid"] = 0;
        $_SESSION['cart'] = array();   
    }

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
        include "includes/lang_".$_SESSION['language'].".php";
        $language = $_SESSION['language'];
    }
    else
    {
        //not set up them set to default English
        include "includes/lang_eng.php";
        $language = "Eng";
        $_SESSION['language'] = "Eng";
    }
    
    
   // error_reporting(E_ALL);
    ini_set("display_errors", 1);
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
            #login{text-align: center}
          
            .col-75{text-align:left}
            .col-25{text-align:right}
            
            .logo {
                font-size:106px;
                color:green;
                font-family: cursive;
            }
            
            .saule{
                position: absolute;
                top: 20%;
                left: 20%;
                transform: translate(-20%, -20%);
            }
            .yoga {
                position: absolute;
                top: 40%;
                left: 30%;
                transform: translate(-40%, -30%);
            }
        </style>
   </head>
   <body>
        <header>
        <?php 
            f_DisplayHeader();
        ?>
        </header>
        <?php echo f_DisplaySiteMenu(C_HOME); ?>
        <div id='container'>
            <img src='images/index.jpeg' style='width:100%'>
            <div id='logo' class='logo saule'>Saule</div>
            <div id='logo' class='logo yoga'>Yoga</div>
        </div>
        <?php echo f_DisplayFooter($language); ?>
    </body>
</html>