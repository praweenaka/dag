<?php


$hostname = 'localhost';
$username = 'SWije_lotterix';
$password = 'Shan#123@';



$dbtht = mysql_connect($hostname, $username, $password);
//$dbtht = mysql_connect($hostname, $username, $password, true);
//$dbacc = mysql_connect($hostname, $username, $password, true);



mysql_select_db('SWijesooriya_tht111', $dbtht);

?>
