<?php
    $msg="";
    
   if(!isset($_SESSION)) {
        session_start();
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
    
    //let's set the language in the session variable
    f_InitSessionVariable();
//    f_InitSessionLanguage();

    //let's set the laguage library
    $language = f_GetSessionLanguage();
    
    f_SetLibraryLanguage($language);
    
    f_SetSessionActivity();   
   
    if (isset($_POST['login']) && !empty($_POST['username']) && !empty($_POST['password']))
    {
        $username = $_POST['username']; //$username = $_SESSION['username'];
        $password = $_POST['password']; 
        

        $sql = "SELECT PersonID, firstname,lastname"
                . ", persontypeid "
                . ", password"
                . ", language"
                . " FROM person where username = '".$username."'";

        $result = $conn->query($sql);
                
        if ($result->num_rows > 0) 
        {

            // output data of each row
            while($row = $result->fetch_assoc()) 
            {
                
                if (password_verify($password, $row['password'])) {

                    // this is the only place that we setup the session personid
                    $_SESSION['personid']       = $row['PersonID'];
                    $_SESSION['persontypeid']   = $row['persontypeid'];
                    $_SESSION['personfullname'] = $row['firstname'].' '.$row['lastname'];
                    
                    echo '<script type="text/javascript">window.location.href = "classes.php"</script>';
                }       
                else {
                    $msg = "<div style='text-align:center'>"._MSG_FAILLED_LOGIN."</div>";                     
                }       
            }      
        }
        $msg = "<div style='text-align:center'>"._MSG_FAILLED_LOGIN."</div>";
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
        
        <style>
            #login{
                text-align: center;
                margin-left:16%;
                margin-right:16%;
            }
        </style>
    </head>
    <body>
       <header>
            <?php 
                f_DisplayTopMenu();
            ?>
        </header>
        <?php echo f_DisplaySiteMenu(); ?>        
        <div id='container'>
            <div id ="login">
                <h1><?php echo f_GetCompagnyName(); ?></h1> 
                <!--<div id = "container"></div>-->
                <?php echo $msg; ?>
            </div>
        </div>
        <?php echo f_DisplayFooter($language); ?>
    </body>
</html>