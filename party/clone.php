<?php
	function __autoload($class_name) {
		include "../classes/".$class_name.".class.php";
	}
	
	// Get party ID
	if(isset($_GET['id']) && !empty($_GET['id'])) {
		$party_id = $_GET['id'];
	}
	
	// Create party manager
	$partyManager = new PartyManager();
?>

<html>
<head>
	<title>Clone party - Partyagenda</title>
	
	<link rel="shortcut icon" type="image/x-icon" href="../favicon.ico" />
	<link rel="stylesheet" type="text/css" href="../style.css" />
	
</head>
<body>

<h1>Clone party</h1>
<form method="GET" action="../index.php">
<input type="submit" value="<<< back" />
</form>
<hr />
<?php
	// Get party_id from URL
	if(isset($party_id)) {
		
		// Get source data of party
		$websiteManager = new WebsiteManager($party_id);
		$videoManager = new VideoManager($party_id);
		$party = $partyManager->getParty($party_id);
		
		// Create copy of party 
		$party->id = NULL;
		$storeResult = $partyManager->insertParty($party);
		if($storeResult) {
			$party_id_clone = $storeResult;
			
			// Get destination party
			$websiteManagerClone = new WebsiteManager($party_id_clone);
			$videoManagerClone = new VideoManager($party_id_clone);			
			
			// Copy online sites
			$onlineSites = $websiteManager->getOnlineSites();
			foreach($onlineSites as $site) 
			{
				$site->id = 0;
				$storeResult = $websiteManagerClone->addOnlineSite($site);
			}
			
			// Copy ticket sites
			$ticketSites = $websiteManager->getTicketSites();
			foreach($ticketSites as $site) 
			{
				$site->id = 0;
				$storeResult = $websiteManagerClone->addTicketSite($site);
			}
			
			// Copy travel sites
			$travelSites = $websiteManager->getTravelSites();
			foreach($travelSites as $site) 
			{
				$site->id = 0;
				$storeResult = $websiteManagerClone->addTravelSite($site);
			}
			
			// Copy video references
			$videos = $videoManager->getVideos();
			foreach($videos as $video) 
			{
				$video->id = 0;
				$videoManagerClone->addVideo($video);
			}
		
			// Copy image - icon
			$sourceFile = "../../icons/".$party_id.".jpg";
			$destinationFile = "../../icons/".$party_id_clone.".jpg";
			if(!copy($sourceFile, $destinationFile))
				echo "Could not copy icon '".$sourceFile."' to '".$destinationFile."'.<br \>\n";
			
			// Copy images - flyer
			$sourceFile = "../../flyers/".$party_id.".jpg";
			$destinationFile = "../../flyers/".$party_id_clone.".jpg";
			if(!copy($sourceFile, $destinationFile))
				echo "Could not copy flyer '".$sourceFile."' to '".$destinationFile."'.<br \>\n";
			
			// Copy images - flyer
			$sourceFile = "../../flyers/thumbs/".$party_id.".jpg";
			$destinationFile = "../../flyers/thumbs/".$party_id_clone.".jpg";
			if(!copy($sourceFile, $destinationFile))
				echo "Could not copy flyer thumbnail '".$sourceFile."' to '".$destinationFile."'.<br \>\n";
				
			echo "<b>Party cloned.</b>"."<br />\n";
		?>
<form method="GET" action="show.php" />
	<input type="hidden" name="id" value="<?php echo $party_id_clone; ?>" />
	<input type="submit" value="Show" />
</form>
<form method="GET" action="edit.php" />
	<input type="hidden" name="id" value="<?php echo $party_id_clone; ?>" />
	<input type="submit" value="Edit" />
</form>
		<?php
		}		
	} else {	
		echo "Specify an ID"."<br />\n";
	}
?>
<hr />
<br />
	
</body>
</html>