<?php
	function __autoload($class_name) {
		include "../classes/".$class_name.".class.php";
	}
?>

<html>
<head>
	<title>Upload icon - Partyagenda</title>
	
	<link rel="shortcut icon" type="image/x-icon" href="../favicon.ico" />
	<link rel="stylesheet" type="text/css" href="../style.css" />
	
</head>
<body>

<h1>Upload icon</h1>
<form method="GET" action="edit.php">
<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
<input type="submit" value="<<< back" />
</form>
<hr />
<?php
	if(!isset($_GET['id']) || empty($_GET['id'])) {
		echo "Specify a party ID"."<br />\n";
	} else {
		$party_id = $_GET['id'];
		
		// 'Add site' (submit) has been pressed.
		if(isset($_POST['submit'])) {
			$hasErrors = false;
		
			$outputFile = "../../icons/".$party_id.".jpg";//$_FILES['iconfile']['name'];
			$inputFile = $_FILES['iconfile']['tmp_name'];
			
			// Check for invalid values
			if(empty($inputFile)){
				$hasErrors = true;
				echo "Input file not specified."."<br />\n";
			}
			
			if(!$hasErrors) {	
				
				if (move_uploaded_file($inputFile, $outputFile)) {
					echo "<b>Icon uploaded.</b>"."<br />\n";
				} else {
					echo "<b>Failed to upload icon.</b>"."<br />\n";
				}
				
				// Unset fields for next party
				unset($outputFile);
				unset($inputFile);
			}
		} // End of isSet()
	}
?>
<hr />
<br />

<?php
	if($_SERVER['REQUEST_METHOD'] == GET && isset($party_id)) {
?>
			
<form method="POST" enctype="multipart/form-data" action="upload_icon.php?id=<?php echo $party_id; ?>">
<fieldset>
    <legend><b>Icon</b></legend>
	<table>
	<tr>
		<td>File:</td>
		<td rowspan="2">
				<!-- MAX_FILE_SIZE must precede the file input field (= 1024 * 1024) -->
				<input type="hidden" name="MAX_FILE_SIZE" value="1048576" />
				<!-- Name of input element determines name in $_FILES array -->
				<input name="iconfile" type="file" /><br />
				(90x90, *.jpg)
		</td>
	</tr>
	</table>
</fieldset>

<input type="submit" name="submit" value="Upload icon" />
</form>

<?php
	}
?>

</body>
</html>