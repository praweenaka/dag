<?php


/*

$hostname = 'localhost';
$username = 'root';
$password = '';

$dbacc = mysql_connect($hostname, $username, $password);
$dbinv = mysql_connect($hostname, $username, $password, true);

//$ben = mysql_connect($hostname, $username, $password);
//$ben_tyre = mysql_connect($hostname, $username, $password, true);

//mysql_select_db('lotterix_accben', $dbacc);
//mysql_select_db('lotterix_ben', $dbinv);

/*mysql_select_db('ben', $ben);
mysql_select_db('ben_tyre', $ben_tyre);*/
//mysql_select_db('ben_tyre_tmp', $ben_tyre);
/*
mysql_select_db('acc', $dbacc);
mysql_select_db('ben_tyre_25', $dbinv);*/

//mysql_select_db('ben_tyre', $dbinv);


/*
$hostname = 'localhost';
$username = 'root';
$password = '';

$dbacc = mysql_connect($hostname, $username, $password);
$dbinv = mysql_connect($hostname, $username, $password, true);

mysql_select_db('acc', $dbacc);
mysql_select_db('tht', $dbinv);	*/



$hostname = 'localhost';
$username = 'lotterix_admin';
$password = '19770705';

$dbacc1 = mysql_connect($hostname, $username, $password);
$dbacc2 = mysql_connect($hostname, $username, $password, true);

//mysql_select_db('lotterix_accben', $dbacc);
//mysql_select_db('lotterix_ben', $dbinv);

mysql_select_db('lotterix_accben', $dbacc2);
mysql_select_db('lotterix_a', $dbacc1);


?>
