<?php

$isdownload=$_GET["isdownload"];

function selfURL() 
{ 
	    $s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : ""; 
	    $protocol = strleft(strtolower($_SERVER["SERVER_PROTOCOL"]), "/").$s; 
	    $port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]); 
	    return $protocol."://".$_SERVER['SERVER_NAME'].$port.$_SERVER['REQUEST_URI']; 
} 

function strleft($s1, $s2) { return substr($s1, 0, strpos($s1, $s2)); }

if($isdownload == "yes"){
	$b_id=$_GET["b_id"];
	$id=$_GET["id"];

	header("Connection: keep-alive");
	header("Content-Type: application/x-bittorrent");
	header("pragma: no-cache");
	header("expires: 0");
	header("Content-Disposition: attachment; filename=\"".$id.".torrent\"");
	header("content-description: php generated data");


	$downloadurl = "http://file.filetender.com/Execdownload2.php?link=" . base64_encode($b_id . "|" . $id . "|");


	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $downloadurl);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HEADER, 0);

	$data = curl_exec($ch);

	echo $data;
}
else
{
	$k=$_GET["k"];
	$k=str_replace(" ","+",$k);
	$page=$_GET["page"];
	$bo_table=$_GET["bo_table"];

	$rssresult = "";

	header("Content-Type: text/html");
 
	$rssresult =  "<rss xmlns:showrss=\"http://showrss.info/\" version=\"2.0\"><channel><title></title><link></link><description></description>";

	if($page == ""){
		$page = 1;
	}

	$headers = array();
	$headers[] = 'Cookie: uuoobe=on;';

	$downloadurl = selfURL();

	$downloadurl = preg_replace('/\?.*/', '', $downloadurl);

	$url = 'http://www.tfreeca22.com/board.php?b_id=' . $bo_table . '&mode=list&sc=' . $k . '&x=0&y=0&page='.$page.'';
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HEADER, 0);

	$data = str_replace("</span>","",str_replace("<span class='sc_font'>","",str_replace("stitle1","stitle",str_replace("stitle2","stitle",str_replace("stitle3","stitle",str_replace("stitle4","stitle",str_replace("stitle5","stitle",str_replace("<tr class=\"bgcolor\">","<tr >",curl_exec($ch)))))))));

	//echo $data;
	$data = explode("<tr >", $data);

	for($i = 1; $i < count($data); $i++){
	$title = explode(" </a>",explode("class=\"stitle\"> ",$data[$i])[1])[0];
	$view = explode("\"",explode("<a href=\"board.php?mode=view&",$data[$i])[1])[0];
	$viewconv=str_replace("&","&amp;",$view);
	//echo $title . "\n";
	//echo $view . "\n";
	$rssresult = $rssresult."<item><title>".$title."</title><link>".$downloadurl."?" . $viewconv . "&amp;isdownload=yes</link><description></description><showrss:showid></showrss:showid><showrss:showname>".$title."</showrss:showname></item>";
	//$rssresult = $rssresult."<item><title>".$title."</title><link>http://localhost/download.php?" . $viewconv . "</link><description></description><showrss:showid></showrss:showid><showrss:showname>".$title."</showrss:showname></item>";
	}

	$rssresult = $rssresult."</channel></rss>";

	echo $rssresult;
}
?>
