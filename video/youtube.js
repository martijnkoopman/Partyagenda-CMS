function fill()
{
	var youtube_id = document.getElementsByName("youtube_id")[0].value;
	if (youtube_id) {
		var req = new XMLHttpRequest();
		req.open("GET", "https://www.googleapis.com/youtube/v3/videos?part=snippet,contentDetails&id="+youtube_id+"&key=XXXXXXXX", true); 
		req.onreadystatechange = function myCode() {
			if (req.readyState == 4) { 
				var doc = eval('(' + req.responseText + ')');
                                var item = doc.items[0];
                                
				var title = item.snippet.title;
				var dur = item.contentDetails.duration.slice(2,-1).replace("H", ":");
				dur = dur.replace("M", ":");
				dur = dur.split(":");
				var duration = 0;
				for (var i = 0; i < dur.length; i++) {
					duration = duration + (dur[dur.length-i-1] * Math.pow(60,i));
				}
				var uploader = item.snippet.channelTitle;
				var uploaded = item.snippet.publishedAt.substring(0,10);
				
				document.getElementsByName("title")[0].value=title;
				document.getElementsByName("duration")[0].value=duration;
				document.getElementsByName("uploader")[0].value=uploader;
				document.getElementsByName("uploaded")[0].value=uploaded;
			}
		}
		req.send(null);
	}
}
