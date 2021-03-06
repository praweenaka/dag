<html>
<body>

<form action="after_upload.php" method="post" enctype="multipart/form-data">
<label for="file">Filename:</label>
<input type="file" name="file" id="file">
<input type="hidden" name="cou" id="cou" value="<?php echo $_GET["cou"]; ?>">

<input type="hidden" name="cus_id" id="cus_id">

<script language="JavaScript">
	document.getElementById("cus_id").value =opener.document.form1.txt_cuscode.value;
</script>
<br>
<input type="submit" name="submit" value="Upload Image">
</form>

</body>
</html> 