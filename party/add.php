<?php
	function __autoload($class_name) {
		include "../classes/".$class_name.".class.php";
	}
?>

<html>
<head>
	<title>Add party - Partyagenda</title>
	
	<link rel="shortcut icon" type="image/x-icon" href="../favicon.ico" />
	<link rel="stylesheet" type="text/css" href="../style.css" />
	
	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
	<script type="text/javascript" src="geocode.js"></script>
	
</head>
<body>

<h1>Add party</h1>
<form method="GET" action="../index.php">
<input type="submit" value="<<< back" />
</form>
<hr />
<?php
	$hasErrors = false;

	if(isset($_POST['submit'])) {
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
			// Create party manager
			$partyManager = new PartyManager();
			
			// Create party
			$party = new Party(NULL, $name, $subname, $popularity, $date_year."-".$date_month."-".$date_day, $time, $minimum_age, $price, $venue, $address, $postcode, $city, $latitude, $longitude, $genres, $line_up);
			
			// Store party in database
			$storeResult = $partyManager->insertParty($party);
			if($storeResult) {
				echo "<b>Party saved.</b>"."<br />\n";
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
?>
<hr />
<br />

<form method="POST" action="add.php">
<fieldset>
    <legend><b>General</b></legend>
	<table>
	<tr>
		<td width="100">Name*:</td>
		<td><input type="text" name="name" value="<?php echo $name; ?>" /></td>
	</tr>
	<tr>
		<td>Subname</td>
		<td><input type="text" name="subname" value="<?php echo $subname; ?>" /></td>
	</tr>
	<tr>
		<td>Popularity*:</td>
		<td>
			<select name="popularity">
				<option<?php if($popularity == 1) echo " selected"; ?>>1</option>
				<option<?php if($popularity == 2) echo " selected"; ?>>2</option>
				<option<?php if($popularity == 3) echo " selected"; ?>>3</option>
				<option<?php if($popularity == 4) echo " selected"; ?>>4</option>
				<option<?php if($popularity == 5) echo " selected"; ?>>5</option>
			</select>
		</td>
	</tr>
	<tr>
		<td>Minimum age:</td>
		<td>
			<select name="minimum_age">
				<option<?php if($minimum_age == 16) echo " selected"; ?>>16</option>
				<option<?php if($minimum_age == 17) echo " selected"; ?>>17</option>
				<option<?php if($minimum_age == 18) echo " selected"; ?>>18</option>
				<option<?php if($minimum_age == 19) echo " selected"; ?>>19</option>
				<option<?php if($minimum_age == 20) echo " selected"; ?>>20</option>
				<option<?php if($minimum_age == 21) echo " selected"; ?>>21</option>
				<option<?php if($minimum_age == 22) echo " selected"; ?>>22</option>
				<option<?php if($minimum_age == 23) echo " selected"; ?>>23</option>
				<option<?php if($minimum_age == 24) echo " selected"; ?>>24</option>
				<option<?php if($minimum_age == 25) echo " selected"; ?>>25</option>
			</select>
		</td>
	</tr>
	<tr>
		<td>Price:</td>
		<td><input type="text" name="price" value="<?php echo $price; ?>" placeholder="20,- (ex fee);VIP: 35,- (ex fee)" /></td>
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
		<td><input type="text" name="time" value="<?php echo $time; ?>" placeholder="22:00 - 06:00" /></td>
	</tr>
	</table>
</fieldset>
<fieldset>
    <legend><b>Location</b></legend>
	<table>
	<tr>
		<td width="100">Venue*:</td>
		<td><input type="text" name="venue" value="<?php echo $venue; ?>" /></td>
	</tr>
	<tr>
		<td>Address:</td>
		<td><input type="text" name="address" value="<?php echo $address; ?>" /></td>
	</tr>
	<tr>
		<td>Postcode:</td>
		<td><input type="text" name="postcode" value="<?php echo $postcode; ?>" placeholder="1234 AB" /></td>
	</tr>
	<tr>
		<td>City*:</td>
		<td><input type="text" name="city" value="<?php echo $city; ?>" /></td>
	</tr>
	<tr>
		<td>Lat, lon*:</td>
		<td>
			<input type="text" name="latitude" value="<?php echo $latitude; ?>" placeholder="53.0000" style="width:150px;" />, 
			<input type="text" name="longitude" value="<?php echo $longitude; ?>"  placeholder="5.0000" style="width:150px;" />
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
		<td><input type="text" name="genres" value="<?php echo $genres; ?>" placeholder="early hardcore;hardcore;hardstyle" /></td>
	</tr>
	<tr>
		<td>Line-up:</td>
		<td><textarea cols="80" rows="4" name="line_up"><?php echo $line_up; ?></textarea></td>
	</tr>
	</table>
</fieldset>

<input type="submit" name="submit" value="Add party" />
</form>

</body>
</html>