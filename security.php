<?php 
date_default_timezone_set('Asia/Colombo');
session_start();

require_once ("connection_sql.php");
ini_set('session.gc_maxlifetime', 30 * 60 * 60 * 60); 

if ($_SESSION["CURRENT_USER"] == "") {
	echo "Please Loging Again !!!";
	exit();
}

if ($_SESSION['company'] !="THT") {
	echo "Please Loging Again.. Different Company !!!";
	exit();
}

$sql = "select * from view_menu where username='" . $_SESSION['UserName'] . "' and name='".$url."' and grp='Stores' and   doc_view=1 and block='0'"; 
$sql = $conn->query($sql);
if ($row = $sql->fetch()) {
}else{
	echo "<script>alert('You Dont  Have Permission This Page');</script>"; 
	exit();
}

$sql="SELECT * FROM invpara";
$result = $conn->query($sql);
$row = $result->fetch();
if ($row["master_dev"]=="1"){
	$_SESSION["dev"]="0";
}

?>