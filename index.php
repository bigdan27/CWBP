<?php

error_reporting(0);
require 'functions.php';

$dns = ['wpnrtnmrewunrtok.xyz'];
$servers = ['s4','s6','user9','v1','vid1','video9','z1','rec1'];

?>
	<!--

Camwhores.tv video downloader
Also works with private vids

  __  __           _        _             _____
 |  \/  |         | |      | |           |  __ \
 | \  / | __ _  __| | ___  | |__  _   _  | |  | | __ _ _   _ _ __ ___
 | |\/| |/ _` |/ _` |/ _ \ | '_ \| | | | | |  | |/ _` | | | | '_ ` _ \
 | |  | | (_| | (_| |  __/ | |_) | |_| | | |__| | (_| | |_| | | | | | |
 |_|  |_|\__,_|\__,_|\___| |_.__/ \__, | |_____/ \__,_|\__, |_| |_| |_|
                                   __/ |                __/ |
                                  |___/                |___/
-->
<!DOCTYPE html>
<html lang="en">
	<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="camwhoresddl.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>

<body>

<div class="container">

<h1>Camwhores.tv private video bypass</h1>
<form method="post" action="#" class="form-horizontal">
 <div class="form-group">
<label class="control-label" for="videoURL">Private video link</label>
<input type="text" name="videoURL" class="form-control" placeholder="Insert private video link here" required /><br />
<input type="submit" name="sumbitVideoURL" value="Submit" class="btn btn-default" style="color:black;"/>


</div>
</form>


<?php

//check if form was submitted
if(isset($_POST['sumbitVideoURL'])){

	// Have to be careful with this URL. Might have to change if this specific video gets taken down.
	$url = "http://www.camwhores.tv/get_file/8/82d37ce62299d92dfea3530bdf343251339ed88e44/930000/930718/930718.mp4/";

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_NOBODY, true);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_exec($ch);
	$ddl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
	curl_close($ch);

	$input = $_POST['videoURL'];
	$random = urldecode($ddl);
	$videoID = getVideoID($input);
	$folderID = getFolderID($input,$videoID);

	/*
	cv, cv2 and cv3 are 3 security tokens that are generated and use to create the link to the video source
	Theses hashes will most likely last for about 10min
	cv3 seems useless since i can get embed video without using it
	*/
	$time = get_string_between($random,'time=','&'); // Returned by php time() function
	$user = get_string_between($random,'//','.');
	$cv = get_string_between($random,'cv=','&');
	$cv2 = get_string_between($random,'cv2=','&');
	$cv3 = get_string_between($random . '/','cv3=','/');
	$lr = '312500'; // not sure about this, it seems not to change over time


	/*

	New servers handling

	*/
	$fetch = "";
foreach($dns as $d){

	foreach($servers as $serv){

		$link = 'http://' . $serv . '.' . $d .'/remote_control.php?time='. $time . '&cv=' . $cv . '&lr='. $lr .'&cv2=' . $cv2 . '&file=/'. $folderID .'/' . $videoID .'/' . $videoID . '.mp4';
		if(checkFileValidity($link)){
			$fetch = $link;
			break;
		}
	}
	}

// Showing download link if we have correct parameters
if($fetch != ""){

echo '<video id="player" width="100%" height="auto" controls>
    <source src="'. $fetch .'" type="video/mp4">
    Your browser does not support the video tag.
</video>';
echo '<br /><a href="'. $fetch . '" download="' . $videoID . '" class="btn btn-success">Download video</a><br/><br/><br/>';
}
		else
			echo '<div class="alert alert-danger">Error while fetching video. Make sure you post a correct URL, or try to change ddl link</div>';




}

?>




</div> <!-- End of container -->


</body>

<div class="scripts">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</div>
</html>