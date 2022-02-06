<script>
    function upload(){
        var formData = new FormData();
        formData.append('uploadFile', $('#uploadFile')[0].files[0]);
        formData.append('type', 'flashcard');
        formData.append('check', $('input[name=random]').is(':checked'));
        $.ajax({
           	url : 'includes/upload.php',
           	type : 'POST',
           	data : formData,
           	processData: false,  // tell jQuery not to process the data
           	contentType: false,  // tell jQuery not to set contentType
           	success: function(result){ $("#output").html(result); },
           	error: function(result){ $("#output").html("doesn't work"); },

        });
    }

    //function to display csvs on load
    function display(){
	    var formData = new FormData();
        formData.append('display','true');
        formData.append('type', "flashcard")
        $.ajax({
           	url : 'includes/upload.php',
           	type : 'POST',
           	data : formData,
           	processData: false,  // tell jQuery not to process the data
           	contentType: false,  // tell jQuery not to set contentType
           	success: function(result){ $("#output").html(result); },
           	error: function(result){ $("#output").html("doesn't work"); },

	});
    }
    function deleteCSV(){
        if (confirm("Are you sure you want to clear the uploaded CSVs?")){
            var formData = new FormData();
            formData.append('destroy','true');
            formData.append('type', "flashcard")
            $.ajax({
                url : 'includes/upload.php',
                type : 'POST',
                data : formData,
                processData: false,  // tell jQuery not to process the data
                contentType: false,  // tell jQuery not to set contentType
                success: function(result){ $("#output").html(result); },
                error: function(result){ $("#output").html("Error!"); },
            });
        }
    }
</script>

<a align="left">Upload a CSV to act like a flashcard.</a>
<a align="left" style="color:red">This will not work if your CSV contains commas anywhere in the data! Blank lines will appear if you have them in your CSV!</a>
<br>
<input type="file" name="uploadFile" id='uploadFile'/>
<button class="button" onclick="return upload();">Upload</button>
<button class="button" onclick="return deleteCSV();">Delete CSVs</button>
<input type="checkbox" name="random"> Make the questions random?

<!-- iframe to run function on load -->
<iframe onload="return display();" style="display:none"></iframe>

<div id="output"></div>
