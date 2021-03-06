<?php




$hostname = 'localhost';
$username = 'coolmans';
$password = 'e1E]0Mfua.0T4L';

$dbacc = mysql_connect($hostname, $username, $password);
$dbinv = mysql_connect($hostname, $username, $password, true);

//$ben = mysql_connect($hostname, $username, $password);
//$ben_tyre = mysql_connect($hostname, $username, $password, true);

mysql_select_db('SWijesooriya_acctht20', $dbacc);
mysql_select_db('coolmans_akeesha', $dbinv);

//mysql_select_db('ben', $ben);
//mysql_select_db('ben_tyre', $ben_tyre);
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
mysql_select_db('ben', $dbinv);	*/


/*
$hostname = 'localhost';
$username = 'lotterix_admin';
$password = 'shan@123';

$dbacc = mysql_connect($hostname, $username, $password);
$dbinv = mysql_connect($hostname, $username, $password, true);

//mysql_select_db('lotterix_accben', $dbacc);
//mysql_select_db('lotterix_ben', $dbinv);

mysql_select_db('lotterix_acctht', $dbacc);
mysql_select_db('lotterix_tht', $dbinv);*/


?>
