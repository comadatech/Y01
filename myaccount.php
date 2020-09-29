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
    
    // Set the session activity
    f_SetSessionActivity(); 
    
    $personid = f_GetPersonID();
  
    // Declare variables
    $msg = "";
    $posted = false;
    $persontypename = "";
    
    if ($personid == 0){
        //no personid from session? we should not go anywhere exept go back to login page 
        echo '<script type="text/javascript"> window.location.href = "index.php" </script>';
    }
   
    //The page has been submitted
    if (isset($_POST['personid']) && !empty($_POST['personid']))
    {
        $posted = true;
       
        // get all posted values 
        //$personid           = mysqli_real_escape_string($conn, $_POST['personid']);
        //$username           = mysqli_real_escape_string($conn, $_POST['username']);
        $email              = mysqli_real_escape_string($conn, $_POST['email']);
        $firstname          = mysqli_real_escape_string($conn, $_POST['firstname']);
        $lastname           = mysqli_real_escape_string($conn, $_POST['lastname']);
        //$gender             = mysqli_real_escape_string($conn, $_POST['gender']);
        $gender             = $_POST['gender'];
        $addressstreet      = mysqli_real_escape_string($conn, $_POST['addressstreet']);
        $addresscity        = mysqli_real_escape_string($conn, $_POST['addresscity']);
        //$addressprovinceid  = mysqli_real_escape_string($conn, $_POST['addressprovinceid']);
        $addressprovinceid  = $_POST['addressprovinceid'];
        $addresspostalcode  = mysqli_real_escape_string($conn, $_POST['addresspostalcode']);
        $phonenumber        = mysqli_real_escape_string($conn, $_POST['phonenumber']);
        $dateofbirth        = mysqli_real_escape_string($conn, $_POST['dateofbirth']);
        
        //lets remove the HTML in the input, to filter out unwanted HTML
        $email              = strip_tags($email);
        $firstname          = strip_tags($firstname);
        $lastname           = strip_tags($lastname);
        //$gender             = strip_tags($gender);
        $addressstreet      = strip_tags($addressstreet);
        $addresscity        = strip_tags($addresscity);
        //$addressprovinceid  = strip_tags($addressprovinceid);
        $addresspostalcode  = strip_tags($addresspostalcode);
        $dateofbirth        = strip_tags($dateofbirth);

        //Escape all other output with htmlspecialchars() and be mindful of the 2nd and 3rd parameters here.
        $email              = htmlspecialchars($email);
        $firstname          = htmlspecialchars($firstname);
        $lastname           = htmlspecialchars($lastname);
        //$gender             = strip_tags($gender);
        $addressstreet      = htmlspecialchars($addressstreet);
        $addresscity        = htmlspecialchars($addresscity);
        //$addressprovinceid  = strip_tags($addressprovinceid);
        $addresspostalcode  = htmlspecialchars($addresspostalcode);
        $dateofbirth        = htmlspecialchars($dateofbirth);        
        
        //Must create function to validate data
        $validemail     = f_ValidateEmail($email, $msg);
        $validfirstname = f_ValidateFirstName($firstname, $msg);
        $validlastname  = f_ValidateLastName($lastname, $msg);
        // need validation of postal code
        // need validation on Phone Number
        // need validation on Date of Birth
        // need validation on city, can only be letter non numeric
         
        if($validemail && $validfirstname && $validlastname){
            if ($conn->connect_error) 
            {
              die("Connection failed: " . $conn->connect_error);
            }

            // let's update the data with the post values
            $sql = "UPDATE person SET email='".$email."'"
                    .", firstname = '".$firstname."'"
                    .", lastname = '".$lastname."'"
                    .", gender = '".$gender."'"
                    .", language = '".$language."'"
                    .", addressstreet = '".$addressstreet."'"
                    .", addresscity = '".$addresscity."'"
                    .", addressprovinceid = '".$addressprovinceid."'"
                    .", addresspostalcode = '".$addresspostalcode."'"
                    .", phonenumber = '".$phonenumber."'"
                    .", dateofbirth = '".$dateofbirth."'"
                    .", modifiedbyuserid = '".$personid."'"
                    ." WHERE personid=".$personid;

            if ($conn->query($sql) === TRUE) 
            {
                $msg = _MSG_SAVE_SUCCESS; 
                //let set the language again in case it has been updated
                $_SESSION['lang'] = $language;
            } 
            else 
            {
              $msg = "Error updating record: " . $conn->error;
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
        </script>
        <style>
            /*this is needed here even if it is already in base.css, bug with firefox.*/
            .subcontainer {
                border-radius: 5px;
                background-color: #fff;
                padding: 20px;
                text-align: left;
                width: 800px;
                margin-left:auto;
                margin-right: auto;
                /*border:1px solid #CCCCCC;*/
                margin-bottom:30px;
            }
            
            .subtitle::before{
                content:'\f007';
                font-family: "FontAwesome";
                font-size:1em;
                padding-right: 10px;
            }
            
            /*Do not move this code*/
            input[type='text']:read-only{
                background-color: #eee;
            }
        </style>
    </head>
    <body>
        <header>
            <?php 
            f_DisplayTopMenu();
            ?>
        </header>
        <?php echo f_DisplaySiteMenu(C_ACCOUNT, $personid); ?>
        <div id ="container">
            <?php            
            if ($_SESSION["personid"] > 0 && !$posted)
            {             
                $sql = "SELECT personid, username, firstname, lastname, gender, language,".
                        " addressstreet, addresscity, addressprovinceid, addresspostalcode, email,".
                        " phonenumber, dateofbirth,"
                        . " if('".$language."'='fra',persontype.PersonTypeNameFra, persontype.PersonTypeNameEng) as PersonTypeName".
                        " FROM person "
                        . " left join persontype"
                        . " on person.persontypeid = persontype.persontypeid"
                        . " where personid = ".$personid;
                $result = $conn->query($sql);
                
                if ($result->num_rows > 0) 
                {
                    // output data of each row
                    while($row = $result->fetch_assoc()) 
                    {                       
                        $username           = $row['username'];
                        $email              = $row['email'];
                        $firstname          = $row['firstname'];
                        $lastname           = $row['lastname'];
                        $gender             = $row['gender'];
                        $addressstreet      = $row['addressstreet'];
                        $addresscity        = $row['addresscity'];
                        $addressprovinceid  = $row['addressprovinceid'];
                        $addresspostalcode  = $row['addresspostalcode'];
                        $phonenumber        = $row['phonenumber'];
                        $dateofbirth        = $row['dateofbirth'];
                        $persontypename     = $row['PersonTypeName'];

                        //lets set a default value for gender as radio input gives
                        // an error when no value, no value mean field does not exist
                        if(is_null($row['gender'])){
                            $gender = 'M';
                        }
                        else{
                            $gender = $row['gender'];
                        }  
                    }  
                }
            }
            if (strlen($msg) > 0){
                echo f_DisplayMessage($msg, 'info');
            } 
            ?>
            <div class='space_height_30'></div>
            <div class="subcontainer">
                <div class='subtitle'><?php echo _ACCOUNT; ?></div>
                <form action="myaccount.php" method="post" id="form1">
                    <div class="row">
                      <div class="col-25">
                          <label for="personid"><?php echo _LABEL_PERSONID; ?></label>
                      </div>
                      <div class="col-75">
                          <input type="text" id="personid" name="personid" readonly value="<?php echo $personid.'-'.$persontypename; ?>">
                      </div>
                    </div>                                   
                    <div class="row">
                      <div class="col-25">
                        <label for="username"><?php echo _LABEL_USERNAME; ?></label>
                      </div>
                      <div class="col-75">
                          <input type="text" id="username" name="username" readonly value="<?php echo $username; ?>">
                      </div>
                    </div>                              
                    <div class="row">
                      <div class="col-25">
                        <label for="fname"><?php echo _LABEL_FIRSTNAME; ?></label>
                      </div>
                      <div class="col-75">
                          <input type="text" id="fname" name="firstname" value="<?php echo $firstname; ?>"  onclick="HideMessage();">
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-25">
                        <label for="lastname"><?php echo _LABEL_LASTNAME; ?></label>
                      </div>
                      <div class="col-75">
                        <input type="text" id="lastname" name="lastname" value="<?php echo $lastname; ?>"  onclick="HideMessage();">
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-25">
                        <label for="dateofbirth"><?php echo _LABEL_DATEOFBIRTH; ?></label>
                      </div>
                      <div class="col-75">
                        <input type="text" id="dateofbirth" name="dateofbirth" value="<?php echo $dateofbirth; ?>"  onclick="HideMessage();">
                      </div>
                    </div>                                
                    <div class="row">
                      <div class="col-25">
                        <label for="gender"><?php echo _LABEL_GENDER; ?></label>
                      </div>
                      <div class="col-75">
                        <label class="gender">
                            <input type="radio" name = "gender" value="M" <?php if ($gender=='M'){echo 'checked';} ?>  onclick="HideMessage();"><?php echo _MALE; ?></br>
                        </label>
                        <label class="gender">
                            <input type="radio" name = "gender" value="F" <?php if ($gender=='F'){echo 'checked';} ?>  onclick="HideMessage();"><?php echo _FEMALE; ?></br>
                        </label>
                        <label class="gender">
                            <input type="radio" name = "gender" value="O" <?php if ($gender=='O'){echo 'checked';} ?>  onclick="HideMessage();"><?php echo _OTHER; ?></br>                                    
                        </label>                                    
                      </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="language"><?php echo _LABEL_LANGUAGE; ?></label>
                        </div>
                        <div class="col-75">
                            <select id="lang" name="language" onchange="HideMessage();">
                                <option value="fra" <?php if ($language=='Fra'){echo 'selected';} ?>>Francais</option>
                                <option value="eng" <?php if ($language=='Eng'){echo 'selected';} ?>>English</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="phonenumber"><?php echo _LABEL_PHONENUMBER; ?></label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="phonenumber" name="phonenumber" value="<?php echo $phonenumber; ?>"  onclick="HideMessage();">
                        </div>
                    </div>                                
                    <div class="row">
                      <div class="col-25">
                        <label for="addressstreet"><?php echo _LABEL_STREETADRESS; ?></label>
                      </div>
                      <div class="col-75">
                        <input type="text" id="addressstreet" name="addressstreet" value="<?php echo $addressstreet; ?>"  onclick="HideMessage();">
                      </div>
                    </div>      
                    <div class="row">
                      <div class="col-25">
                        <label for="AddressCity"><?php echo _LABEL_CITY; ?></label>
                      </div>
                      <div class="col-75">
                        <input type="text" id="addresscity" name="addresscity" value="<?php echo $addresscity; ?>"  onclick="HideMessage();">
                      </div>
                    </div>       
                    <div class="row">
                      <div class="col-25">
                        <label for="addressprovinceid"><?php echo _LABEL_PROVINCE; ?></label>
                      </div>
                      <div class="col-75">
                          <?php echo f_GetProvinceList($addressprovinceid); ?>
                      </div>
                    </div>    
                    <div class="row">
                      <div class="col-25">
                        <label for="addresspostalcode"><?php echo _LABEL_POSTALCODE; ?></label>
                      </div>
                      <div class="col-75">
                        <input type="text" id="addresspostalcode" name="addresspostalcode" maxlength="7" placeholder="A1A 1A1" value="<?php echo $addresspostalcode; ?>"  onclick="HideMessage();">
                      </div>
                    </div>            
                    <div class="row">
                      <div class="col-25">
                        <label for="email"><?php echo _LABEL_EMAIL; ?></label>
                      </div>
                      <div class="col-75">
                        <input type="text" id="email" name="email" value="<?php echo $email; ?>"  onclick="HideMessage();">
                      </div>
                    </div>                                
                     <div class="buttonright">
                        <br/>
                        <!--<input type="submit" value="Submit" class="button">-->
                        <button type = "submit" value="Submit" class="button button1"><?php echo _SAVE ?></button>
                    </div>
                </form>
            </div><!-- /subcontainer -->
        </div> <!-- /container -->
        <?php echo f_DisplayFooter($language); ?>
    </body>
</html>