<?php

include('connection_server.php');
	
	$REF_NO="";
	$sql="select * from s_cusordmas where SDATE='2014-04-05' order by REF_NO";
	echo $sql;
	$result=mysqli_query($GLOBALS['dbinv'],$sql, $dbtht);
	while ($row = mysqli_fetch_array($result)){
		if ($REF_NO != $row["REF_NO"]){
			$REF_NO = $row["REF_NO"];
		} else {
			$sql="delete from s_cusordmas where id=".$row["id"];
			$result=mysqli_query($GLOBALS['dbinv'],$sql, $dbtht);
		}
	}
	
	
	

?>