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
            $('#check').html('works');
            alert("Logged in successfully")
            window.location.reload(true);
        }
        else
            $("#check").html(result);
        },
       	error: function(result){ $("#check").html("doesn't work"); },

	});
    }
</script>

Username:<input type="text" id='user'><br>
Password:<input type="password" id='pass'><br>
<button onclick="return check();">Submit</button>
        
<button onclick='return ajaxNavigation("signup")'>Need to sign up?</button>
<div id="check"></div>