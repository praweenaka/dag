<?php session_start();

	include_once("connectioni.php");
	
	
if(isset($_GET['getCountriesByLetters']) && isset($_GET['letters'])){
	$letters = $_GET['letters'];
	$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
//echo "dist :".$_SESSION["txtlocation"];
//echo "select distinct cityname from geoname_lk where district_n='".$_GET['district']."' and cityname like  '".$letters."%' order by cityname";
	$res = mysqli_query($GLOBALS['dbinv'],"select distinct GEN_NO from s_mas where  GEN_NO like  '".$letters."%' order by GEN_NO" ) or die(mysqli_error());

	//$res = mysqli_query($GLOBALS['dbinv'],"select distinct cityname from geoname_lk where district_n like '".$letters."%' order by cityname") or die(mysqli_error());

	while($inf = mysqli_fetch_array($res)){
		echo $inf["GEN_NO"]."|";
	
	}	
}
?>
