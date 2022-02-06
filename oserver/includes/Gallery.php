<script>
   function upload(){
	var formData = new FormData();
	formData.append('uploadFile', $('#uploadFile')[0].files[0]);
    formData.append('submit',true);
    formData.append('type', "Gallery")
    $.ajax({
       	url : 'includes/upload.php',
       	type : 'POST',
       	data : formData,
       	processData: false,  // tell jQuery not to process the data
       	contentType: false,  // tell jQuery not to set contentType
       	success: function(result){ $("#pictures").html(result); },
       	error: function(result){ $("#pictures").html("doesn't work"); },

	});
    }
    //function to tell php to delete the pictures in gallery
    function deleteCheck(){
        if (confirm("Are you sure you want to clear the gallery pictures?")) {
            var formData = new FormData();
            formData.append('deleteCheck' , true);
            formData.append('type', "Gallery");
            $.ajax({
                url : 'includes/upload.php',
                type : 'POST',
                data : formData,
                processData: false,
                contentType: false,
                success: function(result){ $("#pictures").html("Success!"); },
                error: function(result){ $("#pictures").html("Error!"); },
	        });
        }
    }

    function display(){
	var formData = new FormData();
    formData.append('display','true');
    formData.append('type', "Gallery")
    $.ajax({
       	url : 'includes/upload.php',
       	type : 'POST',
       	data : formData,
       	processData: false,  // tell jQuery not to process the data
       	contentType: false,  // tell jQuery not to set contentType
       	success: function(result){ $("#pictures").html(result); },
       	error: function(result){ $("#pictures").html("doesn't work"); },

	});
    }
</script>

<!-- make images load when the webpage loads -->
<iframe onload="return display();" style="display:none"></iframe>

Upload a picture to add to the gallery<br>
<input type="file" name="uploadFile" id='uploadFile'/>
<button class="button" onclick="return upload();">Upload</button>
<button class="button" onclick="display();">Refresh Gallery</button>
<button class="button" onclick="return deleteCheck();">Clear Pictures</button>
<div id='pictures' onload="return upload();"></div>