<?php
$ipAddress=$_SERVER['REMOTE_ADDR'];

#here U can run external command

$arp=`arp -a $ipAddress`;
$lines=explode("n", $arp);

#looking up the arp U need
foreach($lines as $line){
$cols=preg_split('/s+/', trim($line));
if ($cols[0]==$ipAddress)
$macAddr=$cols[1];
}

echo $arp;
?>