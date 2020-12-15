
<?php

session_start();


require_once ("connection_sql.php");
header('Content-Type: text/xml');
date_default_timezone_set('Asia/Colombo');
if ($_POST["Command"] == "sendproduction") {
    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->beginTransaction();
        

        $sql = "UPDATE dag_item set flag='1'  where refno='" . $_POST['refno'] . "'";
        $result = $conn->query($sql); 

        $conn->commit();
        echo "Updated";

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
    
    


    $sql2 = "insert into produ_spareitem(refno,serialno,price,qty,total,spareitem) values ('" . $_POST['refno'] . "','" . $_POST['serialno'] . "','" . $_POST['price'] . "','" . $_POST['qty'] . "','" . $_POST['total'] . "','" . $_POST['spareitem'] . "')";  
    $result2 = $conn->query($sql2);




    $ResponseXML .= "<sales_table><![CDATA[<table class=\"table\">  ";
    $ResponseXML .= " <tr>
    <th>SIZE</th>.
    <th>MARKER</th>
    <th>SERIAL NO</th>
    <th>WARRENTY</th>
    <th>REMARK</th> 
    <th></th> 
    </tr>";
    

    $sql = "Select * from produ_spareitem";
    foreach ($conn->query($sql) as $row) {

        $ResponseXML .= "<tr> 
        <td style=\"width:200px;\">" . $row['refno']."</td> 
        <td style=\"width:200px;\">" . $row['serialno'] . "</td> 
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
    
    


    $sql2 = "insert into produ_workers(refno,serialno,hours,workers) values ('" . $_POST['refno'] . "','" . $_POST['serialno'] . "','" . $_POST['hours'] . "','" . $_POST['workers'] . "')";  
    $result2 = $conn->query($sql2);




    $ResponseXML .= "<sales_table><![CDATA[<table class=\"table\">  ";
    $ResponseXML .= " <tr>
    <th>NAME</th>.
    <th>HOURS</th> 
    <th></th> 
    </tr>";
    

    $sql = "Select * from produ_workers";
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

?>