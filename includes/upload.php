<style>
    p{
        margin:auto;
    }
</style>
<script>
function uploadFile(){
	var formData = new FormData();
    formData.append('uploadFile', $('#uploadFile')[0].files[0]);
    formData.append("submit",true);
    $.ajax({
        url: "includes/uploadFile.php",
        type: "POST",
        data: formData,
        processData: false,
        contentType:false,
        success: function(result){$("#output").html(result);},
        error: function(result){$("#output").html("Error!");}
    });
}
</script>
<p>Upload a file to the website:</p>
<br>
<input type="file" id="uploadFile">
<button onclick="uploadFile();">Upload</button>
<br><br>
Maximum upload size is 2GB per file currently.
<div id="output"></div>