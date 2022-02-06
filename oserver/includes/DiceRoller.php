<script>
    function diceRoll(){
        var formData = {
            'times' : $('input[name=times]').val(),
            'sides' : $('input[name=sides]').val(),
            'submit' : true
        };
        $.ajax({
            url: "includes/DiceRoller.php",
            type: "POST",
            data: formData,
            success: function(result){$("#rolloutput").html(result);},
            error: function(result){$("#rolloutput").html("Error!");}
        });
    return false;
};
</script>
<?php
//mt_rand(1,6)
function DiceRoller($times,$sides)
{
    $total = 0;
    for($i=0 ; $i<$times ; $i++)
    {
        $total += mt_rand(1,$sides);
    }
    return $total;
}
$times = $_POST['times'] ?? 1;
$sides = $_POST['sides'] ?? 6;

if (isset($_POST['submit'])){
    $errors = array();
    if (empty($times))
        $errors[] = "Times was not entered.";
    if (empty($sides))
        $errors[] = "Sides was not entered";
    if(is_numeric($times)){
        if ($times < 1)
            $errors[] = "Sides was less than 1";
    }
    else
        $errors[] = "Sides was not a number";

    if(count($errors) > 0){
        foreach($errors as $error){
            echo $error;
        }
    }
    else
        echo '<h1>You rolled a '.DiceRoller($times,$sides).".</h1>";
    
}
else{
    ?>
    Number of times: <input type="number" name="times" value="<?php echo $times; ?>"><br>
    Number of sides: <input type="number" name="sides" value="<?php echo $sides; ?>"><br>
    <button onclick="return diceRoll();">Roll!</button><br>
    <?php
}
?>

<div id="rolloutput">

