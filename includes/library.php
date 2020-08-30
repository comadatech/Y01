<?php

function f_GetCompagnyName(){
    return C_COMPAGNYNAME;
}

function f_SetSessionLanguage(){
    //lets set the language for the session
    if (isset($_POST['language']) && !empty($_POST['language'])){
        $language = $_POST['language'];
    }
    else
    {
        if(isset($_SESSION) && !empty($_SESSION['language'])){
//            if(!isset($_SESSION)) {
            $language = $_SESSION['language'];
        }   
        
        else
        {
            //let's set it to default language
            $language = C_DEFAULTLANGUAGE; 
        }

    }
    $_SESSION['language'] = $language;
    return $language;
}

function f_SetSessionActivity(){
   // set session time out
    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > C_TIMEOUT)) {
        // last request was more than 15 minutes ago
        session_unset();     // unset $_SESSION variable for the run-time 
        session_destroy();   // destroy session data in storage
        //go back to login
        echo '<script type="text/javascript"> window.location.href = "login.php" </script>';
    }
    $_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp  
}

function f_DisplayHeader(){
    
   //get count of item(selected activity) in shopping cart
   $CartCount = 0;

    $CartCount = sizeof($_SESSION['cart']);
    
    if($_SESSION['personid'] > 0){
       $loginlogout = _MENU_LOGOUT;
       $item1 = '<a href="profile.php">My account</a>';
    }
    else{
        $loginlogout = _MENU_LOGIN;
        $item1 = '(819) 123-4567';
    }
    
    echo '<div id="leftside"><a href="index.php" style="color:green; text-decoration: none;">'.f_GetCompagnyName().'</a></div>'
    .'<div id="rightside" style="float: right; height:30px">'
                        ._LANGUAGE.'<span class="topbaritem"></span>|'
        .'<span class="topbaritem">'.$item1.'</span>|'
        .'<span class="topbaritem">'.$loginlogout.'</span>|'
//        .'<span class="topbaritem"><a href="mailto:info@sauleyoga.com">info@sauleyoga.com</a></span>|'
            .'<a href="payments.php">'
           .'<i class="fa" style="font-size:24px; cursor: pointer">&#xf07a;</i>'
                .'<span class="badge badge-warning" id="lblCartCount">'.$CartCount.'</span>'
           .'</a>'
    .'</div>';
}

function f_DisplaySiteMenu($activeitem=0){
    echo "<div class='clearfix'></div>";
    echo '<div class="topnav"> 
            <a href="index.php"'.($activeitem==C_HOME?' class="active" ':'').'>'._MENUHOME.'</a>
            <a href="toto.php"'.($activeitem==C_TOTO?' class="active" ':'').'>'._MENUTOTO.'</a>   
            <a href="register.php"'.($activeitem==C_REGISTER?' class="active" ':'').'>'._MENUREGISTER.'</a>
            <a href="contact.php"'.($activeitem==C_CONTACT?' class="active" ':'').'>'._MENUSCONTACT.'</a>
            <a href="subscribeto.php"'.($activeitem==C_CLASSES?' class="active" ':'').'>'._MENUCLASSES.'</a>
            <a href="instructor.php"'.($activeitem==C_INSTRUCTOR?' class="active" ':'').'>'._MENU_INSTRUCTORS.'</a></div>';
     echo "<div class='clearfix'></div>";
     
     //class="active"
}

function f_SetLibraryLanguage($language){
    if ($language == 'Eng'){
        include 'includes/lang_eng.php'; 
    }
    else{
        include 'includes/lang_fra.php';   
    }      
}


function f_GetProvinceList($SelectedProvinceID){
    
       //include files
   require 'config.php';
   $string = '';

    $sql = "select ProvinceID, ProvinceName from province where ActiveIND = 'Y' and DeactivatedDate is null order by ProvinceName";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) 
    {
        $ListHeader = "<select name='addressprovinceid' id='addressprovinceid' onchange='HideMessage();'>";
        $ListFoother = "</select>";

        // output data of each row
        while($row = $result->fetch_assoc()) 
        {   
            if ($row["ProvinceID"] == $SelectedProvinceID){
                $string = $string."<option value='".$row["ProvinceID"]."' selected >".$row['ProvinceName']."</option>";
            }
            else
            {
                $string = $string."<option value='".$row["ProvinceID"]."'>".$row['ProvinceName']."</option>";
            }
        }
        
        return $ListHeader.$string.$ListFoother;
    } 
}

function f_DisplayMessage($message){
    echo "<div id='message' class='message warning'>".$message."</div>";
}

//Combine two messages together with a separator if provided, $newmessage will be added to $originalmessage
// Note that $originalmessage is passe as a reference
function f_ConcatMessage(&$originalmessage,$newmessage, $separator = ''){
    if(strlen($originalmessage) > 0){
        $originalmessage = $originalmessage.$separator.$newmessage;    
    }
    else{
        $originalmessage = $newmessage;    
    }
}

function f_ValidateFirstName($firstname, &$message){
    
    $valid = true;
    
    // firstname cannot be NULL
    if(!f_ValidateNotNull(_LABEL_FIRSTNAME,$firstname, $message)){
       $valid = false; 
    }
    else{
            $message = $message;
    } 
    
    // Should NOT it contain a NUMBER
    if(preg_match('/\d/', $firstname)){
	$message =  _MSG_NOTPERMITTED.' '._LABEL_FIRSTNAME;
        $valid = false; 
    }
    else{
            $message = $message;
    }

    return $valid;    
}

