<script>
   function upload(){
	var formData = new FormData();
    formData.append('uploadFile', $('#uploadFile')[0].files[0]);
    formData.append('type', "CSV")
    formData.append('headers', $('input[name=headers]').is(':checked') ? 'true' : '' );
    $.ajax({
       	url : 'includes/upload.php',
       	type : 'POST',
       	data : formData,
       	processData: false,  // tell jQuery not to process the data
       	contentType: false,  // tell jQuery not to set contentType
       	success: function(result){ $("#CSVOutput").html(result); },
       	error: function(result){ $("#CSVOutput").html("doesn't work"); },
	});
}
</script>
<input type="file" id='uploadFile'>
<button onclick="upload();">Upload</button>
<br><br>
<input type="checkbox" id="headers" name='headers'>CSV has headers
<div id="CSVOutput"></div>
