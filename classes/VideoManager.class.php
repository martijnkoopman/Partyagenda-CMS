<?php
class VideoManager
{
	// Database constants
	const host = "localhost";
	const user = "";
	const pass = "";
	const database = "";
	
	private $mysqli;
	private $party_id;
	
	// Constructor
	function __construct($party_id) {
		$this->party_id = $party_id;
		
		$this->mysqli = new mysqli(self::host, self::user, self::pass, self::database);
		if($this->mysqli->connect_errno) {
			echo "MySQL error: ".$mysqli_connect_error();
		}
	}
	
	// Destructor
	function __destruct() {}
	
	/***********************************/
	/* ********** Get video's ********** */
	/* *********************************/

	public function getVideos() {
		$videos = array();
		
		// Execute query
		$result = $this->mysqli->query("SELECT * FROM `videos` WHERE `party_id` = ".$this->party_id." ORDER BY `uploaded` DESC;");
		
		// For each row
		while($row = $result->fetch_assoc()) {
			// Add party to array
			$videos[] = new Video($row["id"], $row["youtube_id"], $row["title"], $row["duration"], $row["uploader"], $row["uploaded"]);		
		}
		
		// Free result set
		$result->close();
		
		return $videos;
	}
	
	/************************************/
	/* ********** Get video ********** */
	/* **********************************/

	public function getVideo($videoId) {
		// Execute query
		$result = $this->mysqli->query("SELECT * FROM `videos` WHERE `id` = ".$videoId);
		
		// For each row
		if($row = $result->fetch_assoc()) {
			$video = new Video($row["id"], $row["youtube_id"], $row["title"], $row["duration"], $row["uploader"], $row["uploaded"]);	
		}
		
		// Free result set
		$result->close();
		
		return $video;
	}
	
	/*************************************/
	/* ********** Add video ********** */
	/* ***********************************/

	public function addVideo(Video $video) {
		// Form query
		
		// Upload date format: 2012-06-22
		$query = "INSERT INTO `videos` (`id`, `party_id`, `youtube_id`, `title`, `duration` , `uploader`, `uploaded` ) ".
				"VALUES (NULL , '".$this->party_id."', '".$video->youtube_id."', '".$video->title."', '".$video->duration."', '".$video->uploader."', '".$video->uploaded."');";
		// Execute query
		$queryResult = $this->mysqli->query($query);
		if(!$queryResult) {
			echo "Inserting video failed (".$this->mysqli->errno."): ".$this->mysqli->error."<br />\n";
			return false;
		} else {
			return $this->mysqli->insert_id;
		}
	}
	
	/*****************************************/
	/* ********** Update video ********** */
	/* ***************************************/
	
	public function updateVideo(Video $video) {
		// Form query
		$query = "UPDATE `videos` SET `youtube_id` = '".$video->youtube_id."', ".
				"`title` = '".$video->title."', ".
				"`duration` = ".$video->duration.", ".
				"`uploader` = '".$video->uploader."', ".
				"`uploaded` = '".$video->uploaded."' ".
				"WHERE `id` = ".$video->id;

		// Execute query
		$queryResult = $this->mysqli->query($query);
		if(!$queryResult) {
			echo "Updating video failed (".$this->mysqli->errno."): ".$this->mysqli->error."<br />\n";
			return false;
		} else {
			return true;
		}
	}
	
	/***************************************/
	/* ********** Delete video ********** */
	/* *************************************/
	
	public function deleteVideo($videoId) {
		// Execute query
		$queryResult = $this->mysqli->query("DELETE FROM `videos` WHERE `id` = ".$videoId);
		if(!$queryResult) {
			echo "Deleting video failed (".$this->mysqli->errno."): ".$this->mysqli->error."<br />\n";
			return false;
		} else {
			return true;
		}
	}
}
?>