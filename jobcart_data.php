<?php

session_start();


require_once ("connection_sql.php");

header('Content-Type: text/xml');

date_default_timezone_set('Asia/Colombo');

if ($_POST["Command"] == "getdt") {
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<new>";

    $sql = "SELECT jobcart FROM invpara";
    $result = $conn->query($sql);

    $row = $result->fetch();
    $no = $row['jobcart'];
    $uniq = uniqid();
    $ResponseXML .= "<id><![CDATA[$no]]></id>";
    $ResponseXML .= "<uniq><![CDATA[$uniq]]></uniq>";

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
        $i="";
        // $sql3 = "delete from t_jobcard_tmp   where jobno='".$_POST['code']."' and tmp_no='".$_POST['uniq']."'  ";
        // $result3 = $conn->query($sql3);
        

        
        $sql2 = "insert into t_jobcard_tmp(jobno,cardno,datein,cuscode,cusname,datefini,address1,treadpattern,serialno,make,tsize,j_type,STEP,tmp_no) values ('" . $_POST['code'] . "', '" . $_POST['jobref']  . "', '" . $_POST['sdate'] . "', '" . $_POST['cus_code'] . "', '" . $_POST['cus_name'] . "', '" . $_POST['fsdate'] . "', '" . $_POST['address'] . "', '" . $_POST['pattern'] . "', '" . $_POST['serialno'] . "', '" . $_POST['make'] . "', '" . $_POST['size'] . "', '" . $_POST['type'] . "','0', '" . $_POST['uniq'] . "')"; 
        $result2 = $conn->query($sql2);


        // echo "Saved";

    }
    if ($_POST['Command1'] == "del") {

        $sql = "delete from t_jobcard_tmp   where id='".$_POST['id']."'";  
        $result = $conn->query($sql);
    }

    $ResponseXML .= "<sales_table><![CDATA[<table class=\"table\">  ";
    $ResponseXML .= " <tr>
    <th>JOBNO</th>
    <th>CARD NO</th>
    <th>CUSNAME</th>
    <th>DATE FINISHED</th>
    <th>MAKE</th>
    <th>SIZE</th>
    <th>SERIAL NO</th>
    <th>THREAD PATTERN</th>
    <th>JOB TYPE</th>
    <th></th> 
    </tr>";
    

    $sql = "Select * from t_jobcard_tmp where jobno='".$_POST['code']."' and tmp_no='".$_POST['uniq']."'";
    foreach ($conn->query($sql) as $row) {

        $ResponseXML .= "<tr>
        <td style=\"width:200px;\">" . $row['jobno'] . "</td>
        <td style=\"width:200px;\">" . $row['cardno']."</td> 
        <td style=\"width:200px;\">" . $row['cusname'] . "</td> 
        <td style=\"width:200px;\">" . $row['datefini'] . "</td> 
        <td style=\"width:200px;\">" . $row['make'] . "</td> 
        <td style=\"width:200px;\">" . $row['tsize'] . "</td> 
        <td style=\"width:200px;\">" . $row['serialno'] . "</td> 
        <td style=\"width:200px;\">" . $row['treadpattern'] . "</td> 
        <td style=\"width:200px;\">" . $row['j_type'] . "</td>  
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


if ($_POST["Command"] == "save_item") {


    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->beginTransaction();
        
        $sql = "SELECT * from t_jobcard where  jobno  = '" . $_POST['code'] . "'"; 
        $result = $conn->query($sql);
        if ($row = $result->fetch()) {
            exit("Already Saved Job No...!!!");
        }
        $i=1;
        $sqltmp= "select * from t_jobcard_tmp where jobno='".$_POST['code']."' and tmp_no='".$_POST['uniq']."'";
        foreach ($conn->query($sqltmp) as $rowtmp) {
            $sql2 = "insert into t_jobcard(jobno,cardno,datein,cuscode,cusname,datefini,address1,treadpattern,serialno,make,tsize,j_type,STEP) values ('" . $_POST['code'] . "', '" . $rowtmp['cardno'].'/'.$i . "', '" . $rowtmp['datefini'] . "', '" . $rowtmp['cuscode'] . "', '" . $rowtmp['cusname'] . "', '" . $rowtmp['datefini'] . "', '" . $rowtmp['address1'] . "', '" . $rowtmp['treadpattern'] . "', '" . $rowtmp['serialno'] . "', '" . $rowtmp['make'] . "', '" . $rowtmp['tsize'] . "', '" . $rowtmp['j_type'] . "','" . $rowtmp['STEP'] . "')"; 
            $result2 = $conn->query($sql2); 
            $i= $i+1;
        }

        $sql = "delete from t_jobcard_tmp   where jobno='".$_POST['code']."' and tmp_no='".$_POST['uniq']."'";
        $result = $conn->query($sql);

        $sql = "SELECT jobcart FROM invpara";
        $resul = $conn->query($sql);
        $row = $resul->fetch();
        $no = $row['jobcart'];
        $no2 = $no + 1;
        $sql = "update invpara set jobcart = $no2 where jobcart = $no";
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

    $sql = "Select * from t_jobcard where   jobno ='" . $cuscode . "'";
    $result = $conn->query($sql);

    if ($rowM = $result->fetch()) {
        $ResponseXML .= "<id><![CDATA[" . json_encode($rowM) .  "]]></id>";
    }

    $ResponseXML .= "<sales_table><![CDATA[ <table class=\"table\">    ";

    $ResponseXML .= " <tr>
    <th>JOBNO</th>
    <th>CARD NO</th>
    <th>CUSNAME</th>
    <th>DATE FINISHED</th>
    <th>MAKE</th>
    <th>SIZE</th>
    <th>SERIAL NO</th>
    <th>THREAD PATTERN</th>
    <th>JOB TYPE</th>
    <th></th> 
    </tr>";


    $sql1 = "Select * from t_jobcard where jobno ='" . $cuscode . "'"; 
    foreach ($conn->query($sql1) as $row) {

     $ResponseXML .= "<tr>
     <td style=\"width:200px;\">" . $row['jobno'] . "</td>
     <td style=\"width:200px;\">" . $row['cardno'] . "</td> 
     <td style=\"width:200px;\">" . $row['cusname'] . "</td> 
     <td style=\"width:200px;\">" . $row['datefini'] . "</td> 
     <td style=\"width:200px;\">" . $row['make'] . "</td> 
     <td style=\"width:200px;\">" . $row['tsize'] . "</td> 
     <td style=\"width:200px;\">" . $row['serialno'] . "</td> 
     <td style=\"width:200px;\">" . $row['treadpattern'] . "</td> 
     <td style=\"width:200px;\">" . $row['j_type'] . "</td>  
     <td><button   onClick=\"del_item('" . $row['id'] . "')\" type=\"button\" class=\"btn btn-danger btnDelete btn-sm\">Remove</button>
     </td>
     </tr>";  
 }

 $ResponseXML .= "   </table>]]></sales_table>"; 

 $ResponseXML .= "</salesdetails>";
 echo $ResponseXML;
}

?>