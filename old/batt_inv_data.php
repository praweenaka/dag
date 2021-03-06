<?php

session_start();

////////////////////////////////////////////// Database Connector /////////////////////////////////////////////////////////////
require_once ("connectioni.php");

////////////////////////////////////////////// Write XML ////////////////////////////////////////////////////////////////////
header('Content-Type: text/xml');

date_default_timezone_set('Asia/Colombo');

/////////////////////////////////////// GetValue //////////////////////////////////////////////////////////////////////////
///////////////////////////////////// Registration /////////////////////////////////////////////////////////////////////////

if ($_GET["Command"] == "new_inv") {

    if ($_SESSION["dev"] != "") {

        $sql = "Select GIN from invpara";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        $row = mysqli_fetch_array($result);
        $tmpinvno = "000000" . $row["GIN"];
        $lenth = strlen($tmpinvno);
        $invno = trim("GIN/ ") . substr($tmpinvno, $lenth - 8);
        $_SESSION["invno"] = $invno;

        $sql = "Select GIN from tmpinvpara";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        $row = mysqli_fetch_array($result);
        $_SESSION["tmp_no_gin"] = "GIN/" . $row["GIN"];

        $sql = "delete from tmp_gin_data where tmp_no='" . $_SESSION["tmp_no_gin"] . "'";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);

        $sql = "update tmpinvpara set GIN=GIN+1";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);

        echo $invno;
    } else {
        echo "no";
    }
}

 

if ($_GET["Command"] == "save_item") {

    
    $sql = "delete from battry_inv where stk_no = '" . $_GET['stk_no'] . "' and sdate='" . $_GET['sdate'] . "' and c_code = '" . $_GET['c_code'] . "' and rep='" . $_GET['rep'] . "'";
    $result1 = mysqli_query($GLOBALS['dbinv'], $sql);
    
    $sql1 = "insert into battry_inv (c_code,stk_no,sdate,qty,rep) values ('" . $_GET['c_code'] . "','" . $_GET['stk_no'] . "','" . $_GET['sdate'] . "','" . $_GET['txtqty'] . "','" . $_GET['rep'] . "')";
    //echo $sql1;
    //echo $sql1;
    $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);

     $rep = trim($_GET["rep"]);

    $tb = "<table class=\"CSSTableGenerator\">";

    $tb .= "<tr>";
    $tb .= "<td width=\"50\"  background=\"\">Stock No</td>";
    $tb .= "<td width=\"150\"  background=\"\">Description</td>";

    $sql = "select sdate from battry_inv where rep='" . $rep . "' and c_code='" . trim($_GET["c_code"]) . "' group by sdate order by sdate desc limit 2";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);

    while ($row = mysqli_fetch_array($result)) {
        $tb .= "<td  width=\"70\">" . $row['sdate'] . "</td>";
    }

   
    $tb .= "</tr>";

    $sql = "select stk_no from battry_inv where rep='" . $rep . "' and c_code='" . trim($_GET["c_code"]) . "' group by stk_no";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);

    $mdate1 = "";
    $mdate2 = "";

    $date1 = date('Y-m-d');
    $date2 = date('Y-m-d');



    while ($row = mysqli_fetch_array($result)) {
        $mqty1 = 0;
        $mqty2 = 0;
        $mdate1 = "";
        $mdate2 = "";
        $tb .= "<td>" . $row['stk_no'] . "</td>";

        $sql = "select * from s_mas where stk_no ='" . $row['stk_no'] . "'";
        $result1 = mysqli_query($GLOBALS['dbinv'], $sql);
        if ($row1 = mysqli_fetch_array($result1)) {
            $tb .= "<td>" . $row1['DESCRIPT'] . "</td>";
        }

        $sql = "select sdate from battry_inv where rep='" . $rep . "' and c_code='" . trim($_GET["c_code"]) . "' group by sdate order by sdate desc ";
        $result1 = mysqli_query($GLOBALS['dbinv'], $sql);
        while ($row1 = mysqli_fetch_array($result1)) {

            $sql = "select qty from battry_inv where rep='" . $rep . "' and c_code='" . trim($_GET["c_code"]) . "' and stk_no = '" . $row['stk_no'] . "' and sdate = '" . $row1['sdate'] . "'";
            $result2 = mysqli_query($GLOBALS['dbinv'], $sql);

            if ($row2 = mysqli_fetch_array($result2)) {
                $tb .= "<td align='right'>" . $row2['qty'] . "</td>";
            } else {
                $tb .= "<td align='right'>-</td>";
            }

           
        }

         


        $tb .= "</tr>";
    }

    $tb .= "</table>";

    echo $tb;
    
}

 

