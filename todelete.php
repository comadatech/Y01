
<html lang = "en">
   <head>
        <title>Yoga</title>
        <link href = "css/base.css" rel = "stylesheet">
        <link href = "font-awesome/css/font-awesome.min.css" rel="stylesheet" >
        <link href = "css/header.css" rel = "stylesheet">
        <style>
/*           .grid-container {
               height:100%;
                display: grid;
                grid-template-columns: 1fr 1fr 1fr 1fr;
                grid-template-rows: 50px max-content auto 130px;
                gap: 1px 1px;
                grid-template-areas:
                  "header header header header"
                  "menu menu menu menu"
                  "detail detail detail detail"
                  "footer footer footer footer";
            }*/

            header { grid-area: header; }

            .menu { grid-area: menu; }

            .detail { 
                grid-area: detail; 
            }

            footer { 
                grid-area: footer; 
                background-color: #ddd;
            }
              
            /*DIV TABLE*/

            .divTable{
                display: table;
                width:fit-content;
                border: 1px solid #999999;
            }
            
            .divTableRow {
                display: table-row;
            }
 
                
            .divTableHead {
                /*border-top: 1px solid #999999;*/
                display: table-cell;
                padding: 13px 10px;
                text-align:left;
                font-size:1rem;
                height:40px;
            }                

            .divTableCell {
                border-top: 1px solid #999999;
                border-bottom: 1px solid #999999;
                display: table-cell;
                padding: 6px;
                padding-top: 8px;
                text-align: left;
                background-color: #fff4e3;
                font-weight: 600;
            }
                
            .divstudent{
                width: 100%; 
                text-align: left;
                /* padding-left: 60px; */
                /* border: 1px solid red; */
/*                display: list-item;*/
                list-style-type:none;
                margin-left: 50px;
                margin-bottom: 10px;
                margin-top:10px;
                display:none;
            }
                
            .divstudentname{
                font-size:1rem;
                margin-bottom:6px;
            }
                
            .divstudentname::before{
                content:'\f2c0';
                font-family: "FontAwesome";
                /*vertical-align: middle;*/
                margin-right:6px;
            }
                
            .studentage{
                font-size:.6rem;
            }

