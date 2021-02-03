
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">


    <title>Purchase Print</title>

    <style>
        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        .tb  {
           width: 800px;
           border: 1px solid black;


           border-collapse: collapse;
       }
       .tb td  {

           border-top: 1px solid black;
           border-left: 1px solid black;


           border-collapse: collapse;
       }
       .tb th  {

           border-top: 1px solid black;
           border-left: 1px solid black;


           border-collapse: collapse;
       }

       .tb1 {

           border: 1px solid #000000;
       }

   </style>

</head>
<?php
require_once ("connection_sql.php");
$sql = "Select * from s_purmas where REFNO='" . $_GET['invno'] . "'"; 
$result = $conn->query($sql);

if (!$row = $result->fetch()) {
    exit();
}

$sql = "Select * from s_ordmas where refno='" . $row['ORDNO'] . "'";
$result_ord = $conn->query($sql);

if (!$row_ord = $result_ord->fetch()) {
    
}

$sql_invpara = "SELECT * from invpara";
$result_invpara = $conn->query($sql_invpara);
$row_invpara = $result_invpara->fetch(); 



?>
<body>
    <table width="800px;" cellspacing="0" border="0">

        <tr>
            <th class="center"  colspan=5 ><?php echo  $row_invpara['COMPANY'] ?></th>
        </tr>
        <tr>
            <th class="center" colspan=5 ><?php echo $row_invpara['ADD1'] ?></th>
        </tr>
         
        <tr>
            <th class="center" colspan=5 >Office : <?php echo $row_invpara['TELE'] ?>, Fax: <?php echo $row_invpara['FAX'] ?></th>
        </tr>
        
        <tr>

            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>

            <td>Customer Name :<?php echo $row['SUP_NAME'] ?></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="right">Date: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $row['SDATE'] ?></td>
        </tr>
        <tr>

            <td>City : </td>
            <td></td>
            <td></td>
            <td></td>
            <td class="right">PURCHASE No: &nbsp;&nbsp; <?php echo $row['REFNO']; ?></td>
        </tr>
        <tr>

            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>

            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>

            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        
        <tr>

            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            
            <th class='center' colspan='5'> PURCHASE RECEIVED</th>
            

        </tr>
    </table>

    <table class="tb" >
        <tr >

            <th width="30px;">No</th> 
            <th width="200px;">Description</th>
            <th width="80px;">Qty</th>
            <th width="120px;">Rate</th>  
            <th width="120px;">Sub Total</th>
        </tr>
        <?php
       $i = 1;
$mnet = 0;
$qty=0;
 $part="";
        $sql = "Select * from s_purtrn where REFNO='" . $row["REFNO"] . "' order by ldate,id";
foreach ($conn->query($sql) as $row1) {
             $sql_smas = "SELECT * from s_mas where STK_NO='".$row1['STK_NO']."'";
    $result_smas = $conn->query($sql_smas);
    $row_smas= $result_smas->fetch(); 
    
    $subtotal = $row1['REC_QTY'] * $row1['COST'];
    $mnet = $mnet + $subtotal; 
            ?>
            <tr>
 

                <td class="center"><?php echo $i ?></td>
                  <tr>

            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
                
                <td class="left" ><?php echo $row_smas['DESCRIPT']; ?> </td>
                <td class="right"><?php echo number_format($row1['REC_QTY'], 0, ".", ","); ?></td>
                <td class="right"><?php echo number_format($row1['COST'], 2, ".", ","); ?></td> 
                <td class="right"><?php echo number_format($subtotal, 2, ".", ","); ?></td> 
            </tr>
            <?php
            $qty=$qty+$row1['REC_QTY'];
    $i = $i + 1;
    $part=$row1['ldate'];
        }
        
        ?>
 
     
     <tr>

        <td></td> 
        <td></td> 
        <td  class="right"  ><b>TOT QTY</b></td> 
        <td  class="right"><b><?php 
        echo  $qty ;

        ?></b></td>
        <td class="right"><b>SUB TOTAL</b></td>
        <td class="right"><b><?php echo number_format($mnet, 2, ".", ",")   ;?></b> </td>
    </tr>
    
    
     
   
     
</table>


</table>
<div style='height:150px;'></div>
<table width="800px;">
    <tr>
        <td> </td>
        <td>Prepared By:  .................     </td>
        <td></td> 
        <td class="center">Checked By:   .................</td>
        <td>&nbsp;&nbsp;&nbsp;</td>
        <td  class="right">&nbsp;&nbsp;&nbsp;&nbsp;Authorised By:.................</td>
    </tr>
</table>
<!-- ************************************************************************** -->
</body>

</html>
