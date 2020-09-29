<?php
/*
 * There should be no session work on this page
 * todo remove all session code since it should only start on validatelogin.php
 */
   
    session_start();
    
//    //if no session then lets start the session
//    if(!isset($_SESSION["personid"]) or $_SESSION["personid"]<0){
//        $_SESSION["personid"] = 0;    
//    }
//    
//    //must code a isset for the cart in case that it does not exists
//    if(!isset($_SESSION['cart'])){
//        $_SESSION['cart'] = array(); 
//    }
//

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

            .logo {
                font-size:106px;
                color:green;
                font-family: cursive;
            }
            
            .saule{
                position: absolute;
                top: 50px;
                left: 10%;
                transform: translate(-20%, -20%);
                text-shadow: 2px 2px 4px #000000;
                font-family: "Brush Script MT";
                font-size:12rem;
                /*transform:rotate(-20deg);*/

                /*webkit-transform:rotate(-20deg);*/
            }
            .yoga {
                position: absolute;
                top: 220px;
                left: 24%;
                transform: translate(-40%, -30%);
                color:orange;
                text-shadow: 2px 2px 4px #000000;
                font-family: "Brush Script MT";
                font-size:8rem;
                /*transform:rotate(-20deg);*/

                /*webkit-transform:rotate(-20deg);*/
            }
            
            .buttongo{
                position:absolute;
                /*border:1px solid #ffa500;*/
                border-radius:6px;
                color:#ffa500;
                right:8%;
                top:460px;
                padding:20px;
                -webkit-box-shadow: 0px 0px 300px 3px rgba(255,165,0,1);
                -moz-box-shadow: 0px 0px 300px 3px rgba(255,165,0,1);
                box-shadow: 0px 0px 300px 3px rgba(255,165,0,1);
                background-color: #fff;
            }
            
            .coursenligne{
                position:absolute;
                border:1px solid #fff;
                border-radius:6px;
                color:#fff;
                right:22%;
                top:1010px;
                padding:20px;               
            }
            
            .coursenligne a{
                font-size:1.5rem;
                text-decoration: none;
                color:#fff;
            }
            
            .indeximage{
                border-bottom:1px solid #ffcdab
            }
            
            /*Overriding for this page*/
            #container{
                background-color: #ffffff;
            }
            
            .imgalamaison{
                width:100%;
                /*height:300px;*/
            }
            
            .cours{
                position: absolute;
                font: 800 3em "Lato", sans-serif;
                color:#fff;
                width: 100%;
                text-align: center;
                text-shadow: 1px 0 0 #000, -1px 0 0 #000, 0 1px 0 #000, 0 -1px 0 #000, 1px 1px #000, -1px -1px 0 #000, 1px -1px 0 #000, -1px 1px 0 #000;                
            }
            
            .cours__coursenligne{
                top:940px;
            }
            
            .cours__coursyogapleinair{
                top:2140px;
            }
            
            .nicetext{
                padding:20px;
                margin-left:30px;
                margin-right:30px;
                font: 400 15px/1.8 "Lato", sans-serif;
            }
            
            .nicesubtext{
                color: #777;
                background-color:white;
                text-align:center;
                padding:50px 80px;
                text-align: justify;
            }
            
            h3 {
                letter-spacing: 5px;
                text-transform: uppercase;
                font: 20px "Lato", sans-serif;
                color: #111;
                display: block;
                /*font-size: 1.17em;*/
                margin-block-start: 1em;
                margin-block-end: 1em;
                margin-inline-start: 0px;
                margin-inline-end: 0px;
            }
            
        </style>
   </head>
   <body>
        <header>
        <?php 
            f_DisplayTopMenu();
        ?>
        </header>
        <?php echo f_DisplaySiteMenu(C_HOME, $personid); ?>
        <div id='container'>
            <img class='indeximage' src='images/index3.jpeg' style='width:100%'>
            <!--<div id="buttongo" class="buttongo"><a href='#'>Voir nos speciaux</a></div>-->
            <div id="coursenligne" class="coursenligne"><a href='#'>Inscrivez-vous aujourd'hui</a></div>
            
            <div class="cours cours__coursenligne">Inscrivez-vous a nos cours en ligne</div>
            <div class="cours cours__coursyogapleinair">Un sejour dans la nature, ca vous dit?</div>

            <div id='logo' class='logo saule'>Saule</div>
            <div id='logo' class='logo yoga'>Yoga</div>

            <div class="nicetext">
                <div class="nicesubtext">
                    <h3 style="text-align:center;">yoga for everyone at home</h3>
                    <p>We see so many families less engaged with their children and more with their beautiful faces turned down into a little screen. Let's try to consciously be more present with our kids before they are eaten by a sea monster!
                    Want to do something fun that will bring you and your kids closer together in the extra time created in the absence of technology? Try the following little yoga class with the whole family!</p>
                </div>
            </div>
            <div ><img src="images/yogaalamaison.jpeg" class="imgalamaison" /></div>
            <div class="nicetext">
                <div class="nicesubtext">
                    <h3 style="text-align:center;">Yoga in nature</h3>
                    <p>We see so many families less engaged with their children and more with their beautiful faces turned down into a little screen. Let's try to consciously be more present with our kids before they are eaten by a sea monster!
                    Want to do something fun that will bring you and your kids closer together in the extra time created in the absence of technology? Try the following little yoga class with the whole family!</p>
                </div>
            </div>
            <div ><img src="images/yogainnature.jpeg" class="imgalamaison" /></div>
        </div>
        <?php echo f_DisplayFooter($language); ?>
    </body>
</html>