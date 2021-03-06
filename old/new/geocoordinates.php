<?php
session_start();
date_default_timezone_set('Asia/Colombo');

if ($_SERVER['SERVER_NAME'] == "192.168.101.127") {
//exit();	
}	



include('connectioni.php');
		
if(isset($_POST['lat'], $_POST['lng'])) {
    $lat = $_POST['lat'];
    $lng = $_POST['lng'];

    $url = sprintf("https://maps.googleapis.com/maps/api/geocode/json?latlng=%s,%s", $lat, $lng);

    $content = file_get_contents($url); // get json content
	 
	//echo $content;
    $metadata = json_decode($content, true); //json decoder
	
	
	
   if(count($metadata['results']) > 0) {
        // for format example look at url
        // https://maps.googleapis.com/maps/api/geocode/json?latlng=40.714224,-73.961452
        //$result = $metadata['results'][0]['geometry']['location']['lat'];
		
		$str = $metadata['results'][0]['address_components'][0]['long_name'];
		$str .= " " . $metadata['results'][0]['address_components'][1]['long_name'];
		$str .= " " . $metadata['results'][0]['address_components'][2]['long_name'];
		
		$sql = "update loging set loc ='" . $str . "' where Sessioan_Id ='" . $_SESSION['sessionId'] . "'";
		 
		$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
		
		$sql = "insert into geoloc (user_nm,sdate,stime,lat,lng) values ('" . $_SESSION['UserName'] . "','" . date('Y-m-d') ."','" . date('Y-m-d h:i:sa') ."','" . $lat ."','" . $lng ."') ";
		 
		$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
        // save it in db for further use
		if ($_POST['fun'] =="getloc") {
			echo $str;
		} 
        //echo $str; 

    }
    else {
        // no results returned
    }
}


?>