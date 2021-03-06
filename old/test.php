<?php

require_once("connectioni.php");
	
 
	$sql="select * from userpermission group by docid"; 
	$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
	while ($row = mysqli_fetch_array($result)){
		
		$sql1="select * from doc where docid='".$row["docid"]."'";
		$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
		$row1 = mysqli_fetch_array($result1); 

		$sql2 = "update userpermission set doc_name= '" . $row1['docname'] . "'   where docid='".$row["docid"]."'";
		$result2 = mysqli_query($GLOBALS['dbinv'], $sql2);
		 
	}
	
	
	

?>

