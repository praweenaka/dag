<?php

session_start();

////////////////////////////////////////////// Database Connector /////////////////////////////////////////////////////////////
require_once ("connection_sql.php");

////////////////////////////////////////////// Write XML ////////////////////////////////////////////////////////////////////
header('Content-Type: text/xml');

date_default_timezone_set('Asia/Colombo');

/////////////////////////////////////// GetValue //////////////////////////////////////////////////////////////////////////
///////////////////////////////////// Registration /////////////////////////////////////////////////////////////////////////

if ($_GET["Command"] == "new_inv") {

    $sql = "select GIN from invpara";
    $result = $conn->query($sql);
    $row = $result->fetch();
    $tmpinvno = "000000" . $row["GIN"];
    $lenth = strlen($tmpinvno);
    $invno = trim("GIN/") . substr($tmpinvno, $lenth - 8);

    $sql = "Select QTNNO from tmpinvpara";
    $result = $conn->query($sql);
    $row = $result->fetch();

    $tono = $row['QTNNO'];

    $sql = "delete from tmp_gin_data_multi where tmp_no='" . $tono . "'";
    $result = $conn->query($sql);

    $sql = "update tmpinvpara set QTNNO=QTNNO+1";
    $result = $conn->query($sql);


    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";
    $ResponseXML .= "<invno><![CDATA[" . $invno . "]]></invno>";
    $ResponseXML .= "<tmpno><![CDATA[" . $tono . "]]></tmpno>";
    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}


if($_GET["Command"]=="update")
{
   try {
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->beginTransaction();
    $sql="update s_ginmas  set AR_DATE='" . $_GET["DTARdate"] . "', AR_NO='" . $_GET["txtarno"] . "' where  tmp_no ='" . $_GET['tmpno'] . "'"; 
    $result1 = $conn->query($sql);
    $conn->commit();
    echo "ok";
} catch (Exception $e) {
    $conn->rollBack();
    echo $e;
}
}


if ($_GET["Command"] == "add_tmp") {


    if ($_GET["tmpno"] == "") {
        exit("Error");
    }


    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $sql = "delete from tmp_gin_data_multi where dep_from ='" . $_GET['from_dep'] . "' and str_code='" . $_GET['itemCode'] . "' and tmp_no='" . $_GET['tmpno'] . "' ";
    $result = $conn->query($sql);

    $qty = str_replace(",", "", $_GET["qty"]);



    $sql = "Insert into tmp_gin_data_multi (dep_from,str_invno, str_code, str_description, cur_qty, tmp_no, user_id)values 
    ('" . $_GET['from_dep'] . "','" . $_GET['invno'] . "', '" . $_GET['itemCode'] . "', '" . $_GET['itemDesc'] . "', " . $qty . ", '" . $_GET["tmpno"] . "', '" . $_SESSION["CURRENT_USER"] . "') ";
    $result = $conn->query($sql);
    if (!$result) {
        echo $sql . "<br>";
        echo mysqli_error($GLOBALS['dbinv']);
    }

    $ResponseXML .= "<sales_table><![CDATA[<table class=\"table\">
    <tr>
    <td style=\"width: 90px;\">From Dep</td>
    <td style=\"width: 40px;\">Item</td>
    <td style=\"width: 220px;\">Description</td>
    <td style=\"width: 50px;\">Qty</td>
    <td style=\"width: 10px;\"></td>
    </tr>";

    $i = 1;
    $sql = "Select * from view_tmp_gin where tmp_no='" . $_GET['tmpno'] . "'";
    $result = $conn->query($sql);
    foreach ($conn->query($sql) as $row) {

        $ResponseXML .= "<tr>                              
        <td>" . $row['dep_from'] . " " . $row['DESCRIPTION'] . "</td>
        <td>" . $row['str_code'] . "</td>
        <td>" . $row['str_description'] . "</td>
        <td>" . number_format($row['cur_qty'], 0, ".", ",") . "</td>
        <td><a class=\"btn btn-danger btn-sm\" onClick=\"del_item('" . $row['id'] . "')\"> <span class='fa fa-remove'></span></a></td>
        </tr>";
        $i = $i + 1;
    }

    $ResponseXML .= "</table>]]></sales_table>";
    $ResponseXML .= "<item_count><![CDATA[" . $i . "]]></item_count>";
    $ResponseXML .= "</salesdetails>";

    echo $ResponseXML;
}

