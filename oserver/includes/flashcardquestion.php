<?php
if(session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

//handles whether to increment the question number and attaches it to the output of the file, which flashcards.php handles
if(isset($_POST['next'])){
    $_SESSION['number'] += 1;
    $question = $_SESSION['number'];
    foreach(range(0,$question) as $answer){
        $value = $_SESSION[$_POST['file']][$answer].",".$_SESSION['number'];
    }
    echo $value;
}
elseif(isset($_POST['previous'])){
    $_SESSION['number'] -= 1;
    $question = $_SESSION['number'];
    foreach(range(0,$question) as $answer){
        $value = $_SESSION[$_POST['file']][$answer].",".$_SESSION['number'];
    }
    echo $value;
}
else{
    if(isset($_SESSION[$_POST['file']]['number'])){
        $question = $_SESSION['number'];
    }
    else{
        $_SESSION['number'] = 0;
        $question = 0;
    }
    foreach(range(0,$question) as $answer){
        $value = $_SESSION[$_POST['file']][$answer].",".$_SESSION['number'];
    }
    echo $value;
}


