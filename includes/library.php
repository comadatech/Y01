<?php

//Combine two messages together with a separator if provided, $newmessage will be added to $originalmessage
// Note that $originalmessage is passe as a reference
function f_ConcatMessage(&$originalmessage,$newmessage, $separator = ''){
    
    if($separator == '</br>'){$separator = '<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';}
    
    if(strlen($originalmessage) > 0){
        $originalmessage = $originalmessage.$separator.$newmessage;    
    }
    else{
        $originalmessage = $newmessage;    
    }
}

function f_DisplayFooter($language){
    
    echo '<div id="footer" class="footer"><p>'. f_GetCompagnyName().'. '._ALLRIGHTS.'</p><p>'
            .'<a href=""><img src="images/icon-fb-516.png"></a>'
            .'<a href=""><img src="images/icon-instagram.png"></a>'
            .'<a href=""><img src="images/icon-twitter-519.png"></a>'
            .'<a href=""><img src="images/icon-youtube.png"></a>'
            . '</p>';
    
    echo "<ul id='menu'>"
            . "<li><a href='legal.php'>"._LEGAL."</a></li>"
            . "<li><a href='terms.php'>"._TERMS."</a></li>"
            . "</ul></div>";
}

function f_GetCompagnyName(){
    return C_COMPAGNYNAME;
}

function f_GetPersonID(){
    
    $personid = 0;
    
    if (isset($_SESSION['personid']) && !empty($_SESSION['personid']))
        {
            $personid = $_SESSION['personid'];
        }
    return $personid;
}

function f_GetPersonTypeID(){
    
    $persontypeid = 0;
            
    if(isset($_SESSION['persontypeid']) && !empty($_SESSION['persontypeid'])){
        $persontypeid = $_SESSION['persontypeid'];
    }
    
    return $persontypeid;
}

function f_GetSessionLanguage(){

    if(isset($_SESSION) && !empty($_SESSION['language'])){
        $language = $_SESSION['language'];
    }   
    else
    {
        //let's set it to default language
        $language = C_DEFAULTLANGUAGE;
    }
    
    return $language;
}

function f_SetLibraryLanguage($language){
    // Include Language file
    if(isset($_SESSION['language'])){
        include "includes/lang_".$_SESSION['language'].".php";
        $language = $_SESSION['language'];
    }
    else
    {
        //not set up them set to default English
        include "includes/lang_eng.php";
        $language = "eng";
        $_SESSION['language'] = "eng";
    }
}


