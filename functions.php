<?php
/*

Gets a string value between two values, start and end
@param String $string, the string to parse
@param String $start, the first value
@param String $end, the second string value

*/
function get_string_between($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}

/*

Returns the ID of the video
@param String $link, the video URL

*/
function getVideoID($link){

  return get_string_between($link, 'videos/', '/');

}

/*

Returns the ID of the folder containing the video
@param String $link, the video URL
@param String $videoID, the ID of the video

*/
function getFolderID($link,$videoID){

  $opts = array(
    'http'=>array(
    'method'=>"GET",
    'header'=>"Accept-language: en\r\n" .
              "Cookie: foo=bar\r\n"
  )
  );

  $context = stream_context_create($opts);

  // get http page posted
  $html = file_get_contents($link, false, $context);

  // parse http page to get the folder ID
  $parsed = get_string_between($html, 'videos_screenshots/', '/' . $videoID);

  return $parsed;

}


/*

Checks if fetched file corresponds to video file expected
@param String $link, the content URL

*/
function checkFileValidity($link){

  $content = get_headers($link);
  return (preg_match('/mp4/',$content[2]) == 1) || (preg_match('/mp4/',$content[3]) == 1);

}

?>
