<?php

session_start();


require_once ("connection_sql.php");
header('Content-Type: text/xml');
date_default_timezone_set('Asia/Colombo');


if ($_POST["Command"] == "forward") {
    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->beginTransaction();
        $sql = "SELECT * from c_bal where REFNO='" . $_POST['REFNO'] . "' and   trn_type='CNT' and block='1' and Cancell='0'"; 
        $sql = $conn->query($sql);
        if ($row = $sql->fetch()) {
            
            $sql = "UPDATE c_bal set block='2',app1='".$_SESSION["CURRENT_USER"].'-'.date('Y-m-d H:i:s')."' where REFNO='" . $_POST['REFNO'] . "'";
            $result = $conn->query($sql);


            $sql2 = "insert into entry_log(refno, username, docname, trnType, stime, sdate) values ('" . $_POST['REFNO'] . "', '" . $_SESSION["CURRENT_USER"] . "', 'CreditNote', 'forward', '" . date("Y-m-d H:i:s") . "', '" . date("Y-m-d") . "')";
            $result2 = $conn->query($sql2); 

            $conn->commit();
            echo "forward";
        } else {
            exit("Result Not Found...!!!");
        }
    } catch (Exception $e) {
        $conn->rollBack();
        echo $e;
    }
}

if ($_POST["Command"] == "approve") {
    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->beginTransaction();
        $sql = "SELECT * from c_bal where REFNO='" . $_POST['REFNO'] . "' and   trn_type='CNT' and block='2' and Cancell='0'"; 
        $sql = $conn->query($sql);
        if ($row = $sql->fetch()) {

            $sql = "UPDATE c_bal set block='0',app2='".$_SESSION["CURRENT_USER"].'-'.date('Y-m-d H:i:s')."' where REFNO='" . $_POST['REFNO'] . "'";
            $result = $conn->query($sql);

            $sql2 = "insert into entry_log(refno, username, docname, trnType, stime, sdate) values ('" . $_POST['REFNO'] . "', '" . $_SESSION["CURRENT_USER"] . "', 'CreditNote', 'Approve', '" . date("Y-m-d H:i:s") . "', '" . date("Y-m-d") . "')";
            $result2 = $conn->query($sql2); 
            
            $conn->commit();
            echo "Approved";
        } else {
            exit("Result Not Found...!!!");
        }
    } catch (Exception $e) {
        $conn->rollBack();
        echo $e;
    }
}

if ($_POST["Command"] == "search") {

    $tb = "";
    $tb .= "<table width='100%' class='table table-striped table-bordered table-hover' id='dataTables-example'>";


    $sql3 = "Select * from userpermission where username='".$_SESSION["CURRENT_USER"]."' and docid='134' " ;
    $result3 = $conn->query($sql3);
    $row3 = $result3->fetch();

    if($row3['doc_feed']=='1'){
        $sql = "select * from c_bal WHERE BALANCE>0 and Cancell='0' and trn_type='CNT' and block='1' and REFNO like '%" . Trim($_POST["search"]) . "%'";
    }else if($row3['doc_mod']=='1'){
        $sql = "select * from c_bal WHERE BALANCE>0 and Cancell='0' and trn_type='CNT' and block='2' and REFNO like '%" . Trim($_POST["search"]) . "%'";
    }


    $tb .= "<tr>";
    $tb .= "<th>#</th>";
    $tb .= "<th>Ref No</th>";
    $tb .= "<th>Date</th>  ";
    $tb .= "<th>Customer</th>";
    $tb .= "<th>Remark</th>";
    $tb .= "<th>Amount</th> ";
    $tb .= "<th>Balance</th>  ";
    $tb .= "<th>Brand</th>  ";
    $tb .= "<th>Action</th>  ";

    $tb .= "</tr>";
    $i=1;
    foreach ($conn->query($sql) as $row) {

        $sql1 = "Select c_name from vender_sub where c_code='".$row['c_code1']."'";
        $result1 = $conn->query($sql1);
        $row1 = $result1->fetch();

        $sql2 = "Select C_REMARK from cred where C_REFNO='".$row['REFNO']."'";
        $result2 = $conn->query($sql2);
        $row2 = $result2->fetch();

        $tb .= "<tr>";
        $tb .= "<td>".$i. "</td>";
        $tb .= "<td>".$row['REFNO']. "</td>";
        $tb .= "<td>".$row['SDATE']. "</td> "; 
        $tb .= "<td>".$row['c_code1'].'-'.$row1['c_name']. "</td> ";
        $tb .= "<td>".$row2['C_REMARK']. "</td> ";
        $tb .= "<td>".$row['AMOUNT']. "</td> ";
        $tb .= "<td>".$row['BALANCE']. "</td> ";
        $tb .= "<td>".$row['brand']. "</td> "; 

        $tb .= " <td>";




        if($row3['doc_feed']=='1'){ 
           $tb .= "<button type='button' class='btn btn-primary btn-sm' data-toggle='modal' onclick=\"forward1('" . $row['REFNO'] ."');\"   ><i class='fa fa-share'></i> Forward Acc</button>";
       }


       if($row3['doc_mod']=='1'){ 
        $tb .= " <button type='button' class='btn btn-success btn-sm' data-toggle='modal' onclick=\"approve('" . $row['REFNO'] ."');\"  ><i class='fa fa-check '></i> Approve</button> ";
       }


       $tb .= "  </td>";


       $tb .= "</tr>";
       $i=$i+1;
   }
   $tb .= "</table>";

   echo $tb;
}

?>