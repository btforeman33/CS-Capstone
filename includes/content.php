<style>
    table{
        width: 100%;
        height:25px;
    }
    table:hover{
        background-color: #E8F0FE;
        color: #5C67D2;
    }
    .temp{
        position: relative;
        width: 100%;
        height:100%;
        z-index: 1;
        display: none;
        border-style: solid;
    }
</style>
<script>
function DirInto(something){
	var formData = {
            'change' : something
        };
    $.ajax({
        url: "includes/content.php",
        type: "POST",
        data: formData,
        success: function(result){$("#DynamicContent").html(result);},
        error: function(result){$("#DynamicContent").html("Error!");}
    });
}
function showFile(something){
    var temp = document.getElementsByClassName("temp");
    console.log("test");
    temp[0].setAttribute("display","block");
}
function fileGrab(something,type){
    if(type == 'download'){
        $.ajax({
            url: "includes/grabber.php",
            type: "POST",
            success: function(result){
                window.location = "includes/grabber.php?type=".concat(type).concat("&file=").concat(something);
                    
            },
            error: function(result){$("#output").html("Error!");}
        });
    }
    if(type == 'delete'){
        const uri = "includes/grabber.php?type=".concat(type).concat("&file=").concat(encodeURIComponent(something));
        $.ajax({
            url: uri,
            type: "POST",
            success: function(result){
                $("#output").html(result);
                var item = document.getElementById(something);
                item.remove();
                    
            },
            error: function(result){$("#output").html("Error!");}
        });
    }
}
function folderDelete(something,type){
    const uri = "includes/grabber.php?type=delete&folder=".concat(encodeURIComponent(something));
    $.ajax({
        url: uri,
        type: "POST",
        success: function(result){
            $("#output").html(result);
            var item = document.getElementById(something);
            item.remove();
                
        },
        error: function(result){$("#output").html("Error!");}
    });
}

</script>
<div class="temp"></div>
<?php
function dirSize($directory) {
    $size = 0;
    foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory)) as $file){
        $size+=$file->getSize();
    }
    return $size;
} 
@session_start();
$change = $_POST['change'] ?? "";
if(isset($_SESSION['username'])){ 
    $dir = "../../users/".$_SESSION['username'].$change;
    $dirDisplay = $_SESSION['username'].$change;
    $_SESSION['dir'] = $dir;
    $storage = dirSize("../../users/".$_SESSION['username']);
    try{
        echo $dirDisplay;
        echo "<br>";
        if(($storage / 1000000000) > 1){
            echo substr(($storage/1000000000),0,-6)." GB";
        }
        else if (($storage / 1000000) > 1){
            echo substr(($storage / 1000000),0,-3)." MB";
        }
        else if (($storage / 1000) > 1){
            echo ($storage / 1000)." KB";
        }
        else{
            echo $storage." bytes";
        }
        echo " out of 5GB used";
        if ($handle = opendir($dir)) {
            while (false !== ($entry = readdir($handle))) {
                if($entry == "."){
                    continue;
                }
                try{
                    @$test = opendir($dir."/".$entry);
                    if($test == null)
                        throw new Exception("L");
                    if($entry == ".."){
                        $temp = explode("/",$change);
                        unset($temp[count($temp)-1]);
                        $change2 = implode("/",$temp);
                        echo "\n<table id=\"$entry\" onclick='DirInto(\"$change2\")'><td";
                    }else{
                        echo "\n<table id=\"$entry\"><td onclick='return DirInto(\"$change"."/"."$entry\")'";
                    }
                    echo " style='width:90%'>📁$entry</td>";
                    if($entry != ".."){
                        echo "<td><button onclick='return folderDelete(\"$entry\")' style=\"float:right;\">Delete</button></td>";
                    }
                    echo "</table>";
                    
                }
                catch (Exception $e)
                {
                    //here is where to change stuff attached to files
                    echo "\n<table id=\"$entry\"> 
                                <td style='width:90%' onclick='return showFile(\"$entry\");'>🗎$entry 
                                <button onclick='return fileGrab(\"$entry\",\"download\")' style=\"float:right;\">Download</button>
                                <button onclick='return fileGrab(\"$entry\",\"delete\")' style=\"float:right;\">Delete</button>
                                </td>
                            </table>";
                }
            }
            closedir($handle);
        }
    }catch(Error $e){
        echo "No files to be found!";
    }
    
}
?>
<div id="output"></div>