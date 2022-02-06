<?php
$page = $_REQUEST['page'] ?? "null";
if(session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
switch ($page) {                
    case 'login':
        include 'login.php';
        break;

    case 'signup':
        include 'signup.php';
        break;

    case 'logout':
        //deletes all login related session variables
        foreach (array_keys($_SESSION) as $key) {
            if($key == "username" || $key == "accesslevel" || $key == "loggedIn" ){
                unset($_SESSION[$key]);
            }
        }
        break;

    case 'files':
        include 'content.php';
        break;

    case 'upload':
        include 'upload.php';
        break;

    default:
        if(isset($_SESSION['username']) && $_SESSION['username'] != ""){
            echo '<script>function programDownload(){
                const uri = "includes/grabber.php?type=download";
                $.ajax({
                    url: uri,
                    type: "POST",
                    success: function(result){
                        window.location = "includes/grabber.php?program=true";
                    },
                    error: function(result){$("#output").html("Error!");}
                });
            }</script>';
            echo "<h1>Welcome back ".$_SESSION['username']."!</h1>";
            echo "<button onclick=\"programDownload();\">Click here to download backup program</button>";
        }
        else{
            include 'login.php';
        }
        break;
}