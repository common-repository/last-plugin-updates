<?php
header('Content-Type: application/json');
$plugin_slug = $_GET['slug'];

$ch = curl_init('http://api.wordpress.org/plugins/info/1.0/'.$plugin_slug.'.json');
curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
$content = curl_exec($ch);
curl_close($ch);
?>