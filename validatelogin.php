<?php
    $msg="";
    
   if(!isset($_SESSION)) {
        session_start();
   }
   
//      // set session time out
//    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > C_TIMEOUT)) {
//        // last request was more than 15 minutes ago
//        session_unset();     // unset $_SESSION variable for the run-time 
//        session_destroy();   // destroy session data in storage
//        //go back to login
//        echo '<script type="text/javascript"> window.location.href = "index.php" </script>';
//    }
//    $_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp 

   //include files
   require 'includes\config.php';
   include 'includes\library.php';
   include 'includes\constant.php';
   
    //let's set the labguage in the session variable
    $language = f_SetSessionLanguage();
   
    // Set the session activity
    f_SetSessionActivity();    
   
    if (isset($_POST['login']) && !empty($_POST['username']) && !empty($_POST['password']))
    {
        $username = $_POST['username']; //$username = $_SESSION['username'];
        $password = $_POST['password']; 
        

        $sql = "SELECT PersonID, firstname, lastname, password, language FROM person where username = '".$username."'";
        $result = $conn->query($sql);
                
        if ($result->num_rows > 0) 
        {
                                      
            // output data of each row
            while($row = $result->fetch_assoc()) 
            {

                // get the user language and set it up for the session
                // let's get the user prefered language from the person table 
                // instead of f_SetSessionLanguage();
                $language = $row['language'];

                if ($language == 'Eng'){ 
                    $_SESSION['language'] = "Eng";
                    include 'includes/lang_eng.php';   
                }
                else{
                    $_SESSION['language'] = "Fra";
                    include 'includes/lang_fra.php';   
                }
                
                if (password_verify($password, $row['password'])) {

                    // this is the only place that we setup the session personid
                    $_SESSION['personid'] = $row['PersonID'];
                    
                    //echo $_SESSION['personid'];
                    
                    echo '<script type="text/javascript"> window.location.href = "subscribeto.php" </script>';
                    //echo "<div style='text-align:center'>Click <a href='subscription.php'>here</a> to contibue.</div>";
                    
                }       
                else {
                    $msg = "<div style='text-align:center'>"._MSG_FAILLED_LOGIN."</div>";                     
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
    </head>
    <body>
        <h1><?php echo f_GetCompagnyName(); ?></h1> 
        <!--<div id = "container"></div>-->
        <?php echo $msg; ?>
    </body>
    <?php echo f_DisplayFooter($language); ?>
</html>