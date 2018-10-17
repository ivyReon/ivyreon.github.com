<?php
header("Content-Type: text/html");
 
echo "<rss xmlns:showrss=\"http://showrss.info/\" version=\"2.0\"><channel><title></title><link></link><description></description>";

$k=$_GET["k"];
$k=str_replace(" ","+",$k);
$page=$_GET["page"];
$bo_table=$_GET["bo_table"];

if($page == ""){
	$page = 1;
}

$headers = array();
$headers[] = 'Cookie: uuoobe=on;';

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
//echo $title . "\n";
//echo $view . "\n";
echo "<item><title>".$title."</title><link>http://localhost/download.php?" . $view . "</link><description></description><showrss:showid></showrss:showid><showrss:showname>".$title."</showrss:showname></item>";
}

echo "</channel></rss>";
?>