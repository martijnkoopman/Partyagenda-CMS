<?php
	function __autoload($class_name) {
		include "../classes/".$class_name.".class.php";
	}
?>

<html>
<head>
	<title>Construct flyer thumbnail and icon - Partyagenda</title>
	
	<link rel="shortcut icon" type="image/x-icon" href="../favicon.ico" />
	<link rel="stylesheet" type="text/css" href="../style.css" />
	
<script type="text/javascript">
<!--

// Global variables
var id = getUrlVars()["id"];
var image = new Image();
var position = {x: 100, y: 100};
var radius = 45;
var ratio = 1;
var isMouseDown = false;

function getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
        vars[key] = value;
    });
    return vars;
}

function init() {
	// When the image has loaded, draw it to the canvas
    image.onload = function()
    {
		// Compute ratio
		ratio = 600 / image.height;
	
		// Find canvas
		var canvas = document.getElementById("flyer");
		canvas.width  = image.width;
		canvas.height = image.height;
		
		// Set canvas mouseDown listener
		canvas.addEventListener('mousedown', function(evt) {
			isMouseDown = true;
		
			// Get click position
			var rect = canvas.getBoundingClientRect();
			position = { x: Math.round(evt.clientX - rect.left), y: Math.round(evt.clientY - rect.top) };
	
			//position = getMousePos(canvas, evt);
			redraw();
		}, false);
		
		// Set canvas mouseUp listener
		canvas.addEventListener('mouseup', function(evt) {
			isMouseDown = false;
		}, false);
		
		// Set canvas mouseMove listener
		canvas.addEventListener('mousemove', function(evt) {
			if(isMouseDown) {
			// Get click position
			var rect = canvas.getBoundingClientRect();
			position = { x: Math.round(evt.clientX - rect.left), y: Math.round(evt.clientY - rect.top) };
	
			//position = getMousePos(canvas, evt);
			redraw();
			}
		}, false);
		
		redraw();
    }
 
    // Now set the source of the image that we want to load
    image.src = 'http://content.partyagenda-app.nl/v1/flyers/'+id+'.jpg';
	
	// Find range
	var range = document.getElementById("radius");
	
	// Set initial value
	range.value = radius;
	
	// Set range onClick listener
	range.addEventListener("input", function() { 
		radius = range.value;
		redraw();
	}, false);
}

function redraw() {
	var canvas = document.getElementById("flyer");
	canvas.width  = image.width;
	canvas.height = image.height;

	// 1. Clear canvas
	var context = canvas.getContext("2d");
	context.clearRect(0, 0, canvas.width, canvas.height);
	
	// 2. Draw image
	context.drawImage(image, 0, 0, canvas.width, canvas.height);
		
	// 3. Draw square
	context.beginPath();
	context.rect(position.x-radius, position.y-radius, 2*radius, 2*radius);
	context.fillStyle = 'rgba(255, 255, 255, 0.5)';
    context.fill();
	context.lineWidth = 1;
	context.strokeStyle = 'white';
	context.stroke();
	
	// 4. Draw cross
	context.beginPath();
	context.arc(position.x, position.y, 1, 0, 2 * Math.PI, false);
	context.fillStyle = 'black';
	context.fill();
	context.lineWidth = 2;
	context.strokeStyle = 'black';
	context.stroke();
	
	// 5. Print info
	var range_output = document.getElementById("radius_output");
	range_output.innerHTML = radius;
	document.getElementById("x_output").innerHTML = position.x
	document.getElementById("y_output").innerHTML = position.y;
	document.getElementById('x').value = position.x; 
	document.getElementById('y').value = position.y; 
}

//-->
</script>
	
</head>
<body>

<h1>Generate flyer thumbnail and icon</h1>
<form method="GET" action="edit.php">
<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
<input type="submit" value="<<< back" />
</form>
<hr />
<?php
	if(!isset($_GET['id']) || empty($_GET['id'])) {
		echo "Specify a party ID"."<br />\n";
	} else {
		$party_id = $_GET['id'];
		
		$inputFile = "../../flyers/".$party_id.".jpg";
		if(!file_exists($inputFile)) {
			echo "Flyer file '".$inputFile."' does not exist"."<br />\n";
			unset($party_id);
		}
		else if(isset($_POST['submit'])) {	
			// 'Generate thumbnail and icon' (submit) has been pressed.
			$hasErrors = false;
		
			$inputFile = "../../flyers/".$party_id.".jpg";
			$outputThumbFile = "../../flyers/thumbs/".$party_id.".jpg";
			$outputIconFile = "../../icons/".$party_id.".jpg";
			$radius = $_POST['radius'];
			$x = $_POST['x'];
			$y = $_POST['y'];
			
			if(!$hasErrors) {
				$flyer = imagecreatefromjpeg($inputFile);
				$flyerInfo = getimagesize($inputFile);
				$flyerWidth = $flyerInfo[0];
				$flyerHeight = $flyerInfo[1];
				
				// Generate thumbnail (height = 300px)
				$thumbHeight = 300;
				$thumbWidth = round(($thumbHeight / $flyerHeight) * $flyerWidth);
				$thumb = imagecreatetruecolor($thumbWidth, $thumbHeight);
				imagecopyresampled($thumb, $flyer, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $flyerWidth, $flyerHeight);
				imagejpeg($thumb, $outputThumbFile, 85);
				
				// Generate icon
				$topLeftX = $x - $radius;
				$topLeftY = $y - $radius;
				$cropSize = 2*$radius;
				$icon = imagecreatetruecolor(90, 90);
				imagecopyresampled($icon, $flyer, 0, 0, $topLeftX, $topLeftY, 90, 90, $cropSize, $cropSize);
				imagejpeg($icon, $outputIconFile, 85);
				
				echo "<b>Thumbnail and icon generated</b>"."<br />\n";
				
				// Unset fields for next party
				unset($inputFile);
				unset($outputThumbFile);
				unset($outputIconFile);
				unset($radius);
				unset($x);
				unset($y);
			}
			
		} // End of isSet()
	}
?>
<hr />
<br />

<?php
	if($_SERVER['REQUEST_METHOD'] == GET && isset($party_id)) {
?>
			
<form method="POST" enctype="multipart/form-data" action="crop_flyer.php?id=<?php echo $party_id; ?>">
<fieldset>
    <legend><b>Flyer</b></legend>
	<canvas id="flyer"></canvas>
</fieldset>
<fieldset>
    <legend><b>Icon</b></legend>
	<table>
	<tr>
		<td>Radius:</td>
		<td>
			<input id="radius" type="range" name="radius" min="45" max="500" /> 
			<span id="radius_output"></span>
		</td>
	</tr>
	<tr>
		<td>Position:</td>
		<td>
			<span id="x_output"></span>, <span id="y_output"></span>
		</td>
	</tr>
	</table>
</fieldset>

<input id="x" type="hidden" name="x" />
<input id="y" type="hidden" name="y" />

<input type="submit" name="submit" value="Generate flyer thumbnail and icon" />
</form>

<script type="text/javascript">
<!--
	init();
//-->
</script>

<?php
	}
?>

</body>
</html>