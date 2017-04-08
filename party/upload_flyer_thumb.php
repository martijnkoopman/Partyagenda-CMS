<?php
	function __autoload($class_name) {
		include "../classes/".$class_name.".class.php";
	}
?>

<html>
<head>
	<title>Upload flyer thumbnail - Partyagenda</title>
	
	<link rel="shortcut icon" type="image/x-icon" href="../favicon.ico" />
	<link rel="stylesheet" type="text/css" href="../style.css" />
	
</head>
<body>

<h1>Upload flyer thumbnail</h1>
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
		
			$outputFile = "../../flyers/thumbs/".$party_id.".jpg";//$_FILES['flyerfile']['name'];
			$inputFile = $_FILES['flyerfile']['tmp_name'];
			
			// Check for invalid values
			if(empty($inputFile)){
				$hasErrors = true;
				echo "Input file not specified."."<br />\n";
			}
			
			if(!$hasErrors) {	
				
				if (move_uploaded_file($inputFile, $outputFile)) {
					echo "<b>Flyer thumbnail uploaded.</b>"."<br />\n";
				} else {
					echo "<b>Failed to upload flyer.</b>"."<br />\n";
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
			
<form method="POST" enctype="multipart/form-data" action="upload_flyer_thumb.php?id=<?php echo $party_id; ?>">
<fieldset>
    <legend><b>Flyer thumbnail</b></legend>
	<table>
	<tr>
		<td>File:</td>
		<td rowspan="2">
				<!-- MAX_FILE_SIZE must precede the file input field (= 1024 * 1024) -->
				<input type="hidden" name="MAX_FILE_SIZE" value="1048576" />
				<!-- Name of input element determines name in $_FILES array -->
				<input name="flyerfile" type="file" /><br />
				(...x300, *.jpg)
		</td>
	</tr>
	</table>
</fieldset>

<input type="submit" name="submit" value="Upload flyer thumbnail" />
</form>

<?php
	}
?>

</body>
</html>