<?php
	function __autoload($class_name) {
		include "../classes/".$class_name.".class.php";
	}
	
	$partyManager = new PartyManager();
?>
<html>
<head>
	<title>Delete party - Partyagenda</title>
	
	<link rel="shortcut icon" type="image/x-icon" href="../favicon.ico" />
	<link rel="stylesheet" type="text/css" href="../style.css" />
		
</head>
<body>

<h1>Delete party</h1>
<form method="GET" action="../index.php">
<input type="submit" value="<<< back" />
</form>
<hr />

<?php
	if(isset($_POST['submit'])) {
			$party_id = $_POST['party_id'];
			
			// Create party manager
			$partyManager = new PartyManager();
			
			// Store party in database
			$deleteResult = $partyManager->deleteParty($party_id);
			if($deleteResult) {
				echo "<b>Party deleted.</b> (".$party_id.")"."<br />\n";
			}
	} else {
		// Going to delete a party
		if(isset($_GET['id']) && !empty($_GET['id'])) {
			$party_id = $_GET['id'];
		} else {
			echo "Specify an ID"."<br />\n";
		}
	}
?>
<hr />
<br />

<?php
	if($_SERVER['REQUEST_METHOD'] == GET && isset($party_id)) {
	?>
<form method="POST" action="delete.php">
	Are you sure you wish to delete the party with id = <?php echo $party_id; ?><br />
	<input type="hidden" name="party_id" value="<?php echo $party_id; ?>" />
	<input type="submit" name="submit" value="YES, delete" />
</form>
	<?php
	}
	?>

</body>
</html>