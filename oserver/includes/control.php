<?php
$page = $_REQUEST['page'] ?? "null";
if(session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
        switch ($page) {
            case 'Home':
                echo "Home Page";
                break;

            case 'Gallery':
                include 'Gallery.php';
                break;

            case 'DiceRoller':
                include 'DiceRoller.php';
                break;

            case 'Converter':
                include 'converter.php';
                break;

            case 'CSV':
                include 'csvView.php';
                break;
                
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

            case 'account':
                include 'account.php';
                break;
            
            case 'flashcards':
                include 'uploadFlashcard.php';
                break;

            default:
                echo 'Home Page';
                break;
        }