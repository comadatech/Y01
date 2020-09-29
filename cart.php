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
    
    f_SetSessionActivity();
  
    // Declare variables
    $msg        = "";
    $posted     = false;
    $personid   = 0;
    $rowcounter = 0;
    $subtotal   = 0;
    $classalreadysubscribed = "";
    $CartCount  = 0;
    
    $personid = f_GetPersonID();
    
//    if(isset($_SESSION["personid"]) && !empty($_SESSION["personid"]))
//    {
//        if ($_SESSION["personid"] > 0)
//        {
//            $personid = $_SESSION['personid']; 
//        }
//        else{
//            //no personid from session? we should not go anywhere execpt go back to login page 
//            //echo '<script type="text/javascript"> window.location.href = "index.php" </script>';
//        }
//    }
    
    //are we deleting an activity?
    if(isset($_REQUEST['asid']) && !empty($_REQUEST['asid'])){
                
        $asid           = $_REQUEST['asid'];
        $position       = array_search($asid,$_SESSION["cart"]);
        
        if(!is_null($position)){
          unset($_SESSION["cart"][$position]);  
        }
    }
    
    if(isset($_POST['selectedactivity']) && !empty($_POST['selectedactivity'])){
        
        $selectedactivity = $_POST['selectedactivity'];
        $found = false;
        
        if(isset($_SESSION["cart"])){  
            
            //do not add if already in cart
            while (list ($key, $val) = each ($_SESSION['cart'])) 
            { 
                if($selectedactivity == $val){
                  $found = true;  
                }
            } 
            
            // if not found let's add it
            if($found == false){
                array_push($_SESSION['cart'],$_POST['selectedactivity']);
            }
            
            reset($_SESSION['cart']);
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
        <style>
            /* overwritting from base*/

            .grid-container {
              display: grid;
              grid-template-columns: auto auto;
              grid-gap: 10px;
              /*background-color: #2196F3;*/
              padding: 10px;
              height:fit-content;
            }

            .grid-container > div {
              text-align: center;
              padding: 0px 0;
              font-size: 30px;
              border:1px solid #ffa500;
              border-radius: 4px;
              background-color: #fff;
              height: max-content;
            }

            .grid-container .item1 > div {
              /*background-color: #fff;*/
              text-align: left;
              padding: 20px;
              font-size: 16px;
              border:1px solid #ffa500;
              /*margin-bottom:10px;*/
              border-radius: 4px;
            }

            .item2 {
                grid-area: 1 / 2 / 2 / 6;
                height:fit-content;
            }
            
            .alreadysubscribedstyle{
                background-color: dddddd;
            }
            
            .alreadysubscribedtext{
                color:red;
                float:right;
                font-size: .8rem;
            }

            .item1.item1{
                border:0px;
            }
            
            .item1 .item1 > div{
                border:0px;
            }
            
            .item1 img{
                width:140px; 
                height:120px;
            }
            
            .description{
                padding-left:20px;
                font-family: Gill, Helvetica, sans-serif;
                font-size: 13px;
                line-height: 20px;
            }
            
            .location{
                /*padding-left:20px;*/
                font-family: Gill, Helvetica, sans-serif;
                font-size: 13px;
            }
            
            .price{
                font-weight:800;
            }
           
            .price::before{
                content: '$';
            }
            
            .space2 {
                /*height:1px;*/
                border:none !important;
                /*background-color:#fff4e3;*/ 
                padding:6px !important;
            }
            
            .paymentright{
                float:right;
                text-align: right;
                font-size: 1rem;
                padding:10px;
                line-height: 20px;
            }
            
            .paymentleft{
                float:left;
                text-align: left;
                font-size: 1rem;
                padding:10px;
                line-height: 20px;
            }
            
            .button{
                /*width: 98%;*/
                width:48%;
                border-radius:4px;
            }
            
            /*overriden*/
            .button a{
                color:#fff;
                text-decoration: none;
            }
            
            .line{
                width:100%;
                border-bottom: 1px solid #ffa500;
                content:'';
                margin-top:10px;
                clear:both;
            }
            
            .totalline{
                font-size:1.2rem; 
                margin-top:10px;
            }
            
            .removelink{
                float:right;
                font-size: .8rem;
            }
            
            /*Overriding*/
            .subtitle{
                margin-bottom: 0px;
                text-align:left;
            } 
        </style>
   </head>
   <body>
        <header>
        <?php 
            f_DisplayTopMenu();
        ?>
        </header>
       <?php echo f_DisplaySiteMenu(C_NONE, $personid); ?>
        <div id='container'>
        <?php
            if($personid < 1 or is_null($personid))
            {
                echo "<div class='space_height_30'>"
                . "</div><div class='message info'>"._MSG_YOUAREDISCONNECTED."</div>";
            }

            if(isset($_SESSION['cart'])){
                $CartCount = sizeof($_SESSION['cart']);    
            }
            
            echo '<div style="text-align:left; margin-left:20px">'
           .'<div class="subtitle">'._SHOPPINGCART.' ('.$CartCount.' '._CLASSES.')'
                    . '</div></div>';

            if($CartCount > 0)
            {
                echo '<div class="grid-container">'
                .'<div class="item1">';
            
                while (list($key, $val) = each ($_SESSION['cart'])) 
                { 

                    $stmt = $conn->prepare("Call USP_GetActivityScheduleDetail(".$val.",'".$language."')");
                    //$stmt->bind_param("i", $val);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) 
                    {
                        while ($row = $result->fetch_assoc())
                        { 
                            $image                  = $row["image"];
                            $activityname           = $row["ActivityName"];
                            $activityprice          = $row["ActivityPrice"];
                            $activityscheduleid     = $row["activityscheduleid"];
                            $scheduledescription    = $row["ScheduleDescription"];
                            $location               = $row["Location"];

                            $isalreadysubscribed     = f_IsAlreadySubscribe($activityscheduleid, $personid);

                            if($isalreadysubscribed == false){
                                $subtotal = $subtotal + $activityprice;
                                $classalreadysubscribed='';
                            }
                            else{
                                $classalreadysubscribed = 'alreadysubscribedstyle';
                            }


                            ?>
                            <!--<div class="item1">-->
                            <div class="item2 <?php echo $classalreadysubscribed; ?>" >
                                <div class='activity image' style='float:left'><img src='images/<?php echo $image; ?>'></div>

                                <div class='activity description' style='float:left'><?php echo $scheduledescription; ?>
                                    <div class='activity location'><b>Location:</b> <?php echo $location; ?></div>
                                </div>
                                <div class='activity price' style='float:right'><?php echo $activityprice; ?></div>
                                <div style='clear:both'></div>
                                <?php 
                                if($isalreadysubscribed){
                                    echo "<div class='alreadysubscribedtext'>"._MSG_ALREADYSUBSCRIBED."</div><br>";
                                }
                                ?>                            
                                <div class='removelink'><a href='?asid=<?php echo $activityscheduleid; ?>'>Remove</a></div>
                            </div><div class="space2"></div>
                            <?php 
                        } 
                        $stmt->close();
                    }
                }
            }
            else{
//            if($CartCount==0){
                ?>
                <div class="grid-container">
                    <div class="item1">  
                        <div class="item2">
                            <div class='message info'><?php echo _MSG_NOCLASSESELECTED?></div>
                            <div style='clear:both'></div>
                        </div>
                <?php 
                }
                ?>
                </div>
                <div class="item2">
                    <a href='classes.php'><button class='button'><?php echo _ADDMORECLASSES; ?></button></a>
                    <button class='button'><?php echo _GOCHECKOUT; ?></button>
                    <div></div>
                    <?php 

                    setlocale(LC_MONETARY,"en_US");

                    // Do the math
                    $taxrate = f_GetTaxRate();
                    $taxamount = $subtotal * ($taxrate/100); 
                    $totalpayment = $taxamount+ $subtotal;
                    $taxname = f_GetTaxName();

                    // do the formating
                    $taxamount      = f_SetDollarFormat($taxamount);
                    $totalpayment   = f_SetDollarFormat($totalpayment);
                    $subtotal       = f_SetDollarFormat($subtotal);

                    echo '<div class="paymentleft">';
                        echo '<div>'.ucfirst(_CLASSES).' ('.$CartCount.')</div>';
                        echo '<div>'._TAXES.' ('.$taxname.' '.number_format($taxrate,2).'%)</div>';
                    //echo '</div>';    
                    //echo '<div style="clear:both"></div>';
                    // echo '<div class="paymentleft">';
                    //    echo '<div>Total</div>';
                    echo '</div>';
                    echo '<div class="paymentright">';
                        echo '<div>'.$subtotal.'</div>';
                        echo '<div>'.$taxamount.'</div>';
                    echo '</div>';
                    echo '<div class="line"></div>';
                    echo '<div class="paymentleft totalline">Total</div>';
                    echo '<div class="paymentright">';
                        echo '<div class="totalline">'.$totalpayment.'</div>';                
                    echo '</div>';
                    echo '<div style="clear:both"></div>';
                    ?>
                </div>  
                   
            </div>
        </div>
        <?php echo f_DisplayFooter($language); ?>
    </body>
</html>
    