/*                .divstudenttitle{
                    text-align: left;
                    border: none;
                    margin-left: 30px; 
                    font-weight: 700;
                    margin-top: 10px;
                    font-size: 1rem;
                }*/
                
            .divTableHeading {
                    background-color: #EEE;
                    display: table-header-group;
                    font-weight: bold;
            }
            
            .divTableFoot {
                    background-color: #EEE;
                    display: table-footer-group;
                    font-weight: bold;
            }
            
            .divTableBody {
                    display: table-row-group;
            }
                
            .divDetail{
                font-weight:600;
                padding-right:10px;
                margin-left:30px;
            }
                
            .leftalign{
                text-align: left;
            }

            .centeralign{
                text-align:center;
            }
            
            .alreadystarted{
                color:red;
                font-size:.7rem;
            }
            
            .upcoming{
                color:green;
                font-size:.7rem;  
            }
            
            input[type=checkbox] {
                display: none;
            }
            
            .displaystudent:checked ~ .divTable .divTableBody .divstudent {
                display: list-item;
           }

            input[type=checkbox] ~ label {
                position:relative;
              background: green;
              height: 50px;
              color: #fff;
              padding: 16px;
/*              display: block;*/
            }

            
        </style>
   </head>
   <body>
        <div class ="">
            <header>
                <div id="leftside"><a href="index.php" style="text-decoration: none;"><span class="saulelogo">Saule</span><span class="yogalogo"> Yoga</span></a></div><div id="rightside" style="float: right; height:30px; color:#fff"><span class=""><span class="dropdown">
                      <span class="dropbtn">Valerie Samson</span>
                      <span class="dropdown-content"><a href="instructorclasses.php" class="m_myclass">My Classes</a><a href="schedule.php" class="m_subscriptions">My subscriptions</a><a href="myaccount.php" class="m_account">Account</a><a href="profile.php" class="m_profile">Profile</a><a href="instructorsocialmedia.php" class="m_social">Social Media</a><a href="passwordchg.php" class="m_password">Password</a><a href="logout.php" class="m_logout">Logout</a></span></span></span><span class="topbaritem"></span><a href="cart.php" class="cartmenu"><i class="fa" style="font-size:24px; cursor: pointer">&#xf07a;</i><span class="badge badge-warning" id="lblCartCount">0</span></a><span class="topbaritem"></span><a href='?language=fra' class='languagemenu'>FR</a></div>            </header>
            <div class='menu'>
                <div class='clearfix'></div><div class="topnav"> 
            <a href="index.php">Home</a>
            <a href="classes.php">Classes</a>
            <a href="register.php">Register</a>
            <a href="contact.php">Contact</a>
            <a href="instructor.php">Instructors</a></div><div class='clearfix'></div>            </div>
            <div class="detail">
                                <div class="space_height_30"></div>
                
                <div class='subtitle'>My Classes</div>
                <input id="toggle" type="checkbox" name="displaystudent" class="displaystudent"></input>
                <label for="toggle">Show Student</label>   
                    <div id='horaire' class='divTable'>
                     
                        
                        <div class="divTableHeading">
                            
                        <div class='divTableRow'><div class='divTableHead'>Activity</div><div class='divTableHead'>Day</div><div class='divTableHead'>Time</div><div class='divTableHead'>Frequency</div><div class='divTableHead'>Start Date</div><div class='divTableHead'>End Date</div><div class='divTableHead'>Location</div></div></div><div class='divTableBody'><div  class='divTableRow'><div class='divTableCell leftalign'>Hot Yoga<span class="upcoming"> (Upcoming)</span></div><div class='divTableCell leftalign'>Thursday</div><div class='divTableCell centeralign'>10:00</div><div class='divTableCell leftalign'>Weekly</div><div class='divTableCell centeralign'>2020-10-09</div><div class='divTableCell centeralign'>2021-02-02</div><div class='divTableCell leftalign'>105 Pavillion noire, App #33, room 987, Gatineau, QC</div></div><div class='divTableRow'><div class='divstudent'><div class='divstudentname'>Clack Kent <span class="studentage">(20)</span></div><span class='divDetail'>Email:</span><a href='mailto:serge@comada.ca'>serge@comada.ca</a></div></div><div class='divTableRow'><div class='divstudent'><div class='divstudentname'>Marie-Pier Chartrand <span class="studentage">(27)</span></div><div><span><span class='divDetail'>Tel.:</span>222-222-2222</div><span class='divDetail'>Email:</span><a href='mailto:serge_samson@yahoo.com'>serge_samson@yahoo.com</a></div></div><div class='divTableRow'><div class='divstudent'><div class='divstudentname'>Veronique Pharand</div><div><span><span class='divDetail'>Tel.:</span>222-432-1234</div><span class='divDetail'>Email:</span><a href='mailto:vpharand@videotron.ca'>vpharand@videotron.ca</a></div></div><div  class='divTableRow'><div class='divTableCell leftalign'>Yoga for cat<span class="alreadystarted"> (Already Started)</span></div><div class='divTableCell leftalign'>Tuesday</div><div class='divTableCell centeralign'>09:00</div><div class='divTableCell leftalign'>Weekly</div><div class='divTableCell centeralign'>2020-09-01</div><div class='divTableCell centeralign'>2020-12-01</div><div class='divTableCell leftalign'>120 St-Joseph, Room 22</div></div><div class='divTableRow'><div class='divstudent'><div class='divstudentname'>Andrée Samson <span class="studentage">(57)</span></div><span class='divDetail'>Email:</span><a href='mailto:adaviau@videotron.ca'>adaviau@videotron.ca</a></div></div></div>                </div>
            </div>
            <footer>
                <div id="footer" class="footer"><p>Saule Yoga. All rights reserved.</p><p><a href=""><img src="images/icon-fb-516.png"></a><a href=""><img src="images/icon-instagram.png"></a><a href=""><img src="images/icon-twitter-519.png"></a><a href=""><img src="images/icon-youtube.png"></a></p><ul id='menu'><li><a href='legal.php'><a href=''>Legal & Privacy</a></a></li><li><a href='terms.php'><a href=''>Terms & Conditions</a></a></li></ul></div>            </footer>
        </div> <!-- /grid-container -->
    </body>
</html>