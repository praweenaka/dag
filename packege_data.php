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
    
    $sql_e = "SELECT sum(cost) as tot FROM packegelist_expense where code='" . $_POST['packegecode'] . "'  ";  
    $result_e = $conn->query($sql_e); 
    $row_e = $result_e->fetch();
    
    $cost=0;
    $cost=$row_e['tot']+$row_p['tot'] ;

    $sql = "update packegelist set   spcost='" . $row_p['tot'] . "',cost='" .$cost . "'    where code='" . $_POST['packegecode'] . "'  ";  
    $result = $conn->query($sql); 
     

    $ResponseXML .= "<sales_table><![CDATA[<table class=\"table\">  ";
    $ResponseXML .= " <tr>  
    </tr>";
    
$i=1;
$tot=0;
    $sql = "Select * from packegelist_spare where   code='" . $_POST['packegecode'] . "'  ";   
    foreach ($conn->query($sql) as $row) {

        $ResponseXML .= "<tr>  
        <td style=\"width:10px;\">" . $i. "</td> 
        <td style=\"width:200px;\">" . $row['spareitem'] . "</td> 
        <td style=\"width:200px;\">" . $row['cost'] . "</td> 
        <td style=\"width:200px;\">" . $row['qty'] . "</td> 
        <td style=\"width:200px;\">" . $row['total'] . "</td>  
        <td><button   onClick=\"del_spare('" . $row['id'] . "')\" type=\"button\" class=\"btn btn-danger btnDelete btn-sm\">Remove</button>
        </td>
        </tr>";  
    $i=$i+1;
    $tot=$tot+$row['total'];

    }
     $ResponseXML .= "<tr>  
        <td style=\"width:10px;\">&nbsp;</td> 
        <td style=\"width:200px;\"> </td> 
        <td style=\"width:200px;\"> </td> 
        <td style=\"width:200px;\"><b>Total</b> </td> 
        <td style=\"width:200px;\"><b>" . $tot . "</b></td>  
        <td>   </td>
        </tr>";

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

   
    
    $sql_p = "SELECT sum(total) as tot FROM packegelist_spare where code='" . $_POST['packegecode'] . "'  ";  
    $result_p = $conn->query($sql_p); 
    $row_p = $result_p->fetch();
    
    $sql_e = "SELECT sum(cost) as tot FROM packegelist_expense where code='" . $_POST['packegecode'] . "'  ";  
    $result_e = $conn->query($sql_e); 
    $row_e = $result_e->fetch();
    
    $cost=0;
    $cost=$row_e['tot']+$row_p['tot'] ;

    $sql = "update packegelist set   expense='" . $row_e['tot'] . "',cost='" .$cost . "'    where code='" . $_POST['packegecode'] . "'  ";  
    $result = $conn->query($sql); 
     
    

    $ResponseXML .= "<sales_table><![CDATA[<table class=\"table\">  ";
    $ResponseXML .= " <tr>  
    </tr>";
    
    $i=1;
    $tot=0;
    $sql = "Select * from packegelist_expense where   code='" . $_POST['packegecode'] . "'  "; 
    foreach ($conn->query($sql) as $row) {

        $ResponseXML .= "<tr>  
         <td style=\"width:10px;\">" . $i. "</td> 
        <td style=\"width:200px;\">" . $row['name'] . "</td> 
        <td style=\"width:200px;\">" . $row['cost'] . "</td>   
        <td><button   onClick=\"del_expense('" . $row['id'] . "')\" type=\"button\" class=\"btn btn-danger btnDelete btn-sm\">Remove</button>
        </td>
        </tr>";  
$i=$i+1;

    $tot=$tot+$row['cost'];

    }
     $ResponseXML .= "<tr>  
        <td style=\"width:10px;\">&nbsp;</td> 
        <td style=\"width:200px;\"> </td> 
        <td style=\"width:200px;\"> </td> 
        <td style=\"width:200px;\"><b>Total</b> </td> 
        <td style=\"width:200px;\"><b>" . $tot . "</b></td>  
        <td>   </td>
        </tr>";

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
    
    $cost=0;
    $cost=$row_spare['total']+$row_expen['total'];
    $spare=0;
    $spare=$row_spare['total'];
    $expense=0;
    $expense=$row_expen['total'] ;
    $wmargin=0;
    $wmargin=$row_pack['wmargin'];
    $wprice=0;
    $wprice=$row_pack['wprice'];
    
    
    
    
    $ResponseXML .= "<spare><![CDATA[" .  $spare . "]]></spare>";
    $ResponseXML .= "<cost><![CDATA[" .  $cost . "]]></cost>";
    $ResponseXML .= "<expense><![CDATA[" . $expense . "]]></expense>";
    $ResponseXML .= "<wmargin><![CDATA[" . $wmargin . "]]></wmargin>";
    $ResponseXML .= "<wprice><![CDATA[" . $wprice . "]]></wprice>";
    $ResponseXML .= "<rmargin><![CDATA[" . $row_pack['rmargin'] . "]]></rmargin>";
    $ResponseXML .= "<rprice><![CDATA[" . $row_pack['rprice'] . "]]></rprice>";

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

            $sql = "update packegelist set cost='" . $_POST['tot_cost'] . "',spcost='" . $_POST['spcost'] . "',expense='" . $_POST['fix_expen'] . "', wmargin= '" . $_POST['w_margin'] . "', wprice= '" . $_POST['wprice'] . "', rmargin= '" . $_POST['r_margin'] . "', rprice= '" . $_POST['rprice'] . "'    where code='" . $_POST['packegecode'] . "'";
            $result = $conn->query($sql);

            $conn->commit();
            echo "Updated";
        } 
    } catch (Exception $e) {
        $conn->rollBack();
        echo $e;
    }
    
}

if ($_POST["Command"] == "expensecost") {
 header('Content-Type: text/xml');
 
 $ResponseXML = "";
 $ResponseXML .= "<salesdetails>";
 $amou=0;
 $sqlisalma_q = "select * from expenses where name='" . $_POST["name"] . "'";
 $resultsalma_q = $conn->query($sqlisalma_q);
 if ($rowsalma_q = $resultsalma_q->fetch()) {
    $amou = $rowsalma_q['cost'];   
 }
  
$ResponseXML .= "<price><![CDATA[$amou]]></price>";
$ResponseXML .= "</salesdetails>";
echo $ResponseXML;
}

if ($_POST["Command"] == "spareprice") {
 header('Content-Type: text/xml');
 
 $ResponseXML = "";
 $ResponseXML .= "<salesdetails>";
 $amou=0;
 $sqlisalma_q = "select * from spareitem where name='" . $_POST["spareitem"] . "'";
 $resultsalma_q = $conn->query($sqlisalma_q);
 if ($rowsalma_q = $resultsalma_q->fetch()) {
    $amou = $rowsalma_q['sale'];   
 }
  
$ResponseXML .= "<price><![CDATA[$amou]]></price>";
$ResponseXML .= "</salesdetails>";
echo $ResponseXML;
}

?>