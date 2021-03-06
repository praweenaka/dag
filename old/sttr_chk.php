<?php

require_once("connectioni.php");



$sql = "select * from s_crec where CA_DATE>='2018-08-01' and CANCELL!='1' and FLAG!='RET'";
$result = mysqli_query($GLOBALS['dbinv'], $sql);
while ($row = mysqli_fetch_array($result)) {
    $sql1 = "select * from s_sttr where ST_REFNO='" . $row["CA_REFNO"] . "'";
    $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
    if ($row1 = mysqli_fetch_array($result1)) {
        
    } else {
        echo $row["CA_REFNO"] . "-" . $row["CA_DATE"] . "-" . $row["CA_CODE"] . "</br>";
    }
}
?>