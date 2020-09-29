<?php

/*
    Created on : Jul. 27, 2020, 4:49:12 p.m.
    Author     : Serge Samson
    Application Constant, excluding language, see lan_fra.php and lan_eng.php for 
    language.
*/

//recaptch
define("C_SITE_KEY","6LfZrbwZAAAAAMMXWD72om7IIpRRh3Jl-A6n3Lgf");
define("C_SECRET_KEY","6LfZrbwZAAAAAI0UxtXLg2NFeKKNYVytMaGTZjfS");

//Website name/Compagny name
define("C_COMPAGNYNAME","Saule Yoga");

//session time out
define("C_TIMEOUT",30000);

// default language
define("C_DEFAULTLANGUAGE","fra");

//for password change
define("C_MINPASSWORDLENGHT",8);
define("C_MAXPASSWORDLENGHT", 12);

//Person Type - Must math the database table PersonType and should not never change
// as it is tied to business rules.
define("C_PERSONTYPE_ADMIN",1); //'System Admin'
define("C_PERSONTYPE_TEACHER",2);//'Teacher'
define("C_PERSONTYPE_CUSTOMER",3); //'Student/Customer'

// Menu constant
define("C_NONE",0);
define("C_HOME",1);
define("C_REGISTER",2);
define("C_CONTACT",3);
define("C_CLASSES",4);
define("C_INSTRUCTOR",5);
define("C_TOTO",6);
define("C_SCHEDULE",7);
define("C_ACCOUNT",8);
define("C_PASSWORDCHG",9);
define("C_INSTRUCTORCLASSES",10);

/*Instructors Picture Path*/
define("C_INSTRUCTORSPICTUREPATH",'instructorspicture/');
