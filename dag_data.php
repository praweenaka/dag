<?php

session_start();


require_once ("connection_sql.php");

header('Content-Type: text/xml');

date_default_timezone_set('Asia/Colombo');

if ($_POST["Command"] == "getdt") {
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<new>";

    $sql = "SELECT dag,jobno FROM invpara";
    $result = $conn->query($sql); 
    $row = $result->fetch();
    
    $sql1 = "SELECT shortcode,short FROM s_stomas where CODE='".$_POST['department']."'";
    $result1 = $conn->query($sql1); 
    $row1 = $result1->fetch();
    
    if($row1['short']=="K"){
        $shcode=trim($row1['short']."/") ;
    }else{
        $shcode=trim($row1['short']."/") .$row1['shortcode'];
    }
   
    $ResponseXML .= "<scode><![CDATA[".$row1['short']."]]></scode>";
    
    $no = $row['dag'];
    $uniq = uniqid();
    $ResponseXML .= "<id><![CDATA[$no]]></id>";
    $ResponseXML .= "<jobno><![CDATA[".$shcode."]]></jobno>";
    $ResponseXML .= "<uniq><![CDATA[$uniq]]></uniq>";

    $ResponseXML .= "</new>";

    echo $ResponseXML;
}

if ($_POST["Command"] == "setjobno") {
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<new>";

    
    
    $sql1 = "SELECT shortcode,short FROM s_stomas where CODE='".$_POST['department']."'";
    $result1 = $conn->query($sql1); 
    $row1 = $result1->fetch();
    
    if($row1['short']=="K"){
        $shcode=trim($row1['short']."/");
    }else{
        $shcode=trim($row1['short']."/") .$row1['shortcode'];
    }
     
     $ResponseXML .= "<scode><![CDATA[".$row1['short']."]]></scode>";
    $ResponseXML .= "<jobno><![CDATA[".$shcode."]]></jobno>"; 

    $ResponseXML .= "</new>";

    echo $ResponseXML;
}

if ($_POST["Command"] == "add_tmp") {

  try {
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->beginTransaction();

    header('Content-Type: text/xml'); 
    
    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";
    
    if ($_POST['Command1'] == "add") {

        $sql3 = "delete from dag_item_tmp   where refno='".$_POST['refno']."' and serialno='".$_POST['serialno']."'  "; 
        $result3 = $conn->query($sql3);



        $sql2 = "insert into dag_item_tmp(refno,cuscode,cusname,size,marker,adpayment,serialno,warrenty,remark,tmp_no,jobno,belt) values ('" . $_POST['refno'] . "', '" . $_POST['cuscode']  . "', '" . $_POST['cusname'] . "', '" . $_POST['size'] . "', '" . $_POST['marker'] . "', '" . $_POST['adpayment'] . "', '" . $_POST['serialno'] . "', '" . $_POST['warranty'] . "', '" . $_POST['remark'] . "', '" . $_POST['uniq'] . "', '" . $_POST['jobno'] . "', '" . $_POST['belt'] . "')"; 
        $result2 = $conn->query($sql2);

         $sql = "update s_stomas set shortcode = shortcode+ 1 where CODE = '".$_POST['jobno']."'";
         $result = $conn->query($sql);

    }
    if ($_POST['Command1'] == "del") {

        $sql = "delete from dag_item_tmp   where id='".$_POST['id']."'";  
        $result = $conn->query($sql);
    }

    $ResponseXML .= "<sales_table><![CDATA[<table class=\"table\">  ";
    $ResponseXML .= " <tr>
    <th>JOBNO</th>
    <th>SIZE</th>
    <th>BELT</th>
    <th>MARKER</th>
    <th>SERIAL NO</th>
    <th>WARRENTY</th>
    <th>REMARK</th> 
    <th></th> 
    </tr>";
    

    $sql = "Select * from dag_item_tmp where refno='".$_POST['refno']."' and tmp_no='".$_POST['uniq']."'";
    foreach ($conn->query($sql) as $row) {

         
        $ResponseXML .= "<tr> 
        <td style=\"width:200px;\">" . $row['jobno']."</td> 
        <td style=\"width:200px;\">" . $row['size']."</td> 
        <td style=\"width:200px;\">" . $row['belt']."</td> 
        <td style=\"width:200px;\">" . $row['marker'] . "</td> 
        <td style=\"width:200px;\">" . $row['serialno'] . "</td> 
        <td style=\"width:200px;\">" . $row['warrenty'] . "</td> 
        <td style=\"width:200px;\">" . $row['remark'] . "</td>  
        <td><button   onClick=\"del_item('" . $row['id'] . "')\" type=\"button\" class=\"btn btn-danger btnDelete btn-sm\">Remove</button>
        </td>
        </tr>";  


    }
    
    
    
    
   
    $ResponseXML .= "</table>]]></sales_table>";   
    
    $sql1 = "SELECT jobno FROM invpara"; 
    $result1 = $conn->query($sql1); 
    $row1 = $result1->fetch();
    
    $ResponseXML .= "<jobno><![CDATA[".$row1['jobno']."]]></jobno>";
      
    $ResponseXML .= "</salesdetails>";

    echo $ResponseXML;
    $conn->commit();
} catch (Exception $e) {
    $conn->rollBack();
    echo $e;
}
}


