<?php
/*$hostname = 'localhost';
$username = 'root';
$password = '';*/
/*
$hostname = 'localhost';
$username = 'lotterix_admin';
$password = '19770705';

$dbben = mysql_connect($hostname, $username, $password);
$dbtht = mysql_connect($hostname, $username, $password, true);
$dbacc = mysql_connect($hostname, $username, $password, true);

mysql_select_db('ben', $dbben);
mysql_select_db('tht', $dbtht);	
mysql_select_db('acc', $dbacc);	*/

/*mysql_select_db('lotterix_ben', $dbben);
mysql_select_db('lotterix_tht', $dbtht);*/				

//$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die                      ('Error connecting to mysql server!');

//$dbname = 'milhosp';
//$dbname = 'dberp';
//$dbname = 'acc';
//$dbname = 'ben';
//$dbname = 'dberp_e';
//mysql_select_db($dbname);



$hostname = 'localhost';
$username = 'lotterix_admin';
$password = '19770705';

$dbacc = mysql_connect($hostname, $username, $password);
$dbinv = mysql_connect($hostname, $username, $password, true);

//mysql_select_db('lotterix_accben', $dbacc);
//mysql_select_db('lotterix_ben', $dbinv);

mysql_select_db('lotterix_acctht', $dbacc);
mysql_select_db('lotterix_tht', $dbinv);

?>
