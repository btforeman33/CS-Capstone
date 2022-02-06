if submit
    if file was uploaded (check $_FILES)
        capture fileName
        capture file extension
        make sure extension is a valid image (jpg,jpeg,png,gif)
            if not, error
            if so uploadFile()

create form for file uploaded
display all uploaded thumbs
get all images from thumbs directory
foreach through them, creating href with image inside pointing to fullsize image. Don;t forget to exclude . and ..

example:
<a href="images/1.gif" target="_blank"><img src="/images/thumbs/1.gif"></a>



try{

    //code to try
}
catch (Exception $e){
    //what happens when code errors

}
finally{
    //happens regardless. Optional clause

}


EXTRA CREDIT: Make an empty gallery button


<?php
function uploadFile($fileName, $file_ext){
    $target_path = "images";
    $thumb_path = "images/thumbs";

    //Set thumbnail size
    $thumb_width = 200;
    $thumb_height = 160;

    if (move_uploaded_file($_FILES['pictureFile']['tmp_name'], $target_path."/". $_FILES['pictureFile']['name']) === FALSE)
        echo "Could not move uploaded file to ".$target_path." ".htmlentities($_FILES['pictureFile']['name'])."<br/>\n";
    else{
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
        echo "Successfully uploaded ".$target_path." ".htmlentities($_FILES['pictureFile']['name'])."<br/>\n";
    }
}
