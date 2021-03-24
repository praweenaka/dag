
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">


    <title>Invoice Print</title>

    <style>
        /*.center {*/
        /*    text-align: center;*/
        /*}*/

        .right {
            text-align: right;
        }
        
        .tb  {
           width: 750px;
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

$sql = "Select * from s_salma where tmp_no='" . $_GET["tmp_no"] . "' and CANCELL='0'"; 
$result = $conn->query($sql);
$row = $result->fetch();

$sql1 = "Select * from vendor where CODE='" . $row["C_CODE"] . "'";
$result1 = $conn->query($sql1);
$row1 = $result1->fetch();


$sql_invpara = "SELECT * from invpara";
$result_invpara = $conn->query($sql_invpara);
$row_invpara = $result_invpara->fetch(); 



?>
<body>
    <table width="750px;" cellspacing="0" border="0">

        <tr>
            <th style="text-align: left;font-size:25px;"   colspan=1 ><?php echo "AKEESHA" ?></th>
        </tr>
        <tr>
            <th style="text-align: left;"  colspan=1 ><?php echo "ENTERPRISES PRIVATE LIMITED" ?></th>
        </tr>
        
         
        <tr>
            <th style="text-align: left;"  colspan=5 >Tel :<?php echo $row_invpara['TELE'] ?> </th>
        </tr>
         <tr>
            <th style="text-align: left;"  colspan=5 >Email :<?php echo $row_invpara['EMAIL'] ?> </th>
        </tr>
        
        <tr>

            <td></td>
            <td></td>
            <td style="text-align: center;font-size:25px;">INVOICE</td>
            <td></td>
            <td></td>
        </tr>
        <tr>

            <td>Customer Name :<?php echo $row['CUS_NAME'] ?></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="right">Date: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $row['SDATE'] ?></td>
        </tr>
        <tr>

            <td>City :<?php echo $row1['ADD1'] ?></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="right">Invoice No: &nbsp;&nbsp; <?php echo $row['REF_NO']; ?></td>
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
       
    </table>

    <table class="tb" width="750px;" >
        <tr >

            <!--<th width="30px;">No</th>-->
            <th width="80px;">CODE</th>
            <th width="200px;">PRODUCT</th>
            <th width="100px;">RATE</th> 
            <th width="80px;">Qty</th> 
            <th width="80px;">DIS</th> 
            <th width="100px;">SUB TOTAL</th>
        </tr>
        <?php
        $i=1;  
        $part="";
        $qty=0;
        $sql1 = "Select * from t_invo where refno='" . $row['REF_NO'] . "'    order by id asc";  
        foreach ($conn->query($sql1) as $row1) {
            $sql_smas = "SELECT * from s_mas where STK_NO='".$row1['STK_NO']."'";
            $result_smas = $conn->query($sql_smas);
            $row_smas= $result_smas->fetch(); 
            
            if($row1['type']=="dag"){ 
            ?>
            <tr>
  
                
                <td class="left" ><?php echo $row1['jobno']; ?> </td>
                <td class="left" ><?php echo $row1['make'].' '.$row1['size'].' '.$row1['design'].' SN- '.$row1['serialno']; ?> </td>
                <td class="right"><?php echo number_format($row1['selling'], 2, ".", ","); ?></td> 
                <td class="right"><?php echo number_format($row1['qty'], 0, ".", ","); ?></td>
                <td class="right"><?php echo number_format($row1['dis'], 2, ".", ","); ?></td> 
                 <td class="right"><?php echo number_format($row1['subtot'], 2, ".", ","); ?></td> 
            </tr>
            
             <?php    }else if($row1['type']=="product"){ ?>
                  <tr>
  
                
                <td class="left" ><?php echo $row1['stk_no']; ?> </td>
                <td class="left" ><?php echo $row1['name']; ?> </td>
                <td class="right"><?php echo number_format($row1['selling'], 2, ".", ","); ?></td> 
                <td class="right"><?php echo number_format($row1['qty'], 0, ".", ","); ?></td>
                <td class="right"><?php echo number_format($row1['dis'], 2, ".", ","); ?></td> 
                 <td class="right"><?php echo number_format($row1['subtot'], 2, ".", ","); ?></td> 
            </tr>
                 <?php    }else if($row1['type']=="service"){ 
                ?>
                <tr> 
                <td class="left" ><?php echo $row1['vehicleno']; ?> </td>  
                <td class="left" ><?php echo "SERVICE CHARGES"; ?> </td> 
                 <td class="right" ><?php echo $row1['selling']; ?> </td> 
                <td class="right" >1 </td> 
                 <td class="right" ><?php echo $row1['dis']; ?> </td> 
                <td class="right" ><?php echo $row1['subtot']; ?> </td> 
                 </tr>
        <?php }?>
        
            <?php
            $i=$i+1;
             $part=$row1['type'];
             $qty=$qty+$row1['QTY'];
        }
        ?>

        <?php

        $t=4;
        while ($i <$t) {

         echo "<tr>

         <td>&nbsp;</td>
         <td></td>
         <td></td>
         <td></td>
         <td></td> 
         <td></td> 
         </tr>";
         $i=$i+1;
     }

    //  $sql_invo = "Select sum(qty*selling) as subtot,PRICE from t_invo where refno='" . $row['REF_NO'] . "'  order by PART_NO desc";
    // $result_invo = $conn->query($sql_invo);
    // $row_invo= $result_invo->fetch(); 
    
    //  $sql_invo1 = "Select sum(qty*selling) as subtot,PRICE from t_invo where refno='" . $row['REF_NO'] . "'    order by PART_NO desc";
    // $result_invo1 = $conn->query($sql_invo1);
    // $row_invo1= $result_invo1->fetch(); 
     ?>
     
     
    
  
     
   
    <tr>

        <td></td>
        <td></td> 
        <td  class="right" colspan='3' style='font-size:15px;'><b>TOTAL</b></td> 
        <td class="right" style='font-size:20px;'><b><?php 
        echo number_format($row['GRAND_TOT'], 2, ".", ",");

        ?><b/></td>
    </tr>
     <tr>

        <td></td>
        <td></td> 
        <td  class="right" colspan='3' style='font-size:15px;'><b>DISCOUNT</b></td> 
        <td class="right" style='font-size:20px;'><b><?php 
        echo number_format($row['dis'], 2, ".", ",");

        ?><b/></td>
    </tr>
   
</table>


</table>

 

 <table width="750px;"   >
     <tr> 
        <td colspan="6">&nbsp;</td>  
        <td  class="right"   style='font-size:16px;'><b>GRAND TOTAL</b></td> 
        <td class="right"   style='font-size:20px;'><b><?php 
        echo number_format($row['GRAND_TOT'], 2, ".", ",");

        ?><b/></td>
    </tr>
     <tr> 
        <td colspan="6">&nbsp;</td>  
        <td  class="right"  style='font-size:16px;'><b>PAYMENT</b></td> 
        <td class="right"   style='font-size:20px;'><b><?php 
        echo number_format($row['TOTPAY'], 2, ".", ",");

        ?><b/></td>
    </tr>
     <tr> 
         <td colspan="6">&nbsp;</td>  
        <td  class="right"   style='font-size:16px;'><b>BALANCE</b></td> 
        <td class="right"   style='font-size:20px;'><b><?php 
        echo number_format($row['GRAND_TOT']-$row['TOTPAY'], 2, ".", ",");

        ?><b/></td>
    </tr>
</table>
        
<!--<div style='height:12px;'></div>-->
<table width="750px;" >
    <tr>
        <td> </td>
        <td>Prepared By:  .................     </td>
        <td></td> 
        <td class="center">Checked By:   .................</td>
        <td>&nbsp;&nbsp;&nbsp;</td>
        <td  class="right">&nbsp;&nbsp;&nbsp;&nbsp;Authorised By:.................</td>
    </tr> 
</table>
<table width="750px;" >
     <tr>
        <td> </td> 
    </tr>
    <tr>
        <td><p>Authorized Dealers in Demo Moter Spareparts.Specialist in (TATA,LEYLAND) Moter Spares & Engine Oil,Oil Filter & All Kind Of Brake Liner,All Kind Of tyres & Tubes.</p> </td> 
    </tr>
     <tr>
        <td><p>****** THANK YOU COME AGAIN ******</p> </td> 
    </tr>
</table>
<!-- ************************************************************************** -->
</body>

</html>