function f_InitSessionLanguage(){

    if(isset($_SESSION) && !empty($_SESSION['language'])){
    }   
    else
    {
        $_SESSION['language'] = C_DEFAULTLANGUAGE; 
    }
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


function f_DisplaySiteMenu($activeitem=0, $personid = 0){
    
    $persontypeid = f_GetPersonTypeID();
    
    echo "<div class='clearfix'></div>";
    echo '<div class="topnav"> 
            <a href="index.php"'.($activeitem==C_HOME?' class="active" ':'').'>'._MENU_HOME.'</a>
            <a href="classes.php"'.($activeitem==C_CLASSES?' class="active" ':'').'>'._MENU_CLASSES.'</a>
            <a href="register.php"'.($activeitem==C_REGISTER?' class="active" ':'').'>'._MENU_REGISTER.'</a>
            <a href="contact.php"'.($activeitem==C_CONTACT?' class="active" ':'').'>'._MENU_CONTACT.'</a>
            <a href="instructor.php"'.($activeitem==C_INSTRUCTOR?' class="active" ':'').'>'._MENU_INSTRUCTORS.'</a></div>';
    echo "<div class='clearfix'></div>";
}

function f_GetProvinceList($SelectedProvinceID = 0){
    
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

function f_DisplayTopMenu(){
    
    //get count of item(selected activity) in shopping cart
    $CartCount      = 0;
    $personid       = 0;
    $personid       = f_GetPersonID();
    $persontypeid   = f_GetPersonTypeID();
    $personfullname = f_GetPersonFullName();
    $content1       = "";
    $content2       = "";
    $content3       = "";
    

   if(isset($_SESSION['cart']))
   {
        $CartCount = sizeof($_SESSION['cart']);
   }
   
    if($personid > 0){
        
        $content1 = '<span class="dropdown">
                      <span class="dropbtn">'.$personfullname.'</span>
                      <span class="dropdown-content">'; 
  
        /*Menu for client/student*/
        if($personid > 0 && $persontypeid == 3){

            $content2 = '<a href="schedule.php" class="m_subscriptions">'._MENU_MYSUBSCRIPTIONS.'</a>'
                        .'<a href="myaccount.php" class="m_account">'._MENU_ACCOUNT.'</a>'
                        .'<a href="passwordchg.php" class="m_password">'._MENU_CHANGEPASSWORD.'</a>'
                        .'<a href="logout.php" class="m_logout">'._MENU_LOGOUT.'</a>';
        }

        /*Menu for instructors */
        if($personid > 0 && $persontypeid == 2){
            
            $content2 =  '<a href="instructorclasses.php" class="m_myclass">'._MENU_MYCLASSES.'</a>'
                        .'<a href="schedule.php" class="m_subscriptions">'._MENU_MYSUBSCRIPTIONS.'</a>'
                        .'<a href="myaccount.php" class="m_account">'._MENU_ACCOUNT.'</a>'
                        .'<a href="profile.php" class="m_profile">'._MENU_PROFILE.'</a>'
                        .'<a href="instructorsocialmedia.php" class="m_social">'._MENU_SOCIALMEDIA.'</a>'
                        .'<a href="passwordchg.php" class="m_password">'._MENU_CHANGEPASSWORD.'</a>'
                        .'<a href="logout.php" class="m_logout">'._MENU_LOGOUT.'</a>';
        }

        /*Will need to add admin menu*/

    }
    else{
        $personfullname = _MENU_LOGIN;
        
        $content1 = '<span class="dropdown">
                      <span class="loginbtn">'._MENU_LOGIN.'</span>
                      <span class="dropdown-content">';      
    }

    $content3 = '</span></span>';
    
    $dropdownmenu = $content1.$content2.$content3;

    echo '<div id="leftside"><a href="index.php" style="text-decoration: none;">'
    . '<span class="saulelogo">Saule</span>'
            .'<span class="yogalogo"> Yoga</span>'
            . '</a></div>'
    .'<div id="rightside" style="float: right; height:30px; color:#fff">'
//      ._LANGUAGE.'<span class="topbaritem"></span>|'
//        .'<span class="topbaritem"></span>'
        .'<span class="">'.$dropdownmenu.'</span>'
//        .'<span class="topbaritem">'.$loginlogout.'</span>|'
//        .'<span class="topbaritem"><a href="mailto:info@sauleyoga.com">info@sauleyoga.com</a></span>|'
            .'<span class="topbaritem"></span>'
            .'<a href="cart.php" class="cartmenu">'
                .'<i class="fa" style="font-size:24px; cursor: pointer">&#xf07a;</i>'
                .'<span class="badge badge-warning" id="lblCartCount">'.$CartCount.'</span>'
           .'</a>'
           .'<span class="topbaritem"></span>'._LANGUAGE
    .'</div>';
}

function f_DisplayMessage($message, $type=''){
    echo "<div class='space_height_30'></div>";
    echo "<div id='message' class='message ".$type." '>".$message."</div>";
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
    //must have at least one lowercase carater
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

/*Format dollar */
function f_SetDollarFormat($value) {
    
  if ($value<0) return "-".f_SetDollarFormat(-$value);
  
  return '$' . number_format($value, 2);
}

/*If it is in the cart return true otherwise return false*/ 
function f_IsInCart($activityscheduleid){
    if(isset($_SESSION["cart"])){  
        if(array_search($activityscheduleid,$_SESSION["cart"]) !== false){
            return 'Y';
        }
    }
    return 'N';
}

function f_IsAlreadySubscribe($activityscheduleid, $personid){
    
    require 'config.php';
    
    $sql = "SELECT ifnull(activityscheduleid,0) as activityscheduleid "
            . " from activityregistration "
            . " where activityscheduleid = ".$activityscheduleid
            . " and personid=".$personid." and activityregistration.activeind = 'Y'"
            . " and (activityregistration.DeactivatedDate is null or activityregistration.DeactivatedDate = 0) ";
    
    $result = $conn->query($sql);

    if ($result->num_rows > 0) 
    {
        while($_row = $result->fetch_assoc()) 
        {  
            return true;
        }
    }
    return false;
}

function f_GetPersonFullName(){

        if(isset($_SESSION['personfullname']) && !empty($_SESSION['personfullname'])){
            return $_SESSION['personfullname'];
        }
    
    return "";
}

function f_InitSessionVariable(){
    
    f_InitSessionLanguage();
    
    //if no session then lets start the session
    if(!isset($_SESSION["personid"]) or $_SESSION["personid"]<0)
    {
        $_SESSION["personid"] = 0;    
    }
    
    //must code a isset for the cart in case that it does not exists
    if(!isset($_SESSION['cart']))
    {
        $_SESSION['cart'] = array(); 
    }
}

function get_file_extension($file_name) {
    return substr(strrchr($file_name,'.'),1);
}

function f_GetSocialMediaList($socialmediaidlist){
    
    //include files
    require 'config.php';
    $string = '';
    
    //This is to eliminate the ones already added by the instructor
    if(strlen($socialmediaidlist)>0){
        $socialmediaidlist = " and SocialMediaID not in ($socialmediaidlist)";
    }
    
    $sql="select SocialMediaID, SocialMediaName
            from socialmedia
            where ActiveIND = 'Y'
            and (DeactivatedByUserID is null or DeactivatedByUserID=0)
            $socialmediaidlist
            order by SocialMediaName";
    
    $result = $conn->query($sql);

    if ($result->num_rows > 0) 
    {
        $string = '';
        $ListHeader = "<select name='socialmediaid[]' id='socialmediaid' style='width:200px' onchange='HideMessage();'>";
        $ListFoother = "</select>";
        
        $string = $string."<option value='0'>Select a Social Media</option>";

        // output data of each row
        while($row = $result->fetch_assoc()) 
        {   
            $string = $string."<option value='".$row["SocialMediaID"]."'>".$row['SocialMediaName']."</option>";
        }
        return $ListHeader.$string.$ListFoother;
    } 
}

function f_GetPersonInfo($personid, $language ,$colname = ""){
      //include files
    require 'config.php';

    $sql="SELECT PersonID, Person.PersonTypeID, FirstName, "
        ." LastName, UserName, Password, PasswordExpiryDate, "
            . " if ('$language' = 'fra', PersonType.PersonTypeNameFra, PersonType.PersonTypeNameEng) as PersonTypeName,"
        ." Gender, DateOfBirth, `Language`, Person.ActiveIND, ConfirmedIND, "
        ." AddressStreet, AddressCity, AddressProvinceID, AddressPostalCode, "
        ." Email, PhoneNumber, Note, Person.CreatedDate, Person.CreatedByUserID, Person.ModifiedDate,"
        ." Person.ModifiedByUserID, Person.DeactivatedDate, Person.DeactivatedByUserID "
            . " FROM person "
            . " left join PersonType"
            . " on person.persontypeid = PersonType.persontypeid"
            . " where PersonID = $personid";
    
    $result = $conn->query($sql);
    
    $value="";

    if ($result->num_rows > 0) 
    {
        // output data of each row
        while($row = $result->fetch_assoc()) 
        {   
            
            $value = $row[$colname];
            
//            switch ($colname) {
//            case 'PersonTypeID':
//              $value=$row['PersonTypeID'];
//              break;
//            case 'FirstName':
//              $value=$row['PersonTypeID'];
//              break;
//            case label3:
//              code to be executed if n=label3;
//              break;
//              ...
//            default:
//              code to be executed if n is different from all labels;
//          }
        }
    } 
    
    return $value;
    
}
?>