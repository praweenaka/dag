
<?php

session_start();


require_once ("connection_sql.php");
header('Content-Type: text/xml');
date_default_timezone_set('Asia/Colombo');

 
 

if ($_POST["Command"] == "add_spare") {

  try {
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->beginTransaction();

    header('Content-Type: text/xml'); 
    
    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";
    
     
    $ResponseXML .= "<sales_table><![CDATA[<table class=\"table\">  ";
    $ResponseXML .= "  <tr>
                    <th>SPARE ITEM</th>
                    <th>PRICE</th>
                    <th>QTY</th> 
                    <th>TOTAL</th>   
                </tr> ";
    

    $sql = "Select * from produ_spareitem where refno='" . $_POST['refno'] . "' and  serialno='".$_POST['serialno']."'"; 
    foreach ($conn->query($sql) as $row) {

        $ResponseXML .= "<tr>  
        <td style=\"width:200px;\">" . $row['spareitem'] . "</td> 
        <td style=\"width:200px;\">" . $row['price'] . "</td> 
        <td style=\"width:200px;\">" . $row['qty'] . "</td> 
        <td style=\"width:200px;\">" . $row['total'] . "</td>  
       
        </tr>";  


    }

    $ResponseXML .= "</table>]]></sales_table>";   
    $ResponseXML .= "</salesdetails>";

    echo $ResponseXML;
    $conn->commit();
} catch (Exception $e) {
    $conn->rollBack();
    echo $e;
}
}

if ($_POST["Command"] == "add_workers") {

  try {
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->beginTransaction();

    header('Content-Type: text/xml'); 
    
    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";
    
    
 

    $ResponseXML .= "<sales_table><![CDATA[<table class=\"table\">  ";
    $ResponseXML .= "  <tr>
            <th>NAME</th> 
            <th>HOURS</th>  
        </tr>";
    

    $sql = "Select * from produ_workers where  refno='" . $_POST['refno'] . "' and  serialno='".$_POST['serialno']."'";  
    foreach ($conn->query($sql) as $row) {

        $ResponseXML .= "<tr> 
        <td style=\"width:200px;\">" . $row['workers']."</td> 
        <td style=\"width:200px;\">" . $row['hours'] . "</td>   
        </tr>";  


    }

    $ResponseXML .= "</table>]]></sales_table>";   
    $ResponseXML .= "</salesdetails>";

    echo $ResponseXML;
    $conn->commit();
} catch (Exception $e) {
    $conn->rollBack();
    echo $e;
}
}

 if ($_POST["Command"] == "add_builders") {

  try {
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->beginTransaction();

    header('Content-Type: text/xml'); 
    
    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";
   
    
 

    $ResponseXML .= "<sales_table><![CDATA[<table class=\"table\">  ";
    $ResponseXML .= "  <tr>
            <th>NAME</th> 
            <th>HOURS</th>  
        </tr>";
    

    $sql = "Select * from produ_builders where  refno='" . $_POST['refno'] . "' and  serialno='".$_POST['serialno']."'";  
    foreach ($conn->query($sql) as $row) {

        $ResponseXML .= "<tr> 
        <td style=\"width:200px;\">" . $row['workers']."</td> 
        <td style=\"width:200px;\">" . $row['hours'] . "</td>   
        </tr>";  


    }

    $ResponseXML .= "</table>]]></sales_table>";   
    $ResponseXML .= "</salesdetails>";

    echo $ResponseXML;
    $conn->commit();
} catch (Exception $e) {
    $conn->rollBack();
    echo $e;
}
}



if ($_POST["Command"] == "upjobno") {
    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->beginTransaction();
        // AK/6094
         $sql = "UPDATE dag_item set jobno='" . $_POST['newjobno'] . "'   where  refno='" . $_POST['refno'] . "' and  serialno='".$_POST['serialno']."'"; 
         $result = $conn->query($sql);  
        
        $sqllog = "insert into entry_log(refno, username, docname, trnType, stime, sdate) values ('" . trim($_POST['refno']) . "', '" . $_SESSION["CURRENT_USER"] . "', 'UPDATE JOB NO TO ".$_POST['newjobno']."', 'UPDATE JOB NO', '" . date("Y-m-d H:i:s") . "', '" . date("Y-m-d") . "')";
            $resultlog = $conn->query($sqllog);
         
            
        $conn->commit();
        echo "Updated JOB NO";

    } catch (Exception $e) {
        $conn->rollBack();
        echo $e;
    }
}

if ($_POST["Command"] == "canceldag") {
    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->beginTransaction();
         
         $sql = "SELECT * from t_invo where jobno='".$_POST['jobno']."'"; 
         $sql = $conn->query($sql);
         if (!$row=  $sql->fetch()) {
             $sql = "UPDATE dag_item set cancel='1'   where  refno='" . $_POST['refno'] . "' and  jobno='".$_POST['jobno']."'"; 
             $result = $conn->query($sql);  
            
             $sqllog = "insert into entry_log(refno, username, docname, trnType, stime, sdate) values ('" . trim($_POST['refno']) . "', '" . $_SESSION["CURRENT_USER"] . "', 'CANCEL DAG BY  ALL LIST ".$_POST['jobno']."', 'CANCEL DAG', '" . date("Y-m-d H:i:s") . "', '" . date("Y-m-d") . "')";
             $resultlog = $conn->query($sqllog);
             
              $conn->commit();
              
              echo "Updated JOB NO";
         }else{
             echo "Please First Cancel Invoice";
         }
            
       
        

    } catch (Exception $e) {
        $conn->rollBack();
        echo $e;
    }
}
?>