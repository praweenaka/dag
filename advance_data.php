<?php

session_start();


require_once ("connection_sql.php");

header('Content-Type: text/xml');

date_default_timezone_set('Asia/Colombo');

if ($_POST["Command"] == "getdt") {
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<new>";

    $sql = "SELECT adno FROM invpara";
    $result = $conn->query($sql);

    $row = $result->fetch();
    $no = $row['adno'];
    $uniq = uniqid();
    $ResponseXML .= "<id><![CDATA[$no]]></id>";
    $ResponseXML .= "<uniq><![CDATA[$uniq]]></uniq>";

    $ResponseXML .= "</new>";

    echo $ResponseXML;
}

        
        
if($_POST["Command"]=="save_inv")
{
            
                
       try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->beginTransaction();
        
         $sqlisalma_q = "select * from s_adva where C_REFNO='" . $_POST["invno"] . "'";
        $resultsalma_q = $conn->query($sqlisalma_q);
        if ($rowsalma_q = $resultsalma_q->fetch()) {
             

            exit(" No Already Exist !!!");

        } 
        
         if ($_POST["paytype"]=="CHEQUE"){
             $amou=$_POST["chamount"];
         }else{
             $amou=$_POST["caamount"];
         }
                
        if ($_POST["paytype"]=="CHEQUE"){
            $sql="insert into s_invcheq (refno,Sdate,cus_code,CUS_NAME,cheque_no,che_date,bank,che_amount,trn_type) values ('" . trim($_POST["invno"]) . "', '" . $_POST["sdate"] . "', '" . trim($_POST["cuscode"]) . "', '" . trim($_POST["cusname"]) . "', '" . $_POST["chkno"] . "', '" . trim($_POST["chkdate"]) . "', '" . trim($_POST["bank"]) . "', " . $amou . " ,'PAY')";
            $result = $conn->query($sql);
        }
        $sql="insert into s_crec (CA_REFNO, CA_DATE, CA_CODE, CA_CASSH, CA_AMOUNT, DEPARTMENT, FLAG) values('" . trim($_POST["invno"]) . "', '" . $_POST["sdate"] . "','" . trim($_POST["cuscode"]) . "','" . $amou . "','" . $amou . "', '1' , 'PAY')";
        $result = $conn->query($sql);
        
        
        $sql="insert into c_bal (REFNO, SDATE, CUSCODE, AMOUNT, BALANCE, DEP, SAL_EX, trn_type) values ('" . trim($_POST["invno"])  . "', '" . $_POST["sdate"] . "','" . trim($_POST["cuscode"]) . "','" . $amou. "','" . $amou . "', '".$_POST["department"]."', '01', 'PAY')";
        $result = $conn->query($sql);
 
        $sql="insert into s_adva(C_REFNO, C_CODE, C_PAYMENT, C_DATE,paytype) values ('" . trim($_POST["invno"]) . "','" . trim($_POST["cuscode"]) . "','" . $amou . "','" . $_POST["sdate"] . "','" . $_POST["paytype"] . "')";
        $result = $conn->query($sql);


        $sql="UPDATE invpara SET adno=adno+1";
        $result = $conn->query($sql);

        $conn->commit();
            echo "Saved";
        
    } catch (Exception $e) {
        $conn->rollBack();
        echo $e;
    }

}

if ($_GET["Command"] == "pass_quot") {
    $_SESSION["custno"] = $_GET['custno'];

     header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $cuscode = $_GET["custno"];

    $sql = "Select * from s_adva where   C_REFNO ='" . $cuscode . "'";
    $result = $conn->query($sql);

    if ($rowM = $result->fetch()) {
        $sql1 = "select * from vendor where CODE='".$rowM["C_CODE"]."'";
        $result1 = $conn->query($sql1); 
        $row1 = $result1->fetch();
        $ResponseXML .= "<C_REFNO><![CDATA[".$rowM["C_REFNO"]."]]></C_REFNO>"; 
        $ResponseXML .= "<C_DATE><![CDATA[".$rowM["C_DATE"]."]]></C_DATE>"; 
        $ResponseXML .= "<C_CODE><![CDATA[".$rowM["C_CODE"]."]]></C_CODE>"; 
        $ResponseXML .= "<C_PAYMENT><![CDATA[".$rowM["C_PAYMENT"]."]]></C_PAYMENT>"; 
        $ResponseXML .= "<paytype><![CDATA[".$rowM["paytype"]."]]></paytype>"; 
        $ResponseXML .= "<cusname><![CDATA[".$row["NAME"]."]]></cusname>"; 
        
             $ResponseXML .= "<che_date><![CDATA[]]></che_date>"; 
             $ResponseXML .= "<cheque_no><![CDATA[]]></cheque_no>"; 
             $ResponseXML .= "<bank><![CDATA[]]></bank>"; 
             $ResponseXML .= "<che_amount><![CDATA[]]></che_amount>"; 
       
    }
    
    $sqlM1 = "Select * from s_invcheq where   refno ='" . $cuscode . "'"; 
    $resultM1 = $conn->query($sqlM1);

    if ($rowM1 = $resultM1->fetch()) { 
   
              
             $ResponseXML .= "<che_date><![CDATA[".$rowM1["che_date"]."]]></che_date>"; 
             $ResponseXML .= "<cheque_no><![CDATA[".$rowM1["cheque_no"]."]]></cheque_no>"; 
             $ResponseXML .= "<bank><![CDATA[".$rowM1["bank"]."]]></bank>"; 
             $ResponseXML .= "<che_amount><![CDATA[".$rowM1["che_amount"]."]]></che_amount>"; 
             
        
    } 
    
     

    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}
 
 
 if ($_GET["Command"] == "pass_cus") {
 

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
 
 if ($_POST["Command"] == "cancel_inv") {

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";
    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->beginTransaction();

        $sql = "select * from s_adva where C_REFNO ='" . $_POST['invno'] . "'";
        $result = $conn->query($sql);
        if ($row = $result->fetch()) {
 
 
            $sql = "delete from s_crec where CA_REFNO = '" . $_POST['invno'] . "'";
            $conn->exec($sql);
            
             $sql = "delete from c_bal where REFNO = '" . $_POST['invno'] . "'";
            $conn->exec($sql);
          
            
             $sql = "delete from s_invcheq where refno = '" . $_POST['invno'] . "'";
            $conn->exec($sql);
             

            $sql = "update s_adva set cancel='1' where C_REFNO = '" . $_POST['invno'] . "'";
            $conn->exec($sql);
              
            
            $sqllog = "insert into entry_log(refno, username, docname, trnType, stime, sdate) values ('" . $_POST['invno'] . "', '" . $_SESSION["CURRENT_USER"] . "', 'ADVANCE', 'CANCEL', '" . date("Y-m-d H:i:s") . "', '" . date("Y-m-d") . "')";
            $resultlog = $conn->query($sqllog);
            
            echo "Cancel";
            $conn->commit();
        } else {
            echo "Entry Not Found";
        }
    } catch (Exception $e) {
        $conn->rollBack();
        echo $e;
    }
}
?>