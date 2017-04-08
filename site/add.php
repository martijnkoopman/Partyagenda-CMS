<?php
	function __autoload($class_name) {
		include "../classes/".$class_name.".class.php";
	}
?>

<html>
<head>
	<title>Add site - Partyagenda</title>
	
	<link rel="shortcut icon" type="image/x-icon" href="../favicon.ico" />
	<link rel="stylesheet" type="text/css" href="../style.css" />
	
</head>
<body>

<h1>Add site</h1>
<form method="GET" action="../party/edit.php">
<input type="hidden" name="id" value="<?php echo $_GET['party_id']; ?>" />
<input type="submit" value="<<< back" />
</form>
<hr />
<?php
	if(!isset($_GET['party_id']) || empty($_GET['party_id'])) {
		echo "Specify a party ID"."<br />\n";
	} else if(!isset($_GET['type']) || empty($_GET['type'])) {
		echo "Specify a valid type ID"."<br />\n";
		echo "Supported types: 'online', 'ticket' and 'travel'"."<br />\n";
	} else {
		$party_id = $_GET['party_id'];
		$site_type = $_GET['type'];
		
		// 'Add site' (submit) has been pressed.
		if(isset($_POST['submit'])) {
			$hasErrors = false;
		
			$type = $_POST['type'];
			$name = $_POST['name'];
			$url = $_POST['url'];
			
			// Check for invalid values
			if(empty($name)){
				$hasErrors = true;
				echo "Name not specified."."<br />\n";
			}
			if(empty($url)) {
				$hasErrors = true;
				echo "Url not specified."."<br />\n";
			}
			
			if(!$hasErrors) {	
				// Create party manager
				$websiteManager = new WebsiteManager($party_id);
		
				$website = new Website(NULL, $type, $name, $url);
				
				// Store site in database
				if($site_type == "online") {
					$storeResult = $websiteManager->addOnlineSite($website);
				} else if($site_type == "ticket") {
					$storeResult = $websiteManager->addTicketSite($website);
				} else if($site_type == "travel") {
					$storeResult = $websiteManager->addTravelSite($website);
				} else {
					$storeResult = false;
					echo "Unknown type: '".$site_type."'"."<br />\n";
					echo "Supported types: 'online', 'ticket' and 'travel'"."<br />\n";
				}
				if($storeResult) {
					echo "<b>Website added to party.</b>"."<br />\n";
				}
				
				// Unset fields for next party
				unset($type);
				unset($name);
				unset($url);
			}
			
		} // End of isSet()
	}
?>
<hr />
<br />

<?php
	if($_SERVER['REQUEST_METHOD'] == GET && isset($party_id) && isset($site_type)) {
?>

<form method="POST" action="add.php?party_id=<?php echo $party_id; ?>&type=<?php echo $site_type; ?>">
<fieldset>
    <legend><b>General</b></legend>
	<table>
	<tr>
		<td>Type:</td>
		<td>
			<select name="type">
				<option></option>
				<option>website</option>
				<?php
					if($site_type == "online") {
						?>
				<option>facebook</option>
				<option>twitter</option>
				<option>hyves</option>
				<option>youtube</option>
						<?php
					} else if($site_type == "ticket") {
						?>
				<option>paylogic</option>
				<option>ticketscript</option>
				<option>vakantie-veilingen</option>
						<?php
					} else if($site_type == "travel") {
						?>
				<option>event-travel</option>
				<option>partybussen</option>
						<?php
					} 
				?>
			</select>
		</td>
	</tr>
	<tr>
		<td>Name*:</td>
		<td><input type="text" name="name" /></td>
	</tr>
	<tr>
		<td>Url*:</td>
		<td><input type="text" name="url" /></td>
	</tr>
	</table>
</fieldset>

<input type="submit" name="submit" value="Add site" />
</form>

<?php
	}
?>

</body>
</html>