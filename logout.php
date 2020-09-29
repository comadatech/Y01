<?php
session_start();
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    //Since this is the main page, let's ensure that there is no session started
    if(isset($_SESSION)) {
        $_SESSION['personid']=0;
//        unset($_SESSION['cart']);
//        session_start();
//        session_destroy();
//        session_end();
   }
  
  header("Location: index.php"); 
?>

 