<?php

require_once("connectioni.php");



$entREFNO = "TRN/" . $_GET["dtfrom"];


$sql = "delete from s_trn_stores where REFNO='" . $entREFNO . "'";
$result = mysqli_query($GLOBALS['dbinv'], $sql);

//						while($row = mysqli_fetch_array($result)){

$sql_smas = "select * from s_mas ";
$result_smas = mysqli_query($GLOBALS['dbinv'], $sql_smas);
while ($row_smas = mysqli_fetch_array($result_smas)) {

    $stkqty = 0;
    $sql_stkTake = "select sum(QTY) as qty,sum(damage) damQTy from stk_take where STK_NO='" . trim($row_smas["STK_NO"]) . "'";
    //echo $sql_stkTake;
    $result_stkTake = mysqli_query($GLOBALS['dbinv'], $sql_stkTake);
    if ($row_stkTake = mysqli_fetch_array($result_stkTake)) {
        if ($row_stkTake["qty"] > 0) {
            $stkqty = $row_stkTake["qty"];
        }

        if ($row_stkTake["damQTy"] > 0) {
            $stkqty = $stkqty - $row_stkTake["damQTy"];
        }
    }

    $sql_stkDeli = "select sum(QTY) as qty from stk_take_undelever where STK_NO='" . trim($row_smas["STK_NO"]) . "'";
    $result_stkDeli = mysqli_query($GLOBALS['dbinv'], $sql_stkDeli);
    if ($row_stkDeli = mysqli_fetch_array($result_stkDeli)) {
        if ($row_stkDeli["qty"] > 0) {
            $stkqty = $stkqty - $row_stkDeli["qty"];
            //	echo $row_stkDeli["qty"];
        }
    }


    if ($stkqty < 0) {
        $stkqty = 0;
    }

    $sql = "insert into s_trn_stores (SDATE, STK_NO, REFNO, QTY, LEDINDI, DEPARTMENT) values ('" . $_GET["dtfrom"] . "', '" . $row_smas["STK_NO"] . "' , '" . $entREFNO . "', " . number_format($stkqty, 0, ".", "") . ", 'TRN', '1')";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);

    /* $sql="update s_submas_stores set QTYINHAND=".number_format($stkqty, 0, ".", "")." where  STK_NO='" . $row_smas["STK_NO"] . "' and STO_CODE='01'";
      $result =mysqli_query($GLOBALS['dbinv'],$sql) ;

      $sql="update s_mas set QTYINHAND_STORES=".number_format($stkqty, 0, ".", "")." where  STK_NO='" . $row_smas["STK_NO"] . "' ";
      $result =mysqli_query($GLOBALS['dbinv'],$sql) ;
     */
}

echo "Completed";
?>
