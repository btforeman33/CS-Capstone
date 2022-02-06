<html>
    <head>
        <style>
            body {
            font-family: Arial, Helvetica, sans-serif;
            }

            .NavMenu {
            overflow: hidden;
            background-color: #333;
            }

            .NavMenu a {
            float: left;
            font-size: 16px;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
            }

            .dropdown {
            float: left;
            overflow: hidden;
            }

            .dropdown .dropbtn {
            font-size: 16px;  
            border: none;
            outline: none;
            color: white;
            padding: 14px 16px;
            background-color: inherit;
            font-family: inherit;
            margin: 0;
            }

            .NavMenu a:hover, .dropdown:hover .dropbtn {
            background-color: red;
            }

            .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
            }

            .dropdown-content a {
            float: none;
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            text-align: left;
            }

            .dropdown-content a:hover {
            background-color: #ddd;
            }

            .dropdown:hover .dropdown-content {
            display: block;
            }

        </style>
    </head>
    <body>
        <div id="NavMenu" class="NavMenu">
            <a class="NavMenu" href="" onclick="return ajaxNavigation('Home');">Home</a>
            <a href="" onclick="return ajaxNavigation('Gallery');">Gallery</a>
            <a href="" onclick="return ajaxNavigation('flashcards');">Flashcards</a>
                <div class="dropdown">
                    <button class="dropbtn">Misc Tools
                        <i class="fa fa-caret-down"></i>
                    </button>
                    <div class="dropdown-content">
                        <a href="" onclick="return ajaxNavigation('DiceRoller');">Dice Roller</a>
                        <a href="" onclick="return ajaxNavigation('Converter');">Converter</a>
                        <a href="" onclick="return ajaxNavigation('CSV');">CSV Viewer</a>
                    </div>
                </div>
            
            <?php 
            if(session_status() !== PHP_SESSION_ACTIVE) {
                session_start();
            }
            
            //echo navmenu buttons depending if user is logged in or not
            if (isset($_SESSION['username'])){
                ?>
                <a href='' onclick='alert("Logged out"); ajaxNavigation("logout"); window.location.reload(true);' style='float:right'>Logout</a>
                <a href='' style='float:right'><?php echo $_SESSION['username']; ?></a>
                <?php
            }
            else{
                ?>
                <a href=''  onclick="return ajaxNavigation('login');" style='float:right'>Sign Up/Login</a>
                <a style='float:right'>Guest</a>
                <?php
            }

            ?>
            <br>
        </div>
    </body>
</html>