if ($_GET["Command"] == "view_his") {

    $rep = trim($_GET["rep"]);

    $tb = "<table class=\"CSSTableGenerator\">";

    $tb .= "<tr>";
    $tb .= "<td width=\"50\"  background=\"\">Stock No</td>";
    $tb .= "<td width=\"150\"  background=\"\">Description</td>";

    $sql = "select sdate from battry_inv where rep='" . $rep . "' and c_code='" . trim($_GET["c_code"]) . "' group by sdate order by sdate desc limit 2";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);

    while ($row = mysqli_fetch_array($result)) {
        $tb .= "<td  width=\"70\">" . $row['sdate'] . "</td>";
    }

    $tb .= "<td  width=\"70\">Deliverd</td>";
    $tb .= "<td width=\"70\">Movement</td>";
    $tb .= "</tr>";

    $sql = "select stk_no from battry_inv where rep='" . $rep . "' and c_code='" . trim($_GET["c_code"]) . "' group by stk_no";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);

    $mdate1 = "";
    $mdate2 = "";

    $date1 = date('Y-m-d');
    $date2 = date('Y-m-d');



    while ($row = mysqli_fetch_array($result)) {
        $mqty1 = 0;
        $mqty2 = 0;
        $mdate1 = "";
        $mdate2 = "";
        $tb .= "<td>" . $row['stk_no'] . "</td>";

        $sql = "select * from s_mas where stk_no ='" . $row['stk_no'] . "'";
        $result1 = mysqli_query($GLOBALS['dbinv'], $sql);
        if ($row1 = mysqli_fetch_array($result1)) {
            $tb .= "<td>" . $row1['DESCRIPT'] . "</td>";
        }

        $sql = "select sdate from battry_inv where rep='" . $rep . "' and c_code='" . trim($_GET["c_code"]) . "' group by sdate order by sdate desc limit 2";
        $result1 = mysqli_query($GLOBALS['dbinv'], $sql);
        while ($row1 = mysqli_fetch_array($result1)) {

            $sql = "select qty from battry_inv where rep='" . $rep . "' and c_code='" . trim($_GET["c_code"]) . "' and stk_no = '" . $row['stk_no'] . "' and sdate = '" . $row1['sdate'] . "'";
            $result2 = mysqli_query($GLOBALS['dbinv'], $sql);

            if ($row2 = mysqli_fetch_array($result2)) {
                $tb .= "<td align='right'>" . $row2['qty'] . "</td>";
            } else {
                $tb .= "<td align='right'>-</td>";
            }

            if ($mdate1 != "" and $mdate2 == "") {
                $mdate2 = $row1['sdate'];
                $mqty2 = $row2['qty'];
            }

            if ($mdate1 == "") {
                $mdate1 = $row1['sdate'];
                $mqty1 = $row2['qty'];
            }
        }

        if ($mdate1 == "") {
            $mdate1 = $date1;
        }
        if ($mdate2 == "") {
            $mdate2 = $date2;
        }

        $sql = "select sum(qty) as qty from view_salma_invo_smas where sal_ex='" . $rep . "' and c_code='" . trim($_GET["c_code"]) . "' and stk_no = '" . $row['stk_no'] . "' and deli_Date>'" . $mdate2 . "' and deli_Date<'" . $mdate1 . "'";

        $result2 = mysqli_query($GLOBALS['dbinv'], $sql);
        if ($row2 = mysqli_fetch_array($result2)) {
            $tb .= "<td align='right'>" . $row2['qty'] . "</td>";
            $tb .= "<td align='right'>" . (($row2['qty'] + $mqty2) - ($mqty1)) . "</td>";
        } else {
            $tb .= "<td align='right'>-</td>";
        }


        $tb .= "</tr>";
    }

    $tb .= "</table>";

    echo $tb;
}
?>