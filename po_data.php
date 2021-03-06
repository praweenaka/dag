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

    $invno = getno();

    $sql = "Select ARN from tmpinvpara_acc";
    $result = $conn->query($sql);
    $row = $result->fetch();

    $tono = $row['ARN'];

    $sql = "delete from tmp_po_data where tmp_no='" . $tono . "'";
    $result = $conn->query($sql);

    $sql = "update tmpinvpara_acc set ARN=ARN+1";
    $result = $conn->query($sql);


    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";
    $ResponseXML .= "<invno><![CDATA[" . $invno . "]]></invno>";
    $ResponseXML .= "<tmpno><![CDATA[" . $tono . "]]></tmpno>";
    $ResponseXML .= "<dt><![CDATA[" . date('Y-m-d') . "]]></dt>";

    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}

function getno() {

    include './connection_sql.php';
    $sql = "select ARN from invpara";
    $result = $conn->query($sql);
    $row = $result->fetch();
    $tmpinvno = "000000" . $row["ARN"];
    $lenth = strlen($tmpinvno);
    return $invno = trim("ARN/") . substr($tmpinvno, $lenth - 7);
}

if ($_GET["Command"] == "setitem") {

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";


    $sql = "delete from tmp_po_data where stk_no='" . $_GET['itemCode'] . "' and tmp_no='" . $_GET['tmpno'] . "' ";
    $result = $conn->query($sql);
    if ($_GET["Command1"] == "add_tmp") {
        $rate = $_GET['rate'];
        $qty = str_replace(",", "", $_GET["qty"]);

        $discount = 0;
        $subtotal = $rate * $qty;

        $sql = "Insert into tmp_po_data (stk_no, descript, qty, rate,subtot, tmp_no,selling,whprice)values 
        ('" . $_GET['itemCode'] . "', '" . $_GET['itemDesc'] . "'," . $_GET['qty'] . ", " . $_GET['rate'] . ",'" . $subtotal . "','" . $_GET['tmpno'] . "','" . $_GET['selling'] . "','" . $_GET['whprice'] . "') ";
        $result = $conn->query($sql);
    }

    $ResponseXML .= "<sales_table><![CDATA[<table class=\"table table-bordered\">
    ";

    $i = 1;
    $mtot = 0;
    $sql = "Select * from tmp_po_data where tmp_no='" . $_GET['tmpno'] . "'";
    foreach ($conn->query($sql) as $row) {

        $ResponseXML .= "<tr>                              
        <td style=\"width: 120px;\">" . $row['stk_no'] . "</td>
        <td style=\"width: 380px;\">" . $row['descript'] . "</td>
        <td style=\"width: 120px;\">" . $row['qty'] . "</td>
        <td style=\"width: 120px;\">" . $row['rate'] . "</td>
        <td style=\"width: 120px;\">" . $row['selling'] . "</td>
        <td style=\"width: 120px;\">" . $row['whprice'] . "</td>
        <td style=\"width: 120px;\">" . $row['subtot']  . "</td>
        <td style=\"width: 100px;\"><button   onClick=\"del_item('" . $row['stk_no'] . "')\" type=\"button\" class=\"btn btn-danger btnDelete btn-sm\">Remove</button> </td>
        
        </tr>";

        $mtot = $mtot + $row['subtot'];
        $i = $i + 1;
    }



    $ResponseXML .= "   </table>]]></sales_table>";

    $ResponseXML .= "<item_count><![CDATA[" . $i . "]]></item_count>"; 
    $ResponseXML .= "<subtot><![CDATA[" . number_format($mtot, 2, ".", ",") . "]]></subtot>";
    $ResponseXML .= "</salesdetails>";

    echo $ResponseXML;
}

