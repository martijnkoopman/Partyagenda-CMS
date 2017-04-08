<?php
class Sound
{
	/* ********** Properties ********** */
	private $id;
	private $soundcloud_id;
	private $title;
	private $duration;
	private $uploader;
	private $uploaded;
	private $icon_url;
	
	/* ********** Methods ********** */
	// Constructor
	function __construct($id, $soundcloud_id, $title, $duration, $uploader, $uploaded, $icon_url) {		
		$this->id = $id;
		$this->soundcloud_id = $soundcloud_id;
		$this->title = $title;
		$this->duration = $duration;
		$this->uploader = $uploader;
		$this->uploaded = $uploaded;
		$this->icon_url = $icon_url;
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