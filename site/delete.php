<?php
	function __autoload($class_name) {
		include "../classes/".$class_name.".class.php";
	}
	
	$websiteManager = new WebsiteManager(0);
?>
<html>
<head>
	<title>Delete site - Partyagenda</title>
	
	<link rel="shortcut icon" type="image/x-icon" href="../favicon.ico" />
	<link rel="stylesheet" type="text/css" href="../style.css" />
		
</head>
<body>

<h1>Delete site</h1>
<form method="GET" action="../party/edit.php">
<input type="hidden" name="id" value="<?php echo $_GET['party_id']; ?>" />
<input type="submit" value="<<< back" />
</form>
<hr />

<?php
	if(isset($_POST['submit'])) {
			$site_id = $_POST['site_id'];
			$site_type = $_POST['site_type'];
			
			// Delete site from database
			if($site_type == "online") {
				$deleteResult = $websiteManager->deleteOnlineSite($site_id);
			} else if($site_type == "ticket") {
				$deleteResult = $websiteManager->deleteTicketSite($site_id);
			} else if($site_type == "travel") {
				$deleteResult = $websiteManager->deleteTravelSite($site_id);
			} else {
				$deleteResult = false;
				echo "Unknown type: '".$site_type."'"."<br />\n";
				echo "Supported types: 'online', 'ticket' and 'travel'"."<br />\n";
			}
			if($deleteResult) {
				echo "<b>Site removed.</b> (".$site_id.")"."<br />\n";
			}
			
	} else {
		// Going to delete a site
		if(isset($_GET['party_id']) && !empty($_GET['party_id'])) {
			$party_id = $_GET['party_id'];
		} else {
			echo "Specify a party ID"."<br />\n";
		}
		
		if(isset($_GET['site_id']) && !empty($_GET['site_id'])) {
			$site_id = $_GET['site_id'];
		} else {
			echo "Specify a site ID"."<br />\n";
		}
		
		if(isset($_GET['type']) && !empty($_GET['type'])) {
			$site_type = $_GET['type'];
		} else {
			echo "Specify a site type"."<br />\n";
		}
	}
?>
<hr />
<br />

<?php
	if($_SERVER['REQUEST_METHOD'] == GET && isset($party_id) && isset($site_id) && isset($site_type)) {
	?>
<form method="POST" action="delete.php?party_id=<?php echo $party_id; ?>">
	Are you sure you want to delete the site reference with id = <?php echo $site_id; ?><br />
	<input type="hidden" name="site_id" value="<?php echo $site_id; ?>" />
	<input type="hidden" name="site_type" value="<?php echo $site_type; ?>" />
	<input type="submit" name="submit" value="YES, delete" />
</form>
	<?php
	}
	?>

</body>
</html>