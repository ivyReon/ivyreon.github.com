<?php
  include "Snoopy.class.php";
$k=$_GET["k"];
$bo_table=$_GET["bo_table"];
$page=$_GET["page"];
if($page == "")
	$page = 1;
  $snoopy= new snoopy;
  $snoopy->fetch("http://localhost/rss1.php?bo_table=".$bo_table."&k=".$k."&page=".$page."");
  $txt=str_replace("&","&amp;",$snoopy->results);
  echo $txt;
?>
