<?php
/*
    Version: 1.2.2
    Author: HKLCF
    Copyright: HKLCF
    Last Modified: 11/01/2019
*/

$url = isset($_GET['url']) ? htmlspecialchars($_GET['url']) : null;
$support_domain = 'www.mediafire.com';

if(empty($url)) {
  $url = 'http://www.mediafire.com/file/d4prl8x8cqnqf5v/T1398-01.mp4'; // sample link
}
if($url) {
  preg_match('@^(?:http.?://)?([^/]+)@i', $url, $matches);
  $host = $matches[1];
  if($host != $support_domain) {
    echo 'Please input a valid mediafire url.';
    exit;
  }
}

$result = file_get_contents($url, false, stream_context_create(['socket' => ['bindto' => '0:0']])); // force IPv4

preg_match('/aria-label="Download file"\n.+href="(.*)"/', $result, $matches);
$result = urldecode($matches[1]);

$output = [];
$output[] = ['label' => 'Original', 'file' => $result, 'type' => 'video/mp4'];

$output = json_encode($output);

echo $output;
?>
