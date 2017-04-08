<?php
	function __autoload($class_name) {
		include "../classes/".$class_name.".class.php";
	}
	
	$videoManager = new VideoManager(0);
?>
<html>
<head>
	<title>Delete video - Partyagenda</title>
	
	<link rel="shortcut icon" type="image/x-icon" href="../favicon.ico" />
	<link rel="stylesheet" type="text/css" href="../style.css" />
		
</head>
<body>

<h1>Delete video</h1>
<form method="GET" action="../party/edit.php">
<input type="hidden" name="id" value="<?php echo $_GET['party_id']; ?>" />
<input type="submit" value="<<< back" />
</form>
<hr />

<?php
	if(isset($_POST['submit'])) {
			$video_id = $_POST['video_id'];
			
			// Delete video from database
			$deleteResult = $videoManager->deleteVideo($video_id);

			if($deleteResult) {
				echo "<b>Video removed.</b> (".$video_id.")"."<br />\n";
			}
			
	} else {
		// Going to delete a video
		if(isset($_GET['party_id']) && !empty($_GET['party_id'])) {
			$party_id = $_GET['party_id'];
		} else {
			echo "Specify a party ID"."<br />\n";
		}
		
		if(isset($_GET['video_id']) && !empty($_GET['video_id'])) {
			$video_id = $_GET['video_id'];
		} else {
			echo "Specify a video ID"."<br />\n";
		}
	}
?>
<hr />
<br />

<?php
	if($_SERVER['REQUEST_METHOD'] == GET && isset($party_id) && isset($video_id)) {
	?>
<form method="POST" action="delete.php?party_id=<?php echo $party_id; ?>">
	Are you sure you want to delete the video with id = <?php echo $video_id; ?><br />
	<input type="hidden" name="video_id" value="<?php echo $video_id; ?>" />
	<input type="submit" name="submit" value="YES, delete" />
</form>
	<?php
	}
	?>

</body>
</html>