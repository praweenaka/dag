<?php

	require_once("connectioni.php");
	
	

 	$sql_s_mas= "delete from  c_bal where DEV='1' ";
	$result_s_mas =mysqli_query($GLOBALS['dbinv'],$sql_s_mas);
	//$row_s_mas = mysqli_fetch_array($result_s_mas);
	
	$sql_s_mas= "delete from  ch_sttr where DEV='1' ";
	$result_s_mas =mysqli_query($GLOBALS['dbinv'],$sql_s_mas);
	
	$sql_s_mas= "delete from  cred where DEV='1' ";
	$result_s_mas =mysqli_query($GLOBALS['dbinv'],$sql_s_mas);
	
	$sql_s_mas= "delete from  lcrege where dev='1' ";
	$result_s_mas =mysqli_query($GLOBALS['dbinv'],$sql_s_mas);
	
	$sql_s_mas= "delete from  s_cheq where dev='1' ";
	$result_s_mas =mysqli_query($GLOBALS['dbinv'],$sql_s_mas);
	
	$sql_s_mas= "delete from  s_crec where DEV='1' ";
	$result_s_mas =mysqli_query($GLOBALS['dbinv'],$sql_s_mas);
	
	$sql_s_mas= "delete from  s_crnma where DEV='1' ";
	$result_s_mas =mysqli_query($GLOBALS['dbinv'],$sql_s_mas);
	
	$sql_s_mas= "delete from  s_cusordmas where DEV='1' ";
	$result_s_mas =mysqli_query($GLOBALS['dbinv'],$sql_s_mas);
	
	$sql_s_mas= "delete from  s_cusordtrn where DEV='1' ";
	$result_s_mas =mysqli_query($GLOBALS['dbinv'],$sql_s_mas);
	
	$sql_s_mas= "delete from  s_debmas where DEV='1' ";
	$result_s_mas =mysqli_query($GLOBALS['dbinv'],$sql_s_mas);
	
	$sql_s_mas= "delete from  s_invcheq where dev='1' ";
	$result_s_mas =mysqli_query($GLOBALS['dbinv'],$sql_s_mas);
	
	$sql_s_mas= "delete from  s_invo where DEV='1' ";
	$result_s_mas =mysqli_query($GLOBALS['dbinv'],$sql_s_mas);
	
	$sql_s_mas= "delete from  s_invo_order where DEV='1' ";
	$result_s_mas =mysqli_query($GLOBALS['dbinv'],$sql_s_mas);
	
	$sql_s_mas= "delete from  s_led where DEV='1' ";
	$result_s_mas =mysqli_query($GLOBALS['dbinv'],$sql_s_mas);
	
	$sql_s_mas= "delete from  s_quomas where DEV='1' ";
	$result_s_mas =mysqli_query($GLOBALS['dbinv'],$sql_s_mas);
	
	$sql_s_mas= "delete from  s_quotrn where DEV='1' ";
	$result_s_mas =mysqli_query($GLOBALS['dbinv'],$sql_s_mas);
	
	$sql_s_mas= "delete from  s_salma where DEV='1' ";
	$result_s_mas =mysqli_query($GLOBALS['dbinv'],$sql_s_mas);
	
	$sql_s_mas= "delete from  s_sttr where DEV='1' ";
	$result_s_mas =mysqli_query($GLOBALS['dbinv'],$sql_s_mas);
	
	$sql_s_mas= "delete from  s_trn where Dev='1' ";
	$result_s_mas =mysqli_query($GLOBALS['dbinv'],$sql_s_mas);
	
	$sql_s_mas= "delete from  s_wcusordmas where DEV='1' ";
	$result_s_mas =mysqli_query($GLOBALS['dbinv'],$sql_s_mas);
	
	$sql_s_mas= "delete from  s_weeordmas where DEV='1' ";
	$result_s_mas =mysqli_query($GLOBALS['dbinv'],$sql_s_mas);
	
	$sql_s_mas= "delete from  s_weeordtrn where DEV='1' ";
	$result_s_mas =mysqli_query($GLOBALS['dbinv'],$sql_s_mas);
	
	$sql_s_mas= "delete from  stk_take where DEV='1' ";
	$result_s_mas =mysqli_query($GLOBALS['dbinv'],$sql_s_mas);
	
	$sql_s_mas= "delete from  stk_take_undelever where DEV='1' ";
	$result_s_mas =mysqli_query($GLOBALS['dbinv'],$sql_s_mas);
	
	
?>
