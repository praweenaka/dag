<?php session_start();

	include_once("connection.php");
	
	
if(isset($_GET['getCountriesByLetters']) && isset($_GET['letters'])){
	$letters = $_GET['letters'];
	$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
//echo "dist :".$_SESSION["txtlocation"];
//echo "select distinct cityname from geoname_lk where district_n='".$_GET['district']."' and cityname like  '".$letters."%' order by cityname";
	$res = mysql_query("select distinct GEN_NO from s_mas where  GEN_NO like  '".$letters."%' order by GEN_NO" ) or die(mysql_error());

	//$res = mysql_query("select distinct cityname from geoname_lk where district_n like '".$letters."%' order by cityname") or die(mysql_error());

	while($inf = mysql_fetch_array($res)){
		echo $inf["GEN_NO"]."|";
	
	}	
}
?>
