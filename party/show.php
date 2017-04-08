<?php
	function __autoload($class_name) {
		include "../classes/".$class_name.".class.php";
	}
	
	// Get party ID
	if(isset($_GET['id']) && !empty($_GET['id'])) {
		$party_id = $_GET['id'];
	} else {
		echo "Specify an ID"."<br />\n";
	}
?>

<html>
<head>
	<title>Show party - Partyagenda</title>
	
	<link rel="shortcut icon" type="image/x-icon" href="../favicon.ico" />
	<link rel="stylesheet" type="text/css" href="../style.css" />
	
</head>
<body>

<h1>Show party</h1>
<form method="GET" action="../index.php">
	<input type="submit" value="<<< back" />
</form>
<?php
	if(isset($party_id))
	{
?>
<form method="GET" action="edit.php" />
	<input type="hidden" name="id" value="<?php echo $party_id; ?>" />
	<input type="submit" value="Edit" />
</form>
<?php
	}
?>
<hr />
<?php
	if(!isset($party_id)) {
		echo "Specify an ID"."<br />\n";
	}
?>
<hr />
<br />

<?php
	if($_SERVER['REQUEST_METHOD'] == GET && isset($party_id)) {	
		// Create party manager
		$partyManager = new PartyManager();
		
		// Create website manager
		$websiteManager = new WebsiteManager($party_id);
		
		// Create video manager
		$videoManager = new VideoManager($party_id);
	
		// Get the party
		$party = $partyManager->getParty($party_id);
	?>
<form>
<fieldset>
    <legend><b>Icon</b></legend>
	<img src="<?php echo "../../icons/".$party_id.".jpg"; ?>" alt="icon" width="90" height="90" />
</fieldset>
<fieldset>
    <legend><b>General</b></legend>
	<table>
	<tr>
		<td>Name:</td>
		<td><?php echo $party->name; ?></td>
	</tr>
	<tr>
		<td>Subname</td>
		<td><?php echo $party->subname; ?></td>
	</tr>
	<tr>
		<td>Popularity:</td>
		<td><?php echo $party->popularity; ?></td>
	</tr>
	<tr>
		<td>Minimum age:</td>
		<td><?php echo $party->minimum_age; ?>
		</td>
	</tr>
	<tr>
		<td>Price:</td>
		<td><?php echo str_replace(";", "<br />\n", $party->price); ?></td>
	</tr>
	</table>
</fieldset>
<fieldset>
    <legend><b>Date & Time</b></legend>
	<table>
	<tr>
		<td>Date:</td>
		<td><?php echo $party->date; ?></td>
	</tr>
	<tr>
		<td>Time:</td>
		<td><?php echo $party->time; ?></td>
	</tr>
	</table>
</fieldset>
<fieldset>
    <legend><b>Location</b></legend>
	<table>
	<tr>
		<td width="100">Venue:</td>
		<td><?php echo $party->venue; ?></td>
	</tr>
	<tr>
		<td>Address:</td>
		<td><?php echo $party->address; ?></td>
	</tr>
	<tr>
		<td>Postcode:</td>
		<td><?php echo $party->postcode; ?></td>
	</tr>
	<tr>
		<td>City:</td>
		<td><?php echo $party->city; ?></td>
	</tr>
	<tr>
		<td>Lat, long:</td>
		<td><?php echo $party->latitude.", ".$party->longitude; ?></td>
	</tr>
	</table>
</fieldset>
<fieldset>
    <legend><b>Music</b></legend>
	<table>
	<tr>
		<td width="100">Genres:</td>
		<td><?php echo str_replace(";", "<br />\n", $party->genres); ?></td>
	</tr>
	<tr>
		<td>Line-up:</td>
		<td><?php echo str_replace(";", "<br />\n", $party->line_up); ?></td>
	</tr>
	</table>
</fieldset>
<fieldset>
    <legend><b>Online</b></legend>
	<table>
	<?php
		// Get online content for this party
		$onlineSites = $websiteManager->getOnlineSites();
		
		foreach($onlineSites as $site) 
		{
	?>
	<tr>
		<td rowspan="2"><?php echo $site->id; ?></td>
		<td rowspan="2"><?php echo $site->type; ?></td>
		<td><?php echo $site->name; ?></td>
	</tr>
	<tr>
		<td><a href="<?php echo $site->url; ?>"><i><?php echo $site->url; ?></i></a></td>
	</tr>
	<?php
		}
	?>
	</table>
</fieldset>
<fieldset>
    <legend><b>Online tickets</b></legend>
	<table>
	<?php
		// Get online content for this party
		$ticketSites = $websiteManager->getTicketSites();
		
		foreach($ticketSites as $site) 
		{
	?>
	<tr>
		<td rowspan="2"><?php echo $site->id; ?></td>
		<td rowspan="2"><?php echo $site->type; ?></td>
		<td><?php echo $site->name; ?></td>
	</tr>
	<tr>
		<td><a href="<?php echo $site->url; ?>"><i><?php echo $site->url; ?></i></a></td>
	</tr>
	<?php
		}
	?>
	</table>
</fieldset>
<fieldset>
    <legend><b>Online travel</b></legend>
	<table>
	<?php
		// Get online content for this party
		$travelSites = $websiteManager->getTravelSites();
		
		foreach($travelSites as $site) 
		{
	?>
	<tr>
		<td rowspan="2"><?php echo $site->id; ?></td>
		<td rowspan="2"><?php echo $site->type; ?></td>
		<td><?php echo $site->name; ?></td>
	</tr>
	<tr>
		<td><a href="<?php echo $site->url; ?>"><i><?php echo $site->url; ?></i></a></td>
	</tr>
	<?php
		}
	?>
	</table>
</fieldset>

<fieldset>
    <legend><b>Flyer</b></legend>
	<a href="../../flyers/<?php echo $party->id; ?>.jpg">
		<img src="../../flyers/thumbs/<?php echo $party->id; ?>.jpg" alt="Flyer thumbnail" height="300" style="border:1px solid #000;" />
	</a>
</fieldset>
<fieldset>
    <legend><b>Video's</b></legend>
	<table>
	<?php
		// Get online content for this party
		$videos = $videoManager->getVideos();
		
		foreach($videos as $video) 
		{
	?>
	<tr> 
		<td rowspan="4"><?php echo $video->id; ?></td>
		<td style="vertical-align:top;" rowspan="4"><img src="<?php echo "http://i.ytimg.com/vi/".$video->youtube_id."/default.jpg"; ?>" alt="icon" /></td>
		<td><b><?php echo $video->title; ?></b></td>
	</tr>
	<tr>
		<td><?php 
				// Calulate hours, minutes & seconds
				$seconds_left = $video->duration;
				$hours = floor($seconds_left / 3600);			// 60 * 60 = 3600
				$seconds_left =  $seconds_left % 3600;
				$minutes = floor($seconds_left / 60);
				$seconds_left = $seconds_left % 60;
				$seconds = $seconds_left;
				if($hours > 0)
					printf("%02d:%02d:%02d", $hours, $minutes, $seconds); 
				else
					printf("%02d:%02d", $minutes, $seconds);
			?></td>
	</tr>
	<tr>
		<td>door <?php echo $video->uploader; ?></td>
	</tr>
	<tr>
		<td>ge-upload <?php echo $video->uploaded; ?></td>
	</tr>
	<?php
		}
	?>
	</table>
</fieldset>
</form>	

	<?php
	}
	?>

</body>
</html>