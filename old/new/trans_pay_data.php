<?php

session_start();

////////////////////////////////////////////// Database Connector /////////////////////////////////////////////////////////////
require_once ("connection_sql.php");

////////////////////////////////////////////// Write XML ////////////////////////////////////////////////////////////////////
header('Content-Type: text/xml');

date_default_timezone_set('Asia/Colombo');
 
if ($_GET["Command"] == "new_inv") {

    $sql = "select trans_pay from invpara";
    $result = $conn->query($sql);
    $row = $result->fetch();
    $invno = "000000" . ($row["trans_pay"]); 
  
    $_SESSION["trans_user"]="";
    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";
    $ResponseXML .= "<invno><![CDATA[" . $invno . "]]></invno>"; 
    $ResponseXML .= "<sdate><![CDATA[" . date("Y-m-d") . "]]></sdate>";
    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}

if ($_GET["Command"] == "saveinv") {

    try {
         $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->beginTransaction();

        $sqlisalma_q = "select * from s_salma where trans_no='" . $_GET["ref_no"] . "'";
        $resultsalma_q = $conn->query($sqlisalma_q);
        if ($rowsalma_q = $resultsalma_q->fetch()) {
            $conn->rollBack();
            exit("TransportPay   No Already Exist !!!");
        }

        $sql = "select * from tmp_trans_pay where ref_no='" . $_GET["ref_no"] . "'"; 
        foreach ($conn->query($sql) as $rowtmp) {
           //  $sql = "Insert into trans_pay_item (ref_no,invno, invdate, transamou, transthtamou, type, remark,code,sdate,name)values 
           //  ('" . $rowtmp['ref_no'] . "','" . $rowtmp['invno'] . "', '" . $rowtmp['invdate'] . "', '" . $rowtmp['transamou'] . "', '" . $rowtmp["transthtamou"] . "', '" . $rowtmp['type'] . "', '" . $rowtmp['remark'] . "','" . $rowtmp['code'] . "','" . $_GET["sdate"] . "','" . $rowtmp["name"] . "') ";
           // $result = $conn->query($sql);
            $sql = "update s_salma set transamou = '" . $rowtmp['transamou'] . "',trans_thtamou = '" . $rowtmp['transthtamou'] . "',trans_type = '" . $rowtmp['type'] . "',trans_remark = '" . $rowtmp['remark'] . "',trans_no = '" . $_GET["ref_no"] . "',transdate='".$_GET["sdate"]."' where REF_NO='" . $rowtmp['invno'] . "' and CANCELL='0'"; 
            $res_inv = $conn->query($sql);
        }

        $sql = "delete from tmp_trans_pay where ref_no='" . $_GET['ref_no'] . "' ";
        $result = $conn->query($sql);

        $sql = "update invpara set trans_pay = trans_pay +1";
        $res_inv = $conn->query($sql);

        $sql2 = "insert into entry_log(refno, username, docname, trnType, stime, sdate) values ('" . $_GET['ref_no'] . "', '" . $_SESSION["CURRENT_USER"] . "', 'TransportPay', 'Save', '" . date("Y-m-d H:i:s") . "', '" . date("Y-m-d") . "')";
                $result2 = $conn->query($sql2);
 

        echo "Updated";
        $conn->commit();
    } catch (Exception $e) {
        $conn->rollBack();
        echo $e;
    }
}  
 
 if ($_GET["Command"] == "pass_quot") {

    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $cuscode = $_GET["custno"]; 
    $sql = "Select * from s_salma where cancell='0' and  REF_NO='" . $cuscode . "' "; 
    $sql = $conn->query($sql);
    if ($row = $sql->fetch()) {
        $ResponseXML .= "<code><![CDATA[" . $row['REF_NO'] . "]]></code>";
        $ResponseXML .= "<date><![CDATA[" . $row['SDATE'] . "]]></date>"; 
        $ResponseXML .= "<transamou><![CDATA[" . $row['transamou'] . "]]></transamou>"; 
    }
 
    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
 
}

 if ($_GET["Command"] == "pass_quot1") {

    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $cuscode = $_GET["custno"]; 
    $sql = "SELECT * from s_salma where trans_no='" . $cuscode . "' and cancell='0' and trans_cancell='0' and transamou!='0.00'  group by trans_no   ";  
    $sql = $conn->query($sql);
    if ($row = $sql->fetch()) {
        $ResponseXML .= "<trans_no><![CDATA[" . $row['trans_no'] . "]]></trans_no>";
        $ResponseXML .= "<code><![CDATA[" . $row['C_CODE'] . "]]></code>"; 
        $ResponseXML .= "<cusname><![CDATA[" . $row['CUS_NAME'] . "]]></cusname>"; 
        $ResponseXML .= "<transdate><![CDATA[" . $row['transdate'] . "]]></transdate>"; 
     
        $ResponseXML .= "<remtable><![CDATA[<table class='table table-hover'>";

        $sql = "SELECT * from s_salma where trans_no='" . $cuscode . "' and cancell='0' and trans_cancell='0' and transamou!='0.00'   "; 
        foreach ($conn->query($sql) as $row) {

            $ResponseXML .= "<tr>";
             $ResponseXML .= "<td style=\"width: 20px;\"><div></div></td>
                        <td style=\"width: 220px;\"><div>" . $row['REF_NO']. "</div></td>
                         <td style=\"width: 200px;\"><div>" .$row['SDATE']. "</div></td>
                         <td style=\"width: 200px;\"><div>" . number_format($row['transamou'], 2, ".", ",") . "</div> </td>
                         <td style=\"width: 200px;\"><div'>" . number_format($row['trans_thtamou'], 2, ".", ",") . "</div></td>
                         <td style=\"width: 200px;\"><div'>" . $row['trans_type']. "</div></td>
                         <td style=\"width: 200px;\"><div'>" . $row['trans_remark'] . "</div></td> ";                      
            $ResponseXML .= "</tr>";
        }

        $ResponseXML .= "</table>]]></remtable>";
    }
    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
 
}

