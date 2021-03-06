<?php

$hostname = 'localhost';
$username = 'root';
$password = '';

$ben = mysql_connect($hostname, $username, $password, true);
$ben_tyre = mysql_connect($hostname, $username, $password, true);

//mysql_select_db('lotterix_accben', $dbacc);
//mysql_select_db('lotterix_ben', $dbinv);

mysql_select_db('ben', $ben);
mysql_select_db('ben_tyre', $ben_tyre);

$sql = "Select * from s_crnfrmtrn where Sdate >='2014-08-19'";
$result = mysql_query($sql, $ben);
while ($row = mysql_fetch_array($result)) {

    $sql1 = "Insert into s_crnfrmtrn (Sdate, Refno, Code, Name, Sal_ex, Mon, Inv_no, Inv_date, Amount, Qty, Incen_per, Incen_val, Brand, Flag, tmp_no) values('" . $row["Sdate"] . "', '" . $row["Refno"] . "','" . trim($row["Code"]) . "', '" . trim($row["Name"]) . "', '" . $row["Sal_ex"] . "', '" . $row["Mon"] . "','" . trim($row["Inv_no"]) . "', '" . $row["Inv_date"] . "', '" . $row["Amount"] . "', '" . $row["Qty"] . "', '" . $row["Incen_per"] . "', '" . $row["Incen_val"] . "','" . $row["Brand"] . "','".$row["Flag"]."', '".$row["tmp_no"]."')";
    echo $sql1 . "<br>";
    $result1 = mysql_query($sql1, $ben_tyre);

}

$sql = "Select * from s_crnfrm where Sdate >='2014-08-19'";
$result = mysql_query($sql, $ben);
while ($row = mysql_fetch_array($result)) {

    $sql1 = "insert into s_crnfrm (Refno, Sdate, Code, Mon, Amount, Remark, Sal_ex, Flag, Checked, Lock1, Cancell, Credit_note, tmp_no) Values('" . $row["Refno"] . "','" . $row["Sdate"] . "', '" . trim($row["Code"]) . "', '" . $row["Mon"] . "', '" . $row["Amount"] . "','" . trim($row["Remark"]) . "','" . $row["Sal_ex"] . "','".$row["Flag"]."', '".$row["Checked"]."', '".$row["Lock1"]."', '".$row["Cancell"]."', '".$row["Credit_note"]."', '".$row["tmp_no"]."')";
    echo $sql1 . "<br>";
    $result1 = mysql_query($sql1, $ben_tyre);

}






  
?>