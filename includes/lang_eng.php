<?php

/* 
 * Text englais
 * utiliser une convention SVP.
 */

//General
define("_WELCOME","Welcome");
define("_REGISTER", "Register");
define("_SUBMIT", "Submit");
define("_SUBCRIBRED_TO","You are subscribed to the following activities");
define("_NOACTIVIIES","You have not subscribed to any activities. Click <a href='subscribeto.php'>here</a> to subscribe to one of our activities.");
define("_WRONGPASSWORD","Invalid user name or password click <a href='index.php?language=Eng'>here</a> to try again.");
define("_LOGINTITLE","Enter Username and Password");
define("_PROFILE","Profile");
define("_MALE","Male");
define("_FEMALE","Female");
define("_OTHER","Other");
define("_LOGIN","Sign in");
define("_LANGUAGE","<a href='?language=Fra'>Fran&ccedil;ais</a>");
define("_SUBSCRIPTION","Subscription");
define("_LOGOUT","Click <a href = 'index.php?language=eng' tite = 'Logout'>here</a> to logout.");
define("_SCHEDULE","Schedule");
define("_PASSWORDCHANGE","Password Change");
define("_FORGOTPASSWORD","Forgot password? Click <a href=''>Here</a>");
define("_NOTREGISTERED","Not registered? Click <a href='register.php'>Here</a> to register!");
define("_ALLRIGHTS",'All rights reserved.');
define("_LEGAL","<a href=''>Legal & Privacy</a>");
define("_TERMS","<a href=''>Terms & Conditions</a>");
define("_REGISTERTITLE","Register");
define("_ALREADYREGISTER","Already registered? Click <a href='index.php?lang=Eng'>here</a>");
define("_TIPS","Tips");
define("_TOLOGIN","Click <a href='index.php?language=Eng'>here</a> to sign in.");
define("_PRICE","Prix");
define("_SHOPPINGCART",'Shopping Cart');
define("_CLASSES","classes");
define("_GOCHECKOUT","Go to check out");
define("_TAXES","Taxes");
define("_TOTAL","Total");

//Input Label
define("_LABEL_USERNAME","User Name");
define("_LABEL_USERNAME_TT","Enter your user Name");
define("_LABEL_PASSWORD","Password"); 
define("_LABEL_FIRSTNAME","First Name");
define("_LABEL_LASTNAME","Last Name");
define("_LABEL_GENDER","Gender");
define("_LABEL_LANGUAGE","Language");
define("_LABEL_STREETADRESS","Street Address");
define("_LABEL_CITY","City");
define("_LABEL_PROVINCE","Province");
define("_LABEL_POSTALCODE","Postal Code");
define("_LABEL_EMAIL","Email");
define("_LABEL_OLDPASSWORD", "Old Password");
define("_LABEL_NEWPASSWORD", "New Password");
define("_LABEL_RETYPENEWPASSWORD", "Retype New Password");
define("_LABEL_PERSONID","Person #");
define("_LABEL_PHONENUMBER","Phone Number");
define("_LABEL_DATEOFBIRTH","Date of Birth");

//input title
define("_TLABEL_FIRSTNAME","Please enter your first name");
define("_TLABEL_LASTNAME","Please enter your last name");
define("_TLABEL_USERNAME","Please enter a username");
define("_TLABEL_PASSWORD","Please enter a password");
define("_TLABEL_RETYPEPASSWORD","Please retype your password");
define("_TLABEL_EMAIL","Please renter your email");
define("_TLABEL_SHOWPASSWORD","Show password");
define("_TLABEL_SHOWRETYPEPASSWORD","Show retype password");
define("_TLABEL_HIDEPASSWORD","Hide password");
define("_TLABEL_HIDERETYPEPASSWORD","Hide retype password");

//Column Label
define("_COL_ACTIVITYNAME","Activity");
define("_COL_STARTDATE","Start Date");
define("_COL_STARTTIME","Start Time");
define("_COL_ENDDATE","End Date");
define("_COL_TIME","Time");
define("_COL_LOCATION","Location");
define("_COL_REGISTEREDDATE","Registered Date");
define("_COL_ALREADYSTARTED","Already Started");
define("_COL_NOTE","Note");
define("_COL_DETAIL","Detail");

//Menu
define("_MENUHOME","Home");
define("_MENUREGISTER","Register");
define("_MENUSCONTACT","Contact");
define("_MENUCLASSES","Classes");
define("_MENULANGUAGE","Francais");
define("_MENU_INSTRUCTORS","Instructors");
define("_MENU_LOGIN","<a href='login.php'>Sign in</a>");
define("_MENU_LOGOUT","<a href='logout.php'>Logout</a>");
define("_MENUTOTO","Toto");

define("_MENUSUBSCRIBTION","Subscription");
define("_MENUSCHEDULE","Schedule");
define("_MENULOGOUT","Logout");
define("_MENUPROFILE","Profile");
define("_MENUCHANGEPASSWORD","Password");
define("_MENUSUBSCRIBETO","Subscribe To");

//Messages
define("_MSG_SAVE_SUCCESS","Updated successfully!");
define("_MSG_WRONGRETYPEPASSWORD","The new password is not the same as the retype password.");
define("_MSG_INVALIDOLDPASSWORD","Invalid old password");
define("_MSG_PASSWORDMAXLENGHT","Maximum password lenght is ");
define("_MSG_PASSWORDMINLENGHT","Minimum password lenght is ");
define("_MSG_CANNOTBENULL"," can not be null. Please enter a value.");
define("_MSG_FAILLED_LOGIN","Wrong user name or password. Click <a href='index.php?lang=eng'>here</a> to try again.");
define("_MSG_ONEUPPERCASE","<u>New password</u> must have at least one upper case!");
define("_MSG_ONELOWERCASE","<u>New password</u> must have at least one lower case!");
define("_MSG_ONENUMERAL","<u>New password</u> must have at least one numeral!");
define("_MSG_ONESYMBOLS","<u>New password</u> must have at least one Symbols!");
define("_MSG_REGCONFIRMATION","Once you click register you will receive a confirmation email.");
define("_MSG_PASSWORDREQUIREMENTS","Password must be composed of at least ".C_MINPASSWORDLENGHT
                    . " characters and a minimum of ".C_MAXPASSWORDLENGHT." characters."
                    . "<br/><br/>"
                    . "Must also have at least one lowercase, one uppercase, one numeral and one special character. Ex. Qwerty1!");
define("_MSG_MUSTCONFIRM","A confirmation email has been send to you. Please confirm within the next 12 hours.");
define("_MSG_INVALIDEMAIL","Invalid email, must be composed of a @ sign and a dot.");
define("_MSG_NOTPERMITTED","Number are not permitted in");
define("_MSG_ALREADYSUBSCRIBED","Already Subscribed");
define("_MSG_YOUAREDISCONNECTED","You're signed out right now. To save these items or see your previously saved items,  <a href='login.php'>sign in.</a>");
?>