if ($_GET["Command"] == "del_item") {

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $sql = "delete from tmp_gin_data_multi where id='" . $_GET['code'] . "' and tmp_no='" . $_GET['tmpno'] . "'";
    $result = $conn->query($sql);

    $ResponseXML .= "<sales_table><![CDATA[<table class=\"table\">
    <tr>
    <td style=\"width: 90px;\">From Dep</td>
    <td style=\"width: 40px;\">Item</td>
    <td style=\"width: 220px;\">Description</td>
    <td style=\"width: 50px;\">Qty</td>
    <td style=\"width: 10px;\"></td>
    </tr>";

    $i = 1;
    $sql = "Select * from view_tmp_gin where tmp_no='" . $_GET['tmpno'] . "'";
    $result = $conn->query($sql);
    foreach ($conn->query($sql) as $row) {

        $ResponseXML .= "<tr>                              
        <td>" . $row['dep_from'] . " " . $row['DESCRIPTION'] . "</td>
        <td>" . $row['str_code'] . "</td>
        <td>" . $row['str_description'] . "</td>
        <td>" . number_format($row['cur_qty'], 0, ".", ",") . "</td>
        <td><a class=\"btn btn-danger btn-sm\" onClick=\"del_item('" . $row['id'] . "')\"> <span class='fa fa-remove'></span></a></td>
        </tr>";
        $i = $i + 1;
    }

    $ResponseXML .= "</table>]]></sales_table>";

    $ResponseXML .= "<item_count><![CDATA[" . $i . "]]></item_count>";


    $ResponseXML .= "</salesdetails>";

    echo $ResponseXML;
}

