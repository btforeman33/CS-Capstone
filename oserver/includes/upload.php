<?php
// This file contains all methods to upload, rather than having multiple files for each method. Uses if statement with POST sending what type of upload and processing to use.


if(session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if($_POST['type'] == "Gallery"){
    function uploadFile($fileName, $file_ext, $errors, $target_path, $thumb_path){
        //Set thumbnail size
        $thumb_width = 200;
        $thumb_height = 160;

        //thumbnail creation
        
        $upload_image = $target_path."/". basename($fileName);  
        $thumbnail = $thumb_path."/".$fileName;
        list($width,$height) = getimagesize($upload_image);
        $thumb_create = imagecreatetruecolor($thumb_width,$thumb_height);
        switch($file_ext){
            case 'jpg':
            case 'jpeg':
                $source = imagecreatefromjpeg($upload_image);
                break;
            case 'png':
                $source = imagecreatefrompng($upload_image);
                break;
            case 'gif':
                $source = imagecreatefromgif($upload_image);
                break;
            default:
                $source = imagecreatefromjpeg($upload_image);
                break;
        }
        imagecopyresized($thumb_create,$source,0,0,0,0,$thumb_width,$thumb_height,$width,$height);
        switch($file_ext){
            case 'jpg' || 'jpeg':
                imagejpeg($thumb_create,$thumbnail,100);
                break;
            case 'png':
                imagepng($thumb_create,$thumbnail,100);
                break;
            case 'gif':
                imagegif($thumb_create,$thumbnail,100);
                break;
            default:
                imagejpeg($thumb_create,$thumbnail,100);
        }
        echo "Successfully uploaded  ".htmlentities($_FILES['uploadFile']['name'])."<br/>\n";
    }

    function display_all_thumbs(){
        $files = scandir("../images/thumbs");
        foreach ($files as $file) {
            if ($file == "." || $file == "..")
                continue;
            else
                echo "<a href='images/$file'><img src='images/thumbs/$file'></a>";
            
        }
    }

    $errors = [];
    $types = array("jpg","jpeg","png","gif");
    $target_path = "../images";
    $thumb_path = "../images/thumbs";

    if(isset($_POST['display']) && $_POST['display'] == true)
        die(display_all_thumbs());


    if (isset($_POST['submit'])){
        // Check if picture exists
        $files = scandir("../images");
        foreach ($files as $file) {
            if ($file == "." || $file == ".." || $file == "thumbs")
                continue;
            else{
                if($_FILES['uploadFile']['name'] == $file)
                    $errors[] = 'Image already exists!';
            }
        }

        if (isset($_FILES['uploadFile']['name']) && $_FILES['uploadFile']['name'] != ""){
            //moves uploaded file to correct directory

            $explodedFile = explode("/", $_FILES['uploadFile']['type']);
            $file_ext = strtolower($explodedFile[1]);
            $fileName = $_FILES['uploadFile']['name'];
            if (in_array($file_ext, $types) == false)
                $errors[] = "Invalid file type";
            if (move_uploaded_file($_FILES['uploadFile']['tmp_name'], $target_path."/". $_FILES['uploadFile']['name']) === FALSE)
                $errors[] = "Could not move uploaded file to ".$target_path." ".htmlentities($_FILES['uploadFile']['name'])."<br/>\n";
        }
        else
            $errors[] = "No File Submitted";

        if (sizeof($errors) != 0){
            foreach ($errors as $error){
                echo $error.'<br>';
                }
            }
        else
            uploadFile($fileName, $file_ext, $errors, $target_path, $thumb_path);
        }

    if (isset($_POST['deleteCheck'])){
        //deletes all files and thumbs
        $deleteFiles = scandir("../images");
        foreach ($deleteFiles as $file) {
            if ($file == "." || $file == ".." || $file == "thumbs")
                continue;
            unlink("../images/$file");
        }
        $deleteFiles = scandir("../images/thumbs");
        foreach ($deleteFiles as $file) {
            if ($file == "." || $file == "..")
                continue;
            unlink("../images/thumbs/$file");
        }
    }


    display_all_thumbs();
}

if($_POST['type'] == "CSV"){
    if (isset($_FILES['uploadFile']['name']) == false)
        die("No file submitted");
    if (substr($_FILES['uploadFile']['name'],-3,3) != "csv")
        die("Invalid File Type");
    $fp = file($_FILES['uploadFile']['tmp_name']) or die("Cannot open uploaded file ");

    //outputs csv
    echo "<table border='1'>";
    $startNum = 0;
    if ($_POST['headers'] == 'true'){
        foreach (explode(",",$fp[0]) as $line) {
            echo"<td><b>";
            echo $line;
            echo"</b></td>";
        }
        $startNum += 1;
    }
    while ($startNum != sizeof($fp)) {
        echo "<tr>";
        foreach (explode(",",$fp[$startNum]) as $line) {
            echo "<td>";
            echo $line;
            echo "</td>";
        }
        echo "</tr>";
        $startNum += 1;

    }
    echo "</table><br>";
}

if($_POST['type'] == "flashcard"){
    function displayCSV(){
        $temp = array_keys($_SESSION);
        foreach ($temp as $csv){
            //makes sure it doesnt echo out login session variables
            if($csv == "username" || $csv == "accesslevel"){
                continue;
            }
            else{
                $size = $_SESSION[$csv]['size'];
                echo "<form action='includes/flashcards.php' target='_blank'>";
                if($csv == 'number'){
                    continue;
                }
                echo "<button class='button' name='csv' formmethod='post' type='submit' value='$csv'>$csv</button>";
                echo "<input type='hidden' name='size' value='$size'>";
                echo '</form>';
            }
        }
    }
    if(isset($_POST['display'])){
        displayCSV();
    }
    elseif(isset($_POST['destroy'])){
        $temp = array_keys($_SESSION);
        foreach ($temp as $key){
            if($key !== "username" || $key !== "accesslevel" || $key !== "loggedIn" ){
                unset($_SESSION[$key]);
            }
        }
        echo 'Success!';
    }
    else{
        if (isset($_FILES['uploadFile']['name']) == false){
            echo "No file submitted";
            die(displayCSV());
        }
        if (substr($_FILES['uploadFile']['name'],-3,3) != "csv"){
            echo "Invalid File Type";
            die(displayCSV());
        }
        $name = $_FILES['uploadFile']['name'];
        $file =file($_FILES['uploadFile']['tmp_name']);
        $keys = array_keys($_SESSION);
        foreach ($keys as $key) {
            if($name == $key){
                echo 'File already exists!';
                die(displayCSV());
            }
        }
        for ($i = 0; $i < count($file); $i++){
            $test = explode(",",$file[$i]);
            if (count($test) > 2 || count($test) < 2){
                echo "<a style='color:red'>CSV contains an incorrect amount of columns! (Only have 2 columns, first is for the front of the card)</a>";
                die(displayCSV());
            }
        }
        //randomizes the csv based on if the randomize checkbox was ticked on uploadflashcards.php
        if($_POST['check'] == 'true'){
            shuffle($file);
        }
            
        
        //attaches size variable to the respective file in the session array
        $_SESSION[$_FILES['uploadFile']['name']] = $file;
        $size = 0;
        foreach ($file as $temp){
            $size += 1;
        }
        $_SESSION[$_FILES['uploadFile']['name']]['size'] = $size;
        
        displayCSV();
    }
}
