<?php
	function __autoload($class_name) {
		include "../classes/".$class_name.".class.php";
	}
?>
<html>
<head>
	<title>Edit site - Partyagenda</title>
	
	<link rel="shortcut icon" type="image/x-icon" href="../favicon.ico" />
	<link rel="stylesheet" type="text/css" href="../style.css" />
		
</head>
<body>

<?php
	if(!isset($_GET['party_id']) || empty($_GET['party_id'])) {
		echo "Specify a party ID"."<br />\n";
		?>	
			<h1>Edit site</h1>
			<form method="GET" action="index.php">
			<input type="submit" value="<<< back" />
			</form>
			<hr />
		<?php
	} else if(!isset($_GET['site_id']) || empty($_GET['site_id'])) {
		echo "Specify a site ID"."<br />\n";
	} else if(!isset($_GET['type']) || empty($_GET['type'])) {
		echo "Specify a valid type ID"."<br />\n";
		echo "Supported types: 'online', 'ticket' and 'travel'"."<br />\n";
	} else {
		$party_id = $_GET['party_id'];
		$site_id = $_GET['site_id'];
		$site_type = $_GET['type'];
		
		?>
			<h1>Edit site</h1>
			<form method="GET" action="../party/edit.php">
			<input type="hidden" name="id" value="<?php echo $party_id; ?>" />
			<input type="submit" value="<<< back" />
			</form>
			<hr />
		<?php
		
		// Create party manager
		$websiteManager = new WebsiteManager($party_id);
		
		if($site_type == "online") {
			$site = $websiteManager->getOnlineSite($site_id);
		} else if($site_type == "ticket") {
			$site = $websiteManager->getTicketSite($site_id);
		} else if($site_type == "travel") {
			$site = $websiteManager->getTravelSite($site_id);
		}

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
				$website = new Website($site_id, $type, $name, $url);
		
				if($site_type == "online") {
					$updateResult = $websiteManager->updateOnlineSite($website);
				} else if($site_type == "ticket") {
					$updateResult = $websiteManager->updateTicketSite($website);
				} else if($site_type == "travel") {
					$updateResult = $websiteManager->updateOnlineSite($website);
				} else {
					$updateResult = false;
					echo "Unknown type: '".$site_type."'"."<br />\n";
					echo "Supported types: 'online', 'ticket' and 'travel'"."<br />\n";
				}
				
				if($updateResult) {
					echo "<b>Website updated.</b>"."<br />\n";
				}
			}
				
			// Unset fields for next party
			unset($type);
			unset($name);
			unset($url);			
		} 
	}
?>
<hr />
<br />

<?php
	if($_SERVER['REQUEST_METHOD'] == GET && isset($party_id) && isset($site_id) && isset($site_type)) {
	?>
<form method="POST" action="edit.php?party_id=<?php echo $party_id; ?>&site_id=<?php echo $site_id; ?>&type=<?php echo $site_type; ?>">
<fieldset>
    <legend><b>General</b></legend>
	<table>
	<tr>
		<td>Type:</td>
		<td>
			<select name="type">
				<option></option>
				<option <?php if($site->type == "website") echo "selected=\"selected\""; ?>>website</option>
				<?php
					if($site_type == "online") {
						?>
				<option <?php if($site->type == "facebook") echo "selected=\"selected\""; ?>>facebook</option>
				<option <?php if($site->type == "twitter") echo "selected=\"selected\""; ?>>twitter</option>
				<option <?php if($site->type == "hyves") echo "selected=\"selected\""; ?>>hyves</option>
				<option <?php if($site->type == "youtube") echo "selected=\"selected\""; ?>>youtube</option>
						<?php
					} else if($site_type == "ticket") {
						?>
				<option <?php if($site->type == "paylogic") echo "selected=\"selected\""; ?>>paylogic</option>
				<option <?php if($site->type == "ticketscript") echo "selected=\"selected\""; ?>>ticketscript</option>
				<option <?php if($site->type == "vakantie-veilingen") echo "selected=\"selected\""; ?>>vakantie-veilingen</option>
						<?php
					} else if($site_type == "travel") {
						?>
				<option <?php if($site->type == "event-travel") echo "selected=\"selected\""; ?>>event-travel</option>
				<option <?php if($site->type == "partybussen") echo "selected=\"selected\""; ?>>partybussen</option>
						<?php
					} 
				?>
			</select>
		</td>
	</tr>
	<tr>
		<td>Name*:</td>
		<td><input type="text" name="name" value="<?php echo $site->name; ?>" /></td>
	</tr>
	<tr>
		<td>Url*:</td>
		<td><input type="text" name="url" value="<?php echo $site->url; ?>" /></td>
	</tr>
	</table>
</fieldset>

<input type="submit" name="submit" value="Update site" />
</form>

	<?php
	}
	?>

</body>
</html>