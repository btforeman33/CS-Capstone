<html>
    <head>
        <style>
            body {
                background-color: #bbbbbb;
            }
            .dynamicContent {
                background-color: white;
                border-radius: 25px;
                box-sizing: border-box;
                padding: 10px;
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
    </head>
    <body>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
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
        <?php
        require_once('includes/NavMenu.php');
        echo '<br><div class="dynamicContent" id="DynamicContent">';
        require_once('includes/control.php');
        ?>
    </body>    
</html