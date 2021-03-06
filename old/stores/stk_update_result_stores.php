<?php

include_once("connectioni.php");


$sql = "update s_trn_stores set tru_qty = qty where (ledindi='TRN' or ledindi = 'ARN' or ledindi ='GRN' or ledindi = 'GINR' or ledindi ='IIN') ";

mysqli_query($GLOBALS['dbinv'], $sql);

$sql = "update s_trn_stores set tru_qty = qty * -1 where (ledindi = 'ISO' or ledindi = 'ARR' or ledindi ='INV' or ledindi = 'GINI' or ledindi ='IOU') ";
mysqli_query($GLOBALS['dbinv'], $sql);



$rs_smas1 = "select STK_NO, sum(tru_qty) as tot from s_trn_stores   where SDATE >= '2019-04-01' group by STK_NO order by STK_NO ";
$result_smas1 = mysqli_query($GLOBALS['dbinv'], $rs_smas1);
while ($row_smas1 = mysqli_fetch_array($result_smas1)) {



    $sql = "update s_mas set QTYINHAND_STORES =" . $row_smas1['tot'] . "  where  STK_NO='" . trim($row_smas1["STK_NO"]) . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);

    $sql = "update s_submas_stores set QTYINHAND =" . $row_smas1['tot'] . " where STO_CODE='1' and STK_NO='" . trim($row_smas1["STK_NO"]) . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
}
///////





echo "Update Completed";
?>