if ($_POST["Command"] == "save_item") {
    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->beginTransaction();

        $sql_invpara = "SELECT * from invpara";

        $result_invpara = $conn->query($sql_invpara);
        $row_invpara = $result_invpara->fetch();

        $vatrate = $row_invpara["vatrate"];

        $sql = "select * from s_purmas where REFNO='" . $_POST["invno"] . "'";
        $result = $conn->query($sql);
        if ($row = $result->fetch()) {
            echo "AR Number Already Exists";
            exit();
        }else {
            $sql1 = "insert into c_bal(REFNO, SDATE, CUSCODE, AMOUNT, BALANCE, Cancell, trn_type, vatrate, totpay,tmp_no) values ('" . $_POST["invno"] . "', '" . $_POST["invdate"] . "', '" . $_POST["c_code"] . "', '" . $_POST["total_value"] . "', '" . $_POST["total_value"] . "',  '0', 'ARN', '" . $vatrate . "', 0, '" . $_POST["tmpno"] . "')";
            $conn->exec($sql1);

            $sql1 = "insert into s_purmas(REFNO, SDATE, SUP_CODE, SUP_NAME, AMOUNT, PUR_DATE, tmp_no,LCNO,DEPARTMENT) values ('" . $_POST["invno"] . "', '" . $_POST["invdate"] . "', '" . $_POST["c_code"] . "', '" . $_POST["c_name"] . "',  '" . $_POST["total_value"] . "', '" . $_POST["invdate"] . "', '" . $_POST["tmpno"] . "','" . $_POST['lc_no'] . "','" . $_POST['department'] .  "')"; 
            $conn->exec($sql1);
            


            $sql = "select * from tmp_po_data where tmp_no='" . $_POST["tmpno"] . "'"; 
            foreach ($conn->query($sql) as $row) {

                $sql121 = "insert into s_purtrn(REFNO, SDATE, STK_NO, DESCRIPT,acc_cost, COST, REC_QTY, O_QTY, vatrate, CANCEL,DEPARTMENT,SELLING,whprice) values"
                . " ('" . $_POST["invno"] . "', '" . $_POST["invdate"] . "', '" . $row['stk_no'] . "', '" . $row['descript'] . "'," . $row['rate'] . ", " . $row['rate'] . ", " . $row['qty'] . "," . $row['qty'] . ",'" . $vatrate . "','0','" . $_POST['department'] .  "','" . $row['selling'] .  "','" . $row['whprice'] .  "')";

                $conn->exec($sql121);


                $sql3 = "select * from s_submas where STK_NO='" . $row['stk_no'] . "' and STO_CODE='" . $_POST["department"] . "'";
                $result3 = $conn->query($sql3);

                if ($row3 = $result3->fetch()) {
                    $sql = "update s_submas set  QTYINHAND=QTYINHAND+" . $row['qty'] . " where  STK_NO='" . $row['stk_no'] . "' and sto_code='" . $_POST['department'] . "'";
                    $conn->exec($sql);
                } else {

                    $sql1 = "insert into s_submas(STO_CODE, STK_NO, DESCRIPt, QTYINHAND) values ('" . $_POST['department'] . "','" . $row['stk_no'] . "','" . $row['descript'] . "'," . $row['qty'] . ")";
                    $conn->exec($sql1);
                }

                $sql1 = "update s_mas set  QTYINHAND=QTYINHAND+" . $row['qty'] . ",COST=" . $row['rate'] . ",SELLING=" . $row['selling'] . ",whprice=" . $row['whprice'] . ",AR_selling=" . $row['rate'] . " where  STK_NO='" . $row['stk_no'] . "'";
                $conn->exec($sql1);



                $sql12 = "insert into s_trn(STK_NO, SDATE, QTY, LEDINDI, REFNO,DEPARTMENT) values "
                . "('" . $row['stk_no'] . "', '" . $_POST["invdate"] . "', '" . $row['qty'] . "', 'ARN', '" . $_POST["invno"] . "','" . $_POST['department']  . "')";
                $conn->exec($sql12);

            }

            $sql = "delete from tmp_po_data where tmp_no='" . $_POST["tmpno"] . "'";
            $result = $conn->query($sql);


            $sql1 = "update invpara set ARN=ARN+1";
            $conn->exec($sql1);

            $conn->commit();
            echo "Saved";

        }

    } catch (Exception $e) {
        $conn->rollBack();
        echo $e;
    }
}




if ($_GET["Command"] == "pass_rec") {

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";
    $sql = "Select * from s_purmas where REFNO='" . $_GET['refno'] . "'";
    $result = $conn->query($sql);

    if ($row = $result->fetch()) {
        $ResponseXML .= "<C_REFNO><![CDATA[" . $row["REFNO"] . "]]></C_REFNO>";
        $ResponseXML .= "<C_DATE><![CDATA[" . $row["SDATE"] . "]]></C_DATE>";
        $ResponseXML .= "<C_CODE><![CDATA[" . $row["SUP_CODE"] . "]]></C_CODE>";
        $ResponseXML .= "<name><![CDATA[" . $row["SUP_NAME"] . "]]></name>"; 
        $ResponseXML .= "<txt_remarks><![CDATA[" . $row["REMARK"] . "]]></txt_remarks>";
        $ResponseXML .= "<amount><![CDATA[" . $row["AMOUNT"] . "]]></amount>";
        
        
        
        $ResponseXML .= "<lc_no><![CDATA[" . $row["LC_No"] . "]]></lc_no>";
        $ResponseXML .= "<department><![CDATA[" . $row["DEPARTMENT"] . "]]></department>";
        
        $ResponseXML .= "<tmp_no><![CDATA[" . $row["tmp_no"] . "]]></tmp_no>";
        $msg = "";
        if ($row['CANCEL'] == "1") {
            $msg = "Cancelled";
        }
        $ResponseXML .= "<msg><![CDATA[" . $msg . "]]></msg>";

        $sql = "delete from tmp_po_data where tmp_no='" . $row["tmp_no"] . "'";
        $result = $conn->query($sql);




        $ResponseXML .= "<sales_table><![CDATA[<table class=\"table table-bordered\">
        <tr>
        <td style=\"width: 120px;\">Item</td>
        <td style=\"width: 380px;\">Description</td>
        <td style=\"width: 120px;\">Qty</td>
        <td style=\"width: 120px;\">Cost</td>
        <td style=\"width: 120px;\">RETAIL</td>
        <td style=\"width: 120px;\">Wholesale</td>
        <td style=\"width: 120px;\">Sub Total</td>

        <td style=\"width: 100px;\"></td>
        </tr>";

        $i = 1;
        $mtot = 0;
        $sql = "Select * from s_purtrn where REFNO='" . $row["REFNO"]. "'";
        foreach ($conn->query($sql) as $row1) {

           $ResponseXML .= "<tr>                              
           <td>" . $row1['STK_NO'] . "</td>
           <td>" . $row1['DESCRIPT'] . "</td>
           <td>" . number_format($row1['REC_QTY'], 2, ".", ",") . "</td>
           <td>" . number_format($row1['COST'], 2, ".", ",") . "</td>  
           <td>" . number_format($row1['SELLING'], 2, ".", ",") . "</td>  
            <td>" . number_format($row1['whprice'], 2, ".", ",") . "</td>  
           <td>" . number_format($row1['COST']*$row1['REC_QTY'], 2, ".", ",") . "</td>  
           </tr>";
       }

       $mtot1 = 0;


       $ResponseXML .= "   </table>]]></sales_table>";

       $ResponseXML .= "<item_count><![CDATA[" . $i . "]]></item_count>";

   }




   $ResponseXML .= "</salesdetails>";
   echo $ResponseXML;
}


 



