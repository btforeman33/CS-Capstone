<head>
    <style>
        body{
            background-color: whitesmoke;
            margin: auto;
            align-content: center;
            width:50%;
        }
        div{
            align-self:auto;
        }

    </style>
</head>
<script>
   function check(){
	var formData = {
            'user' : $('input[id=user]').val(),
            'pass' : $('input[id=pass]').val(),
            'submit' : true
        };
    $.ajax({
       	url : 'includes/loginCheck.php',
       	type : 'POST',
       	data : formData,
       	success: function(result){ 
            if(result == '1'){
                alert("Logged in successfully");
                location.reload();
            }
            else
                $("#check").html(result);
        },
       	error: function(result){ $("#check").html("Connection failed!"); },

	});
    }
</script>
<div id="login">
    Username:<input type="text" id='user' value=""><br>
    Password:<input type="password" id='pass' ><br>
    <button onclick="return check();">Submit</button>
    <button onclick='return ajaxNavigation("signup");'>Need to sign up?</button>
</div>
<div id="check"></div>