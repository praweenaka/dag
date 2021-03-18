<?php session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<title>Print Advance</title>
<style type="text/css">
 
.companyname {
	color: #0000FF;
	font-weight: bold;
	font-size: 24px;
}

.com_address {
	color: #000000;
	font-weight: bold;
	font-size: 18px;
}

.heading {
	color: #000000;
	font-weight: bold;
	font-size: 20px;
}

body {
	color: #000000;
	font-size: 18px;
}
 
</style>
</head>

<body><center>

<?php 
 
    session_start();
include_once './connection_sql.php';
	
	 date_default_timezone_set('Asia/Colombo'); 
	 
	$sql="select * from s_adva where C_REFNO='".$_GET["invno"]."'";
	$result = $conn->query($sql); 
        $row = $result->fetch();  
	
	$sql1="select * from vendor where CODE='".$row["C_CODE"]."'";
 	$result1 = $conn->query($sql1); 
        $row1 = $result1->fetch(); 
	
	$address=$row1["ADD1"]." ".$row1["ADD2"];
	
	$sql_para="select * from invpara ";
	$result_para = $conn->query($sql_para); 
        $row_para = $result_para->fetch(); 
	?>
    
    <table width="1000"   border="0">
        <tr>
            <td  style="width: 500px">
                <p style="margin: 0px;color: #189ce7;font-size: 35px" ><i><b><?php echo $row_para["COMPANY"]; ?></b></i></p>
                <p style="margin: 0px;" ><i><b><?php echo $row_para["ADD1"].", ".$row_para["ADD2"].", " .$row_para["ADD3"] ?></b></i></p>
                <!--  <p style="margin: 0px;" ><i><b><?php echo $row_para["ADD1"].", ".$row_para["ADD2"].", " .$row_para["ADD3"]  ?></b></i></p>-->
                 
                <br>
                <p style="margin: 0px;font-size:35px" ><i><b>ADVANCE PAYMENT</b></i></p> 

                     
                </td>


            </tr>
            

        </table>
<table width="922" height="300" border="0">
   
  <tr>
    <td width="130">Customer :</td>
    <td  width="400"><?php echo $row["C_CODE"]; ?></td>
    <td width="100">Advance No :</td>
    <td width="207"><?php echo $_GET["invno"]; ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><?php echo $row1["NAME"]; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    
    <td><?php echo $address; ?></td>
    <td>Date :</td>
    <td><?php echo $row["C_DATE"]; ?></td>
  </tr>
 
 
  <tr>
    <td>Cheque Details
	</td>
    <td width="420">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td colspan="4"><table width="922" border="1" cellpadding="0" cellspacing="0">
      <tr>
        <th width="170" scope="col">Cheque. Date</th>
        <th width="170" scope="col">Cheque. No</th>
        <th width="170" scope="col">Bank</th>
        <th width="170" scope="col">Cheque. Amount</th>  
      </tr>
     <?php 
	 $totpay=0;
	$totcashtot=0;
	  
		
        $sql_inv="select * from s_invcheq where refno='".$_GET["invno"]."'"; 
        $result_inv = $conn->query($sql_inv); 
        $row_inv = $result_inv->fetch();
	 	 
	 
            if ($row["paytype"]!="Cash"){
	    echo "<tr>
        <td align=center>".$row_inv["che_date"]."</td>
        <td align=center>".$row_inv["cheque_no"]."</td>
         <td align=center>".$row_inv["bank"]."</td>"; 
		
        echo "<td align=center>".number_format($row_inv["che_amount"], 2, ".", ",")."</td>";
            }
		 
		
		 
		echo " 
      </tr>";  
	  ?>
     
    </table></td>
  </tr>
   
   
   
  
  
 
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>



  <tr>
    <td colspan="4"><table width="1000" border="0">
      
       
      
      <tr>
        <td><b><?php  
            if ($row["paytype"]=="Cash"){
                	echo "Cash Amount : ".number_format($row["C_PAYMENT"],2); 
            }else{
                	echo "Cheque Amount : ".number_format($row["C_PAYMENT"],2); 
            }
		
		  ?></b></td>
        <td>&nbsp;</td>
        <td>_________________</td>
        <td>&nbsp;</td>
        <td>_________________</td>
      </tr>
      <tr>
        <td><?php echo $_SESSION['UserName']." ".date("Y-m-d H:i:s"); ?></td>
        <td>&nbsp;</td>
        <td>Entered by</td>
        <td>&nbsp;</td>
        <td>Checked by</td>
      </tr>
</table>
</body>
</html>