if ($_GET["Command"] == "del_inv") {

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";
    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->beginTransaction();

        $sql = "select REFNO,amount,balance,cancell from c_bal where REFNO ='" . $_GET['refno'] . "'";
        $result = $conn->query($sql);
        if ($row = $result->fetch()) {
            if ($row['cancell'] != "0") {
                echo "Already Cancelled";
                exit();
            }

            if ($row['amount'] != $row['balance']) {
                echo "Already Paid";
                exit();
            } else {

                $sql = "update s_purmas set cancel='1' where refno = '" . $row['REFNO'] . "'";
                $conn->exec($sql);


                $sql = "select * from s_purtrn where REFNO ='" . $row['REFNO'] . "'";
                foreach ($conn->query($sql) as $row1) {
                    $sql = "update s_mas set  QTYINHAND=QTYINHAND-" . $row1["REC_QTY"] . " where  STK_NO='" . $row1["STK_NO"] . "'";
                    $conn->exec($sql);

                    $sql = "update s_submas set  QTYINHAND=QTYINHAND-" . $row1["REC_QTY"] . " where  STK_NO='" . $row1["STK_NO"] . "' and sto_code='" . $row1['DEPARTMENT'] . "'";
                    $conn->exec($sql);
                }


                $sql = "update s_purtrn set cancel='1' where refno = '" . $row['REFNO'] . "'";
                $conn->exec($sql);

                $sql = "delete from s_trn where REFNO = '" . $row['REFNO'] . "'";
                $conn->exec($sql);


                $sql = "delete from c_bal where REFNO = '" . $row['REFNO'] . "'";
                $conn->exec($sql);

                $conn->commit();
                echo "ok";
            }
        } else {
            echo "Entry Not Found";
        }
    } catch (Exception $e) {
        $conn->rollBack();
        echo $e;
    }
}



if ($_GET["Command"] == "pass_itno") {
  header('Content-Type: text/xml');
  echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";


  $ResponseXML = "";
  $ResponseXML .= "<salesdetails>";



  $sql = "Select * from s_mas where stk_no='" . $_GET['itno'] . "'";
  $result = $conn->query($sql);
  if ($row = $result->fetch()) {


    $ResponseXML .= "<str_code><![CDATA[" . $row['STK_NO'] . "]]></str_code>";
    $ResponseXML .= "<str_description><![CDATA[" . $row['DESCRIPT'] . "]]></str_description>";
    $ResponseXML .= "<cost><![CDATA[" . $row['COST'] . "]]></cost>";
    $ResponseXML .= "<actual_selling><![CDATA[" . $row['SELLING'] . "]]></actual_selling>";
     $ResponseXML .= "<wholesale><![CDATA[" . $row['whprice'] . "]]></wholesale>";


    $sql_s = "select * from s_submas where STK_NO ='" . $_GET['itno'] . "' and STO_CODE = '" . $_GET['from_dep'] . "'"; 
    $resulst = $conn->query($sql_s);
    if ($rows = $resulst->fetch()) {

      $ResponseXML .= "<qtyinhand><![CDATA[" . $rows['QTYINHAND'] . "]]></qtyinhand>"; 
    }else{
      $ResponseXML .= "<qtyinhand><![CDATA[0]]></qtyinhand>"; 
    }


  }




  $ResponseXML .= "</salesdetails>";
  echo $ResponseXML;
}


if ($_GET["Command"] == "pass_cus") {
    $_SESSION["custno"] = $_GET['custno'];

    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $cuscode = $_GET["custno"]; 

    $sql = "Select * from vendor where   CODE ='" . $cuscode . "'";
    $result = $conn->query($sql);

    if ($rowM = $result->fetch()) {
        $ResponseXML .= "<id><![CDATA[" . json_encode($rowM) .  "]]></id>";
    }

    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}


?>