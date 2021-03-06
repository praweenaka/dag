<?php

$hostname = 'localhost';
$username = 'root';
$password = '';

$dbacc = mysql_connect($hostname, $username, $password);
$GLOBALS['dbinv'] = mysql_connect($hostname, $username, $password, true);

mysql_select_db('tht_stores', $dbstores);
mysql_select_db('tht');	
//$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die                      ('Error connecting to mysql server!');

//$dbname = 'milhosp';
//$dbname = 'dberp';
//$dbname = 'acc';
//$dbname = 'ben';
//$dbname = 'dberp_e';
//mysql_select_db($dbname);

/*

$hostname = 'localhost';
$username = 'lotterix_admin';
$password = '19770705';

$dbacc = mysql_connect($hostname, $username, $password);
$GLOBALS['dbinv'] = mysql_connect($hostname, $username, $password, true);

mysql_select_db('lotterix_accben', $dbacc);
mysql_select_db('lotterix_ben');*/
?>