if ($_GET["Command"] == "save_item") {


    if ($_GET["tmpno"] == "") {
        exit("Error");
    }

    $sql = "select * from s_ginmas where tmp_no = '" . $_GET["tmpno"] . "'";
    $result = $conn->query($sql);
    if ($row = $result->fetch()) {
        exit("Error");
    }

    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->beginTransaction();

        $idate = date('Y-m-d');

        $sql2 = "select * from s_stomas where CODE='" . $_GET["to_dep"] . "' ";
        $result1 = $conn->query($sql2);
        $row1 = $result1->fetch();
        $DESCRIPTION_to = $row1["DESCRIPTION"];



        $sql = "select dep_from,str_code,cur_qty from tmp_gin_data_multi where tmp_no='" . $_GET["tmpno"] . "' group by dep_from";
        foreach ($conn->query($sql) as $row) {

            $sqlsub1 = "Select * from s_submas where STK_NO='" . $row["str_code"] . "' and QTYINHAND<'".$row['cur_qty']."' and STO_CODE='" . $_GET["from_dep"] . "'"; 
            $resultsub1 = $conn->query($sqlsub1);
            if ($rowsub1 = $resultsub1->fetch()) {
                exit('Under Stock');
            }

            $sql = "select GIN from invpara";
            $result1 = $conn->query($sql);
            $row1 = $result1->fetch();
            $tmpinvno = "000000" . $row1["GIN"];
            $lenth = strlen($tmpinvno);
            $invno = trim("GIN/") . substr($tmpinvno, $lenth - 8);

            $sql2 = "select * from s_stomas where CODE='" . trim($row['dep_from']) . "' ";
            $result2 = $conn->query($sql2);
            $row2 = $result2->fetch();
            $DESCRIPTION_from = $row2["DESCRIPTION"];


            $sql1 = "insert into s_ginmas(SDATE, REF_NO, DEP_FROM, DEP_F_NAME, DEP_TO, DEP_T_NAME, tmp_no,del_to) values
            ('" . $idate . "', '" . $invno . "', '" . $row['dep_from'] . "', '" . $DESCRIPTION_from . "', '" . $_GET["to_dep"] . "', '" . $DESCRIPTION_to . "', '" . $_GET["tmpno"] . "','M')";
            $result2 = $conn->query($sql1);

            $sql = "select * from tmp_gin_data_multi where tmp_no='" . $_GET["tmpno"] . "' and dep_from = '" . $row['dep_from'] . "'";
            foreach ($conn->query($sql) as $row1) {

                $cur_qty = str_replace(",", "", $row1["cur_qty"]);

                $sqlsub = "Select * from s_submas where STK_NO='" . $row1["str_code"] . "' and STO_CODE='" . $_GET["to_dep"] . "'";
                $resultsub = $conn->query($sqlsub);
                if ($rowsub = $resultsub->fetch()) {
                    $sql1 = "update s_submas set QTYINHAND=QTYINHAND+" . $cur_qty . " where STK_NO='" . $row1["str_code"] . "' and STO_CODE='" . $_GET["to_dep"] . "'";
                    $result1 = $conn->query($sql1);
                } else {
                    $sql1 = "insert into s_submas(STO_CODE, STK_NO, DESCRIPt, OPEN_STK, QTYINHAND) values ('" . $_GET["to_dep"] . "',  '" . $row1["str_code"] . "', '" . $row1["str_description"] . "', 0, " . $cur_qty . ")";
                    $result1 = $conn->query($sql1);
                }

                $sql1 = "update s_submas set QTYINHAND=QTYINHAND-" . $cur_qty . " where STK_NO='" . $row1["str_code"] . "' and STO_CODE='" . $row['dep_from'] . "'";
                $result1 = $conn->query($sql1);

                $sql1 = "insert into s_trn(STK_NO, SDATE, QTY, LEDINDI, REFNO, DEPARTMENT, seri_no, Dev, SAL_EX, ACTIVE, DONO) values 
                ('" . $row1["str_code"] . "', '" . $idate . "', '" . $cur_qty . "', 'GINI', '" . $invno . "', '" . $row['dep_from'] . "', '', '" . $_SESSION['dev'] . "', '', '1', '')";
                $result1 = $conn->query($sql1);

                $sql1 = "insert into s_trn(STK_NO, SDATE, QTY, LEDINDI, REFNO, DEPARTMENT, seri_no, Dev, SAL_EX, ACTIVE, DONO) values
                ('" . $row1["str_code"] . "', '" . $idate . "', '" . $cur_qty . "', 'GINR', '" . $invno . "', '" . $_GET["to_dep"] . "', '', '" . $_SESSION['dev'] . "', '', '1', '')";
                $result1 = $conn->query($sql1);
            }

            $sql1 = "update invpara set GIN=GIN+1";
            $result1 = $conn->query($sql1);

            $sql2 = "insert into entry_log(refno, username, docname, trnType, stime, sdate) values ('" . $invno . "', '" . $_SESSION["CURRENT_USER"] . "', 'GIN', 'SAVE', '" . date("Y-m-d H:i:s") . "', '" . date("Y-m-d") . "')";
            $result = $conn->query($sql2);
        }

        $conn->commit();
        echo "Saved";
    } catch (Exception $e) {
        $conn->rollBack();
        echo $e;
    }
}


