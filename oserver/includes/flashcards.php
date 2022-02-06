<style>
    body {
    font-family: Arial, Helvetica, sans-serif;
    background: #bbbbbb;
    }

    .flip-card {
    background-color: transparent;
    width: 550px;
    height: 500px;
    left: 50%;
    padding-top:5%;
    padding-bottom: 6%;
    perspective: 1000px;
    }

    .flip-card-inner {
    position: relative;
    width: 100%;
    height: 100%;
    text-align: center;
    transition: transform 0.6s;
    transform-style: preserve-3d;
    }

    .flip-card:hover .flip-card-inner {
    transform: rotateY(180deg);
    }

    .flip-card-front, .flip-card-back {
    font-weight: bold;
    font-size: 200%;
    position: absolute;
    box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
    padding-top: 3%;
    border-radius: 25px;
    padding: 10px;
    width: 100%;
    height: 100%;
    word-wrap: break-word;
    -webkit-backface-visibility: hidden;
    backface-visibility: hidden;
    }

    .flip-card-front {
    background-color: #FFFFFF;
    color: black;
    }

    .flip-card-back {
    background-color: #000000;
    vertical-align: 50%;
    color: white;
    transform: rotateY(180deg);
    }

    button.button4{
    background-color:black;
    display:inline-block;
    padding:0.3em 1.2em;
    margin:0 0.1em 0.1em 0;
    border:0.16em solid rgba(255,255,255,0);
    border-radius:2em;
    font-style: italic;
    font-size: 120%;
    width: 300px;
    height:45px;
    text-decoration:none;
    font-family:'Roboto',sans-serif;
    font-weight:300;
    color:#FFFFFF;
    text-shadow: 0 0.04em 0.04em rgba(0,0,0,0.35);
    text-align:center;
    transition: all 0.2s;
    }
    button.button4:hover{
    border-color: rgba(255,255,255,1);
    }

    button.button5{
    background-color:white;
    display:inline-block;
    padding:0.3em 1.2em;
    margin:0 0.1em 0.1em 0;
    border:0.16em solid rgba(0,0,0,0);
    border-radius:2em;
    font-style: italic;
    font-size: 130%;
    width: 300px;
    height:45px;
    text-decoration:none;
    font-family:'Roboto',sans-serif;
    font-weight:300;
    color:#000000;
    text-shadow: 0 0.04em 0.04em rgba(255,255,255,0.35);
    text-align:center;
    transition: all 0.2s;
    }
    button.button5:hover{
    border-color: rgba(0,0,0,1);
    }
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<?php
error_reporting(0);
if(session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
?>
<script>
    //sets size of the file currently uploaded to attach with the file as its passed through sessions
    var size = <?php echo $_POST['size'];?> - 1;

    //3 functions depending on whether its just loading the cards or if its generating another question
    function upload(){
        var formData = new FormData();
        formData.append('file', '<?php echo $_POST['csv'];?>');
        $.ajax({
           	url : 'flashcardquestion.php',
           	type : 'POST',
           	data : formData,
            processData: false,  // tell jQuery not to process the data
       	    contentType: false,  // tell jQuery not to set contentType
           	success: function(result){
                try {
                    // takes the output from the flashcard page and explodes it into different sections
                    var exploded = result.split(",");
                    var question = exploded[0];
                    var answer = exploded[1];
                    var number = exploded[2];
                    var number = parseInt(number);

                    //Check Question number and print buttons to make sure it stays in its boundaries
                    if(number < size){
                        $("#buttons").html("<button class='button4' onclick='return nextquestion();'>Next Question</button>");
                    }
                    if(number > 0){
                        $("#buttons").html("<button class='button5' onclick='return previousquestion();'>Previous Question</button>");
                    }
                    if(number < size){
                        if(number > 0){
                            $("#buttons").html("<button class='button5' onclick='return previousquestion();'>Previous Question</button><button class='button4' onclick='return nextquestion();'>Next Question</button>");
                        }
                    }

                    $("#flip-card-front").html(question);
                    $("#flip-card-back").html(answer);
                } catch (error) {
                    $("#flip-card-front").html('Not a valid CSV file!')
                }
            },
           	error: function(result){ $("#output").html("doesn't work"); },
            });
    }
    function nextquestion(){
        var formData = new FormData();
        formData.append('file', '<?php echo $_POST['csv'];?>');
        formData.append('next',true);
        $.ajax({
           	url : 'flashcardquestion.php',
           	type : 'POST',
           	data : formData,
            processData: false,  // tell jQuery not to process the data
       	    contentType: false,  // tell jQuery not to set contentType
           	success: function(result){
                try {
                    // takes the output from the flashcard page and explodes it into different sections
                    var exploded = result.split(",");
                    var question = exploded[0];
                    var answer = exploded[1];
                    var number = exploded[2];
                    var number = parseInt(number);

                    //Check Question number and print buttons to make sure it stays in its boundaries
                    if(number < size){
                        $("#buttons").html("<button class='button4' onclick='return nextquestion();'>Next Question</button>");
                    }
                    if(number > 0){
                        $("#buttons").html("<button class='button5' onclick='return previousquestion();'>Previous Question</button>");
                    }
                    if(number < size){
                        if(number > 0){
                            $("#buttons").html("<button class='button5' onclick='return previousquestion();'>Previous Question</button><button class='button4' onclick='return nextquestion();'>Next Question</button>");
                        }
                    }
                    
                    $("#flip-card-front").html(question);
                    $("#flip-card-back").html(answer);
                } catch (error) {
                    $("#flip-card-front").html('Not a valid CSV file!')
                }
            },
           	error: function(result){ $("#output").html("doesn't work"); },
            });
    }
    function previousquestion(){
        var formData = new FormData();
        formData.append('file', '<?php echo $_POST['csv'];?>');
        formData.append('previous',true);
        $.ajax({
           	url : 'flashcardquestion.php',
           	type : 'POST',
           	data : formData,
            processData: false,  // tell jQuery not to process the data
       	    contentType: false,  // tell jQuery not to set contentType
           	success: function(result){
                try {
                    // takes the output from the flashcard page and explodes it into different sections
                    var exploded = result.split(",");
                    var question = exploded[0];
                    var answer = exploded[1];
                    var number = exploded[2];
                    var number = parseInt(number);

                    //Check Question number and print buttons to make sure it stays in its boundaries
                    if(number < size){
                        $("#buttons").html("<button class='button4' onclick='return nextquestion();'>Next Question</button>");
                    }
                    if(number > 0){
                        $("#buttons").html("<button class='button5' onclick='return previousquestion();'>Previous Question</button>");
                    }
                    if(number < size){
                        if(number > 0){
                            $("#buttons").html("<button class='button5' onclick='return previousquestion();'>Previous Question</button><button class='button4' onclick='return nextquestion();'>Next Question</button>");
                        }
                    }

                    $("#flip-card-front").html(question);
                    $("#flip-card-back").html(answer);
                } catch (error) {
                    $("#flip-card-front").html('Not a valid CSV file!')
                }
            },
           	error: function(result){ $("#output").html("doesn't work"); },
            });
    }
</script>
<div align="middle">
    <div class="flip-card">
        <div class="flip-card-inner">
            <div id="flip-card-front" class="flip-card-front">
            </div>
            <div id="flip-card-back" class="flip-card-back">
                <iframe onload="upload();" style="display:none"></iframe>
            </div>
        </div>
    </div>
</div>
<div align="middle" id="buttons">
</div>