if ($_GET["Command"] == "search_custom") {
    $ResponseXML = "";
    $ResponseXML .= "<table class=\"table\">
                <tr>
                        <th width=\"160\"  >Invoice No</th>
                    <th width=\"424\"  >Customer Code</th>
                    <th width=\"424\"  >Customer Name</th>
                    <th width=\"424\"  >Inv.Date</th>
                    <th width=\"300\"  >Address</th>
                    </tr>"; 
    if($_SESSION["trans_user"]==""){
         $sql = "SELECT * from s_salma where cancell='0' and REF_NO <> ''";
    }else{
         $sql = "SELECT * from s_salma where cancell='0' and C_CODE='".$_SESSION["trans_user"]."' and REF_NO <> ''";
    } 

    if ($_GET['cusno'] != "") {
        $sql .= " and REF_NO like '%" . $_GET['cusno'] . "%'";
    }
    if ($_GET['cusno1'] != "") {
        $sql .= " and C_CODE like '%" . $_GET['cusno1'] . "%'";
    }
    if ($_GET['date'] != "") {
        $sql .= " and CUS_NAME like '%" . $_GET['date'] . "%'";
    }
    $stname = $_GET['stname'];

    $sql .= " ORDER BY sdate desc limit  50";
      
    foreach ($conn->query($sql) as $row) {
        $cuscode = $row["REF_NO"];

        if($row['transamou']=="0.00"){
            $stname="NotPaid";
             $ResponseXML .= "<tr>               
                              <td onclick=\"custno('$cuscode', '$stname');\">" . $row['REF_NO'] . "</a></td>
                              <td onclick=\"custno('$cuscode', '$stname');\">" . $row['C_CODE'] . "</a></td>
                              <td onclick=\"custno('$cuscode', '$stname');\">" . $row['CUS_NAME'] . "</a></td>
                              <td onclick=\"custno('$cuscode', '$stname');\">" . $row['SDATE'] . "</a></td>
                              <td onclick=\"custno('$cuscode', '$stname');\">" . $row['C_ADD1'] . "</a></td>
                            </tr>";
        }else{
             $stname="Paid";
            $ResponseXML .= "<tr  bgcolor=\"red\">               
                              <td onclick=\"custno('$cuscode', '$stname');\">" . $row['REF_NO'] . "</a></td>
                              <td onclick=\"custno('$cuscode', '$stname');\">" . $row['C_CODE'] . "</a></td>
                              <td onclick=\"custno('$cuscode', '$stname');\">" . $row['CUS_NAME'] . "</a></td>
                              <td onclick=\"custno('$cuscode', '$stname');\">" . $row['SDATE'] . "</a></td>
                              <td onclick=\"custno('$cuscode', '$stname');\">" . $row['C_ADD1'] . "</a></td>
                            </tr>"; 
        }
        
    }
    $ResponseXML .= "</table>";
    echo $ResponseXML;
}