if ($_POST["Command"] == "save_item") {


    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->beginTransaction();
        
        $sql = "SELECT * from dag where  refno='".$_POST['refno']."' ";
        $result = $conn->query($sql);
        if ($row = $result->fetch()) {
            exit("Already Saved DAG No...!!!");
        }

        $sql1 = "insert into dag(refno,cuscode,cusname,adpayment,sdate,tmp_no,flag) values ('" . $_POST['refno'] . "', '" . $_POST['cuscode']  . "', '" . $_POST['cusname'] . "',   '" . $_POST['adpayment'] . "', '" . $_POST['sdate'] . "', '" . $_POST['uniq'] . "','0' )"; 
        $result1 = $conn->query($sql1);

        $i=1;
        $sqltmp= "select * from dag_item_tmp where refno='".$_POST['refno']."' and tmp_no='".$_POST['uniq']."'";
        foreach ($conn->query($sqltmp) as $rowtmp) {
           $sql2 = "insert into dag_item(refno,cuscode,cusname,size,marker,adpayment,serialno,warrenty,remark,tmp_no,flag,sdate,jobno,belt) values ('" . $_POST['refno'] . "', '" . $rowtmp['cuscode']  . "', '" . $rowtmp['cusname'] . "', '" . $rowtmp['size'] . "', '" . $rowtmp['marker'] . "', '" . $rowtmp['adpayment'] . "', '" . $rowtmp['serialno'] . "', '" . $rowtmp['warrenty'] . "', '" . $rowtmp['remark'] . "', '" . $_POST['uniq'] . "' ,'0', '" . $_POST['sdate'] . "', '" . $rowtmp['jobno'] . "', '" . $rowtmp['belt'] . "')"; 
           $result2 = $conn->query($sql2); 
           $i= $i+1;
       }


       $sql = "delete from dag_item_tmp   where refno='".$_POST['refno']."' and tmp_no='".$_POST['uniq']."'";
       $result = $conn->query($sql);

       $sql = "SELECT dag FROM invpara";
       $resul = $conn->query($sql);
       $row = $resul->fetch();
       $no = $row['dag'];
       $no2 = $no + 1;
       $sql = "update invpara set dag = $no2 where dag = $no";
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

    $sql = "Select * from dag where   refno ='" . $cuscode . "'";
    $result = $conn->query($sql);

    if ($rowM = $result->fetch()) {
        $ResponseXML .= "<id><![CDATA[" . json_encode($rowM) .  "]]></id>";
    }

    $ResponseXML .= "<sales_table><![CDATA[ <table class=\"table\">    ";

    $ResponseXML .= " <tr>
    <th>JOBNO</th>
    <th>SIZE</th>
    <th>BELT</th>
    <th>MARKER</th>
    <th>SERIAL NO</th>
    <th>WARRENTY</th>
    <th>REMARK</th>  
    </tr>";


    $sql1 = "Select * from dag_item where refno ='" . $cuscode . "'"; 
    foreach ($conn->query($sql1) as $row) {

       $ResponseXML .= "<tr>
       <td style=\"width:200px;\">" . $row['jobno'] . "</td>
        <td style=\"width:200px;\">" . $row['size'] . "</td>
        <td style=\"width:200px;\">" . $row['belt'] . "</td>
       <td style=\"width:200px;\">" . $row['marker'] . "</td> 
       <td style=\"width:200px;\">" . $row['serialno'] . "</td> 
       <td style=\"width:200px;\">" . $row['warrenty'] . "</td> 
       <td style=\"width:200px;\">" . $row['remark'] . "</td>    
       </tr>";  
   }

   $ResponseXML .= "   </table>]]></sales_table>"; 

   $ResponseXML .= "</salesdetails>";
   echo $ResponseXML;
}



if ($_POST["Command"] == "cancel_inv") {


    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->beginTransaction();
        
        $sql = "SELECT * from dag where  refno='".$_POST['refno']."' and cancel='1'";
        $result = $conn->query($sql);
        if ($row = $result->fetch()) {
            exit("Already Cancel DAG No...!!!");
        }
        $sql = "SELECT * from dag where  refno='".$_POST['refno']."'  ";
        $result = $conn->query($sql);
        if ($row = $result->fetch()) {
            $sql = "update dag set cancel = '1' where  refno='".$_POST['refno']."' ";
            $result = $conn->query($sql);
            $conn->commit();
            echo "Cancel";
        }

        



    } catch (Exception $e) {
        $conn->rollBack();
        echo $e;
    }
}


?>