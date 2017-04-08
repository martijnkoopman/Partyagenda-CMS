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
	
	// Create party manager
	$partyManager = new PartyManager();
?>

<html>
<head>
	<title>Edit party - Partyagenda</title>
	
	<link rel="shortcut icon" type="image/x-icon" href="../favicon.ico" />
	<link rel="stylesheet" type="text/css" href="../style.css" />
	
	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
	<script type="text/javascript" src="geocode.js"></script>
	
</head>
<body>

<h1>Edit party</h1>
<form method="GET" action="../index.php">
<input type="submit" value="<<< back" />
</form>
<?php
	if(isset($party_id))
	{
?>
<form method="GET" action="show.php" />
	<input type="hidden" name="id" value="<?php echo $party_id; ?>" />
	<input type="submit" value="Show" />
</form>
<form method="GET" action="clone.php" />
	<input type="hidden" name="id" value="<?php echo $party_id; ?>" />
	<input type="submit" value="Clone" />
</form>
<?php
	}
?>
<hr />
<?php
	// Get party_id from URL
	if(isset($party_id)) {
		
		// Edit party when 'Edit party' is pressed
		if(isset($_POST['submit'])) 
		{
			$hasErrors = false;

			$name = $_POST['name'];
			$subname = $_POST['subname'];
			$popularity = $_POST['popularity'];
			$minimum_age = $_POST['minimum_age'];
			$price = $_POST['price'];
			// Date & Time
			$date_day = $_POST['date_day'];
			$date_month = $_POST['date_month'];
			$date_year = $_POST['date_year'];
			$time = $_POST['time'];
			// Location
			$venue = $_POST['venue'];
			$address = $_POST['address'];
			$postcode = $_POST['postcode'];		
			$city = $_POST['city'];	
			$latitude = $_POST['latitude'];	
			$longitude = $_POST['longitude'];
			// Music
			$genres = $_POST['genres'];
			$line_up = $_POST['line_up'];
			
			// Check for invalid values
			if(empty($name)){
				$hasErrors = true;
				echo "Name not specified."."<br />\n";
			}
			if(empty($popularity)) {
				$hasErrors = true;
				echo "Popularity not specified."."<br />\n";
			}
			if(empty($date_day) || empty($date_month) || empty($date_year)) {
				$hasErrors = true;
				echo "Date not (properly) specified."."<br />\n";
			}
			if(empty($venue)) {
				$hasErrors = true;
				echo "Venue not specified."."<br />\n";
			}
			if(empty($city)) {
				$hasErrors = true;
				echo "City not specified."."<br />\n";
			}
			if(empty($latitude) || empty($longitude)) {
				$hasErrors = true;
				echo "Latitude or longitude not specified."."<br />\n";
			}
		
			if(!$hasErrors) {					
				// Create party
				$party = new Party($party_id, $name, $subname, $popularity, $date_year."-".$date_month."-".$date_day, $time, $minimum_age, $price, $venue, $address, $postcode, $city, $latitude, $longitude, $genres, $line_up);
				
				// Store party in database
				$storeResult = $partyManager->updateParty($party);
				if($storeResult) {
					echo "<b>Party updated.</b>"."<br />\n";
				}
				
				// Unset fields for next party
				unset($name);
				unset($subname);
				unset($popularity);
				unset($minimum_age);
				unset($price);
				// Date & Time
				unset($date_day);
				unset($date_month);
				unset($date_year);
				unset($time);
				// Location
				unset($venue);
				unset($address);
				unset($postcode);	
				unset($city);
				unset($latitude);
				unset($longitude);
				// Music
				unset($genres);
				unset($line_up);
			}
		} // End of isSet()
	} else {	
		echo "Specify an ID"."<br />\n";
	}
?>
<hr />
<br />

