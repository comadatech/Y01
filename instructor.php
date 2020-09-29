<?php
   
//   //if session is not started then start the session
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
    
    $personid = f_GetPersonID();

?>

<html lang = "en">
   
    <head>
        <title>Yoga</title>
        <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
        <meta http-equiv="Pragma" content="no-cache" />
        <meta http-equiv="Expires" content="0" />
        <link href = "css/base.css" rel = "stylesheet">
        <link href = "css/divtable.css" rel = "stylesheet">
        <link href = "font-awesome/css/font-awesome.min.css" rel="stylesheet" >
        <link href = "css/header.css" rel = "stylesheet">
        <style>
/*            body{
               background-color: #fff4e3;
            }*/
            
/*            #subcontainer{
                background-color:#fff4e3;
            }*/
            
            .grid-container {
              display: grid;
              grid-template-columns: 2% 96% 2%;
              grid-template-rows: 1fr;
              gap: 34px 4px;
              grid-template-areas:
                "card1 card2 card3";
              margin-bottom: 40px;
            }

            .card1 { grid-area: card1; }

            .card2 { 
                grid-area: card2; 
                padding:10px;
                background-color:#5d5d5a;
                display:inline-block;
                text-align: left;
                border-radius: 4px;
                /*clip-path: polygon(87% 0, 100% 21%, 100% 100%, 0% 100%, 0 51%, 0% 0%);*/
            }

            
            .card2__title{
                display:grid;
                font-size: 2rem;
                font-weight: 800px;
                margin-bottom: 5px;
                padding-left:40px;
                padding-top:20px;
                color:#ffffff;
            }
            
            .card2__subtitle{
                display: grid;
                font-size: 1rem;
                color: #ffcdab;
                margin-bottom: 5px;
                /*background-color: #ffffff;*/
/*                padding:10px;*/
                padding-left: 40px;
            }
            
            
            .card2__image{
                display: block;
                height: 240px;
                float:left;
                border:1px solid #7b6c74;
                /*border-radius:4px;*/
/*                outline: 2px solid white;
                outline-offset: -8px;
                outline-style:double;*/
                margin:10px;
            }

            
            .card2__description{
                display: grid;
                /*display: inline;*/
                padding:40px;
                color:#ffffff;
                /*border:1px solid #ddd;*/
                background-color: transparent;
                white-space:pre-wrap;
                
            }

            
            .card2__activitylist{
                display: inline;
                float:right;
                /*padding:40px;*/
                color:#fff;
                padding-bottom:20px;
                
            }         
            
            .card2__activitylist a {
                color:#fff;
                /*text-decoration:none;*/
                
            }
            
/*            .card2__activitylist a:hover::before {
                content:'\f064';
                font-family: "FontAwesome";
                padding: 12px;
                vertical-align: middle;
                color:#fff;
            }*/
            
            .card2__button{
                /*display:inline;*/
                display: inline-block;
                padding:10px 30px 10px 30px;
                border:none;
                border-radius:30px;
                margin-left:40px;
                background-color: #fff;
                float:right;
                margin-right: 40px;
                bottom:0px;
            }
            
            
            .card2__button:hover{
                /*background-color: #ffcdab;*/
                border:1px double #fff;
                -webkit-box-shadow: 10px 10px 22px -9px rgba(92,82,52,1);
                -moz-box-shadow: 10px 10px 22px -9px rgba(92,82,52,1);
                box-shadow: 10px 10px 22px -9px rgba(92,82,52,1);
            }

            .card3 { grid-area: card3; }

        </style>
    </head>
    <body>
        <header>
        <?php 
            f_DisplayTopMenu();
        ?>
        </header>
        <?php echo f_DisplaySiteMenu(C_INSTRUCTOR, $personid); ?>   
        <div id='subcontainer'>
            <div class="subtitle"><?php echo _INSTRUCTORS ?></div>
                <?php
                //$sql = "select person.personid, concat(firstname,' ',lastname) as name"
                 //       . ",Instructor.CompetencyEng as CompetencyEng, picture, bio "
                  //      . "from person left join Instructor on person.personid=Instructor.personid where persontypeid = 2";
                $sql="call USP_GetInstructorList('".$language."')";
                
                $result = $conn->query($sql);
                
                $Instructorspicturepath = C_INSTRUCTORSPICTUREPATH;
                $rowcounter             = 0;
                
                if ($result->num_rows > 0) 
                {                  
                    // output data of each row
                    while($row = $result->fetch_assoc()) 
                    {
                        $personid           = $row['personid'];
                        $name               = $row['name'];
                        $competencyeng      = $row['Competency'];
                        $picture            = $row['picture'];
                        $fullpicturepath    = $Instructorspicturepath.'instructor_'.$personid.'.jpg';
                        $bio                = $row['Bio'];
                        $activitylist       = $row['ActivityList'];
                        $rowcounter++;                       
                        
                        $shadow1 = "-webkit-box-shadow: 10px 10px 4px -4px rgba(93,93,90,.5);";
                        $shadow1 .= "-moz-box-shadow: 10px 10px 4px -4px rgba(93,93,90,.5);";
                        $shadow1 .=  "box-shadow: 10px 10px 4px -4px rgba(93,93,90,.5);";
                        
                        $shadow2 = "-webkit-box-shadow: 10px 10px 4px -4px rgba(161,107,0,0.5);";
                        $shadow2 .= "-moz-box-shadow: 10px 10px 4px -4px rgba(161,107,0,0.5);";
                        $shadow2 .="box-shadow: 10px 10px 4px -4px rgba(161,107,0,0.5);";
                        
                        if(fmod($rowcounter,2)==0){
                            $cardbackgroundcolor = " style='background-color:#ffa45c; ".$shadow2."' "; 
                        }
                        else
                        {
                            $cardbackgroundcolor = " style='background-color:#5d5d5a; ".$shadow1."' ";  
                        }
                ?>
            <div class="grid-container" id='instructor<?php echo $personid?>'>
                <div class="card1"></div>
                <div class="card2" <?php echo $cardbackgroundcolor; ?>>
                    <img src='<?php echo $fullpicturepath.'?time()'; ?>' class='card2__image'>
                    
                    
                    <span class='card2__title'><?php echo $name; ?></span>
                    <p class='card2__subtitle'><?php echo $competencyeng; ?></p>
                    <p class='card2__description' rows="4" cols="50" readonly="readonly"><?php echo $bio; ?></p>
                    <p class='card2__activitylist'><?php echo $activitylist; ?></p>
                </div>
                <div class="card3"></div>               
            </div>
           <?php }}?>
        </div>
    </body>
</html>