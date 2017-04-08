<?php
	function __autoload($class_name) {
		include "../classes/".$class_name.".class.php";
	}
?>
<html>
<head>
	<title>Edit video - Partyagenda</title>
	
	<link rel="shortcut icon" type="image/x-icon" href="../favicon.ico" />
	<link rel="stylesheet" type="text/css" href="../style.css" />
		
</head>
<body>

<?php
	if(!isset($_GET['party_id']) || empty($_GET['party_id'])) {
		echo "Specify a party ID"."<br />\n";
		?>	
			<h1>Edit video</h1>
			<form method="GET" action="index.php">
			<input type="submit" value="<<< back" />
			</form>
			<hr />
		<?php
	} else if(!isset($_GET['video_id']) || empty($_GET['video_id'])) {
		echo "Specify a video ID"."<br />\n";
	} else {
		$party_id = $_GET['party_id'];
		$video_id = $_GET['video_id'];
		
		?>
			<h1>Edit video</h1>
			<form method="GET" action="../party/edit.php">
			<input type="hidden" name="id" value="<?php echo $party_id; ?>" />
			<input type="submit" value="<<< back" />
			</form>
			<hr />
		<?php
		
		// Create video manager
		$videoManager = new VideoManager($party_id);
		
		// Get the video from db
		$video = $videoManager->getVideo($video_id);

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
				// Create video
				$video = new Video($video_id, $youtube_id, $title, $duration, $uploader, $uploaded);
		
				$updateResult = $videoManager->updateVideo($video);
				
				if($updateResult) {
					echo "<b>Video updated.</b>"."<br />\n";
				}
			}
				
			// Unset fields for next video
			unset($youtube_id);
			unset($title);
			unset($duration);
			unset($uploader);
			unset($uploaded);		
		} 
	}
?>
<hr />
<br />

<?php
	if($_SERVER['REQUEST_METHOD'] == GET && isset($party_id) && isset($video_id)) {
	?>
<form method="POST" action="edit.php?party_id=<?php echo $party_id; ?>&video_id=<?php echo $video_id; ?>">
<fieldset>
    <legend><b>Video</b></legend>
	<table>
	<tr>
		<td>Youtube ID*:</td>
		<td>
			<input type="text" name="youtube_id" value="<?php echo $video->youtube_id; ?>" />
		</td>
	</tr>
	<tr>
		<td>Title*:</td>
		<td><input type="text" name="title" value="<?php echo $video->title; ?>" /></td>
	</tr>
	<tr>
		<td>duration:</td>
		<td><input type="text" name="duration" value="<?php echo $video->duration; ?>" placeholder="seconds" /></td>
	</tr>
	<tr>
		<td>Uploader:</td>
		<td><input type="text" name="uploader" value="<?php echo $video->uploader; ?>" /></td>
	</tr>
	<tr>
		<td>Date uploaded*:</td>
		<td><input type="text" name="uploaded" value="<?php echo $video->uploaded; ?>" placeholder="yyyy-mm-dd" /></td>
	</tr>
	</table>
</fieldset>

<input type="submit" name="submit" value="Update video" />
</form>

	<?php
	}
	?>

</body>
</html>