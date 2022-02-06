<?php
function dirSize($directory) {
    $size = 0;
    foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory)) as $file){
        $size+=$file->getSize();
    }
    return $size;
} 
if(session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
if (isset($_POST['submit'])){
    $target_path = "../../users/".$_SESSION['username']."/";
    $errors = [];
    $files = scandir($target_path);
    if(!isset($_FILES['uploadFile']))
        $errors[] = "No File Submitted";
    else if($_FILES['uploadFile']['size'] + dirSize($target_path) > 5368709120){
        die("File would exceed 5GB limit! Delete files on website to free more space!");
    }
    if (isset($_FILES['uploadFile']['name']) && $_FILES['uploadFile']['name'] != ""){
        //moves uploaded file to correct directory

        $explodedFile = explode("/", $_FILES['uploadFile']['type']);
        $file_ext = strtolower($explodedFile[1]);
        $fileName = $_FILES['uploadFile']['name'];
        if (move_uploaded_file($_FILES['uploadFile']['tmp_name'], $target_path."/". $_FILES['uploadFile']['name']) === FALSE)
            $errors[] = "Could not move uploaded file to ".$target_path." ".htmlentities($_FILES['uploadFile']['name'])."<br/>\n";
    }

    if (sizeof($errors) != 0){
        foreach ($errors as $error){
            echo $error.'<br>';
            }
        }
    else{
        die("Successfully uploaded");
    }
}
else if (isset($_POST['type'])){
    $target_path = "../../users/".$_POST['user'];
    $upload_path = "../../users/".$_POST['user']."/".$_FILES['file']['type'];
    $files = scandir($target_path);
    foreach ($files as $file) {
        if ($file == "." || $file == "..")
            continue;
    }
    if(file_exists($upload_path) == false){
        mkdir($upload_path, 0777, true);
    }
    if($_FILES['file']['size'] + dirSize($target_path) > 5242880000){
        die("File would exceed 5GB limit! Delete files on website to free more space!");
    }
    if (isset($_FILES['file']['name']) && $_FILES['file']['name'] != ""){
        //moves uploaded file to correct directory
        $fileName = $_FILES['file']['name'];
        if (move_uploaded_file($_FILES['file']['tmp_name'], $upload_path."/". $_FILES['file']['name']) === FALSE)
            die("Could not move uploaded file to ".$upload_path." ".htmlentities($_FILES['file']['name'])."<br/>\n");
    }
    else
        die("No File Submitted");

    die("Success!");
}