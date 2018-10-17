<?php

$b_id=$_GET["b_id"];
$id=$_GET["id"];

header("Connection: keep-alive");
header("Content-Type: application/x-bittorrent");
//header("Content-Length: 12086");
header("pragma: no-cache");
header("expires: 0");
header("Content-Disposition: attachment; filename=\"".$id.".torrent\"");
header("content-description: php generated data");


$downloadurl = "http://file.filetender.com/Execdownload.php?link=" . base64_encode($b_id . "|" . $id . "|");


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $downloadurl);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);

$data = curl_exec($ch);

echo $data;
?>