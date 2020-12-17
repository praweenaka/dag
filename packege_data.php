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
    
    
    if ($_POST['Command1'] == "del_item") {
        $sql = "delete from packegelist_spare where id='" . $_POST['id'] . "'  "; 
        $result = $conn->query($sql);
    }

    

    if ($_POST["Command1"] == "add_tmp") {

        $sql = "SELECT * FROM packegelist where code='" . $_POST['packegecode'] . "'  "; 
        $result = $conn->query($sql); 
        $row = $result->fetch();

        $sql2 = "insert into packegelist_spare(code,design,size,spareitem,cost,qty,total) values ('" . $row['code'] . "','" . $row['design'] . "','" . $row['size'] . "','" . $_POST['spareitem'] . "','" . $_POST['cost'] . "','" . $_POST['qty'] . "','" . $_POST['total'] . "')";  
        $result2 = $conn->query($sql2);

    }


    $ResponseXML .= "<sales_table><![CDATA[<table class=\"table\">  ";
    $ResponseXML .= " <tr>  
    </tr>";
    

    $sql = "Select * from packegelist_spare where   code='" . $_POST['packegecode'] . "'  "; 
    foreach ($conn->query($sql) as $row) {

        $ResponseXML .= "<tr>  
        <td style=\"width:200px;\">" . $row['spareitem'] . "</td> 
        <td style=\"width:200px;\">" . $row['cost'] . "</td> 
        <td style=\"width:200px;\">" . $row['qty'] . "</td> 
        <td style=\"width:200px;\">" . $row['total'] . "</td>  
        <td><button   onClick=\"del_spare('" . $row['id'] . "')\" type=\"button\" class=\"btn btn-danger btnDelete btn-sm\">Remove</button>
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


if ($_POST["Command"] == "add_expense") {

  try {
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->beginTransaction();

    header('Content-Type: text/xml'); 
    
    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";
    
    
    if ($_POST['Command1'] == "del_item") {
        $sql = "delete from packegelist_expense where id='" . $_POST['id'] . "'  "; 
        $result = $conn->query($sql);
    }

    

    if ($_POST["Command1"] == "add_tmp") {

        $sql = "SELECT * FROM packegelist_expense where code='" . $_POST['packegecode'] . "'  "; 
        $result = $conn->query($sql); 
        $row = $result->fetch();

        $sql2 = "insert into packegelist_expense(code,design,size,name,cost) values ('" . $row['code'] . "','" . $row['design'] . "','" . $row['size'] . "','" . $_POST['name'] . "','" . $_POST['cost'] . "')";  
        $result2 = $conn->query($sql2);

    }


    $ResponseXML .= "<sales_table><![CDATA[<table class=\"table\">  ";
    $ResponseXML .= " <tr>  
    </tr>";
    

    $sql = "Select * from packegelist_expense where   code='" . $_POST['packegecode'] . "'  "; 
    foreach ($conn->query($sql) as $row) {

        $ResponseXML .= "<tr>  
        <td style=\"width:200px;\">" . $row['name'] . "</td> 
        <td style=\"width:200px;\">" . $row['cost'] . "</td>   
        <td><button   onClick=\"del_expense('" . $row['id'] . "')\" type=\"button\" class=\"btn btn-danger btnDelete btn-sm\">Remove</button>
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