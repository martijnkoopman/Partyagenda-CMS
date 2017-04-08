<?php
class Website
{
	/* ********** Properties ********** */
	private $id;
	private $type;
	private $name;
	private $url;
	
	/* ********** Methods ********** */
	// Constructor
	function __construct($id, $type, $name, $url) {		
		$this->id = $id;
		$this->type = $type;
		$this->name = $name;
		$this->url = $url;
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