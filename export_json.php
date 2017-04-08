<?php
	function __autoload($class_name) {
		include "classes/".$class_name.".class.php";
	}
	
	// Create content manager
	$contentManager = new ContentManager();
?>

<html>
<head>
	<title>Export to app - Partyagenda</title>
	
	<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
	<link rel="stylesheet" type="text/css" href="style.css" />
	
</head>
<body>

<h1>Export to app</h1>
<form method="GET" action="index.php">
<input type="submit" value="<<< back" />
</form>
<hr />
<?php
	// Map database to file as JSON
	if($success = $contentManager->export2json()) {
		echo "<b>Succes! Database mapped to file as JSON</b>"."<br />\n";
	} else {
		echo "<b>Error!</b>"."<br />\n";
	}
?>

<hr />
<br />

<?php
	if($success) {
		echo $contentManager->getJsonResult()."<br />\n";
	}
?>

</body>
</html>