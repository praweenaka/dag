<?php

session_start();

////////////////////////////////////////////// Database Connector /////////////////////////////////////////////////////////////
require_once ("connection_sql.php");

////////////////////////////////////////////// Write XML ////////////////////////////////////////////////////////////////////
header('Content-Type: text/xml');

date_default_timezone_set('Asia/Colombo');

/////////////////////////////////////// GetValue //////////////////////////////////////////////////////////////////////////
///////////////////////////////////// Registration ////s/////////////////////////////////////////////////////////////////////
if ($_GET["Command"] == "rejectdag") {
  
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
 
    $_SESSION['rejectdag']="";
     $_SESSION['rejectdag']=$_GET["rejectdag"];

    
}

if ($_GET["Command"] == "new_inv") {
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<new>";
    $_SESSION['customer']="";
    $_SESSION['rejectdag']="";
    $sql = "SELECT INVNO FROM invpara"; 
    $result = $conn->query($sql);

    $row = $result->fetch();
    
    $sql2= "delete from t_invo_tmp"; 
    $result2 = $conn->query($sql2);
        
    $no = $row['INVNO'];
    $uniq = uniqid();
    $ResponseXML .= "<id><![CDATA[$no]]></id>";
    $ResponseXML .= "<uniq><![CDATA[$uniq]]></uniq>";
    $ResponseXML .= "<dt><![CDATA[" . date('Y-m-d') . "]]></dt>";

    $ResponseXML .= "</new>";

    echo $ResponseXML;
}
if ($_GET["Command"] == "setitem") {

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";
    $err ="";
    
    if ($_GET['Command1'] == "del_item") {
        $sql = "delete from t_invo_tmp where id='" . $_GET['itemCode'] . "'  ";
        $result = $conn->query($sql);
    }

    

    if ($_GET["Command1"] == "add_tmp") {
        
        $sql2= "delete from t_invo_tmp where serialno='" . $_GET['serialno'] . "' and jobno='" . $_GET['jobno'] . "' and type='dag' and tmpno='" . $_GET['tmpno'] . "'"; 
        $result2 = $conn->query($sql2);
       
        $qty = 1;  
        $amount = str_replace(",", "", ($_GET["selling"]+$_GET["repair"])*$qty);  
        $discount =  $_GET["dis"];

        $subtotal =($amount - ($amount * $_GET["dis"] / 100));
         

        $sql = "Insert into t_invo_tmp (refno, jobno, make,design,size, serialno,adpay,cost,selling, dis,repair1,subtot,tmpno,type,qty)values 
        ('" . $_GET['txt_entno'] . "', '" . $_GET['jobno'] . "', '" . $_GET['make'] . "', '" . $_GET['design'] . "', '" . $_GET['size'] . "', '" . $_GET['serialno'] . "', '" . $_GET['adpay'] . "', '" . $_GET['cost'] . "', '" . $_GET['selling'] . "', '" . $_GET['dis'] . "', '" . $_GET['repair'] . "' , '" . $subtotal . "',  '" . $_GET['tmpno'] . "','dag','1' ) ";
       $result = $conn->query($sql);
            
        
       

    }

    $ResponseXML .= "<sales_table><![CDATA[<table class=\"table table-bordered\">
    <tr>
    <th style=\"width: 10px;\">#</th>
    <th style=\"width: 100px;\">JOB NO</th>
    <th style=\"width: 10px;\"></th>
    <th style=\"width: 100px;\">MAKE</th> 
    <th style=\"width: 70px;\">SIZE</th>
    <th style=\"width: 70px;\">DESIGN</th>
    <th style=\"width: 100px;\">SERIAL NO</th>
    <th style=\"width: 90px;\">AD PAY</th>
    <th style=\"width: 90px;\">COST</th>
    <th style=\"width: 120px;\">SELLING</th>
    <th style=\"width: 90px;\">REPAIR</th>
    <th style=\"width: 60px;\">Dis</th>
    <th style=\"width: 120px;\">SubTotal</th>
    <th style=\"width: 50px;\"></th>
    </tr>";

    $i = 1;
    $mtot = 0;
    $mtot2 = 0;
    $discount = 0;
    $sql = "Select * from t_invo_tmp where tmpno='" . $_GET['tmpno'] . "' and type='dag'";
    foreach ($conn->query($sql) as $row) {

        $ResponseXML .= "<tr>         
        <td>" . $i . "</td>   
        <td>" . $row['jobno'] . "</td>   
        <td></td>
        <td>" . $row['make'] . "</td>
        <td>" . $row['size'] . "</td> 
        <td>" . $row['design'] . "</td> 
        <td>" . $row['serialno'] . "</td> 
        <td>" . number_format($row['adpay'], 2, ".", ",") . "</td>
        <td>" . number_format($row['cost'], 2, ".", ",") . "</td>
        <td>" . number_format($row['selling'], 2, ".", ",") . "</td>
        <td>" . number_format($row['repair1'], 2, ".", ",") . "</td>
        <td>" . number_format($row['dis'], 2, ".", ",") . "</td>
        <td>" . number_format($row['subtot'], 2, ".", ",") . "</td>
        <td><a class=\"btn btn-danger btn-xs\" onClick=\"del_item('" . $row['id'] . "')\"> <span class='fa fa-remove'></span></a></td>
        </tr>";
        $discount=$discount+(($row['selling']+$row['repair1'])*$row['qty']*$row['dis']/100);
        $mtot = $mtot + $row['subtot']; 
        
        $i = $i + 1;
    }



    $ResponseXML .= "   </table>]]></sales_table>";

    $sqlall = "select sum(subtot) as subtot,sum(selling*qty*dis/100) as discount  from t_invo_tmp where tmpno='" . $_GET['tmpno'] . "'";
    $resultall = $conn->query($sqlall);
    $rowall = $resultall->fetch();

    $ResponseXML .= "<item_count><![CDATA[" . $i . "]]></item_count>"; 
    $ResponseXML .= "<gtot><![CDATA[" . number_format($rowall['subtot'] , 2, ".", ",") . "]]></gtot>";
    $ResponseXML .= "<discount><![CDATA[" . number_format($rowall['discount'], 2, ".", ",") . "]]></discount>";
    $ResponseXML .= "<subtot><![CDATA[" . number_format($rowall['subtot']+$rowall['discount'], 2, ".", ",") . "]]></subtot>"; 
    $ResponseXML .= "<err><![CDATA[" . $err . "]]></err>";
    $ResponseXML .= "</salesdetails>";

    echo $ResponseXML;
}


