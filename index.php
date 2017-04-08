<?php
	function __autoload($class_name) {
		include "classes/".$class_name.".class.php";
	}
	
	$partyManager = new PartyManager();
	$partys = $partyManager->getPartys();
?>
<html>
<head>
	<title>Party's - Partyagenda</title>
	
	<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
	<link rel="stylesheet" type="text/css" href="style.css" />

<style type="text/css">

</style>
	
</head>
<body>

<h1>Party's</h1>
<form method="GET" action="index.php"><input type="submit" value="Refresh" /></form>
<form method="GET" action="party/add.php"><input type="submit" value="Add party" /></form>
<form method="GET" action="export_json.php"><input type="submit" value="Export to app" /></form>

<hr />
<hr />
<br />

<?php
	foreach($partys as $party) {
		?>
<div style="width:100%; background-color:#FFF; border: solid 1px #000; color:#000;">
	<div style="overflow:hidden; background-color:#CCC;">
		<div style="float:left;">
			<p style="font-size:14px; font-weight:bold; display:inline;"><?php echo $party->date; ?></p><br />
		</div>
		<div style="float:right;">
			<p style="font-size:14px; font-weight:bold; display:inline;"><?php echo $party->id; ?></p><br />
		</div>
	</div>
	<div style="overflow:hidden;">
		<div style="float:left; width:80%;">
			<img src="../icons/<?php echo $party->id; ?>.jpg" alt="Icon" width="90" height="90" align="left" />
			<p style="font-size:18px; font-weight:bold; display:inline;"><?php echo $party->name; ?></p><br />
			<?php if(1) { ?> 
			<p style="font-size:18px; font-weight:bold; display:inline;"><?php echo $party->subname; ?></p><br />
			<?php } ?>
			<?php 
				for($i = 0; $i < $party->popularity; $i++) {
					echo "# ";
				}
			?><br />
			<?php echo $party->venue; ?>, <?php echo $party->city; ?><br />
		</div>
		<div style="float:right; height:90px; text-align:center;">
			<form method="GET" action="party/show.php" />
				<input type="hidden" name="id" value="<?php echo $party->id; ?>" />
				<input type="submit" value="Show" />
			</form><br />
			<form method="GET" action="party/edit.php" />
				<input type="hidden" name="id" value="<?php echo $party->id; ?>" />
				<input type="submit" value="Edit" />
			</form><br />
			<form method="GET" action="party/delete.php" />
				<input type="hidden" name="id" value="<?php echo $party->id; ?>" />
				<input type="submit" value="Delete" />
			</form><br />
		</div>
	</div>
</div>
<br />
		<?php
	}
?>

</body>
</html>