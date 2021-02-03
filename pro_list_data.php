
<?php

session_start();


require_once ("connection_sql.php");
header('Content-Type: text/xml');
date_default_timezone_set('Asia/Colombo');
if ($_POST["Command"] == "sendonhand") {
    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->beginTransaction();
        
        $sqlR = "SELECT sum(total) as total,sum(cost)as cost FROM produ_spareitem where refno='" . $_POST['refno'] . "' and  serialno='".$_POST['serialno']."' ";  
        $resultR = $conn->query($sqlR); 
        $rowR = $resultR->fetch();

        $sql = "UPDATE dag_item set flag='0',repair=repair-'" . $rowR['total']. "',total=total-'" . $rowR['total']. "' ,cost=cost-'" . $rowR['cost']. "',repair_cost=repair_cost-'" . $rowR['cost']. "',pro_date=''  where refno='" . $_POST['refno'] . "' and  serialno='".$_POST['serialno']."'";  
        $result = $conn->query($sql); 
        
        $sql = "delete from produ_builders where refno='" . $_POST['refno'] . "' and  serialno='".$_POST['serialno']."'";  
        $result = $conn->query($sql);
        
        $sql = "delete from produ_workers where refno='" . $_POST['refno'] . "' and  serialno='".$_POST['serialno']."'";  
        $result = $conn->query($sql);
        
        $sql = "delete from produ_spareitem where refno='" . $_POST['refno'] . "' and  serialno='".$_POST['serialno']."'";  
        $result = $conn->query($sql);
        
        
        
        
        $sqllog = "insert into entry_log(refno, username, docname, trnType, stime, sdate) values ('" . trim($_POST['refno']) . "', '" . $_SESSION["CURRENT_USER"] . "', 'SEND PRO TO ONHAND', 'Save', '" . date("Y-m-d H:i:s") . "', '" . date("Y-m-d") . "')";
            $resultlog = $conn->query($sqllog);
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
        $sqllog = "insert into entry_log(refno, username, docname, trnType, stime, sdate) values ('" . trim($_POST['refno']) . "', '" . $_SESSION["CURRENT_USER"] . "', 'SEND PRO TO REJECT', 'Save', '" . date("Y-m-d H:i:s") . "', '" . date("Y-m-d") . "')";
            $resultlog = $conn->query($sqllog);
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
        
        $sqlR = "SELECT sum(total) as total,sum(cost)as cost FROM produ_spareitem where refno='" . $_POST['refno'] . "' and  serialno='".$_POST['serialno']."' and cancel='0'";  
        $resultR = $conn->query($sqlR); 
        $rowR = $resultR->fetch();
        
        $sqlP = "SELECT * FROM packegelist where design='" . $_POST['design'] . "' and size='" . $_POST['size'] . "'";
        $resultP = $conn->query($sqlP); 
        $rowP = $resultP->fetch();
        
        $sqlV = "SELECT * FROM vendor where NAME='" . $_POST['cusname'] . "' ";
        $resultV = $conn->query($sqlV); 
        $rowV = $resultV->fetch();
        $amou=0;
        $repair=0;
        $tot=0;
        if($rowV['cus_type']=="WHOLESALE"){
            $amou=$rowP['wprice'];
        }else if($rowV['cus_type']=="RETAIL"){
            $amou=$rowP['rprice'];
        } else {
            $amou=$rowP['rprice'];
        }    
        
         $repair=$rowR['total'];
         $tot=$amou+$repair;
         $cost=$rowP['cost']+$rowR['cost'];
        $sql = "UPDATE dag_item set amount='" . $amou . "',repair_cost='" . $rowR['cost'] . "',amount_cost='" . $rowP['cost'] . "',repair='" . $repair . "',cost=cost+'" . $cost. "',total=total+'" . $tot. "',flag='2',warrenty='" . $_POST['warranty'] . "',pro_date='" . date("Y-m-d") . "',com_date='" . date("Y-m-d") . "',design='" . $_POST['design'] . "'  where refno='" . $_POST['refno'] . "' and  serialno='".$_POST['serialno']."'"; 
        $result = $conn->query($sql);  
        
        $sqllog = "insert into entry_log(refno, username, docname, trnType, stime, sdate) values ('" . trim($_POST['refno']) . "', '" . $_SESSION["CURRENT_USER"] . "', 'SEND PRO TO COM', 'Save', '" . date("Y-m-d H:i:s") . "', '" . date("Y-m-d") . "')";
            $resultlog = $conn->query($sqllog);
            
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
        $sqlV = "SELECT * FROM spareitem where name='" . $_POST['spareitem'] . "' ";
        $resultV = $conn->query($sqlV); 
        $rowV = $resultV->fetch();
        
        $sql2 = "insert into produ_spareitem(refno,serialno,price,qty,total,spareitem,cost) values ('" . $_POST['refno'] . "','" . $_POST['serialno'] . "','" . $_POST['price'] . "','" . $_POST['qty'] . "','" . $_POST['total'] . "','" . $_POST['spareitem'] . "','".$rowV['cost']."')";  
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


if ($_POST["Command"] == "add_builders") {

  try {
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->beginTransaction();

    header('Content-Type: text/xml'); 
    
    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";
    
    
    if ($_POST['Command1'] == "del_item") {
        $sql = "delete from produ_builders where id='" . $_POST['id'] . "'  "; 
        $result = $conn->query($sql);
    }

    

    if ($_POST["Command1"] == "add_tmp") {


        $sql2 = "insert into produ_builders(refno,serialno,hours,workers) values ('" . $_POST['refno'] . "','" . $_POST['serialno'] . "','" . $_POST['hours1'] . "','" . $_POST['builders'] . "')";  
        $result2 = $conn->query($sql2);


    }

    $ResponseXML .= "<sales_table><![CDATA[<table class=\"table\">  ";
    $ResponseXML .= " <tr>  </tr>";
    

    $sql = "Select * from produ_builders where  refno='" . $_POST['refno'] . "' and  serialno='".$_POST['serialno']."'";  
    foreach ($conn->query($sql) as $row) {

        $ResponseXML .= "<tr> 
        <td style=\"width:200px;\">" . $row['workers']."</td> 
        <td style=\"width:200px;\">" . $row['hours'] . "</td>   
        <td><button   onClick=\"del_itembuilders('" . $row['id'] . "')\" type=\"button\" class=\"btn btn-danger btnDelete btn-sm\">Remove</button>
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