<?php
	//$_SERVER['REQUEST_METHOD'] == GET && 
	if(isset($party_id)) {
		// Create website manager
		$websiteManager = new WebsiteManager($party_id);
		
		// Create video manager
		$videoManager = new VideoManager($party_id);
	
		// Get the party
		$party = $partyManager->getParty($party_id);
	?>
<fieldset>
    <legend><b>Icon</b></legend>
	<table border="0">
	<tr>
		<td><img src="<?php echo "../../icons/".$party_id.".jpg"; ?>" alt="icon" width="90" height="90" /></td>
		<td>
			<form method="GET" action="upload_icon.php" />
			<input type="hidden" name="id" value="<?php echo $party->id; ?>" />
			<input type="submit" value="Change icon" />
			</form>
		</td>
	</tr>
	</table>
</fieldset>
<br />

<form method="POST" action="edit.php?id=<?php echo $party_id ?>">
<fieldset>
    <legend><b>General</b></legend>
	<table>
	<tr>
		<td>Name*:</td>
		<td><input type="text" name="name" value="<?php echo $party->name; ?>" /></td>
	</tr>
	<tr>
		<td>Subname</td>
		<td><input type="text" name="subname" value="<?php echo $party->subname; ?>" /></td>
	</tr>
	<tr>
		<td>Popularity*:</td>
		<td>
			<select name="popularity">
				<option<?php if($party->popularity == 1) echo " selected"; ?>>1</option>
				<option<?php if($party->popularity == 2) echo " selected"; ?>>2</option>
				<option<?php if($party->popularity == 3) echo " selected"; ?>>3</option>
				<option<?php if($party->popularity == 4) echo " selected"; ?>>4</option>
				<option<?php if($party->popularity == 5) echo " selected"; ?>>5</option>
			</select>
		</td>
	</tr>
	<tr>
		<td>Minimum age:</td>
		<td>
			<select name="minimum_age">
				<option<?php if($party->minimum_age == 16) echo " selected"; ?>>16</option>
				<option<?php if($party->minimum_age == 17) echo " selected"; ?>>17</option>
				<option<?php if($party->minimum_age == 18) echo " selected"; ?>>18</option>
				<option<?php if($party->minimum_age == 19) echo " selected"; ?>>19</option>
				<option<?php if($party->minimum_age == 20) echo " selected"; ?>>20</option>
				<option<?php if($party->minimum_age == 21) echo " selected"; ?>>21</option>
				<option<?php if($party->minimum_age == 22) echo " selected"; ?>>22</option>
				<option<?php if($party->minimum_age == 23) echo " selected"; ?>>23</option>
				<option<?php if($party->minimum_age == 24) echo " selected"; ?>>24</option>
				<option<?php if($party->minimum_age == 25) echo " selected"; ?>>25</option>
			</select>
		</td>
	</tr>
	<tr>
		<td>Price:</td>
		<td><input type="text" name="price" value="<?php echo $party->price; ?>" placeholder="20,- (ex fee);VIP: 35,- (ex fee)" /></td>
	</tr>
	</table>
</fieldset>
<fieldset>
    <legend><b>Date & Time</b></legend>
	<table>
	<tr>
		<td width="100">Date*: </td>
		<td>
			<select name="date_day">
				<?php 
					$date_info = date_parse($party->date);
					$date_day = $date_info['day']; 
					$date_month = $date_info['month']; 
					$date_year = $date_info['year']; 
				?>
				<option<?php if($date_day == 1) echo " selected"; ?>>1</option>
				<option<?php if($date_day == 2) echo " selected"; ?>>2</option>
				<option<?php if($date_day == 3) echo " selected"; ?>>3</option>
				<option<?php if($date_day == 4) echo " selected"; ?>>4</option>
				<option<?php if($date_day == 5) echo " selected"; ?>>5</option>
				<option<?php if($date_day == 6) echo " selected"; ?>>6</option>
				<option<?php if($date_day == 7) echo " selected"; ?>>7</option>
				<option<?php if($date_day == 8) echo " selected"; ?>>8</option>
				<option<?php if($date_day == 9) echo " selected"; ?>>9</option>
				<option<?php if($date_day == 10) echo " selected"; ?>>10</option>
				<option<?php if($date_day == 11) echo " selected"; ?>>11</option>
				<option<?php if($date_day == 12) echo " selected"; ?>>12</option>
				<option<?php if($date_day == 13) echo " selected"; ?>>13</option>
				<option<?php if($date_day == 14) echo " selected"; ?>>14</option>
				<option<?php if($date_day == 15) echo " selected"; ?>>15</option>
				<option<?php if($date_day == 16) echo " selected"; ?>>16</option>
				<option<?php if($date_day == 17) echo " selected"; ?>>17</option>
				<option<?php if($date_day == 18) echo " selected"; ?>>18</option>
				<option<?php if($date_day == 19) echo " selected"; ?>>19</option>
				<option<?php if($date_day == 20) echo " selected"; ?>>20</option>
				<option<?php if($date_day == 21) echo " selected"; ?>>21</option>
				<option<?php if($date_day == 22) echo " selected"; ?>>22</option>
				<option<?php if($date_day == 23) echo " selected"; ?>>23</option>
				<option<?php if($date_day == 24) echo " selected"; ?>>24</option>
				<option<?php if($date_day == 25) echo " selected"; ?>>25</option>
				<option<?php if($date_day == 26) echo " selected"; ?>>26</option>
				<option<?php if($date_day == 27) echo " selected"; ?>>27</option>
				<option<?php if($date_day == 28) echo " selected"; ?>>28</option>
				<option<?php if($date_day == 29) echo " selected"; ?>>29</option>
				<option<?php if($date_day == 30) echo " selected"; ?>>30</option>
				<option<?php if($date_day == 31) echo " selected"; ?>>31</option>
			</select>
			<select name="date_month">
				<option value="1"<?php if($date_month == 1) echo " selected"; ?>>1 -- januari</option>
				<option value="2"<?php if($date_month == 2) echo " selected"; ?>>2 -- februari</option>
				<option value="3"<?php if($date_month == 3) echo " selected"; ?>>3 -- maart</option>
				<option value="4"<?php if($date_month == 4) echo " selected"; ?>>4 -- april</option>
				<option value="5"<?php if($date_month == 5) echo " selected"; ?>>5 -- mei</option>
				<option value="6"<?php if($date_month == 6) echo " selected"; ?>>6 -- juni</option>
				<option value="7"<?php if($date_month == 7) echo " selected"; ?>>7 -- juli</option>
				<option value="8"<?php if($date_month == 8) echo " selected"; ?>>8 -- augustus</option>
				<option value="9"<?php if($date_month == 9) echo " selected"; ?>>9 -- september</option>
				<option value="10"<?php if($date_month == 10) echo " selected"; ?>>10 -- oktober</option>
				<option value="11"<?php if($date_month == 11) echo " selected"; ?>>11 -- november</option>
				<option value="12"<?php if($date_month == 12) echo " selected"; ?>>12 -- december</option>
			</select>
			<select name="date_year">
				<option<?php if($date_year == 2016) echo " selected"; ?>>2016</option>
				<option<?php if($date_year == 2017) echo " selected"; ?>>2017</option>
			</select>
		</td>
	</tr>
	<tr>
		<td>Time: </td>
		<td><input type="text" name="time" value="<?php echo $party->time; ?>" placeholder="22:00 - 06:00" /></td>
	</tr>
	</table>
</fieldset>
<fieldset>
    <legend><b>Location</b></legend>
	<table>
	<tr>
		<td width="100">Venue*:</td>
		<td><input type="text" name="venue" value="<?php echo $party->venue; ?>" /></td>
	</tr>
	<tr>
		<td>Address:</td>
		<td><input type="text" name="address" value="<?php echo $party->address; ?>" /></td>
	</tr>
	<tr>
		<td>Postcode:</td>
		<td><input type="text" name="postcode" value="<?php echo $party->postcode; ?>" placeholder="1234 AB" /></td>
	</tr>
	<tr>
		<td>City*:</td>
		<td><input type="text" name="city" value="<?php echo $party->city; ?>" /></td>
	</tr>
	<tr>
		<td>Lat, lon*:</td>
		<td>
			<input type="text" name="latitude" value="<?php echo $party->latitude; ?>" placeholder="53.0000" style="width:150px;" />, 
			<input type="text" name="longitude" value="<?php echo $party->longitude; ?>"  placeholder="5.0000" style="width:150px;" />
			<span style="background-color: black; color: white" onclick="fill()">Fill</span>
		</td>
	</tr>
	</table>
</fieldset>
<fieldset>
    <legend><b>Music</b></legend>
	<table>
	<tr>
		<td width="100">Genres:</td>
		<td><input type="text" name="genres" value="<?php echo $party->genres; ?>" placeholder="early hardcore;hardcore;hardstyle" /></td>
	</tr>
	<tr>
		<td>Line-up:</td>
		<td><textarea cols="80" rows="4" name="line_up"><?php echo $party->line_up; ?></textarea></td>
	</tr>
	</table>
</fieldset>

<input type="submit" name="submit" value="Save changes" /><br />
<br />
</form>

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
		<td rowspan="2">
			<form method="GET" action="../site/edit.php" />
				<input type="hidden" name="party_id" value="<?php echo $party_id; ?>" />
				<input type="hidden" name="site_id" value="<?php echo $site->id; ?>" />
				<input type="hidden" name="type" value="online" />
				<input type="submit" value="Edit" />
			</form>
			<form method="GET" action="../site/delete.php" />
				<input type="hidden" name="party_id" value="<?php echo $party_id; ?>" />
				<input type="hidden" name="site_id" value="<?php echo $site->id; ?>" />
				<input type="hidden" name="type" value="online" />
				<input type="submit" value="Delete" />
			</form>
		</td>
	</tr>
	<tr>
		<td><a href="<?php echo $site->url; ?>"><i><?php echo $site->url; ?></i></a></td>
	</tr>
	<?php
		}
	?>
	</table>
	
	<form method="GET" action="../site/add.php" />
		<input type="hidden" name="party_id" value="<?php echo $party_id; ?>" />
		<input type="hidden" name="type" value="online" />
		<input type="submit" value="Add site" />
	</form>
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
		<td rowspan="2">
			<form method="GET" action="../site/edit.php" />
				<input type="hidden" name="party_id" value="<?php echo $party_id; ?>" />
				<input type="hidden" name="site_id" value="<?php echo $site->id; ?>" />
				<input type="hidden" name="type" value="ticket" />
				<input type="submit" value="Edit" />
			</form>
			<form method="GET" action="../site/delete.php" />
				<input type="hidden" name="party_id" value="<?php echo $party_id; ?>" />
				<input type="hidden" name="site_id" value="<?php echo $site->id; ?>" />
				<input type="hidden" name="type" value="ticket" />
				<input type="submit" value="Delete" />
			</form>
		</td>
	</tr>
	<tr>
		<td><a href="<?php echo $site->url; ?>"><i><?php echo $site->url; ?></i></a></td>
	</tr>
	<?php
		}
	?>
	</table>
	
	<form method="GET" action="../site/add.php" />
		<input type="hidden" name="party_id" value="<?php echo $party_id; ?>" />
		<input type="hidden" name="type" value="ticket" />
		<input type="submit" value="Add site" />
	</form>
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
		<td rowspan="2">
			<form method="GET" action="../site/edit.php" />
				<input type="hidden" name="party_id" value="<?php echo $party_id; ?>" />
				<input type="hidden" name="site_id" value="<?php echo $site->id; ?>" />
				<input type="hidden" name="type" value="travel" />
				<input type="submit" value="Edit" />
			</form>
			<form method="GET" action="../site/delete.php" />
				<input type="hidden" name="party_id" value="<?php echo $party_id; ?>" />
				<input type="hidden" name="site_id" value="<?php echo $site->id; ?>" />
				<input type="hidden" name="type" value="travel" />
				<input type="submit" value="Delete" />
			</form>
		</td>
	</tr>
	<tr>
		<td><a href="<?php echo $site->url; ?>"><i><?php echo $site->url; ?></i></a></td>
	</tr>
	<?php
		}
	?>
	</table>
	
	<form method="GET" action="../site/add.php" />
		<input type="hidden" name="party_id" value="<?php echo $party_id; ?>" />
		<input type="hidden" name="type" value="travel" />
		<input type="submit" value="Add site" />
	</form>