function f_ValidateLastName($lastname, &$message){
    
    $valid = true;
    
    // firstname cannot be NULL
    if(!f_ValidateNotNull(_LABEL_LASTNAME,$lastname, $message)){
       $valid = false; 
    }
    else{
            $message = $message;
    } 
    
    // Should NOT it contain a NUMBER
    if(preg_match('/\d/', $lastname)){
	$message =  _MSG_NOTPERMITTED.' '._LABEL_LASTNAME;
        $valid = false; 
    }
    else{
            $message = $message;
    }

    return $valid;    
}


function f_ValidateEmail($email, &$message){
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
       $valid = false; 
       $message = _MSG_INVALIDEMAIL;
    } 
    else 
    {
        $message = $message;
        $valid = true;   
    }
    
    return $valid;
}

function f_ValidateNotNull($colname,$string, &$message){
    if($string === ''){

        f_ConcatMessage($message, "<u>".$colname."</u>"._MSG_CANNOTBENULL,"</br>");
        $valid = false;
    }
    else
    {
        $message = $message;
        $valid = true;
    }
    return $valid;
}

function f_DisplayFooter($language){
    echo '<div id="footer"><p>'. f_GetCompagnyName().'. '._ALLRIGHTS.'</p><p>'
            .'<a href=""><img src="images/icon-fb-516.png"></a>'
            .'<a href=""><img src="images/icon-instagram.png"></a>'
            .'<a href=""><img src="images/icon-twitter-519.png"></a>'
            .'<a href=""><img src="images/icon-youtube.png"></a>'
            . '</p>';
    
    echo "<ul id='menu'>"
            . "<li>"._LEGAL."</li>"
            . "<li>"._TERMS."</li>"
            . "</ul></div></a>";

}

function f_GetLanguage(){
    if(isset($_SESSION)) {
        return $_SESSION['language'];
   }    
   else{
       return C_DEFAULTLANGUAGE;
   }
}

function f_ValidateNewPassword($password, &$message){
    //max caraters
    //min caracters
    //must have at least one number
    //must have at least one special caracter
    //must have at least une lowercase caracter
    // must have at least one lowercase carater
    $returnvalue = true;
    
    //Max Lenght
    if(strlen($password )> C_MAXPASSWORDLENGHT ){
        
        $newmessage = _MSG_PASSWORDMAXLENGHT.C_MAXPASSWORDLENGHT;
        f_ConcatMessage($message,$newmessage.'.','</br>');
        $returnvalue = false;
    }
    
    //Min lenght
    if(strlen($password )< C_MINPASSWORDLENGHT ){
        $newmessage = _MSG_PASSWORDMINLENGHT.C_MINPASSWORDLENGHT;
        f_ConcatMessage($message,$newmessage.'.','</br>');
        $returnvalue = false;
    }
    
    $ucl = preg_match('/[A-Z]/', $password); // Uppercase Letter
    $lcl = preg_match('/[a-z]/', $password); // Lowercase Letter
    $dig = preg_match('/\d/', $password); // Numeral
    $nos = preg_match('/\W/', $password); // Non-alpha/num characters (allows underscore)

    if(!$ucl) {
        $newmessage = _MSG_ONEUPPERCASE;
        f_ConcatMessage($message,$newmessage,'</br>');
        $returnvalue = false;
    }

    if(!$lcl) {
        $newmessage = _MSG_ONELOWERCASE;
        f_ConcatMessage($message,$newmessage,'</br>');
        $returnvalue = false;
    }

    if(!$dig) {
        $newmessage = _MSG_ONENUMERAL;
        f_ConcatMessage($message,$newmessage,'</br>');
        $returnvalue = false;
    }

    // I negated this if you want to dis-allow non-alphas/num:
    if(!$nos) {
        $newmessage =  "<u>New password</u>, must have at least one Symbols!";
        f_ConcatMessage($message,$newmessage,'</br>');
        $returnvalue = false;
    }    

    return $returnvalue;
}

function f_PopupMessage($title,$message)
{
    $msg = "<div id='helptext' style='display:none'>"
            ."<div id='header' style='background-color:red'>"
            ."<div style='float: left; font-weight:bold'>".$title."</div>"
            ."<div style='float: right'>"
                . "<i id='closebotton' class='fa fa-window-close' style='border:0px; padding: 0px;' onclick='help();'></i>"
            ."</div>"
            ."</div>"
            . "<br/><br/>"
            . $message
            ."</div>"
            . "</div>";
    
    echo $msg;
}

function f_IsUserNameExists($username, $conn){
    // does username already exists?
    $sql = "SELECT PersonID, firstname, lastname, password, language FROM person where username = '".$username."'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) 
    {
        return true;
    }
    return false;
}

function f_GetTaxRate(){
    
    require 'config.php';
    
    $sql = "SELECT percentage from TaxRate where ActiveInd = 'Y' and StartDate <= now() and DeactivatedDate is null";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) 
    {
        while($_row = $result->fetch_assoc()) 
        {  
            $percentage = $_row["percentage"];
            return $percentage;
        }
    }
    return 0;
}

function f_GetTaxName(){
    
    require 'config.php';
    
    $sql = "SELECT taxnameeng from TaxRate where ActiveInd = 'Y' and StartDate <= now() and DeactivatedDate is null";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) 
    {
        while($_row = $result->fetch_assoc()) 
        {  
            $taxname = $_row["taxnameeng"];
            return $taxname;
        }
    }
    return 0;
}

function f_SetDollarFormat($value) {
    
  if ($value<0) return "-".f_SetDollarFormat(-$value);
  
  return '$' . number_format($value, 2);
}

function f_IsInCart($selectedactivity){

        $found = false;
        
        if(isset($_SESSION["cart"])){  
            
            //do not add if already in cart
            while (list ($key, $val) = each ($_SESSION['cart'])) 
            { 
                if($selectedactivity == $val){
                  $found = true;  
                }
            }
        }
        
        return $found;
}
?>