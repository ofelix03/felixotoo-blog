<html>
<head>
	<title></title>
</head>
<body>
<?php 
echo form_open_multipart('cms/upload');
?>
<input type='file' name='upload' />
<input type='text' name='name'  value='felix'/>

<input type='submit' value='upload' />
</body>
</html>