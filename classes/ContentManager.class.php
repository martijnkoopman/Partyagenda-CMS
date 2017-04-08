<?php

class ContentManager {

	// Database constants
	const host = "localhost";
	const user = "";
	const pass = "";
	const database = "";
	
	const filePath = "../data.json";

	private $jsonResult;
	
	private $mysqli;
	
	// Constructor
	function __construct() {
		$this->mysqli = new mysqli(self::host, self::user, self::pass, self::database);
		if($this->mysqli->connect_errno) {
			echo "MySQL error: ".$mysqli_connect_error();
		}
	}
	
	// Destructor
	function __destruct() {}
	
	/******************************************************/
	/* ********** Map database to file as JSON ********** */
	/* ****************************************************/
	
	public function export2json() 
	{
		// Map the DB to a JSON result
		if(!($this->jsonResult = $this->generateJson())) 
		{
			echo "Failed to map DB as JSON!"."<br />\n";
			return false;
		} 
		else 
		{
			// Write the JSON result to the file
			if(!$this->jsonResultToFile(self::filePath)) 
			{
				echo "Failed to write JSON result to '".self::filePath."'"."<br />\n";
				return false;
			}
		}

		return true;
	}
	
	public function getJsonResult() {
		if(empty($this->jsonResult)) {
			$this->jsonResult = $this->generateJson();
		}
		return $this->jsonResult;
	}
	
	/* ********** Map database to a JSON result ********** */
	
	// Util: generate a json result from database
	private function generateJson() 
	{
		// Create party array
		$partyArray = array();
	
		// Get party's from database 
		$partyQuery = "SELECT * FROM `partys` ORDER BY `date` ASC";
		$partyResult = $this->mysqli->query($partyQuery);
		if(!$partyResult) {
			echo "Failed to select party's from database! (".$this->mysqli->errno."): ".$this->mysqli->error."<br />\n";
			return false;
		}
	
		while ($partyRow = $partyResult->fetch_assoc()) {
			// Strip SQL safe slashes
			foreach($partyRow as $key => $value) {
				$partyRow[$key] = stripslashes($value);
			}
		
			// Create online array
			$onlineArray = array();
			
			// Get online sites from database
			$onlineQuery = "SELECT * FROM `online` WHERE `party_id` = ".(int)$partyRow['id']." ORDER BY `id` ASC";
			$onlineResult = $this->mysqli->query($onlineQuery);
			if(!$onlineResult) {
				echo "Failed to select online sites from database! (".$this->mysqli->errno."): ".$this->mysqli->error."<br />\n";
				return false;
			}
		
			while ($onlineRow = $onlineResult->fetch_assoc()) {	
				$onlineArray[] = array("type" => $onlineRow['type'],
								"name" => $onlineRow['name'],
								"url" => $onlineRow['url']);
			}
			$onlineResult->free();
			
			// Create ticket array
			$ticketArray = array();
			
			// Get ticket sites from database
			$ticketQuery = "SELECT * FROM `online_tickets` WHERE `party_id` = ".(int)$partyRow['id']." ORDER BY `id` ASC";
			$ticketResult = $this->mysqli->query($ticketQuery);
			if(!$ticketResult) {
				echo "Failed to select ticket sites from database! (".$this->mysqli->errno."): ".$this->mysqli->error."<br />\n";
				return false;
			}
			
			while ($ticketRow = $ticketResult->fetch_assoc()) {	
				$ticketArray[] = array("type" => $ticketRow['type'],
								"name" => $ticketRow['name'],
								"url" => $ticketRow['url']);
			}
			$ticketResult->free();
			
			// Create travel array
			$travelArray = array();
			
			// Get travel sites from database
			$travelQuery = "SELECT * FROM `online_travel` WHERE `party_id` = ".(int)$partyRow['id']." ORDER BY `id` ASC";
			$travelResult = $this->mysqli->query($travelQuery);
			if(!$travelResult) {
				echo "Failed to select travel sites from database! (".$this->mysqli->errno."): ".$this->mysqli->error."<br />\n";
				return false;
			}
			
			while ($travelRow = $travelResult->fetch_assoc()) {	
				$travelArray[] = array("type" => $travelRow['type'],
								"name" => $travelRow['name'],
								"url" => $travelRow['url']);
			}
			$travelResult->free();
			
			// Create video array
			$videoArray = array();
			
			// Get video from database
			$videoQuery = "SELECT * FROM `videos` WHERE `party_id` = ".(int)$partyRow['id']." ORDER BY `id` ASC";
			$videoResult = $this->mysqli->query($videoQuery);
			if(!$videoResult) {
				echo "Failed to select videos from database! (".$this->mysqli->errno."): ".$this->mysqli->error."<br />\n";
				return false;
			}

			while ($videoRow = $videoResult->fetch_assoc()) {	
				$videoArray[] = array("youtube_id" => $videoRow['youtube_id'],
								"title" => $videoRow['title'],
								"duration" => $videoRow['duration'],
								"uploader" => $videoRow['uploader'],
								"uploaded" => $videoRow['uploaded']);
			}
			$videoResult->free();

			$partyArray[] = array("id" => (int)$partyRow['id'],
				"name" => $partyRow['name'],
				"subname" => $partyRow['subname'],
				"popularity" => (int)$partyRow['popularity'],
				"date" => $partyRow['date'],
				"time" => $partyRow['time'],
				"min_age" => (int)$partyRow['minimum_age'],
				"price" => $partyRow['price'],
				"venue" => $partyRow['venue'],
				"address" => $partyRow['address'],
				"postcode" => $partyRow['postcode'],
				"city" => $partyRow['city'],
				"latitude" => $partyRow['latitude'],
				"longitude" => $partyRow['longitude'],
				"online" => $onlineArray,
				"tickets" => $ticketArray,
				"travel" => $travelArray,
				"genres" => $partyRow['genres'],
				"line_up" => $partyRow['line_up'],
				"videos" => $videoArray);
			
		}
		$partyResult->free();

		$totalResult = array("status" => "OK", "list" => $partyArray);
		
		// Note: json_encode() only takes UTF-8 encoded data
		array_walk_recursive($totalResult, 'ContentManager::utf8_encode_items');
		$jsonData =  json_encode($totalResult);

		return $jsonData;
	}
	
	// Util: UTF-8 encode array
	public static function utf8_encode_items(&$item, $key)
	{
		$item = utf8_encode($item);
	}
		
	// Util: Write text to a file
	private function jsonResultToFile($filePath) {
		// Open and write to file
		if($fileHandle = fopen($filePath, "w")) {
			// Write UTF-8 data 
			if(fwrite($fileHandle, pack("CCC",0xef,0xbb,0xbf)) && fwrite($fileHandle, $this->getJsonResult())) {
				return true;
			}
		}
		return false;
	}
}