if ($_GET["Command"] == "setproduct") {

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";
    $err ="";
    
    if ($_GET['Command1'] == "del_item") {
        $sql = "delete from t_invo_tmp where id='" . $_GET['itemCode'] . "'   ";
        $result = $conn->query($sql);
    }

     $sql = "delete from t_invo_tmp where stk_no='" . $_GET['code'] . "' and tmpno='" . $_GET['tmpno'] . "' and type='product'";
     $result = $conn->query($sql);

    if ($_GET["Command1"] == "add_tmp") {
        $qty =  $_GET["qty1"];
        $amount = str_replace(",", "", $_GET["selling1"]*$qty);  
        $discount =  $_GET["dis1"];
       

        $subtotal =($amount - ($amount * $_GET["dis1"] / 100));
        
        // $sqlsub = "select QTYINHAND from s_submas where STK_NO='" . $_GET['code'] . "' AND STO_CODE='01'";
        // $resultsub = $conn->query($sqlsub);
        // if ($rowsub = $resultsub->fetch()) {
        //     if ($rowsub["QTYINHAND"] > $_GET['qty1']) {
               $sql = "Insert into t_invo_tmp (refno,stk_no,name,qty,cost,selling, dis,subtot,tmpno,type)values 
                ('" . $_GET['txt_entno'] . "', '" . $_GET['code'] . "', '" . $_GET['name'] . "', '" . $_GET['qty1'] . "', '" . $_GET['cost1'] . "', '" . $_GET['selling1'] . "', '" . $_GET['dis1'] . "'  , '" . $subtotal . "',  '" . $_GET['tmpno'] . "','product' ) ";
               $result = $conn->query($sql);
            // }else{ 
            //      exit("Under Stock"); 
            // }
        // }
        
        

    }

    $ResponseXML .= "<sales_table><![CDATA[<table class=\"table table-bordered\">
    <tr>
    <th style=\"width: 10px;\">#</th>
    <th style=\"width: 100px;\">CODE</th> 
    <th style=\"width: 100px;\">NAME</th> 
    <th style=\"width: 70px;\">QTY</th>
    <th style=\"width: 70px;\">COST</th>
    <th style=\"width: 100px;\">SELLING</th>   
    <th style=\"width: 60px;\">Dis</th>
    <th style=\"width: 120px;\">SubTotal</th>
    <th style=\"width: 50px;\"></th>
    </tr>";

    $i = 1;
    $mtot = 0;
    $mtot2 = 0;
    $discount = 0;
    $sql = "Select * from t_invo_tmp where tmpno='" . $_GET['tmpno'] . "' and type='product'";
    foreach ($conn->query($sql) as $row) {

        $ResponseXML .= "<tr>         
        <td>" . $i . "</td>    
        <td>" . $row['stk_no'] . "</td>
        <td>" . $row['name'] . "</td> 
        <td>" . $row['qty'] . "</td>  
        <td>" . number_format($row['cost'], 2, ".", ",") . "</td>
        <td>" . number_format($row['selling'], 2, ".", ",") . "</td> 
        <td>" . number_format($row['dis'], 2, ".", ",") . "</td>
        <td>" . number_format($row['subtot'], 2, ".", ",") . "</td>
        <td><a class=\"btn btn-danger btn-xs\" onClick=\"del_itemproduct('" . $row['id'] . "')\"> <span class='fa fa-remove'></span></a></td>
        </tr>";
        $discount=$discount+(($row['selling']*$row['qty'])*$row['dis']/100);
        $mtot = $mtot + $row['subtot']; 
        
        $i = $i + 1;
    }



    $ResponseXML .= "   </table>]]></sales_table>";

    $sqlall = "select sum(subtot) as subtot,sum(selling*qty*dis/100) as discount  from t_invo_tmp where tmpno='" . $_GET['tmpno'] . "'";
    $resultall = $conn->query($sqlall);
    $rowall = $resultall->fetch();

    $ResponseXML .= "<item_count><![CDATA[" . $i . "]]></item_count>"; 
    $ResponseXML .= "<gtot><![CDATA[" . number_format($rowall['subtot'] , 2, ".", ",") . "]]></gtot>";
    $ResponseXML .= "<discount><![CDATA[" . number_format($rowall['discount'], 2, ".", ",") . "]]></discount>";
    $ResponseXML .= "<subtot><![CDATA[" . number_format($rowall['subtot']+$rowall['discount'], 2, ".", ",") . "]]></subtot>"; 
    $ResponseXML .= "<err><![CDATA[" . $err . "]]></err>";
    $ResponseXML .= "</salesdetails>";

    echo $ResponseXML;
}


