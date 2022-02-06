<?php
$needle = $_POST['needle'] ?? null;
$haystack = $_POST['haystack'] ?? null;
$case = $_POST['case'] ?? "";
?>

<form action="" method="POST">
    Needle:<input type="text" name="needle" style="width:100%" value="<?php echo $needle;?>"></br>
    Haystack:<input type="text" name="haystack" style="width:100%" value="<?php echo $haystack;?>"></br>
    Is this Case Sensitive?<input type="checkbox" name="case" value="i"></br>
    <input type="submit">
</form>

<?php
if($needle != "" && $haystack != ""){
    if(preg_match("/".$needle."/".$case, $haystack))
        echo "Matched!";
    else
        echo "No match.";
}
