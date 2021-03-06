<?php




$hostname = 'localhost';
$username = 'root';
$password = '';

$dbacc = mysql_connect($hostname, $username, $password);
$GLOBALS['dbinv'] = mysql_connect($hostname, $username, $password, true);

//mysql_select_db('lotterix_accben', $dbacc);
//mysql_select_db('lotterix_ben');

mysql_select_db('acc', $dbacc);
mysql_select_db('ben');

/*

$hostname = 'localhost';
$username = 'root';
$password = '';

$dbacc = mysql_connect($hostname, $username, $password);
$GLOBALS['dbinv'] = mysql_connect($hostname, $username, $password, true);

mysql_select_db('acc', $dbacc);
mysql_select_db('tht');	*/



$hostname = 'localhost';
$username = 'lotterix_admin';
$password = 'shan@123';

$dbacc = mysql_connect($hostname, $username, $password);
$GLOBALS['dbinv'] = mysql_connect($hostname, $username, $password, true);

//mysql_select_db('lotterix_accben', $dbacc);
//mysql_select_db('lotterix_ben');

mysql_select_db('lotterix_ben');


?>