if ($_GET["Command"] == "search_custom1") {
    $ResponseXML = "";
    $ResponseXML .= "<table class=\"table\">
                <tr>
                        <th width=\"160\"  >Ref No</th>
                    <th width=\"424\"  >Date</th> 
                    <th width=\"424\"  >Customer Code</th>
                    <th width=\"424\"  >Customer Name</th>
                    </tr>";   
     $sql = "SELECT * from s_salma where CANCELL='0' and trans_no <> ''";
    

    if ($_GET['cusno'] != "") {
        $sql .= " and trans_no like '%" . $_GET['cusno'] . "%'";
    }
    if ($_GET['cusno1'] != "") {
        $sql .= " and C_CODE like '%" . $_GET['cusno1'] . "%'";
    }
    if ($_GET['date'] != "") {
        $sql .= " and CUS_NAME like '%" . $_GET['date'] . "%'";
    }
    $stname = $_GET['stname'];

    $sql .= " group by trans_no limit  50";
      
    foreach ($conn->query($sql) as $row) {
        $cuscode = $row["trans_no"];

        $stname="transpay";
        $ResponseXML .= "<tr>               
                              <td onclick=\"custno('$cuscode', '$stname');\">" . $row['trans_no'] . "</a></td>
                              <td onclick=\"custno('$cuscode', '$stname');\">" . $row['transdate'] . "</a></td>
                              <td onclick=\"custno('$cuscode', '$stname');\">" . $row['C_CODE'] . "</a></td>
                              <td onclick=\"custno('$cuscode', '$stname');\">" . $row['CUS_NAME'] . "</a></td> 
                            </tr>";
    }
    $ResponseXML .= "</table>";
    echo $ResponseXML;
}

if ($_GET["Command"] == "add_tmp") {

    if ($_GET['Command1'] == "add") {
    
         $sql = "delete from tmp_trans_pay where invno='" . $_GET['invno'] . "' and ref_no='" . $_GET['ref_no'] . "' ";
        $result = $conn->query($sql);

        $sql = "Insert into tmp_trans_pay (ref_no,invno, invdate, transamou, transthtamou, type, remark,code,name)values 
            ('" . $_GET['ref_no'] . "','" . $_GET['invno'] . "', '" . $_GET['invdate'] . "', '" . $_GET['transamou'] . "', '" . $_GET["transthtamou"] . "', '" . $_GET['type'] . "', '" . $_GET['remark'] . "','" . $_GET['code'] . "','" . $_GET["name"] . "') ";

        $result = $conn->query($sql);
    }

    if ($_GET['Command1'] == "del") {

        $sql = "delete from tmp_trans_pay where invno='" . $_GET['invno'] . "' and ref_no='" . $_GET['ref_no'] . "' ";
        $result = $conn->query($sql);
    }
 

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>"; 
    $ResponseXML .= "<sales_table><![CDATA[ <table class=\"table\">";

    $i = 1; 
    $sql = "Select * from tmp_trans_pay where ref_no='" . $_GET['ref_no'] . "'";
    foreach ($conn->query($sql) as $row) {
 

         
        $ResponseXML .= "<td style=\"width: 20px;\"><div></div></td>
                        <td style=\"width: 220px;\"><div>" . $row['invno']. "</div></td>
                         <td style=\"width: 200px;\"><div>" .$row['invdate']. "</div></td>
                         <td style=\"width: 200px;\"><div>" . number_format($row['transamou'], 2, ".", ",") . "</div> </td>
                         <td style=\"width: 200px;\"><div'>" . number_format($row['transthtamou'], 2, ".", ",") . "</div></td>
                         <td style=\"width: 200px;\"><div'>" . $row['type']. "</div></td>
                         <td style=\"width: 200px;\"><div'>" . $row['remark'] . "</div></td>
                         <td><a class=\"btn btn-danger btn-xs\"  onClick=\"del_item('" . $row['invno'] . "');\"><span class='fa fa-remove'></a></td>";

        

        $ResponseXML .= "<td>" . $qty . "</td>
                        
                            
                             
                            </tr>";
        $i = $i + 1;
    }
    $ResponseXML .= "   </table>]]></sales_table>";
 
    $ResponseXML .= "<Command1><![CDATA[" . $_GET['Command1'] . "]]></Command1>";
  
    $ResponseXML .= " </salesdetails>";


    echo $ResponseXML;
}


if ($_GET["Command"] == "cancel_inv") {

 
    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->beginTransaction();

        $sql = "update s_salma set transamou = 0.00,trans_thtamou = 0.00,trans_type = '',trans_remark = 'Cancel',trans_cancell='1',trans_no = '',transdate=' and trans_cancell='0' where trans_no='" . $_GET['ref_no'] . "' and CANCELL='0'"; 
            $res_inv = $conn->query($sql);   

        $sql2 = "insert into entry_log(refno, username, docname, trnType, stime, sdate) values ('" . $_GET['ref_no'] . "', '" . $_SESSION["CURRENT_USER"] . "', 'TransportPay', 'Cancel', '" . date("Y-m-d H:i:s") . "', '" . date("Y-m-d") . "')";
                $result2 = $conn->query($sql2);

        echo "Canceled";
     } catch (Exception $e) {
        $conn->rollBack();
        echo $e;
    }
}
