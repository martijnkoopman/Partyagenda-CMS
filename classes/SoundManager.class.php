<?php
class SoundManager
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
	/* ********** Get sounds ********** */
	/* *********************************/

	public function getSounds() {
		$sounds = array();
		
		// Execute query
		$result = $this->mysqli->query("SELECT * FROM `sound` WHERE `party_id` = ".$this->party_id);
		
		// For each row
		while($row = $result->fetch_assoc()) {
			// Add party to array
			$sounds[] = new Sound($row["id"], $row["soundlcoud_id"], $row["title"], $row["duration"], $row["uploader"], $row["uploaded"], $row["icon_url"]);		
		}
		
		// Free result set
		$result->close();
		
		return $sounds;
	}
	
	/************************************/
	/* ********** Get sound ********** */
	/* **********************************/

	public function getSound($soundId) {
		// Execute query
		$result = $this->mysqli->query("SELECT * FROM `sound` WHERE `id` = ".$soundId);
		
		// For each row
		if($row = $result->fetch_assoc()) {
			$sound = new Sound($row["id"], $row["soundlcoud_id"], $row["title"], $row["duration"], $row["uploader"], $row["uploaded"], $row["icon_url"]);	
		}
		
		// Free result set
		$result->close();
		
		return $sound;
	}
	
	/*************************************/
	/* ********** Add sound ********** */
	/* ***********************************/

	public function addSound(Sound $sound) {
		// Form query
		
		// Upload date format: 2012-06-22
		$query = "INSERT INTO `sound` (`id`, `party_id`, `soundcloud_id`, `title`, `duration` , `uploader`, `uploaded`, `icon_url` ) ".
				"VALUES (NULL , '".$this->party_id."', '".$sound->soundcloud_id."', '".$sound->title."', '".$sound->duration."', '".$sound->uploader."', '".$sound->uploaded."', '".$sound->icon_url."');";
		// Execute query
		$queryResult = $this->mysqli->query($query);
		if(!$queryResult) {
			echo "Inserting sound failed (".$this->mysqli->errno."): ".$this->mysqli->error."<br />\n";
			return false;
		} else {
			return $this->mysqli->insert_id;
		}
	}
	
	/*****************************************/
	/* ********** Update sound ********** */
	/* ***************************************/
	
	public function updateSound(Sound $sound) {
		// Form query
		$query = "UPDATE `sound` SET `soundcloud_id` = '".$sound->soundcloud_id."', ".
				"`title` = '".$sound->title."', ".
				"`duration` = ".$sound->duration.", ".
				"`uploader` = '".$sound->uploader."', ".
				"`uploaded` = '".$sound->uploaded."' ".
				"`icon_url` = '".$sound->icon_url."' ".
				"WHERE `id` = ".$sound->id;

		// Execute query
		$queryResult = $this->mysqli->query($query);
		if(!$queryResult) {
			echo "Updating sound failed (".$this->mysqli->errno."): ".$this->mysqli->error."<br />\n";
			return false;
		} else {
			return true;
		}
	}
	
	/***************************************/
	/* ********** Delete sound ********** */
	/* *************************************/
	
	public function deleteSound($soundId) {
		// Execute query
		$queryResult = $this->mysqli->query("DELETE FROM `sound` WHERE `id` = ".$soundId);
		if(!$queryResult) {
			echo "Deleting sound failed (".$this->mysqli->errno."): ".$this->mysqli->error."<br />\n";
			return false;
		} else {
			return true;
		}
	}
}
?>