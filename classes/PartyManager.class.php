<?php
class PartyManager
{
	// Database constants
	const host = "localhost";
	const user = "";
	const pass = "";
	const database = "";
	
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
	
	// Get all party's
	public function getPartys() {
		$partys = array();
	
		// Execute query
		$result = $this->mysqli->query("SELECT * FROM `partys` ORDER BY `date` ASC");
		// For each row
		while($row = $result->fetch_assoc()) {
			// Add party to array
			$partys[] = new Party(stripslashes($row["id"]), stripslashes($row["name"]), stripslashes($row["subname"]), 
								stripslashes($row["popularity"]), stripslashes($row["date"]), stripslashes($row["time"]), 
								stripslashes($row["minimum_age"]), stripslashes($row["price"]), stripslashes($row["venue"]), 
								stripslashes($row["address"]), stripslashes($row["postcode"]), stripslashes($row["city"]), 
								stripslashes($row["latitude"]), stripslashes($row["longitude"]), stripslashes($row["genres"]), 
								stripslashes($row["line_up"]));		
		}
		
		// Free result set
		$result->close();

		return $partys;
	}
	
	// Get a party
	public function getParty($partyId) {
		// Execute query
		$result = $this->mysqli->query("SELECT * FROM `partys` WHERE `id` = ".$partyId);
		
		if($result->num_rows > 0) {
			// Get row
			$row = $result->fetch_assoc();
			if($row) {		
				// Create party
				$party = new Party(stripslashes($row["id"]), stripslashes($row["name"]), stripslashes($row["subname"]), 
								stripslashes($row["popularity"]), stripslashes($row["date"]), stripslashes($row["time"]), 
								stripslashes($row["minimum_age"]), stripslashes($row["price"]), stripslashes($row["venue"]), 
								stripslashes($row["address"]), stripslashes($row["postcode"]), stripslashes($row["city"]), 
								stripslashes($row["latitude"]), stripslashes($row["longitude"]), stripslashes($row["genres"]), 
								stripslashes($row["line_up"]));		
				
				// free result set
				$result->close();
				
				return $party;
			}
		}
		return null;
	}
	
	// Insert a party
	public function insertParty(Party $party) {
		// Form query
		$query = "INSERT INTO `partys` ( ".
					"`id`, `name`, `subname`, `popularity`, `date`, `time`, `minimum_age`, `price`, ".
					"`venue`, `address`, `postcode`, `city`, `latitude`, `longitude`, `genres`, `line_up` ".
					") ".
					"VALUES ( ".
					"NULL, '".$this->mysqli->real_escape_string($party->name)."', '".$this->mysqli->real_escape_string($party->subname)."', ".
					"'".$this->mysqli->real_escape_string($party->popularity)."', '".$this->mysqli->real_escape_string($party->date)."', ".
					"'".$this->mysqli->real_escape_string($party->time)."', '".$this->mysqli->real_escape_string($party->minimum_age)."', ".
					"'".$this->mysqli->real_escape_string($party->price)."', '".$this->mysqli->real_escape_string($party->venue)."', ".
					"'".$this->mysqli->real_escape_string($party->address)."', '".$this->mysqli->real_escape_string($party->postcode)."', ".
					"'".$this->mysqli->real_escape_string($party->city)."', '".$this->mysqli->real_escape_string($party->latitude)."', ".
					"'".$this->mysqli->real_escape_string($party->longitude)."', '".$this->mysqli->real_escape_string($party->genres)."', ".
					"'".$this->mysqli->real_escape_string($party->line_up)."');";
	
		// Execute query
		$queryResult = $this->mysqli->query($query);
		if(!$queryResult) {
			echo "Inserting party failed (".$this->mysqli->errno."): ".$this->mysqli->error."<br />\n";
			return false;
		} else {
			return $this->mysqli->insert_id;
		}
	}
	
	// Update a party
	public function updateParty(Party $party) {
		// Form query
		$query = "UPDATE `partys` ".
				"SET `name` = '".$this->mysqli->real_escape_string($party->name)."', ".
				"`subname` = '".$this->mysqli->real_escape_string($party->subname)."', ".
				"`popularity` = ".$this->mysqli->real_escape_string($party->popularity).", ".
				"`date` = '".$this->mysqli->real_escape_string($party->date)."', ".
				"`time` = '".$this->mysqli->real_escape_string($party->time)."', ".
				"`minimum_age` = ".$this->mysqli->real_escape_string($party->minimum_age).", ".
				"`price` = '".$this->mysqli->real_escape_string($party->price)."', ".
				"`venue` = '".$this->mysqli->real_escape_string($party->venue)."', ".
				"`address` = '".$this->mysqli->real_escape_string($party->address)."', ".
				"`postcode` = '".$this->mysqli->real_escape_string($party->postcode)."', ".
				"`city` = '".$this->mysqli->real_escape_string($party->city)."', ".
				"`latitude` = '".$this->mysqli->real_escape_string($party->latitude)."', ".
				"`longitude` = '".$this->mysqli->real_escape_string($party->longitude)."', ".
				"`genres` = '".$this->mysqli->real_escape_string($party->genres)."', ". 
				"`line_up` = '".$this->mysqli->real_escape_string($party->line_up)."' ".
				"WHERE `id` = ".$this->mysqli->real_escape_string($party->id).";";
				
		// Execute query
		$queryResult = $this->mysqli->query($query);
		if(!$queryResult) {
			echo "Updating party failed (".$this->mysqli->errno."): ".$this->mysqli->error."<br />\n";
			return false;
		} else {
			return true;
		}
	}
	
	public function deleteParty($party_id) {
		// Execute query
		$queryResult = $this->mysqli->query("DELETE FROM `partys` WHERE `id` = ".$this->mysqli->real_escape_string($party_id));
		if(!$queryResult) {
			echo "Deleting party failed (".$this->mysqli->errno."): ".$this->mysqli->error."<br />\n";
			return false;
		} else {
			return true;
		}
	}
}
?>