if ($_GET["Command"] == "setservice") {

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";
    $err ="";
    
    if ($_GET['Command1'] == "del_item") {
        $sql = "delete from t_invo_tmp where id='" . $_GET['id'] . "'  ";
        $result = $conn->query($sql);
    }

    

    if ($_GET["Command1"] == "add_tmp") {
        $qty = 1;  
        
        $amount = str_replace(",", "", $_GET["amount"]*$qty);  
        $discount = 0;

        $subtotal =($amount - ($amount * $_GET["dis"] / 100));

        $sql = "Insert into t_invo_tmp (refno, vehicleno, service,employee,cost,selling, dis,subtot,tmpno,type,qty)values 
        ('" . $_GET['txt_entno'] . "', '" . $_GET['vehino'] . "', '" . $_GET['services'] . "', '" . $_GET['employee'] . "', '" . $_GET['amount'] . "', '" . $_GET['amount'] . "', '" . $_GET['dis'] . "' , '" . $subtotal . "',  '" . $_GET['tmpno'] . "','service' ,'1') ";
       $result = $conn->query($sql);

    }

    $ResponseXML .= "<sales_table><![CDATA[<table class=\"table table-bordered\">
    <tr>
    <th style=\"width: 10px;\">#</th>
    <th style=\"width: 100px;\">VEHICLE NO</th>
    <th style=\"width: 100px;\">EMPLOYEE</th> 
    <th style=\"width: 70px;\">SERVICES</th>
    <th style=\"width: 70px;\">AMOUNT</th> 
    <th style=\"width: 50px;\"></th>
    </tr>";

    $i = 1;
    $mtot = 0;
    $mtot2 = 0;
    $discount = 0;
    $sql = "Select * from t_invo_tmp where tmpno='" . $_GET['tmpno'] . "' and type='service'";
    foreach ($conn->query($sql) as $row) {

        $ResponseXML .= "<tr>         
        <td>" . $i . "</td>   
        <td>" . $row['vehicleno'] . "</td> 
        <td>" . $row['employee'] . "</td>
        <td>" . $row['service'] . "</td>  
        <td>" . number_format($row['subtot'], 2, ".", ",") . "</td>  
        <td><a class=\"btn btn-danger btn-xs\" onClick=\"del_itemservice('" . $row['id'] . "')\"> <span class='fa fa-remove'></span></a></td>
        </tr>";
        $discount=$discount+($row['selling']*$row['qty']*$row['dis']/100);
        $mtot = $mtot + $row['subtot']; 
        
        $i = $i + 1;
    }



    $ResponseXML .= "   </table>]]></sales_table>";
    
    $sqlall = "select sum(subtot) as subtot,sum(selling*qty*dis/100) as discount  from t_invo_tmp where tmpno='" . $_GET['tmpno'] . "'";
    $resultall = $conn->query($sqlall);
    $rowall = $resultall->fetch();

    $ResponseXML .= "<item_count><![CDATA[" . $i . "]]></item_count>"; 
    $ResponseXML .= "<gtot><![CDATA[" . number_format($rowall['subtot'] , 2, ".", ",") . "]]></gtot>";
    $ResponseXML .= "<discount><![CDATA[" . number_format($rowall['discount'], 2, ".", ",") . "]]></discount>";
    $ResponseXML .= "<subtot><![CDATA[" . number_format($rowall['subtot']+$rowall['discount'], 2, ".", ",") . "]]></subtot>"; 
    $ResponseXML .= "<err><![CDATA[" . $err . "]]></err>";
    $ResponseXML .= "</salesdetails>";

    echo $ResponseXML;
}

