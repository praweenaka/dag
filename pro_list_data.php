
<?php

session_start();


require_once ("connection_sql.php");
header('Content-Type: text/xml');
date_default_timezone_set('Asia/Colombo');
if ($_POST["Command"] == "sendonhand") {
    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->beginTransaction();
        

        $sql = "UPDATE dag_item set flag='0'  where refno='" . $_POST['refno'] . "' and  serialno='".$_POST['serialno']."'"; 
        $result = $conn->query($sql); 

        $conn->commit();
        echo "SEND ON HAND";

    } catch (Exception $e) {
        $conn->rollBack();
        echo $e;
    }
}

if ($_POST["Command"] == "sendreject") {
    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->beginTransaction();
        

        $sql = "UPDATE dag_item set cancel='1'  where refno='" . $_POST['refno'] . "' and  serialno='".$_POST['serialno']."'"; 
        $result = $conn->query($sql); 

        $conn->commit();
        echo "SEND TO REJECT";

    } catch (Exception $e) {
        $conn->rollBack();
        echo $e;
    }
}

if ($_POST["Command"] == "sendfinish") {
    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->beginTransaction();
        

        $sql = "UPDATE dag_item set flag='2',warrenty='" . $_POST['warranty'] . "',pro_date='" . date("Y-m-d") . "',design='" . $_POST['design'] . "'  where refno='" . $_POST['refno'] . "' and  serialno='".$_POST['serialno']."'"; 
        $result = $conn->query($sql); 

        $conn->commit();
        echo "SEND TO FINISH";

    } catch (Exception $e) {
        $conn->rollBack();
        echo $e;
    }
}

if ($_POST["Command"] == "add_spare") {

  try {
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->beginTransaction();

    header('Content-Type: text/xml'); 
    
    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";
    
    
    if ($_POST['Command1'] == "del_item") {
        $sql = "delete from produ_spareitem where id='" . $_POST['id'] . "'  ";
        $result = $conn->query($sql);
    }

    

    if ($_POST["Command1"] == "add_tmp") {

        $sql2 = "insert into produ_spareitem(refno,serialno,price,qty,total,spareitem) values ('" . $_POST['refno'] . "','" . $_POST['serialno'] . "','" . $_POST['price'] . "','" . $_POST['qty'] . "','" . $_POST['total'] . "','" . $_POST['spareitem'] . "')";  
        $result2 = $conn->query($sql2);

    }


    $ResponseXML .= "<sales_table><![CDATA[<table class=\"table\">  ";
    $ResponseXML .= " <tr>  
    </tr>";
    

    $sql = "Select * from produ_spareitem where refno='" . $_POST['refno'] . "' and  serialno='".$_POST['serialno']."'"; 
    foreach ($conn->query($sql) as $row) {

        $ResponseXML .= "<tr>  
        <td style=\"width:200px;\">" . $row['spareitem'] . "</td> 
        <td style=\"width:200px;\">" . $row['price'] . "</td> 
        <td style=\"width:200px;\">" . $row['qty'] . "</td> 
        <td style=\"width:200px;\">" . $row['total'] . "</td>  
        <td><button   onClick=\"del_item('" . $row['id'] . "')\" type=\"button\" class=\"btn btn-danger btnDelete btn-sm\">Remove</button>
        </td>
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
    
    
    if ($_POST['Command1'] == "del_item") {
        $sql = "delete from produ_workers where id='" . $_POST['id'] . "'  "; 
        $result = $conn->query($sql);
    }

    

    if ($_POST["Command1"] == "add_tmp") {


        $sql2 = "insert into produ_workers(refno,serialno,hours,workers) values ('" . $_POST['refno'] . "','" . $_POST['serialno'] . "','" . $_POST['hours'] . "','" . $_POST['workers'] . "')";  
        $result2 = $conn->query($sql2);


    }

    $ResponseXML .= "<sales_table><![CDATA[<table class=\"table\">  ";
    $ResponseXML .= " <tr>  </tr>";
    

    $sql = "Select * from produ_workers where  refno='" . $_POST['refno'] . "' and  serialno='".$_POST['serialno']."'";  
    foreach ($conn->query($sql) as $row) {

        $ResponseXML .= "<tr> 
        <td style=\"width:200px;\">" . $row['workers']."</td> 
        <td style=\"width:200px;\">" . $row['hours'] . "</td>   
        <td><button   onClick=\"del_itemworkers('" . $row['id'] . "')\" type=\"button\" class=\"btn btn-danger btnDelete btn-sm\">Remove</button>
        </td>
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


if ($_POST["Command"] == "totqty") {
 header('Content-Type: text/xml');
 
 $ResponseXML = "";
 $ResponseXML .= "<salesdetails>";
 $total = 0;
 if ($_POST["qty"] != '') { 
    if ($_POST["price"] != '') { 
        $total =  $_POST["qty"] * $_POST["price"] ; 
    }  
}


 

$ResponseXML .= "<toot><![CDATA[$total]]></toot>";
$ResponseXML .= "</salesdetails>";
echo $ResponseXML;
}
?>