if ($_GET["Command"] == "del_inv") {

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";
    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->beginTransaction();

        $sql = "select REF_NO,cancel from s_ginmas where tmp_no ='" . $_GET['tmpno'] . "'";
        $result = $conn->query($sql);
        if ($row = $result->fetch()) {
            if ($row['cancel'] != "0") {
                echo "Not Found";
                exit();
            } else {


                $sql = "select REF_NO , dep_to from s_ginmas where tmp_no ='" . $_GET['tmpno'] . "'";
                foreach ($conn->query($sql) as $row1) {

                    $sql = "select * from s_trn where REFNO='" . $row1["REF_NO"] . "' and LEDINDI='GINR'";


                    foreach ($conn->query($sql) as $row) {
                        $sql1 = "update s_submas set QTYINHAND=QTYINHAND-" . $row["QTY"] . " where STK_NO='" . $row["STK_NO"] . "' and STO_CODE='" . $row["DEPARTMENT"] . "'";
                        $result1 = $conn->query($sql1);
                    }


                    $sql = "select * from s_trn where REFNO='" . $row1["REF_NO"] . "' and LEDINDI='GINI'";

                    foreach ($conn->query($sql) as $row) {
                        $sql1 = "update s_submas set QTYINHAND=QTYINHAND+" . $row["QTY"] . " where STK_NO='" . $row["STK_NO"] . "' and STO_CODE='" . $row["DEPARTMENT"] . "'";
                        $result1 = $conn->query($sql1);
                    }

                    $sql1 = "delete from s_trn where REFNO='" . $row1["REF_NO"] . "'";
                    $result1 = $conn->query($sql1);


                    $sql1 = "update  s_ginmas set cancel='1' where tmp_no ='" . $_GET['tmpno'] . "'";
                    $result1 = $conn->query($sql1);
                }




                echo "ok";

                $conn->commit();
            }
        } else {
            echo "Entry Not Found";
        }
    } catch (Exception $e) {
        $conn->rollBack();
        echo $e;
    }
}






if ($_GET["Command"] == "gin") {

    //$department=$_GET["department"];

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";


    $sql1 = "delete from tmp_gin_data_multi where tmp_no='" . $_GET["invno"] . "'";
    $result1 = $conn->query($sql1);

    $sql = "select * from s_ginmas where tmp_no='" . $_GET['invno'] . "' ";

    foreach ($conn->query($sql) as $row) {

        $dep_to = $row['DEP_TO'];

        $sql1 = "select * from s_trn where REFNO='" . $row['REF_NO'] . "' and LEDINDI='GINI'";

        foreach ($conn->query($sql1) as $row1) {

            $sql3 = "select * from s_mas where STK_NO='" . $row1['STK_NO'] . "'";
            $result3 = $conn->query($sql3);
            $row3 = $result3->fetch();

            $sql2 = "Insert into tmp_gin_data_multi (dep_from,str_invno, str_code, str_description, cur_qty, tmp_no, user_id)values 
            ('" . $row1['DEPARTMENT'] . "','" . $row['REF_NO'] . "', '" . $row1['STK_NO'] . "', '" . $row3['DESCRIPT'] . "', " . $row1["QTY"] . ", '" . $_GET["invno"] . "', '" . $_SESSION["CURRENT_USER"] . "') ";
            //echo $sql2;
            $result = $conn->query($sql2);
        }
    }


    $ResponseXML .= "<sales_table><![CDATA[<table class=\"table\">
    <tr>
    <td style=\"width: 90px;\">From Dep</td>
    <td style=\"width: 40px;\">Item</td>
    <td style=\"width: 220px;\">Description</td>
    <td style=\"width: 50px;\">Qty</td>
    <td style=\"width: 10px;\"></td>
    </tr>";

    $i = 1;
    $sql = "Select * from view_tmp_gin where tmp_no='" . $_GET['invno'] . "'";
    $result = $conn->query($sql);
    foreach ($conn->query($sql) as $row) {

        $ResponseXML .= "<tr>                              
        <td>" . $row['dep_from'] . " " . $row['DESCRIPTION'] . "</td>
        <td>" . $row['str_code'] . "</td>
        <td>" . $row['str_description'] . "</td>
        <td>" . number_format($row['cur_qty'], 0, ".", ",") . "</td>
        <td>" . $row['str_invno'] . "</td>
        </tr>";
        $i = $i + 1;
    }


    $ResponseXML .= "   </table>]]></sales_table>";




    $ResponseXML .= "<tmp_no><![CDATA[" . $_GET['invno'] . "]]></tmp_no>";
    $ResponseXML .= "<to_dep><![CDATA[" . $dep_to . "]]></to_dep>";
    $ResponseXML .= " </salesdetails>";
    echo $ResponseXML;
}
?>