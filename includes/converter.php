<html>
    <head></head>
    <body>
        <script>
            function converter(){
            var check = $('input:radio[name=conversion]:checked').val();
            var formData = {
                'conversion' : check,
                'number' : $('input[name=number]').val(),
                'submit' : true
            };
            $.ajax({
                url: "includes/converter.php",
                type: "POST",
                data: formData,
                success: function(result){$("#conversionOutput").html(result);},
                error: function(result){$("#conversionOutput").html("Error!");}
            });
        return false;
    };
        </script>
        <?php
        $number = $_POST['number'] ?? 1;
        $conversion = $_POST['conversion'] ?? null;
        function NumberConversion($number,$conversion)
        {
            if ($conversion == "dec"){
                echo "$number in decimal is $number<br>";
                echo "$number in binary is ".decbin($number)."<br>";
                echo "$number in octal is ".decoct($number)."<br>";
                echo "$number in hexadecimal is ".dechex($number)."<br>";
            }
                
            if ($conversion == "bin"){
                echo "$number in decimal is ".bindec($number)."<br>";
                echo "$number in binary is $number<br>";
                $math = bindec($number)."<br>";
                echo "$number in octal is ".decoct($math)."<br>";
                echo "$number in hexadecimal is ".dechex($math)."<br>"; 
            }

            elseif ($conversion == "oct"){
                $math = octdec($number);
                echo "$number in decimal is $math<br>";
                echo "$number in binary is ".decbin($math)."<br>";
                echo "$number in octal is ".decoct($math)."<br>";
                echo "$number in hexadecimal is ".dechex($math)."<br>";
            }

            elseif ($conversion == "hex"){
                $math = hexdec($number);
                echo "$number in decimal is $math<br>";
                echo "$number in binary is ".decbin($math)."<br>";
                echo "$number in octal is ".decoct($math)."<br>";
                echo "$number in hexadecimal is ".dechex($math)."<br>";
            }
        }

        if (isset($_POST['submit'])) {
            $errors = array();
            //checks if input is binary
            $binaryCheck = array("1","0");
            if (is_numeric($number)){
                if ($number < 0)
                    $errors[] = "Number less than 0";
            }
            else
                $errors[] = "Invalid number";

            if($conversion != "dec" && $conversion != "bin" && $conversion != "oct" && $conversion != "hex")
                $errors[] = "invalid conversion type";

            if ($conversion == "bin"){
                settype($number, "string");
                $numberSplit = str_split($number);
                for ($i=0; $i < count($numberSplit); $i++){
                    if ($numberSplit[$i] != $binaryCheck[0] && $numberSplit[$i] != $binaryCheck[1])
                        $errors[] = "Number is not binary";
                        break;
                }
            }

            //checks if input is hex
            if (preg_match("/[^0-9|^A-F|^a-f]/",$number) == 1){
                $errors[] = "Invalid hexadecimal number";
            }
                
            if (sizeof($errors) == 0) {
                NumberConversion($number,$conversion);
            }
            else{
                foreach ($errors as $error) {
                    echo $error,"<br>";
                }
            } 
        }
        else{
            ?>
            <input type="number" name="number"> Enter a number to convert <br><br> 
            Select current data type 
            <br>
            <input type="radio" value="dec" name="conversion">Decimal<br>
            <input type="radio" value="bin" name="conversion">Binary<br>
            <input type="radio" value="oct" name="conversion">Octal<br>
            <input type="radio" value="hex" name="conversion">Hexadecimal<br> <br>
            <button onclick="return converter();">Convert!</button>
            <?php
        }
        ?>
        <div id="conversionOutput">
    </body>