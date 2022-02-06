<html>
    <head>
        <style>
            body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: whitesmoke;
            }

            .NavMenu {
            overflow: hidden;
            background-color: whitesmoke;
            border-radius: 25px;
            font-weight: bold;
            }

            .NavMenu a {
            float: left;
            font-size: 16px;
            background-color: white;
            color: #89CFF0;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
            border-radius: 25px;
            border-style: solid;
            border-color: #89CFF0;
            }

            .NavMenu a:hover, .dropdown:hover .dropbtn {
            background-color: #89CFF0;
            color: white;
            }
        </style>
    </head>
    <body>
        <div id="NavMenu" class="NavMenu">
            <a class="NavMenu" href="" onclick="return ajaxNavigation('Home');">Home</a>
            <a class="NavMenu" href="" onclick="return ajaxNavigation('files');">Files</a>
            <a class="NavMenu" href="" onclick="return ajaxNavigation('upload');">Upload File</a>
            
            <?php 
            if(session_status() !== PHP_SESSION_ACTIVE) {
                session_start();
            }
            
            //echo navmenu buttons depending if user is logged in or not
            if (isset($_SESSION['username'])){
                ?>
                <a href='' onclick='ajaxNavigation("logout"); alert("Logged out"); window.location.reload(true);' style='float:right'>Logout</a>
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