</fieldset>

<fieldset>
    <legend><b>Flyer</b></legend>
	<table border="0">
	<tr>
		<td style="vertical-align:top;">
			<a href="../../flyers/<?php echo $party->id; ?>.jpg">
				<img src="../../flyers/thumbs/<?php echo $party->id; ?>.jpg" alt="Flyer thumbnail" height="300" style="border:1px solid #000;" />
			</a>
		</td>
		<td>
			<form method="GET" action="upload_flyer.php" />
			<input type="hidden" name="id" value="<?php echo $party->id; ?>" />
			<input type="submit" value="Upload flyer" />
			</form><br />
			<form method="GET" action="upload_flyer_thumb.php" />
			<input type="hidden" name="id" value="<?php echo $party->id; ?>" />
			<input type="submit" value="Upload flyer thumbnail" />
			</form><br />
			<form method="GET" action="crop_flyer.php" />
			<input type="hidden" name="id" value="<?php echo $party->id; ?>" />
			<input type="submit" value="Generate flyer thumbnail and icon" />
			</form>
		</td>
	</tr>
	</table>
</fieldset>
<fieldset>
	<legend><b>Video's</b></legend>
	<!-- Video's -->
	<table>
	<?php
		// Get videos for this party
		$videos = $videoManager->getVideos();
		
		foreach($videos as $video) 
		{
	?>
	<tr> 
		<td rowspan="4"><?php echo $video->id; ?></td>
		<td style="vertical-align:top;" rowspan="4"><img src="<?php echo "http://i.ytimg.com/vi/".$video->youtube_id."/default.jpg"; ?>" alt="icon" /></td>
		<td><b><?php echo $video->title; ?></b></td>
		<td rowspan="4">
			<form method="GET" action="../video/edit.php" />
				<input type="hidden" name="party_id" value="<?php echo $party_id; ?>" />
				<input type="hidden" name="video_id" value="<?php echo $video->id; ?>" />
				<input type="submit" value="Edit" />
			</form>
			<form method="GET" action="../video/delete.php" />
				<input type="hidden" name="party_id" value="<?php echo $party_id; ?>" />
				<input type="hidden" name="video_id" value="<?php echo $video->id; ?>" />
				<input type="submit" value="Delete" />
			</form>
		</td>
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
			?>
		</td>
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
	
	<form method="GET" action="../video/add.php" />
		<input type="hidden" name="id" value="<?php echo $party->id; ?>" />
		<input type="submit" value="Add video" />
	</form>
</fieldset>
	<?php
	}
	?>
</body>
</html>