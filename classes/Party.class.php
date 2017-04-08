<?php
class Party
{
	/* ********** Properties ********** */
	private $id;
	private $name;
	private $subname;
	private $popularity;
	private $date;
	private $time;
	private $minimum_age;
	private $price;
	// Location
	private $venue;
	private $address;
	private $postcode;
	private $city;
	private $latitude;
	private $longitude;
	// Music
	private $genres;
	private $line_up;

	
	/* ********** Methods ********** */
	// Constructor
	function __construct($id, $name, $subname, $popularity, $date, $time, $minimum_age, $price, $venue, $address, $postcode, $city, $latitude, $longitude, $genres, $line_up) {
		
		$this->id = $id;
		$this->name = $name;
		$this->subname = $subname;
		$this->popularity = $popularity;
		$this->date = $date;
		$this->time = $time;
		$this->minimum_age = $minimum_age;
		$this->price = $price;
		$this->venue = $venue;
		$this->address = $address;
		$this->postcode = $postcode;
		$this->city = $city;
		$this->latitude = $latitude;
		$this->longitude = $longitude;
		$this->genres = $genres;
		$this->line_up = $line_up;
	}
	
	// Destructor
	function __destruct() {}
	
	// Getter
	public function __get($key) {
		return $this->$key;
	}
	
	// Setter
	public function __set($key, $val) {
		$this->$key = $val;
	}
}
?>