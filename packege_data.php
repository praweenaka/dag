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

    $sql_p = "SELECT sum(total) as tot FROM packegelist_spare where code='" . $_POST['packegecode'] . "'  ";  
    $result_p = $conn->query($sql_p); 
    $row_p = $result_p->fetch();


    $sql = "update packegelist set  cost='" . $row_p['tot'] . "'   where code='" . $_POST['packegecode'] . "'  ";  
    $result = $conn->query($sql);



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

        $sql = "SELECT * FROM packegelist where code='" . $_POST['packegecode'] . "'  ";  
        $result = $conn->query($sql); 
        $row = $result->fetch();

        $sql2 = "insert into packegelist_expense(code,design,size,name,cost) values ('" . $row['code'] . "','" . $row['design'] . "','" . $row['size'] . "','" . $_POST['name'] . "','" . $_POST['cost'] . "')";  
        $result2 = $conn->query($sql2);



    }

    $sql_p = "SELECT sum(cost) as tot FROM packegelist_expense where code='" . $_POST['packegecode'] . "'  ";  
    $result_p = $conn->query($sql_p); 
    $row_p = $result_p->fetch();


    $sql = "update packegelist set  expense='" . $row_p['tot'] . "'   where code='" . $_POST['packegecode'] . "'  ";  
    $result = $conn->query($sql);

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




if ($_POST["Command"] == "add_summeryview") {

  try {
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->beginTransaction();

    header('Content-Type: text/xml'); 
    
    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";
    
    $sql_spare = "SELECT sum(total) as total FROM packegelist_spare where code='" . $_POST['packegecode'] . "' and cancel='0'  ";  
    $result_spare = $conn->query($sql_spare); 
    $row_spare = $result_spare->fetch();

    $sql_expen = "SELECT sum(cost) as total FROM packegelist_expense where code='" . $_POST['packegecode'] . "' and cancel='0'  ";  
    $result_expen = $conn->query($sql_expen); 
    $row_expen = $result_expen->fetch();

    $sql_pack = "SELECT * FROM packegelist where code='" . $_POST['packegecode'] . "' and cancel='0'  ";  
    $result_pack = $conn->query($sql_pack); 
    $row_pack = $result_pack->fetch();

    $ResponseXML .= "<spare><![CDATA[" . number_format($row_spare['total'], 2, ".", ","). "]]></spare>";
    $ResponseXML .= "<expense><![CDATA[" .number_format($row_expen['total'], 2, ".", ","). "]]></expense>";
    $ResponseXML .= "<wmargin><![CDATA[" .number_format($row_pack['wmargin'], 2, ".", ","). "]]></wmargin>";
    $ResponseXML .= "<wprice><![CDATA[" .number_format($row_pack['wprice'], 2, ".", ","). "]]></wprice>";
    $ResponseXML .= "<rmargin><![CDATA[" .number_format($row_pack['rmargin'], 2, ".", ","). "]]></rmargin>";
    $ResponseXML .= "<rprice><![CDATA[" .number_format($row_pack['rprice'], 2, ".", ","). "]]></rprice>";

    $ResponseXML .= "</salesdetails>";

    echo $ResponseXML;
    $conn->commit();
} catch (Exception $e) {
    $conn->rollBack();
    echo $e;
}
}

if ($_POST["Command"] == "wpricecal") {
   header('Content-Type: text/xml');

   $ResponseXML = "";
   $ResponseXML .= "<salesdetails>";
   $total = 0;
   if ($_POST["spcost"] != '') { 
    if ($_POST["fix_expen"] != '') { 
        $total =  $_POST["fix_expen"] + $_POST["spcost"]+$_POST["w_margin"] ; 
    }  
}


// $tot = number_format($total);

$ResponseXML .= "<toot><![CDATA[$total]]></toot>";
$ResponseXML .= "</salesdetails>";
echo $ResponseXML;
}

if ($_POST["Command"] == "rpricecal") {
   header('Content-Type: text/xml');

   $ResponseXML = "";
   $ResponseXML .= "<salesdetails>";
   $total = 0;
   if ($_POST["spcost"] != '') { 
    if ($_POST["fix_expen"] != '') { 
        $total =  $_POST["fix_expen"] + $_POST["spcost"]+$_POST["r_margin"] ; 
    }  
}


// $tot = number_format($total);

$ResponseXML .= "<toot><![CDATA[$total]]></toot>";
$ResponseXML .= "</salesdetails>";
echo $ResponseXML;
}


if ($_POST["Command"] == "sparecal") {
   header('Content-Type: text/xml');

   $ResponseXML = "";
   $ResponseXML .= "<salesdetails>";
   $total = 0;
   if ($_POST["cost"] != '') { 
    if ($_POST["qty"] != '') { 
        $total =  $_POST["qty"] * $_POST["cost"] ; 
    }  
}


$ResponseXML .= "<toot><![CDATA[$total]]></toot>";
$ResponseXML .= "</salesdetails>";
echo $ResponseXML;
}


if ($_POST["Command"] == "updatepackege") {


    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->beginTransaction();

        $sqlisalma_q = "select * from packegelist where code='" . $_POST['packegecode'] . "'";
        $resultsalma_q = $conn->query($sqlisalma_q);
        if ($rowsalma_q = $resultsalma_q->fetch()) {

            $sql = "update packegelist set cost='" . $_POST['spcost'] . "',expense='" . $_POST['fix_expen'] . "', wmargin= '" . $_POST['w_margin'] . "', wprice= '" . $_POST['wprice'] . "', rmargin= '" . $_POST['r_margin'] . "', rprice= '" . $_POST['rprice'] . "'    where code='" . $_POST['packegecode'] . "'";
            $result = $conn->query($sql);

            $conn->commit();
            echo "Updated";
        } 
    } catch (Exception $e) {
        $conn->rollBack();
        echo $e;
    }
    
}

?>