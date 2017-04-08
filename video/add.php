<?php
	function __autoload($class_name) {
		include "../classes/".$class_name.".class.php";
	}
?>

<html>
<head>
	<title>Add video - Partyagenda</title>
	
	<link rel="shortcut icon" type="image/x-icon" href="../favicon.ico" />
	<link rel="stylesheet" type="text/css" href="../style.css" />
	
	<script type="text/javascript" src="youtube.js"></script>
	
</head>
<body>

<h1>Add video</h1>
<form method="GET" action="../party/edit.php">
<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
<input type="submit" value="<<< back" />
</form>
<hr />
<?php
	if(!isset($_GET['id']) || empty($_GET['id'])) {
		echo "Specify a party ID"."<br />\n";
	} else {
		$party_id = $_GET['id'];
		
		// 'Add video' (submit) has been pressed.
		
		if(isset($_POST['submit'])) {
			$hasErrors = false;
		
			$youtube_id = $_POST['youtube_id'];
			$title = $_POST['title'];
			$duration = $_POST['duration'];
			$uploader = $_POST['uploader'];
			$uploaded = $_POST['uploaded'];
			
			// Check for invalid values
			if(empty($youtube_id)){
				$hasErrors = true;
				echo "Youtube ID not specified."."<br />\n";
			}
			if(empty($title)) {
				$hasErrors = true;
				echo "Title not specified."."<br />\n";
			}
			if(empty($uploaded)) {
				$hasErrors = true;
				echo "Date uploaded not specified."."<br />\n";
			}
			
			if(!$hasErrors) {	
				// Create video manager
				$videoManager = new VideoManager($party_id);
		
				// Create new video
				$video = new Video(NULL, $youtube_id, $title, $duration, $uploader, $uploaded);
				
				// Store video in database
				$storeResult = $videoManager->addVideo($video);

				if($storeResult) {
					echo "<b>Video added to party.</b>"."<br />\n";
				}

				// Unset fields for next video
				unset($youtube_id);
				unset($title);
				unset($duration);
				unset($uploader);
				unset($uploaded);
			}
		} // End of isSet()
	}
?>
<hr />
<br />

<?php
	if($_SERVER['REQUEST_METHOD'] == GET && isset($party_id)) {
?>

<form method="POST" action="add.php?id=<?php echo $party_id; ?>">
<fieldset>
    <legend><b>Video</b></legend>
	<table>
	<tr>
		<td>Youtube ID*:</td>
		<td>
			<input type="text" name="youtube_id" />
			<span style="background-color: black; color: white" onclick="fill()">Fill</span>
		</td>
	</tr>
	<tr>
		<td>Title*:</td>
		<td><input type="text" name="title" /></td>
	</tr>
	<tr>
		<td>duration:</td>
		<td><input type="text" name="duration" placeholder="seconds" /></td>
	</tr>
	<tr>
		<td>Uploader:</td>
		<td><input type="text" name="uploader" /></td>
	</tr>
	<tr>
		<td>Date uploaded*:</td>
		<td><input type="text" name="uploaded" placeholder="yyyy-mm-dd" /></td>
	</tr>
	</table>
</fieldset>

<input type="submit" name="submit" value="Add video" />
</form>
<br />
Media resource: https://www.googleapis.com/youtube/v3/videos?part=snippet&id=[VIDEOID]&key=[KEY]
<?php
	}
?>

</body>
</html>