if ($_GET["Command"] == "save_item") {
    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->beginTransaction();
        $invno = $_GET["txt_entno"];
        $sqlisalma_q = "select REF_NO from s_salma where REF_NO='" . $invno . "'";
        $resultsalma_q = $conn->query($sqlisalma_q);
        if ($rowsalma_q = $resultsalma_q->fetch()) {
            $conn->rollBack();

            exit("Invoice No Already Exist !!!");
            

        } 

        $sqlisalma_q = "select REF_NO from s_salma where tmp_no='" . $_GET["tmpno"] . "'";
        $resultsalma_q = $conn->query($sqlisalma_q);
        if ($rowsalma_q = $resultsalma_q->fetch()) {
            $conn->rollBack();

            exit("Invoice No Already Exist !!!");

        } 

        if ($_SESSION['UserName'] == "") {
            echo "Invalid Session";
            exit();
        }
        // if ($_SESSION['company'] == "") {
        //     echo "Invalid Session";
        //     exit();
        // }
        // foreach ($conn->query($sql) as $rowtmp1) {
        //   
        //     $i = $i + 1;
        // }

        
        // if ($insuf_qty != "") {
        //     exit("Under Stock");
        // }
 

        $sql = "select * from vendor where CODE = '" . trim($_GET["customercode"]) . "'";
        $result = $conn->query($sql);
        if ($row = $result->fetch()) {
            if ($row["blacklist"] == "1") { 
                exit("Invoice Facilitey Stoped for This Customer..!!!");
            }
        }
 
        $sql = "delete from s_salma where REF_NO = '" . $invno . "'";
        $conn->exec($sql);
 
        $sql = "delete from t_invo where refno = '" . $invno . "'";
        $conn->exec($sql);
 
        $subtot = str_replace(",", "", $_GET["subtot"]);


        $mtot = 0;
        $subdis = 0;
        $sql = "select * from t_invo_tmp where tmpno='" . $_GET["tmpno"] . "'";
        foreach ($conn->query($sql) as $row) {

          $subdis =  $row['selling']*$row['qty']*$row['dis']/100;



          $sqldag = "select * from dag_item where jobno = '" . $row["jobno"] . "' and serialno = '" . $row["serialno"] . "'";
          $resultdag = $conn->query($sqldag);
          $rowdag = $resultdag->fetch();
          
          $sqlvat = "select vatrate from invpara";
          $resultvat = $conn->query($sqlvat);
          $rowvat = $resultvat->fetch();

            if($row['type']=="dag"){
                 $sql = "Insert into t_invo (refno,sdate,department,rep,tax_per, jobno, make,design,size, serialno,adpay,cost,selling, dis,repair1,subtot,tmpno,reject,type,qty)values 
              ('" . $invno . "', '" . $_GET['invdate'] . "','01','" . $_GET['salesrep'] . "','" . $rowvat["vatrate"] . "','" . $row['jobno'] . "', '" . $row['make'] . "', '" . $row['design'] . "', '" . $row['size'] . "', '" . $row['serialno'] . "', '" . $row['adpay'] . "', '" . $row['cost'] . "', '" . $row['selling'] . "', '" . $row['dis'] . "', '" . $row['repair1'] . "' , '" . $row['subtot'] . "',  '" . $row['tmpno'] . "' ,  '" . $rowdag['reject'] . "','" . $row["type"] . "','" . $row["qty"] . "') ";
              $result = $conn->query($sql);
              
              $sql = "Insert into s_trn (`SDATE`, `STK_NO`, `REFNO`, `QTY`, `LEDINDI`, `DEPARTMENT`,type) values 
          ('" . $_GET['invdate'] . "','" . $row["jobno"] . "','" . trim($invno) . "', '1','INV', '01','" . $row["type"] . "')";
          
               $sql3 = "update dag_item set invno='".$invno."',flag='7',inv_date='" . $_GET['invdate'] . "',amount1 = '" . $row["selling"] . "',repair1 = '" . $row["repair1"] . "',total1 = '" . $row["subtot"] . "',dis1 = '" . $row["dis"] . "' where jobno = '" . $row["jobno"] . "' and serialno = '" . $row["serialno"] . "'";
              $result3 = $conn->query($sql3);
              
          $result = $conn->query($sql);
          
            }else if($row['type']=="product"){
                $sql = "Insert into t_invo (refno,sdate,stk_no,name,qty,department,rep,tax_per,cost,selling, dis,subtot,tmpno,reject,type)values 
              ('" . $invno . "', '" . $_GET['invdate'] . "', '" . $row['stk_no'] . "', '" . $row['name'] . "', '" . $row['qty'] . "','01','" . $_GET['salesrep'] . "','" . $rowvat["vatrate"] . "', '" . $row['cost'] . "', '" . $row['selling'] . "', '" . $row['dis'] . "', '" . $row['subtot'] . "',  '" . $row['tmpno'] . "' ,  '" . $rowdag['reject'] . "','" . $row["type"] . "') ";
              $result = $conn->query($sql);
               
                   
                   $sql = "Insert into s_trn (`SDATE`, `STK_NO`, `REFNO`, `QTY`, `LEDINDI`, `DEPARTMENT`,type) values 
          ('" . $_GET['invdate'] . "','" . $row["code"] . "','" . trim($invno) . "', '" . $row['qty'] . "','INV', '01','" . $row["type"] . "')";
          $result = $conn->query($sql);
          
         $sqls_mas = "update s_mas set QTYINHAND= QTYINHAND-" . $row['qty']  . " where STK_NO='" . $row["stk_no"] . "'";
        $results_mas = $conn->query($sqls_mas);

        $sqls_submas = "update s_submas set QTYINHAND=QTYINHAND- " . $row['qty']  . " where STK_NO= '" . $row["stk_no"] . "' and STO_CODE= '01'";
        $results_submas = $conn->query($sqls_submas);
          
            }else if($row['type']=="service"){
                
                $sql = "Insert into t_invo (refno,sdate,vehicleno,service,qty,department,rep,tax_per,cost,selling, dis,subtot,tmpno,reject,type)values 
              ('" . $invno . "', '" . $_GET['invdate'] . "', '" . $row['vehicleno'] . "', '" . $row['service'] . "', '" . $row['qty'] . "','01','" . $_GET['salesrep'] . "','" . $rowvat["vatrate"] . "', '" . $row['amount'] . "', '" . $row['amount'] . "', '" . $row['dis'] . "', '" . $row['subtot'] . "',  '" . $row['tmpno'] . "' ,  '" . $rowdag['reject'] . "','" . $row["type"] . "') ";
              $result = $conn->query($sql);
              
                 
               $sql = "Insert into s_trn (`SDATE`, `STK_NO`, `REFNO`, `QTY`, `LEDINDI`, `DEPARTMENT`,type) values 
          ('" . $_GET['invdate'] . "','" . $row["code"] . "','" . trim($invno) . "', '" . $row['qty'] . "','INV', '01','" . $row["type"] . "')";
          $result = $conn->query($sql);
            }    
         
         

          $mtot = $mtot + ($row["subtot"]);
      }


      $sql = "select vatrate from invpara";
      $result = $conn->query($sql);
      $row = $result->fetch();




      $mgrand_tot = number_format($mtot, 2, ".", ""); 
      $sql = "insert s_salma (REF_NO,SDATE,trn_type,C_CODE, CUS_NAME,c_add1,vat,tmp_no,REMARK,grand_tot,SAL_EX,gst,use_name,DEPARTMENT,dele_no,TYPE,DISCOU,TYPE1) values 
      ('" . $invno . "', '" . $_GET['invdate'] . "','INV' ,'" . $_GET["customercode"] . "', '" . $_GET["customername"] . "','" . $_GET["cus_address"] . "','0','" . $_GET["tmpno"] . "','" . $_GET['txt_remarks'] . "' ,'" . $mgrand_tot . "','" . $_GET['salesrep'] . "','" . $row['vatrate'] . "','" . $_SESSION['UserName'] . "','01','" . $_GET['DANO'] . "','".$_GET["paymethod"]."','".$subdis."','".$_GET["rejectdag"]."' )";
      $result = $conn->query($sql);

 


      if ($_GET["paymethod"] == "CA") {

        // $sql = "select RECNO from invpara where COMCODE='" . $_SESSION['company'] . "'";
        $sql = "select RECNO from invpara";
        $result = $conn->query($sql);
        $row = $result->fetch();

        $tmprecno = "000000" . $row["RECNO"];
        $lenth = strlen($tmprecno);
        $recno =  trim("CRN/CR/") . substr($tmprecno, $lenth - 5);
 
        $sql = "insert into s_crec(CA_REFNO, CA_DATE, CA_CODE, CA_CASSH, CA_AMOUNT, overpay, FLAG, pay_type, CA_SALESEX, CANCELL, tmp_no, DEPARTMENT, cus_ref, AC_REFNO, TTDATE, DEV) values
        ('" . $recno . "', '" . $_GET["invdate"] . "', '" . trim($_GET["customercode"]) . "', " . $mgrand_tot . ", " . $mgrand_tot . ", 0, 'REC', 'Cash', '" . trim($_GET["salesrep"]) . "', '0', '" . $_GET["tmpno"] . "', 'O', '0', '', '',  '" . $_SESSION['dev'] . "' )";
                 
        $result = $conn->query($sql);

        $sql1 = "insert into s_sttr(ST_REFNO, ST_DATE, ST_INVONO, ST_PAID, ST_CHNO, st_chdate, ST_FLAG, st_days, ap_days, st_chbank, cus_code, DEV, del_days, deliin_days, deliin_amo, deliin_lock, department) values
        ('" . $recno . "', '" . $_GET["invdate"] . "', '" . $invno . "', " . $mgrand_tot . ", '', '" . $_GET["invdate"] . "', 'CAS', '', '', '', '" . trim($_GET["customercode"]) . "', '" . $_SESSION['dev'] . "', 0, 0, 0, '0', 'O')";
        $result1 = $conn->query($sql1);

        $sql2 = "update s_salma set TOTPAY=TOTPAY + " . $mgrand_tot . " where REF_NO = '" . $invno . "'";
        $result2 = $conn->query($sql2);

        $sql3 = "update s_salma set CASH=CASH + " . $mgrand_tot . " where REF_NO = '" . $invno . "'";
        $result3 = $conn->query($sql3);

        // $sql4 = "update invpara set RECNO=RECNO + 1 where COMCODE='" . $_SESSION['company'] . "'";
        $sql4 = "update invpara set RECNO=RECNO + 1";
        $result4 = $conn->query($sql4);
    }


    $sql = "update invpara set INVNO=INVNO+1";
    $conn->exec($sql);
    
    $sqllog = "insert into entry_log(refno, username, docname, trnType, stime, sdate) values ('" . trim($invno) . "', '" . $_SESSION["CURRENT_USER"] . "', 'INVOICE', 'Save', '" . date("Y-m-d H:i:s") . "', '" . date("Y-m-d") . "')";
            $resultlog = $conn->query($sqllog);

    $conn->commit();
    echo "Saved";
} catch (Exception $e) {
    $conn->rollBack();
    echo $e;
}
}




