<?php
class Video
{
	/* ********** Properties ********** */
	private $id;
	private $youtube_id;
	private $title;
	private $duration;
	private $uploader;
	private $uploaded;
	
	/* ********** Methods ********** */
	// Constructor
	function __construct($id, $youtube_id, $title, $duration, $uploader, $uploaded) {		
		$this->id = $id;
		$this->youtube_id = $youtube_id;
		$this->title = $title;
		$this->duration = $duration;
		$this->uploader = $uploader;
		$this->uploaded = $uploaded;
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