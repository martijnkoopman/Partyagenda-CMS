<?php
class WebsiteManager
{
	// Database constants
	const host = "localhost";
	const user = "";
	const pass = "";
	const database = "";
	
	// Table names
	const online_table = "online";
	const tickets_table = "online_tickets";
	const travel_table = "online_travel";
	
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
	
	/**************************************/
	/* ********** Get websites ********** */
	/* ************************************/
	
	// Get online sites for a party
	public function getOnlineSites() {
		return $this->getSites(self::online_table);
	}
	
	// Get ticket sites for a party
	public function getTicketSites() {
		return $this->getSites(self::tickets_table);
	}
	
	// Get travel sites for a party
	public function getTravelSites() {
		return $this->getSites(self::travel_table);
	}

	// Get website entries from database
	private function getSites($table) {
		$sites = array();
		
		// Execute query
		$result = $this->mysqli->query("SELECT * FROM `".$table."` WHERE `party_id` = ".$this->party_id);
		
		// For each row
		while($row = $result->fetch_assoc()) {
			// Add party to array
			$sites[] = new Website($row["id"], $row["type"], $row["name"], $row["url"]);		
		}
		
		// Free result set
		$result->close();
		
		return $sites;
	}
	
	/*************************************/
	/* ********** Get website ********** */
	/* ***********************************/
	
	// Get an online site
	public function getOnlineSite($siteId) {
		return $this->getSite($siteId, self::online_table);
	}
	
	// Get a ticket site
	public function getTicketSite($siteId) {
		return $this->getSite($siteId, self::tickets_table);
	}
	
	// Get a travel site
	public function getTravelSite($siteId) {
		return $this->getSite($siteId, self::travel_table);
	}

	// Get website entries from database
	private function getSite($siteId, $table) {	
		// Execute query
		$result = $this->mysqli->query("SELECT * FROM `".$table."` WHERE `id` = ".$siteId);
		
		if($row = $result->fetch_assoc()) {
			$website = new Website($row["id"], $row["type"], $row["name"], $row["url"]);		
		}
		
		// Free result set
		$result->close();
		
		return $website;
	}
	
	/**************************************/
	/* ********** Add websites ********** */
	/* ************************************/
	
	// Add an online website reference
	public function addOnlineSite(Website $onlineSite) {
		return $this->addSite($onlineSite, self::online_table);
	}
	
	public function addTicketSite(Website $ticketSite) {
		return $this->addSite($ticketSite, self::tickets_table);
	}
	
	public function addTravelSite(Website $travelSite) {
		return $this->addSite($travelSite, self::travel_table);
	}
	
	private function addSite(Website $website, $table) {
		// Form query
		$query = "INSERT INTO `".$table."` (`id`, `party_id`, `type`, `name`, `url`) ".
				"VALUES (NULL, '".$this->party_id."', '".$website->type."', '".$website->name."', '".$website->url."');";
		// Execute query
		$queryResult = $this->mysqli->query($query);
		if(!$queryResult) {
			echo "Inserting site failed (".$this->mysqli->errno."): ".$this->mysqli->error."<br />\n";
			return false;
		} else {
			return $this->mysqli->insert_id;
		}
	}
	
	/*****************************************/
	/* ********** Update websites ********** */
	/* ***************************************/

	// Update an online website reference
	public function updateOnlineSite(Website $onlineSite) {
		return $this->updateSite($onlineSite, self::online_table);
	}
	
	public function updateTicketSite(Website $ticketSite) {
		return $this->updateSite($ticketSite, self::tickets_table);
	}

	public function updateTravelSite(Website $travelSite) {
		return $this->updateSite($travelSite, self::travel_table);
	}
	
	public function updateSite(Website $website, $table) {
		// Form query
		$query = "UPDATE `".$table."` ".
				"SET `type` = '".$website->type."', ".
				"`name` = '".$website->name."', ". 
				"`url` = '".$website->url."' ".
				"WHERE `id` = ".$website->id.";";
				
		// Execute query
		$queryResult = $this->mysqli->query($query);
		if(!$queryResult) {
			echo "Updating site failed (".$this->mysqli->errno."): ".$this->mysqli->error."<br />\n";
			return false;
		} else {
			return true;
		}
	}
	
	/*****************************************/
	/* ********** Delete websites ********** */
	/* ***************************************/
	
	public function deleteOnlineSite($site_id) {
		return $this->deleteSite($site_id, self::online_table);
	}

	public function deleteTicketSite($site_id) {
		return $this->deleteSite($site_id, self::tickets_table);
	}
	
	public function deleteTravelSite($site_id) {
		return $this->deleteSite($site_id, self::travel_table);
	}
	
	private function deleteSite($site_id, $table) {
		// Execute query
		$queryResult = $this->mysqli->query("DELETE FROM `".$table."` WHERE `id` = ".$site_id);
		if(!$queryResult) {
			echo "Deleting site failed (".$this->mysqli->errno."): ".$this->mysqli->error."<br />\n";
			return false;
		} else {
			return true;
		}
	}
}
?>