if ($_GET["Command"] == "pass_rec") {

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";
    $sql = "Select * from s_salma where REF_NO='" . $_GET['refno'] . "'";
    $result = $conn->query($sql);

   if ($row = $result->fetch()) {
        $ResponseXML .= "<id><![CDATA[" . json_encode($row) .  "]]></id>";
    
 
        $msg = "";
        if ($row['CANCELL'] == "1") {
            $msg = "Cancelled";
        }
        $ResponseXML .= "<msg><![CDATA[" . $msg . "]]></msg>";

         

        

        $ResponseXML .= "<sales_table><![CDATA[<table class=\"table\">
      <tr>
    <th style=\"width: 100px;\">JOB NO</th>
    <th style=\"width: 10px;\"></th>
    <th style=\"width: 100px;\">MAKE</th> 
    <th style=\"width: 70px;\">DESIGN</th>
    <th style=\"width: 70px;\">SIZE</th>
    <th style=\"width: 100px;\">SERIAL NO</th>
    <th style=\"width: 90px;\">AD PAY</th>
    <th style=\"width: 90px;\">COST</th>
    <th style=\"width: 120px;\">SELLING</th>
    <th style=\"width: 90px;\">REPAIR</th>
    <th style=\"width: 60px;\">Dis</th>
    <th style=\"width: 120px;\">SubTotal</th>
    <th style=\"width: 50px;\"></th>
    </tr>";

        $i = 1; 
        $mtot = 0;  
        $sql = "Select * from t_invo where refno='" . $row["REF_NO"] . "' and type='dag'";
        foreach ($conn->query($sql) as $row1) {

            $ResponseXML .= "<tr>                              
            <td>" . $row1['jobno'] . "</td>   
        <td></td>
        <td>" . $row1['make'] . "</td>
        <td>" . $row1['design'] . "</td> 
        <td>" . $row1['size'] . "</td> 
        <td>" . $row1['serialno'] . "</td> 
        <td>" . number_format($row1['adpay'], 2, ".", ",") . "</td>
        <td>" . number_format($row1['cost'], 2, ".", ",") . "</td>
        <td>" . number_format($row1['selling'], 2, ".", ",") . "</td>
        <td>" . number_format($row1['repair1'], 2, ".", ",") . "</td>
        <td>" . number_format($row1['dis'], 2, ".", ",") . "</td>
        <td>" . number_format($row1['subtot'], 2, ".", ",") . "</td>

            </tr>";

            $i = $i + 1;
            $mtot=$mtot+$row1['subtot']; 
        }

        $ResponseXML .= "   </table>]]></sales_table>";
        
         $ResponseXML .= "<sales_table1><![CDATA[<table class=\"table\">
      <tr>
      <th style=\"width: 10px;\">#</th>
    <th style=\"width: 100px;\">CODE</th> 
    <th style=\"width: 100px;\">NAME</th> 
    <th style=\"width: 70px;\">QTY</th>
    <th style=\"width: 70px;\">COST</th>
    <th style=\"width: 100px;\">SELLING</th>   
    <th style=\"width: 60px;\">Dis</th>
    <th style=\"width: 120px;\">SubTotal</th> 
    </tr>";

        $i = 1; 
         
        $sql = "Select * from t_invo where refno='" . $row["REF_NO"] . "' and type='product'";
        foreach ($conn->query($sql) as $row1) {

            $ResponseXML .= "<tr>                              
            <td>" . $i . "</td>    
        <td>" . $row1['stk_no'] . "</td>
        <td>" . $row1['name'] . "</td> 
        <td>" . $row1['qty'] . "</td>  
        <td>" . number_format($row1['cost'], 2, ".", ",") . "</td>
        <td>" . number_format($row1['selling'], 2, ".", ",") . "</td> 
        <td>" . number_format($row1['dis'], 2, ".", ",") . "</td>
        <td>" . number_format($row1['subtot'], 2, ".", ",") . "</td>

            </tr>";

            $i = $i + 1;
            $mtot=$mtot+$row1['subtot']; 
        }

        $ResponseXML .= "   </table>]]></sales_table1>";
        
         $ResponseXML .= "<sales_table2><![CDATA[<table class=\"table\">
      <tr>
        <th style=\"width: 10px;\">#</th>
    <th style=\"width: 100px;\">VEHICLE NO</th>
    <th style=\"width: 100px;\">EMPLOYEE</th> 
    <th style=\"width: 70px;\">SERVICES</th>
    <th style=\"width: 70px;\">AMOUNT</th> 
    <th style=\"width: 50px;\"></th>
    </tr>";

        $i = 1; 
        
        $sql = "Select * from t_invo where refno='" . $row["REF_NO"] . "' and type='service'";
        foreach ($conn->query($sql) as $row1) {

            $ResponseXML .= "<tr>                              
           <td>" . $i . "</td>   
        <td>" . $row1['vehicleno'] . "</td> 
        <td>" . $row1['employee'] . "</td>
        <td>" . $row1['service'] . "</td>  
        <td>" . number_format($row1['subtot'], 2, ".", ",") . "</td>  

            </tr>";

            $i = $i + 1;
            $mtot=$mtot+$row1['subtot']; 
        }

        $ResponseXML .= "   </table>]]></sales_table2>";
 
        $ResponseXML .= "<item_count><![CDATA[" . $i . "]]></item_count>";
         $ResponseXML .= "<type><![CDATA[" . $row['TYPE'] . "]]></type>";
        $ResponseXML .= "<discount><![CDATA[" . number_format($row['DISCOU'], 2, ".", "") . "]]></discount>"; 
        $ResponseXML .= "<gtot><![CDATA[" . number_format($row['GRAND_TOT'], 2, ".", ",") . "]]></gtot>";
        $ResponseXML .= "<subtot><![CDATA[" . number_format($mtot+$row['DISCOU'], 2, ".", ",") . "]]></subtot>";
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

        $sql = "select REF_NO,CANCELL,TOTPAY from s_salma where tmp_no ='" . $_GET['tmpno'] . "'";
        $result = $conn->query($sql);
        if ($row = $result->fetch()) {



            if ($row['CANCELL'] != "0") {
                echo "Already Enterd";
                exit();
            }
            if ($row['CANCELL'] != "0") {
                echo "Already Cancelled";
                exit();
            }

            if ($row['TOTPAY'] > 0) {
                echo "Already Paid";
                exit();
            }
 

            $invno = $row['REF_NO'];
 
            $sql = "delete from s_trn where refno = '" . $invno . "'";
            $conn->exec($sql);
            
            $invno = $row['REF_NO'];

            $sql = "update s_salma set CANCELL='1' where REF_NO = '" . $row['REF_NO'] . "'";
            $conn->exec($sql);

            $sql = "update t_invo set cancel='1' where refno = '" . $row['REF_NO'] . "'";
            $conn->exec($sql);
            
             $sqltmp = "select * from t_invo where refno = '" . $row['REF_NO'] . "' and type='product'";
             $resulttmp = $conn->query($sqltmp);
             while ($rowtmp = $resulttmp->fetch()) { ;

                $sql2 = "update s_mas set QTYINHAND=QTYINHAND+" . $rowtmp["qty"] . " where STK_NO='" . $rowtmp['stk_no'] . "'";
                $resul2 = $conn->query($sql2);

                $sql2 = "update s_submas set QTYINHAND=QTYINHAND+" . $rowtmp["qty"] . " where STO_CODE='01' and STK_NO='" . $rowtmp['stk_no'] . "'";
                $resul2 = $conn->query($sql2);
 
            }
            
            $sql = "update dag_item set flag='2',inv_date=  '',amount1 = '0.00',repair1 = '0.00',total1 = '0.00',dis1 = '0.00' where invno = '" . $row['REF_NO'] . "'";
           $result = $conn->query($sql);
            
            $sqllog = "insert into entry_log(refno, username, docname, trnType, stime, sdate) values ('" . trim($row['REF_NO']) . "', '" . $_SESSION["CURRENT_USER"] . "', 'INVOICE', 'CANCEL', '" . date("Y-m-d H:i:s") . "', '" . date("Y-m-d") . "')";
            $resultlog = $conn->query($sqllog);
            
            echo "ok";
            $conn->commit();
        } else {
            echo "Entry Not Found";
        }
    } catch (Exception $e) {
        $conn->rollBack();
        echo $e;
    }
}



