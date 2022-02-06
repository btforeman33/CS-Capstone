<html>
    <head>
        <style>
            body {
                background-color: white;
            }
            .dynamicContent {
                background-color: white;
                border-radius: 25px;
                box-sizing: border-box;
                padding: 10px;
                border-style: solid;
                border-color: #89CFF0;
            }
            .button {
                text-align: center;
                font-size: 13px;
                font-weight: bold;
                padding:10px;
                border-radius: 25px;
                transition-duration: 0.4s;
                cursor: pointer;
                background-color: white;
                color: black;
                border: 2px solid #555555;
            }

            .button:hover {
                background-color: #555555;
                color: white;
            }
        </style>
        <script>
        function ajaxNavigation(page){
            var formData = {'page' : page};

            $.ajax({
                url: "includes/control.php",
                type: "POST",
                data: formData,
                success: function(result){$("#DynamicContent").html(result);},
                error: function(result){$("#DynamicContent").html("Error!");}
            });
            return false;
        };
        </script>
        
    </head>
    <body>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        
        <?php
        if(session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        if(isset($_SESSION['username']) && $_SESSION['username'] != ""){
            require_once('includes/NavMenu.php');
        }
        echo '<br><div class="dynamicContent" id="DynamicContent">';
        include 'includes/control.php';
        
        ?>
    </body>    
</html