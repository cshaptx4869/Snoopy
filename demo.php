<?php
	include "Snoopy.class.php";
	$snoopy = new Snoopy;
	$snoopy->proxy_host = "www.phpoac.com";
	$snoopy->proxy_port = "8080";
	$snoopy->agent = "(compatible; MSIE 4.01; MSN 2.5; AOL 4.0; Windows 98)";
	$snoopy->referer = "http://www.phpoac.com/";
	$snoopy->cookies["SessionID"] = 238472834723489l;
	$snoopy->cookies["favoriteColor"] = "RED";
	$snoopy->rawheaders["Pragma"] = "no-cache";
	$snoopy->maxredirs = 2;
	$snoopy->offsiteok = false;
	$snoopy->expandlinks = false;
	$snoopy->user = "joe";
	$snoopy->pass = "bloe";
	if($snoopy->fetchtext("http://www.iti5.cn"))
	{
	      echo " <PRE>".htmlspecialchars($snoopy->results)." </PRE>\n";
	}
	else
	    echo "error fetching document: ".$snoopy->error."\n";
? >
