<?php 
date_default_timezone_set('Asia/Colombo');
session_start();
include('connectioni.php');
ini_set('session.gc_maxlifetime', 30 * 60 * 60 * 60); 

if ($_SESSION["CURRENT_USER"] == "") {
	echo "Please Loging Again !!!";
	exit();
}
 
if ($_SESSION['company'] !="THT") {
	echo "Please Loging Again.. Different Company !!!";
	exit();
}
$url = "";    
$url.= $_SERVER['HTTP_HOST'];   
$url.= $_SERVER['REQUEST_URI'];   
$url=substr($_SERVER['REQUEST_URI'],5,-4); 


$sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and name='".$url."' and    doc_view=1 and block='0'";   
$result = mysqli_query($GLOBALS['dbinv'], $sql);
if ($row = mysqli_fetch_array($result)) { 
}else{
	echo "<script>alert('You Dont  Have Permission This Page');</script>"; 
	exit();
}

$sql="SELECT * FROM invpara";
$result=mysqli_query($GLOBALS['dbinv'],$sql);
$row = mysqli_fetch_array($result);
if ($row["master_dev"]=="1"){
	$_SESSION["dev"]="0";
}

?>