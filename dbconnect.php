<?php

$con = mysqli_connect("localhost", "username", "password", "table_name") or die("Error " . mysqli_error($con));
date_default_timezone_set('Asia/Kolkata');
$timeNow = date("Y-m-d H:i:s");

$siteUrl = 'localhost/ots/';

$siteNameFull = "MinD Webs Online Test Series";
$siteName = "<b>MinD Webs</b> OTS";
$siteNameShort = "MW OTS";

$sNameShortMenu = "<b>MW</b> OTS";
$sNameMenu = "<b>MinD Webs</b> OTS";

$footer = "&copy; 2018-19 Dipan Roy | Created by <a href=\"http://mindwebs.org\" target=\"_blank\">MinD Webs Team</a>";

$myEmail = 'administrator@mindwebs.org';
$ourMail = 'notification@mindwebs.org';
?>