if ($_GET["Command"] == "pass_cus") {
    $_SESSION["custno"] = $_GET['custno'];

    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $cuscode = $_GET["custno"];
    $_SESSION['customer']="";
     $_SESSION['customer']=$_GET["custno"];

    $sql = "Select * from vendor where   CODE ='" . $cuscode . "'";
    $result = $conn->query($sql);

    if ($rowM = $result->fetch()) {
        $ResponseXML .= "<id><![CDATA[" . json_encode($rowM) .  "]]></id>";
    }

    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}

if ($_GET["Command"] == "pass_card") {
    $_SESSION["custno"] = $_GET['custno'];

    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $cuscode = $_GET["custno"];
    
      
    $sql1 = "SELECT * from  t_invo_tmp where serialno='" . $_GET['serialno'] . "' and jobno='" . $_GET['jobno'] . "' and type='dag'"; 
    $result1 = $conn->query($sql1);

    if ($row1 = $result1->fetch()) {
         $ResponseXML .= "<val><![CDATA[" . 'yes' . "]]></val>";
    }else{
         $ResponseXML .= "<val><![CDATA[" . 'no' . "]]></val>";
    }
    
    $sql = "SELECT * from dag_item where id='".$cuscode."' ";
    $result = $conn->query($sql);

    if ($rowM = $result->fetch()) {
        $ResponseXML .= "<id><![CDATA[" . json_encode($rowM) .  "]]></id>";
    }

    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}


if ($_GET["Command"] == "pass_proitem") {
    $_SESSION["custno"] = $_GET['custno'];
    
    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $cuscode = $_GET["custno"];
   
   
    
    $sql = "SELECT * from s_mas where STK_NO='".$cuscode."' ";
    $result = $conn->query($sql); 
    if ($rowM = $result->fetch()) {
        $sqlven = "SELECT * from vendor where CODE='".$_SESSION["customer"]."' ";
        $resultven = $conn->query($sqlven);  
        $rowven = $resultven->fetch();
        
        if($rowven['cus_type']=="WHOLESALE"){
            $ResponseXML .= "<selling><![CDATA[" . $rowM['whprice'] . "]]></selling>"; 
        }else{
            $ResponseXML .= "<selling><![CDATA[" . $rowM['SELLING'] . "]]></selling>"; 
        }
            
         
    
        $ResponseXML .= "<id><![CDATA[" . json_encode($rowM) .  "]]></id>";
    }

    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}

?>