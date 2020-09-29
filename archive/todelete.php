
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
        
        function showhide(object, object2) {
          var x = document.getElementById(object);
          if (x.type === "password") {
            x.type = "text";
            document.getElementById(object2.id).className = "fa fa-eye-slash"; 
                    
          } else {
            x.type = "password";
            document.getElementById(object2.id).className = "fa fa-eye"; 
          }
        }        
      </script>
      <style>
        .fa.field{
                padding: 6px;
                border: 1px solid black;
                border-radius: 4px;
                margin-left: 10px;
        }
      </style>
   </head>
   <body>
        <header>
            <div id="leftside">
                <a href="index.php" style="text-decoration: none;">
                    <span class="saulelogo">Saule</span>
                    <span class="yogalogo"> Yoga</span>
                </a>
            </div>
            <div id="rightside" style="float: right; height:30px; color:#fff">
                <span class="">
                    <span class="dropdown">
                        <span class="dropbtn">Serge Samson</span>
                        <span class="dropdown-content">
                            <a href="instructorclasses.php" class="m_myclass">My Classes</a>
                            <a href="schedule.php" class="m_subscriptions">My subscriptions</a>
                            <a href="myaccount.php" class="m_account">Account</a>
                            <a href="passwordchg.php" class="m_password">Password</a>
                            <a href="logout.php" class="m_logout">Logout</a>
                        </span>
                    </span>
                </span>
                <span class="topbaritem"></span>
                <a href="cart.php" class="cartmenu">
                    <i class="fa" style="font-size:24px; cursor: pointer">&#xf07a;</i>
                    <span class="badge badge-warning" id="lblCartCount">0</span>
                </a>
                <span class="topbaritem"></span>
                <a href='?language=fra' class='languagemenu'>FR</a>
            </div>
        </header>
       
                    
                    <div class='clearfix'></div><div class="topnav"> 
            <a href="index.php">Home</a>
            <a href="classes.php">Classes</a>
            <a href="register.php">Register</a>
            <a href="contact.php">Contact</a>
            <a href="instructor.php">Instructors</a></div><div class='clearfix'></div>        <div id = "container">
            <div class='subtitle'>My Subscriptions</div>
            <div id=''>
                        <br/>
            <div class="subcontainer">
                <form action="passwordchg.php" method="post" id="form1">
                <div class="row">
                  <div class="col-25">
                  </div>
                  <div class="col-75">
                      <input type="text" id="personid" name="personid" hidden value="2">
                  </div>
                </div>                                 
  
                <div class="row">
                  <div class="col-25">
                    <label for="oldpassword">Old Password</label>
                  </div>
                  <div class="col-75">
                      <input type="password" id="oldpassword" onclick="HideMessage();" name="oldpassword"><i id="oldpasswordbutton" class="fa fa-eye field" onclick="showhide('oldpassword',this);"></i>
                  </div>
                </div>     
                <div class="row">
                  <div class="col-25">
                    <label for="newpassword">New Password</label>
                  </div>
                  <div class="col-75">
                      <input type="password" id="newpassword" onclick="HideMessage();" name="newpassword"><i id="newpasswordbutton" class="fa fa-eye field" onclick="showhide('newpassword',this);"></i>
                  </div>
                </div>           
                <div class="row">
                  <div class="col-25">
                    <label for="retypepassword">Retype New Password</label>
                  </div>
                  <div class="col-75">
                      <input type="password" id="retypepassword" onclick="HideMessage();" name="retypepassword"><i id="retypepasswordbutton" class="fa fa-eye field" onclick="showhide('retypepassword',this);"></i>
                  </div>
                </div>                                   
                <div class="row">
                    <br/>
                  <input type="submit" value="Submit">
                </div>
              </form>
            </div>
        </div> <!-- /container -->
    </body>
</html>