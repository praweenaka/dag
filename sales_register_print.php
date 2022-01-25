
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<?php

session_start();
date_default_timezone_set('Asia/Colombo');
?>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">


    <title><?php echo $_GET['type']?> REPORT</title>

    <style>
        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        .tb  {
           width: 1000px;
           border: 1px solid black;


           border-collapse: collapse;
       }
        
       .tb td  {

           border-top: 1px solid black;
           border-left: 1px solid black;
           font-size:18px;

           border-collapse: collapse;
       }
       .tb th  {

           border-top: 1px solid black;
           border-left: 1px solid black;


           border-collapse: collapse;
       }
       .tb2  {
           
           border: 1px solid black;


           border-collapse: collapse;
       }
       .tb2 td  {

           border-top: 1px solid black;
           border-left: 1px solid black;
           font-size:18px;

           border-collapse: collapse;
       }
       .tb2 th  {

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

 

$sql_invpara = "SELECT * from invpara";
$result_invpara = $conn->query($sql_invpara);
$row_invpara = $result_invpara->fetch(); 



?>
<body>
    <center>
    <table width="1000px;" cellspacing="0" border="0">

        <tr>
            <th class="center"  colspan=5 ><?php echo "AKEESHA DAG" ?></th>
        </tr> 
        
        <tr> 
            <th class='center' colspan='5'> <?php echo $_GET['type']?> REPORT - (<?php echo date('Y-m-d H:i:s');?>)</th> 
        </tr>
        <tr> 
        <?php 
         if($_GET['check'] =="on"){?>
            <th class='center' colspan='5'>DATE  <?php echo $_GET['dtfrom']?> To  <?php echo $_GET['dtto']?> </th> 
           <?php } ?>
        </tr>
        <tr> 
        <?php 
         if($_GET['cus_type'] !="ALL"){?>
            <th class='center' colspan='5'>CUSTOMER TYPE  <?php echo $_GET['cus_type']?>  </th> 
           <?php } ?>
        </tr> 
        <tr> 
        <?php 
         if($_GET['alltype'] !="ALL"){?>
            <th class='center' colspan='5'>TYPE  (<?php echo $_GET['alltype']?> ) </th> 
           <?php } ?>
        </tr> 
        <tr>

            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td align="right">&nbsp;</td>
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
<!--==================================================================================-->
    <?php 
    if($_GET['type']=="OUTSTANDING DETAIL"){
        ?>
                <table class="tb" width="1000px;" >
                <tr >
        
                    <th width="30px;">NO</th>
                    <th width="100px;">INVOICE NO</th>
                    <th width="100px;">INVOICE DATE</th>
                    <th width="400px;">CUSTOMER</th>
                    <th width="100px;">TYPE</th>
                    <th width="100px;">DAYS</th>
                    <th width="120px;">GRAND TOTAL</th>
                    <th width="100px;">PAID</th>  
                    <th width="100px;">BALANCE</th>
                </tr>
                <?php
                $i=1;  
                $part="";
                $BAL=0;
                $sql1 = "Select * from s_salma  where CANCELL='0'  and GRAND_TOT>TOTPAY  ";  
                if($_GET['cuscode'] !=""){
                     $sql1.=" and C_CODE='".$_GET['cuscode']."'"; 
                }
                if($_GET['cus_type'] !="ALL"){
                     if($_GET['cus_type'] =="WHOLESALE"){
                         $sql1.=" and (cus_type='".$_GET['cus_type']."' or cus_type='BOTH' )";
                     }else{
                         $sql1.=" and cus_type='".$_GET['cus_type']."'";
                     }
                }
              
                $sql1.=" order by  C_CODE,SDATE asc";
                
                
                foreach ($conn->query($sql1) as $row1) {
                     
                    ?>
                    <tr>
                         <?php  
                        
                        if($part!=$row1['C_CODE']){
                            $sqlven = "Select sum(GRAND_TOT-TOTPAY) as totout from s_salma  where CANCELL='0'  and GRAND_TOT>TOTPAY  and C_CODE='".$row1['C_CODE']."'";  
             
                            $resultven = $conn->query($sqlven); 
                            $rowven = $resultven->fetch();
                             echo "<td colspan=\"8\"><b>". $row1['CUS_NAME'] ."   </b></td>";
                             echo "<td colspan=\"1\" align=\"right\"><b>".number_format($rowven['totout'], 2, ".", ",")." </b></td>";
                            
                        } 
        ?>
                    </tr>
                    <tr style="font-size:13px;">
                
                        <td class="center"><?php echo $i ?></td>
                        
                        <?php  
                        
                       
                            $date1 = new DateTime($row1['SDATE']); 
                            $date2 = new DateTime(date('Y-m-d'));
                            $days  = $date2->diff($date1)->format('%a');
                        ?>
                        
                        <td class="left" ><?php echo $row1['REF_NO']; ?> </td>
                        <td class="left" ><?php echo $row1['SDATE']; ?> </td>
                         <td class="left" ><?php echo $row1['CUS_NAME']; ?> </td>
                         <td class="left" ><?php echo $row1['cus_type']; ?> </td>
                         
                         <td class="right" style="background-color:yellow;" ><?php echo $days; ?> </td>
                        <td align="right"><?php echo number_format($row1['GRAND_TOT'], 2, ".", ","); ?></td>
                        <td align="right"><?php echo number_format($row1['TOTPAY'], 2, ".", ","); ?></td> 
                        <td align="right" style="background-color:#52ebe4;"><?php echo number_format($row1['GRAND_TOT']-$row1['TOTPAY'], 2, ".", ","); ?></td> 
                    </tr>
                    
                    <tr>
                        
                    </tr>
                    <?php
                    $i=$i+1;
                     $part=$row1['C_CODE']; 
                     $BAL=$BAL+($row1['GRAND_TOT']-$row1['TOTPAY']);
                }
                ?>
           
           
            <tr>
        
                <td></td>
                <td></td> 
                <td  align="right" colspan='6' style='font-size:20px;'><b>Total Balance</b></td> 
                <td align="right" style='font-size:20px;'><b><?php 
                echo number_format($BAL, 2, ".", ",");
        
                ?><b/></td>
            </tr>
        </table>
  <?php  }
    
    ?>
    
    <!--===========================================================================================-->
    
      <?php 
    if($_GET['type']=="OUTSTANDING SUMMARY"){
        
                    $sql3 = "Select sum(GRAND_TOT) as AMOUNT,sum(TOTPAY) as PAY from s_salma  where CANCELL='0' and GRAND_TOT>TOTPAY and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' ";  
                if($_GET['cuscode']!=""){
                     $sql3.=" and C_CODE='".$_GET['cuscode']."'"; 
                }
                
                if($_GET['cus_type'] !="ALL"){
                     if($_GET['cus_type'] =="WHOLESALE"){
                         $sql3.=" and (cus_type='".$_GET['cus_type']."' or cus_type='BOTH' )";
                     }else{
                         $sql3.=" and cus_type='".$_GET['cus_type']."'";
                     }
                }
                
              
                $sql3.=" order by  C_CODE,SDATE asc";
                    $result3 = $conn->query($sql3); 
                    $row3 = $result3->fetch();
                    
         ?>
         <table width="1000px;"   border="1" >
              <tr>

            <td  colspan="1" class="right" style="background-color:yellow;font-size:23px;">TOTAL :<?php echo $row3['AMOUNT'] ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PAYMENTS:   <?php echo $row3['PAY'] ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;BALANCE:   <?php echo $row3['AMOUNT']-$row3['PAY'] ?></td>
              
        </tr>
              <tr> 
              <td>
                       
                                    
         <?php
                $i=1;  
                $part="";
                $BAL=0;
                $sql1 = "Select * from s_salma  where CANCELL='0'  and  SDATE>='" . $_GET["dtfrom"] . "' and GRAND_TOT>TOTPAY and SDATE<='" . $_GET["dtto"] . "' ";  
                if($_GET['cuscode']!=""){
                     $sql1.=" and C_CODE='".$_GET['cuscode']."'"; 
                }
                
                if($_GET['cus_type'] !="ALL"){
                     if($_GET['cus_type'] =="WHOLESALE"){
                         $sql1.=" and (cus_type='".$_GET['cus_type']."' or cus_type='BOTH' )";
                     }else{
                         $sql1.=" and cus_type='".$_GET['cus_type']."'";
                     }
                }
                
              
                $sql1.=" order by  C_CODE,SDATE asc";
                
                
                foreach ($conn->query($sql1) as $row) {
                      
                    ?>
     

    <table class="tb" width="1000px;"  >
        <tr>

            <td colspan="5">Customer Name :<?php echo $row['CUS_NAME'] ?></td>
             
            <td  colspan="1" class="right">Date:   <?php echo $row['SDATE'] ?></td>
        </tr>
         <tr>

            <td colspan="5">City :<?php echo $row1['ADD1'] ?> </td>
            
            <td colspan="1" class="right" >Invoice No: <?php echo" <a href=\"invoice_print_half.php?refno=" . $row['REF_NO']. "\" target=\"_blank\"  >".$row['REF_NO']."</a>";?></td>
        </tr>
         <tr>
     <td colspan="5" class="left">Vehicle No: &nbsp;&nbsp; <?php echo $row['dele_no']; ?></td>
              
            <td colspan="1" class="right"></td>
           
        </tr>
        
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
                <td class="left" ><?php     $remark="SERVICE CHARGES - ".$row1['employee'];
                echo $remark;  ?> </td> 
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

      
    
  
     
   
    <tr>

           <td  class="right" colspan='4' rowspan="3">
               <?php
               if($row['GRAND_TOT']-$row['TOTPAY']=="0.00"){ 
                 echo "   <center><h1 style=\"color:red\">PAID</h1></center>";
                 
              }
               ?>
           </td> 
           
        <td  class="right" colspan='1' style='font-size:15px;'><b>TOTAL</b></td> 
        <td class="right" style='font-size:20px;'><b><?php 
        echo number_format($row['GRAND_TOT'], 2, ".", ",");

        ?><b/></td>
    </tr>
     <tr>

       
        <td  class="right" colspan='1' style='font-size:15px;'><b>PAID</b></td> 
        <td class="right" style='font-size:20px;'><b><?php 
        echo number_format($row['TOTPAY'], 2, ".", ",");

        ?><b/></td>
    </tr>
    <tr>

       
        <td  class="right" colspan='1' style='font-size:15px;'><b>BALANCE</b></td> 
        <td class="right" style='font-size:20px;'><b><?php 
        echo number_format($row['GRAND_TOT']-$row['TOTPAY'], 2, ".", ",");

        ?><b/></td>
    </tr>
    <tr> <td colspan='6'>&nbsp;</td></tr>
    <tr>
        <td colspan="8">
            <table class="tb2"   >
         <tr style="background-color:#4aef84" > 
            <th colspan="10">PAYMENT HISTORY</th>  
        </tr>
        <tr > 
           
            <th colspan="2">REFNO</th>
            <th colspan="1">DATE</th>
            <th colspan="2">AMOUNT</th>  
            <th colspan="2">TYPE</th>  
            <th colspan="2">CHK NO</th>  
            <th colspan="2">CHK DATE</th>  
        </tr>
        
        <?php
        $i=1;  
        $part="";
        $qty=0;
        $sql2 = "Select * from s_sttr where ST_INVONO='" . $row['REF_NO'] . "'    order by id asc";   
        foreach ($conn->query($sql2) as $row2) {
            
            ?>
            <tr>
  
                   <td class="left" colspan="2"><?php echo $row2['ST_REFNO']; ?> </td>
                  <td class="center" colspan="1"><?php echo $row2['ST_DATE']; ?> </td>
                    <td class="right" colspan="2"><?php echo number_format($row2['ST_PAID'], 2, ".", ","); ?></td> 
                    <td class="center" colspan="2"><?php 
                        if($row2['ST_FLAG'] =="CAS"){
                            echo "CASH";  
                        }else if($row2['ST_FLAG'] =="CHK"){    
                            echo "CHEQUE";
                        }else{
                            echo "OTHER";
                        } 
                         ?> 
                    </td>
                    <td class="center" colspan="2"><?php 
                      if($row2['ST_FLAG']=="CAS"){
                            echo "";  
                        }else if($row2['ST_FLAG']=="CHK"){    
                           echo $row2['ST_CHNO']; 
                        }else{
                           echo $row2['ST_CHNO']; 
                        } 
                    ?>
                    </td>
                    <td class="center" colspan="2"><?php 
                         if($row2['ST_FLAG']=="CAS"){
                            echo "";  
                        }else if($row2['ST_FLAG']=="CHK"){    
                           echo $row2['st_chdate']; 
                        }else{
                           echo $row2['st_chdate']; 
                        } 
                        ?> 
                 </td>
            </tr>
            
             
        <?php }?>
         
</table> 
 
        </td>
    </tr>
    <tr> <td colspan='6'>&nbsp;</td></tr>
    <tr> <td colspan='6'>&nbsp;</td></tr>
    <tr> <td colspan='6'>&nbsp;</td></tr>
    <tr> <td colspan='6'>&nbsp;</td></tr>
</table>


    



 
    <?php  }
    ?>  
        
                                        </td>
                                    
     </tr > 
    </table>
    <?php  }
    
    ?>
    
    <!--=================================================================================-->
    
    
    <?php 
    if($_GET['type']=="RECEIPTCASH"){
        ?>
        <table class="tb" width="1000px;" >
                <tr >
        
                    <th width="30px;">NO</th>
                    <th width="100px;">RECEIPT NO</th>
                    <th width="100px;">RECEIPT DATE</th>
                    <th width="100px;">PAY TYPE</th>
                    <th width="400px;">CUSTOMER</th>
                    <th width="120px;">AMOUNT</th> 
                </tr>
                <?php
                $i=1;  
                $part="";
                $BAL=0;
                $sql1 = "Select * from s_crec  where CANCELL='0'  and pay_type='Cash'    ";  
                  if($_GET['check'] =="on"){
                     $sql1.=" and   CA_DATE>='" . $_GET["dtfrom"] . "' and CA_DATE<='" . $_GET["dtto"] . "'"; 
                 }
                if($_GET['cuscode']!=""){
                     $sql1.=" and CA_CODE='".$_GET['cuscode']."'"; 
                }
               
              
                $sql1.=" order by  CA_CODE,CA_DATE asc";
                
                
                foreach ($conn->query($sql1) as $row1) {
                      $sqlven = "SELECT * FROM vendor where CODE='".$row1['CA_CODE']."'";
                        $resultven = $conn->query($sqlven); 
                        $rowven = $resultven->fetch();
                    ?>
                    <tr style="font-size:13px;">
         
        
                        <td class="center"><?php echo $i ?></td>
                        
                        <td class="left" ><?php echo $row1['CA_REFNO']; ?> </td>
                        <td class="left" ><?php echo $row1['CA_DATE']; ?> </td>
                         
                        <td class="left" ><?php echo $row1['pay_type']; ?> </td>
                         <td class="left" ><?php echo $rowven['NAME']; ?> </td>
                        <td align="right"><?php echo number_format($row1['CA_AMOUNT'], 2, ".", ","); ?></td> 
                    </tr>
                    <?php
                    $i=$i+1;
                      
                     $BAL=$BAL+$row1['CA_AMOUNT'] ;
                }
                
                ?>
                 <tr>
         
                <td  align="right" colspan='5' style='font-size:20px;'><b>TOTAL CASH</b></td> 
                <td align="right" style='font-size:20px;'><b><?php 
                echo number_format($BAL, 2, ".", ",");
        
                ?><b/></td>
            </tr>
             <tr>
                  <td colspan="9"><b>CASH ADVANCE</b></td>
                    </tr>
           
                
                <?php
                     
                    $tot3=0; 
                    include './connection_sql.php';
 
                    $sql = "select * from s_adva  where cancel='0' and paytype ='CASH' ";
                    if($_GET['cuscode']!=""){
                         $sql.=" and C_CODE='".$_GET['cuscode']."'"; 
                    }
                     if($_GET['check'] =="on"){
                         $sql.=" and   C_DATE>='" . $_GET["dtfrom"] . "' and C_DATE<='" . $_GET["dtto"] . "'"; 
                    }
                    
                     
                     $sql.=" group by C_REFNO ";  
                  
                    foreach ($conn->query($sql) as $row) {

                        $sqlR = "SELECT * FROM vendor where CODE='" . $row['C_CODE'] . "' ";  
                        $resultR = $conn->query($sqlR); 
                        $rowR = $resultR->fetch();
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>     
                            <td><?php echo $row['C_REFNO']; ?></td> 
                            <td><?php echo $row['C_DATE']; ?></td>   
                            <td colspan='2'><?php echo $rowR['NAME']; ?></td>    
                            <td align="right"><?php echo number_format($row['C_PAYMENT'],2); ?></td>  
                              
                    </tr>

                    <?php
                    $i= $i+1;
                    $tot3= $tot3+ $row['C_PAYMENT']; 
                }
                ?>
          
           
            <tr>
         
                <td  align="right" colspan='5' style='font-size:20px;'><b>TOTAL ADVANCE</b></td> 
                  
                  
                <td align="right" style='font-size:20px;'><b><?php 
                echo number_format($tot3, 2, ".", ",");
        
                ?><b/></td> 
                
            </tr>
              
        
        
        
        
             <?php   if($_GET['cuscode']==""){?>
                 <tr>
                  <td colspan="9"><b>EXPENSES</b></td>
                    </tr>
                    <?php
                
                
                      $sql = "select * from payment  where cancel='0' and type='EXPENSE'  ";
                   
                     if($_GET['check'] =="on"){
                         $sql.=" and   sdate>='" . $_GET["dtfrom"] . "' and sdate<='" . $_GET["dtto"] . "'"; 
                     }
                     
                    
                 $tot1=0;
                    foreach ($conn->query($sql) as $row) {
 
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>     
                            <td><?php echo $row['refno']; ?></td> 
                            <td><?php echo $row['sdate']; ?></td>    
                            <td colspan='2'><?php echo $row['remark']; ?></td>   
                            <td align="right"><?php echo $row['amount']; ?></td>  
                              


                    </tr>

                    <?php
                    $i= $i+1; 
                     $tot1= $tot1+$row['amount']; 
                }
                ?>
          
           
            <tr>
        
                <td  align="right" colspan='5' style='font-size:20px;'><b>TOTAL EXPENSE</b></td> 
                <td align="right" style='font-size:20px;'><b><?php 
                echo number_format($tot1, 2, ".", ",");
        
                ?><b/></td>
            </tr>
            <tr>
                 <td colspan="9"><b>SALARY</b></td>
            </tr>
             <?php
                   
                    $tot2=0; 
                    include './connection_sql.php';
 
                    $sql = "select * from payment  where cancel='0' and type='SALARY'  ";
                   
                     if($_GET['check'] =="on"){
                         $sql.=" and   sdate>='" . $_GET["dtfrom"] . "' and sdate<='" . $_GET["dtto"] . "'"; 
                    }
                     
                    if($_GET['employee']!=""){
                         $sql.=" and name='".$_GET['employee']."'"; 
                    } 
                    
                 
                    foreach ($conn->query($sql) as $row) {
 
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>     
                            <td><?php echo $row['refno']; ?></td> 
                            <td><?php echo $row['sdate']; ?></td>   
                            <td><?php echo $row['name']; ?></td>     
                            <td><?php echo $row['remark']; ?></td>   
                            <td align="right"><?php echo $row['amount']; ?></td>  
                             
                        </td>   


                    </tr>

                    <?php
                    $i= $i+1; 
                     $tot2= $tot2+$row['amount']; 
                }
                ?>
          
           
            <tr>
         
                <td  align="right" colspan='5' style='font-size:20px;'><b>TOTAL SALARY</b></td> 
                <td align="right" style='font-size:20px;'><b><?php 
                echo number_format($tot2, 2, ".", ",");
        
                ?><b/></td> 
            </tr>
             <tr>
                 <td colspan="9"><b>OT</b></td>
            </tr>
             <?php
                   
                    $tot3=0; 
                    include './connection_sql.php';
 
                    $sql = "select * from payment  where cancel='0' and type='OT'  ";
                   
                     if($_GET['check'] =="on"){
                         $sql.=" and   sdate>='" . $_GET["dtfrom"] . "' and sdate<='" . $_GET["dtto"] . "'"; 
                    }
                     
                    if($_GET['employee']!=""){
                         $sql.=" and name='".$_GET['employee']."'"; 
                    } 
                    
                 
                    foreach ($conn->query($sql) as $row) {
 
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>     
                            <td><?php echo $row['refno']; ?></td> 
                            <td><?php echo $row['sdate']; ?></td>   
                            <td><?php echo $row['name']; ?></td>     
                            <td><?php echo $row['remark']; ?></td>   
                            <td align="right"><?php echo $row['amount']; ?></td>  
                             
                        </td>   


                    </tr>

                    <?php
                    $i= $i+1; 
                     $tot3= $tot3+$row['amount']; 
                }
                ?>
          
           
            <tr>
         
                <td  align="right" colspan='5' style='font-size:20px;'><b>TOTAL OT</b></td> 
                <td align="right" style='font-size:20px;'><b><?php 
                echo number_format($tot3, 2, ".", ",");
        
                ?><b/></td> 
            </tr>
             <tr>
          
                <td  align="right" colspan='5' style='font-size:20px;'><b>TOTAL BALANCE</b></td> 
                <td align="right" style='font-size:20px;'><b><?php 
                echo number_format($BAL+$tot3-$tot1-$tot2-$tot3, 2, ".", ",");
        
                ?><b/></td>
            </tr>
            
            <?php }?>
        </table>
   <?php  }
    
    ?>
    
    <!--===========================================================================================-->
    
    <?php 
    if($_GET['type']=="RECEIPTCHEQUE"){
        ?>
        <table class="tb" width="1000px;" >
                <tr >
        
                    <th width="30px;">NO</th>
                    <th width="100px;">RECEIPT NO</th>
                    <th width="100px;">RECEIPT DATE</th>
                    <th width="100px;">PAY TYPE</th>
                    <th width="400px;">CUSTOMER</th>
                    <th width="120px;">CHEQUE NO</th> 
                    <th width="120px;">CHEQUE DATE</th> 
                    <th width="120px;">SETTLE CHEQUE AMOUNT</th> 
                </tr>
                <?php
                $i=1;  
                $part="";
                $BAL=0;
                $sql1 = "Select * from s_sttr  where   ST_FLAG='CHK'    ";  
                  if($_GET['check'] =="on"){
                     $sql1.=" and   ST_DATE>='" . $_GET["dtfrom"] . "' and ST_DATE<='" . $_GET["dtto"] . "'"; 
                 }
                if($_GET['cuscode']!=""){
                     $sql1.=" and cus_code='".$_GET['cuscode']."'"; 
                }
               
              
                $sql1.=" order by  cus_code,ST_DATE asc";
                
                
                foreach ($conn->query($sql1) as $row1) {
                      $sqlven = "SELECT * FROM vendor where CODE='".$row1['cus_code']."'";
                        $resultven = $conn->query($sqlven); 
                        $rowven = $resultven->fetch();
                    ?>
                    <tr style="font-size:13px;">
         
        
                        <td class="center"><?php echo $i ?></td>
                        
                        <td class="left" ><?php echo $row1['ST_REFNO']; ?> </td>
                        <td class="left" ><?php echo $row1['ST_DATE']; ?> </td>
                        <td class="left" ><?php echo "CHEQUE"; ?> </td>
                        <td class="left" ><?php echo $rowven['NAME']; ?> </td>
                        <td class="left" ><?php echo $row1['ST_CHNO']; ?> </td>
                        <td class="left" ><?php echo $row1['st_chdate']; ?> </td> 
                        <td align="right"><?php echo number_format($row1['ST_PAID'], 2, ".", ","); ?></td> 
                    </tr>
                    <?php
                    $i=$i+1;
                      
                     $BAL=$BAL+$row1['ST_PAID'] ;
                }
                
                ?>
                 <tr>
         
                <td  align="right" colspan='7' style='font-size:20px;'><b>TOTAL CHEQUE</b></td> 
                <td align="right" style='font-size:20px;'><b><?php 
                echo number_format($BAL, 2, ".", ",");
        
                ?><b/></td>
            </tr>
            <tr>
                  <td colspan="9"><b>CHEQUE ADVANCE</b></td>
                    </tr>
           
                
                <?php
                     
                    $tot3=0; 
                    include './connection_sql.php';
 
                    $sql = "select * from s_adva  where cancel='0' and paytype ='CHEQUE' ";
                    if($_GET['cuscode']!=""){
                         $sql.=" and C_CODE='".$_GET['cuscode']."'"; 
                    }
                     if($_GET['check'] =="on"){
                         $sql.=" and   C_DATE>='" . $_GET["dtfrom"] . "' and C_DATE<='" . $_GET["dtto"] . "'"; 
                    }
                    
                     
                     $sql.=" group by C_REFNO ";  
                  
                    foreach ($conn->query($sql) as $row) {

                        $sqlR = "SELECT * FROM vendor where CODE='" . $row['C_CODE'] . "' ";  
                        $resultR = $conn->query($sqlR); 
                        $rowR = $resultR->fetch();
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>     
                            <td><?php echo $row['C_REFNO']; ?></td> 
                            <td><?php echo $row['C_DATE']; ?></td>   
                            <td colspan='3'><?php echo $rowR['NAME']; ?></td>    
                            <td align="right"><?php echo number_format($row['C_PAYMENT'], 2, ".", ","); ?></td>  
                              
                    </tr>

                    <?php
                    $i= $i+1;
                    $tot3= $tot3+ $row['C_PAYMENT']; 
                }
                ?>
          
           
            <tr>
         
                <td  align="right" colspan='7' style='font-size:20px;'><b>TOTAL ADVANCE</b></td> 
                  
                  
                <td align="right" style='font-size:20px;'><b><?php 
                echo number_format($tot3, 2, ".", ",");
        
                ?><b/></td> 
                
            </tr>
            
         <?php   if($_GET['cuscode']==""){?>
                 <tr>
                  <td colspan="9"><b>EXPENSES</b></td>
                    </tr>
                    <?php
                
                
                      $sql = "select * from payment  where cancel='0' and type='EXPENSE'  ";
                   
                     if($_GET['check'] =="on"){
                         $sql.=" and   sdate>='" . $_GET["dtfrom"] . "' and sdate<='" . $_GET["dtto"] . "'"; 
                     }
                     
                    
                 $tot1=0;
                    foreach ($conn->query($sql) as $row) {
 
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>     
                            <td><?php echo $row['refno']; ?></td> 
                            <td><?php echo $row['sdate']; ?></td>    
                            <td colspan='4'><?php echo $row['remark']; ?></td>   
                            <td align="right"><?php echo $row['amount']; ?></td>  
                              


                    </tr>

                    <?php
                    $i= $i+1; 
                     $tot1= $tot1+$row['amount']; 
                }
                ?>
          
           
            <tr>
        
                <td  align="right" colspan='7' style='font-size:20px;'><b>TOTAL EXPENSE</b></td> 
                <td align="right" style='font-size:20px;'><b><?php 
                echo number_format($tot1, 2, ".", ",");
        
                ?><b/></td>
            </tr>
            <tr>
                 <td colspan="9"><b>SALARY</b></td>
            </tr>
             <?php
                   
                    $tot2=0; 
                    include './connection_sql.php';
 
                    $sql = "select * from payment  where cancel='0' and type='SALARY'  ";
                   
                     if($_GET['check'] =="on"){
                         $sql.=" and   sdate>='" . $_GET["dtfrom"] . "' and sdate<='" . $_GET["dtto"] . "'"; 
                    }
                     
                    if($_GET['employee']!=""){
                         $sql.=" and name='".$_GET['employee']."'"; 
                    } 
                    
                 
                    foreach ($conn->query($sql) as $row) {
 
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>     
                            <td><?php echo $row['refno']; ?></td> 
                            <td><?php echo $row['sdate']; ?></td>   
                            <td><?php echo $row['name']; ?></td>     
                            <td colspan='3'><?php echo $row['remark']; ?></td>   
                            <td align="right"><?php echo $row['amount']; ?></td>  
                             
                        </td>   


                    </tr>

                    <?php
                    $i= $i+1; 
                     $tot2= $tot2+$row['amount']; 
                }
                ?>
          
           
            <tr>
         
                <td  align="right" colspan='7' style='font-size:20px;'><b>TOTAL SALARY</b></td> 
                <td align="right" style='font-size:20px;'><b><?php 
                echo number_format($tot2, 2, ".", ",");
        
                ?><b/></td> 
            </tr>
             <tr>
          
                <td  align="right" colspan='7' style='font-size:20px;'><b>TOTAL BALANCE</b></td> 
                <td align="right" style='font-size:20px;'><b><?php 
                echo number_format($BAL+$tot3-$tot1-$tot2, 2, ".", ",");
        
                ?><b/></td>
            </tr>
            
            <?php }?>
        </table>
   <?php  }
    
    ?>
    
    <!--===========================================================================================-->
    
    <?php 
    if($_GET['type']=="RECEIPTCASHTT"){
        ?>
        <table class="tb" width="1000px;" >
                <tr >
        
                    <th width="30px;">NO</th>
                    <th width="100px;">RECEIPT NO</th>
                    <th width="100px;">RECEIPT DATE</th>
                    <th width="100px;">PAY TYPE</th>
                    <th width="400px;">CUSTOMER</th>
                    <th width="120px;">AMOUNT</th> 
                </tr>
                <?php
                $i=1;  
                $part="";
                $BAL=0;
                $sql1 = "Select * from s_crec  where CANCELL='0'  and pay_type='Cash TT'    ";  
                  if($_GET['check'] =="on"){
                     $sql1.=" and   CA_DATE>='" . $_GET["dtfrom"] . "' and CA_DATE<='" . $_GET["dtto"] . "'"; 
                 }
                if($_GET['cuscode']!=""){
                     $sql1.=" and CA_CODE='".$_GET['cuscode']."'"; 
                }
               
              
                $sql1.=" order by  CA_CODE,CA_DATE asc";
                
                
                foreach ($conn->query($sql1) as $row1) {
                      $sqlven = "SELECT * FROM vendor where CODE='".$row1['CA_CODE']."'";
                        $resultven = $conn->query($sqlven); 
                        $rowven = $resultven->fetch();
                    ?>
                    <tr style="font-size:13px;">
         
        
                        <td class="center"><?php echo $i ?></td>
                        
                        <td class="left" ><?php echo $row1['CA_REFNO']; ?> </td>
                        <td class="left" ><?php echo $row1['CA_DATE']; ?> </td>
                        <td class="left" ><?php echo $row1['pay_type']; ?> </td>
                         <td class="left" ><?php echo $rowven['NAME']; ?> </td>
                        <td align="right"><?php echo number_format($row1['CA_AMOUNT'], 2, ".", ","); ?></td> 
                    </tr>
                    <?php
                    $i=$i+1;
                      
                     $BAL=$BAL+$row1['CA_AMOUNT'] ;
                }
                
                ?>
                 <tr>
         
                <td  align="right" colspan='5' style='font-size:20px;'><b>TOTAL CASH</b></td> 
                <td align="right" style='font-size:20px;'><b><?php 
                echo number_format($BAL, 2, ".", ",");
        
                ?><b/></td>
            </tr>
             <?php   if($_GET['cuscode']==""){?>
                 <tr>
                  <td colspan="9"><b>EXPENSES</b></td>
                    </tr>
                    <?php
                
                
                      $sql = "select * from payment  where cancel='0' and type='EXPENSE'  ";
                   
                     if($_GET['check'] =="on"){
                         $sql.=" and   sdate>='" . $_GET["dtfrom"] . "' and sdate<='" . $_GET["dtto"] . "'"; 
                     }
                     
                    
                 $tot1=0;
                    foreach ($conn->query($sql) as $row) {
 
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>     
                            <td><?php echo $row['refno']; ?></td> 
                            <td><?php echo $row['sdate']; ?></td>    
                            <td colspan='2'><?php echo $row['remark']; ?></td>   
                            <td align="right"><?php echo $row['amount']; ?></td>  
                              


                    </tr>

                    <?php
                    $i= $i+1; 
                     $tot1= $tot1+$row['amount']; 
                }
                ?>
          
           
            <tr>
        
                <td  align="right" colspan='5' style='font-size:20px;'><b>TOTAL EXPENSE</b></td> 
                <td align="right" style='font-size:20px;'><b><?php 
                echo number_format($tot1, 2, ".", ",");
        
                ?><b/></td>
            </tr>
            <tr>
                 <td colspan="9"><b>SALARY</b></td>
            </tr>
             <?php
                   
                    $tot2=0; 
                    include './connection_sql.php';
 
                    $sql = "select * from payment  where cancel='0' and type='SALARY'  ";
                   
                     if($_GET['check'] =="on"){
                         $sql.=" and   sdate>='" . $_GET["dtfrom"] . "' and sdate<='" . $_GET["dtto"] . "'"; 
                    }
                     
                    if($_GET['employee']!=""){
                         $sql.=" and name='".$_GET['employee']."'"; 
                    } 
                    
                 
                    foreach ($conn->query($sql) as $row) {
 
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>     
                            <td><?php echo $row['refno']; ?></td> 
                            <td><?php echo $row['sdate']; ?></td>   
                            <td><?php echo $row['name']; ?></td>     
                            <td><?php echo $row['remark']; ?></td>   
                            <td align="right"><?php echo $row['amount']; ?></td>  
                             
                        </td>   


                    </tr>

                    <?php
                    $i= $i+1; 
                     $tot2= $tot2+$row['amount']; 
                }
                ?>
          
           
            <tr>
         
                <td  align="right" colspan='5' style='font-size:20px;'><b>TOTAL SALARY</b></td> 
                <td align="right" style='font-size:20px;'><b><?php 
                echo number_format($tot2, 2, ".", ",");
        
                ?><b/></td> 
            </tr>
             <tr>
          
                <td  align="right" colspan='5' style='font-size:20px;'><b>TOTAL BALANCE</b></td> 
                <td align="right" style='font-size:20px;'><b><?php 
                echo number_format($BAL-$tot1-$tot2, 2, ".", ",");
        
                ?><b/></td>
            </tr>
            <?php }?>
        </table>
   <?php  }
    
    ?>
    
    <!--===========================================================================================-->
 
     
    <?php 
    if($_GET['type']=="RECEIPTALL"){
        ?>
        <table class="tb" width="1000px;" >
                <tr >
        
                    <th width="30px;">NO</th>
                    <th width="100px;">RECEIPT NO</th>
                    <th width="100px;">RECEIPT DATE</th>
                    <th width="100px;">PAY TYPE</th>
                    <th width="400px;">CUSTOMER</th>
                    <th width="120px;">AMOUNT</th> 
                </tr>
                <?php
                $i=1;  
                $part="";
                $BAL=0;
                $sql1 = "Select * from s_crec  where CANCELL='0'  and FLAG!='PAY'    ";  
                  if($_GET['check'] =="on"){
                     $sql1.=" and   CA_DATE>='" . $_GET["dtfrom"] . "' and CA_DATE<='" . $_GET["dtto"] . "'"; 
                 }
                if($_GET['cuscode']!=""){
                     $sql1.=" and CA_CODE='".$_GET['cuscode']."'"; 
                }
               
              
                $sql1.=" order by  CA_CODE,CA_DATE asc";
                
                
                foreach ($conn->query($sql1) as $row1) {
                      $sqlven = "SELECT * FROM vendor where CODE='".$row1['CA_CODE']."'";
                        $resultven = $conn->query($sqlven); 
                        $rowven = $resultven->fetch();
                    ?>
                    <tr style="font-size:13px;">
         
        
                        <td class="center"><?php echo $i ?></td>
                        
                        <td class="left" ><?php echo $row1['CA_REFNO']; ?> </td>
                        <td class="left" ><?php echo $row1['CA_DATE']; ?> </td>
                        <td class="left" ><?php echo $row1['pay_type']; ?> </td>
                         <td class="left" ><?php echo $rowven['NAME']; ?> </td>
                        <td align="right"><?php echo number_format($row1['CA_AMOUNT'], 2, ".", ","); ?></td> 
                    </tr>
                    <?php
                    $i=$i+1;
                      
                     $BAL=$BAL+$row1['CA_AMOUNT'] ;
                }
                
                ?>
                 <tr>
         
                <td  align="right" colspan='5' style='font-size:20px;'><b>Total AMOUNT</b></td> 
                <td align="right" style='font-size:20px;'><b><?php 
                echo number_format($BAL, 2, ".", ",");
        
                ?><b/></td>
            </tr>
                <tr>
                  <td colspan="6"><b>CASH ADVANCE</b></td>
                    </tr>
           
                
                <?php
                     
                    $tot3=0; 
                    include './connection_sql.php';
 
                    $sql = "select * from s_adva  where cancel='0' and paytype ='CASH' ";
                    if($_GET['cuscode']!=""){
                         $sql.=" and C_CODE='".$_GET['cuscode']."'"; 
                    }
                     if($_GET['check'] =="on"){
                         $sql.=" and   C_DATE>='" . $_GET["dtfrom"] . "' and C_DATE<='" . $_GET["dtto"] . "'"; 
                    }
                    
                     
                     $sql.=" group by C_REFNO ";  
                  
                    foreach ($conn->query($sql) as $row) {

                        $sqlR = "SELECT * FROM vendor where CODE='" . $row['C_CODE'] . "' ";  
                        $resultR = $conn->query($sqlR); 
                        $rowR = $resultR->fetch();
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>     
                            <td><?php echo $row['C_REFNO']; ?></td> 
                            <td><?php echo $row['C_DATE']; ?></td>   
                            <td colspan='2'><?php echo $rowR['NAME']; ?></td>    
                            <td align="right"><?php echo number_format($row['C_PAYMENT'],2); ?></td>  
                              
                    </tr>

                    <?php
                    $i= $i+1;
                    $tot3= $tot3+ $row['C_PAYMENT']; 
                }
                ?>
          
           
            <tr>
         
                <td  align="right" colspan='5' style='font-size:20px;'><b>TOTAL CASH ADVANCE</b></td> 
                  
                  
                <td align="right" style='font-size:20px;'><b><?php 
                echo number_format($tot3, 2, ".", ",");
        
                ?><b/></td> 
                
            </tr>
            
                <tr>
                  <td colspan="6"><b>CHEQUE ADVANCE</b></td>
                    </tr>
           
                
                <?php
                     
                    $tot4=0; 
                    include './connection_sql.php';
 
                    $sql = "select * from s_adva  where cancel='0' and paytype ='CHEQUE' ";
                    if($_GET['cuscode']!=""){
                         $sql.=" and C_CODE='".$_GET['cuscode']."'"; 
                    }
                     if($_GET['check'] =="on"){
                         $sql.=" and   C_DATE>='" . $_GET["dtfrom"] . "' and C_DATE<='" . $_GET["dtto"] . "'"; 
                    }
                    
                     
                     $sql.=" group by C_REFNO ";  
                  
                    foreach ($conn->query($sql) as $row) {

                        $sqlR = "SELECT * FROM vendor where CODE='" . $row['C_CODE'] . "' ";  
                        $resultR = $conn->query($sqlR); 
                        $rowR = $resultR->fetch();
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>     
                            <td><?php echo $row['C_REFNO']; ?></td> 
                            <td><?php echo $row['C_DATE']; ?></td>   
                            <td colspan='2'><?php echo $rowR['NAME']; ?></td>    
                            <td align="right"><?php echo number_format($row['C_PAYMENT'],2); ?></td>  
                              
                    </tr>

                    <?php
                    $i= $i+1;
                    $tot4= $tot4+ $row['C_PAYMENT']; 
                }
                ?>
          
           
            <tr>
         
                <td  align="right" colspan='5' style='font-size:20px;'><b>TOTAL CHEQUE ADVANCE</b></td> 
                  
                  
                <td align="right" style='font-size:20px;'><b><?php 
                echo number_format($tot4, 2, ".", ",");
        
                ?><b/></td> 
                
            </tr>
            
            <?php   if($_GET['cuscode']==""){?>
                 <tr>
                  <td colspan="9"><b>EXPENSES</b></td>
                    </tr>
                    <?php
                
                
                      $sql = "select * from payment  where cancel='0' and type='EXPENSE'  ";
                   
                     if($_GET['check'] =="on"){
                         $sql.=" and   sdate>='" . $_GET["dtfrom"] . "' and sdate<='" . $_GET["dtto"] . "'"; 
                     }
                     
                    
                 $tot1=0;
                    foreach ($conn->query($sql) as $row) {
 
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>     
                            <td><?php echo $row['refno']; ?></td> 
                            <td><?php echo $row['sdate']; ?></td>    
                            <td colspan='2'><?php echo $row['remark']; ?></td>   
                            <td align="right"><?php echo $row['amount']; ?></td>  
                              


                    </tr>

                    <?php
                    $i= $i+1; 
                     $tot1= $tot1+$row['amount']; 
                }
                ?>
          
           
            <tr> 
                <td  align="right" colspan='5' style='font-size:20px;'><b>TOTAL EXPENSE</b></td> 
                <td align="right" style='font-size:20px;'><b><?php 
                echo number_format($tot1, 2, ".", ",");
        
                ?><b/></td>
            </tr>
            <tr>
                 <td colspan="9"><b>SALARY</b></td>
            </tr>
             <?php
                   
                    $tot2=0; 
                    include './connection_sql.php';
 
                    $sql = "select * from payment  where cancel='0' and type='SALARY'  ";
                   
                     if($_GET['check'] =="on"){
                         $sql.=" and   sdate>='" . $_GET["dtfrom"] . "' and sdate<='" . $_GET["dtto"] . "'"; 
                    }
                     
                    if($_GET['employee']!=""){
                         $sql.=" and name='".$_GET['employee']."'"; 
                    } 
                    
                 
                    foreach ($conn->query($sql) as $row) {
 
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>     
                            <td><?php echo $row['refno']; ?></td> 
                            <td><?php echo $row['sdate']; ?></td>   
                            <td><?php echo $row['name']; ?></td>     
                            <td><?php echo $row['remark']; ?></td>   
                            <td align="right"><?php echo $row['amount']; ?></td>  
                             
                        </td>   


                    </tr>

                    <?php
                    $i= $i+1; 
                     $tot2= $tot2+$row['amount']; 
                }
                ?>
          
           
            <tr>
         
                <td  align="right" colspan='5' style='font-size:20px;'><b>TOTAL SALARY</b></td> 
                <td align="right" style='font-size:20px;'><b><?php 
                echo number_format($tot2, 2, ".", ",");
        
                ?><b/></td> 
            </tr>
             <tr>
          
                <td  align="right" colspan='5' style='font-size:20px;'><b>Total Balance</b></td> 
                <td align="right" style='font-size:20px;'><b><?php 
                echo number_format($BAL+$tot3+$tot4-$tot1-$tot2, 2, ".", ",");
        
                ?><b/></td>
            </tr>
            <?php  }
    
    ?>
        </table>
    <?php
    } 
    ?>
    
    <!--===========================================================================================-->
    
      <?php 
    if($_GET['type']=="INVOICE SUMMARY"){
        
                    $sql3 = "Select sum(GRAND_TOT) as AMOUNT,sum(TOTPAY) as PAY from s_salma  where CANCELL='0'  and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' ";  
                if($_GET['cuscode']!=""){
                     $sql3.=" and C_CODE='".$_GET['cuscode']."'"; 
                }
                
                if($_GET['cus_type'] !="ALL"){
                     if($_GET['cus_type'] =="WHOLESALE"){
                         $sql3.=" and (cus_type='".$_GET['cus_type']."' or cus_type='BOTH' )";
                     }else{
                         $sql3.=" and cus_type='".$_GET['cus_type']."'";
                     }
                }
                
              
                $sql3.=" order by  C_CODE,SDATE asc";
                    $result3 = $conn->query($sql3); 
                    $row3 = $result3->fetch();
                    
         ?>
         <table width="1000px;"   border="1" >
              <tr>

            <td  colspan="1" class="right" style="background-color:yellow;font-size:23px;">TOTAL :<?php echo $row3['AMOUNT'] ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PAYMENTS:   <?php echo $row3['PAY'] ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;BALANCE:   <?php echo $row3['AMOUNT']-$row3['PAY'] ?></td>
              
        </tr>
              <tr> 
              <td>
                       
                                    
         <?php
                $i=1;  
                $part="";
                $BAL=0;
                $sql1 = "Select * from s_salma  where CANCELL='0'  and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' ";  
                if($_GET['cuscode']!=""){
                     $sql1.=" and C_CODE='".$_GET['cuscode']."'"; 
                }
                
                if($_GET['cus_type'] !="ALL"){
                     if($_GET['cus_type'] =="WHOLESALE"){
                         $sql1.=" and (cus_type='".$_GET['cus_type']."' or cus_type='BOTH' )";
                     }else{
                         $sql1.=" and cus_type='".$_GET['cus_type']."'";
                     }
                }
                
              
                $sql1.=" order by  C_CODE,SDATE asc";
                
                
                foreach ($conn->query($sql1) as $row) {
                      
                    ?>
     

    <table class="tb" width="1000px;"  >
        <tr>

            <td colspan="5" style="background-color:#0099ab;">Customer Name :<?php echo $row['CUS_NAME'] ?></td>
             
            <td  colspan="1" class="right">Date:   <?php echo $row['SDATE'] ?></td>
        </tr>
         <tr>

            <td colspan="5">City :<?php echo $row1['ADD1'] ?> </td>
            
            <td colspan="1" class="right" >Invoice No: <?php echo" <a href=\"invoice_print_half.php?refno=" . $row['REF_NO']. "\" target=\"_blank\"  >".$row['REF_NO']."</a>";?></td>
        </tr>
         <tr>
     <td colspan="5" class="left">Vehicle No: &nbsp;&nbsp; <?php echo $row['dele_no']; ?></td>
              
            <td colspan="1" class="right"></td>
           
        </tr>
        
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
                <td class="left" ><?php     $remark="SERVICE CHARGES - ".$row1['employee'];
                echo $remark;  ?> </td> 
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

      
    
  
     
   
    <tr>

           <td  class="right" colspan='4' rowspan="3">
               <?php
               if($row['GRAND_TOT']-$row['TOTPAY']=="0.00"){ 
                 echo "   <center><h1 style=\"color:red\">PAID</h1></center>";
                 
              }
               ?>
           </td> 
           
        <td  class="right" colspan='1' style='font-size:15px;'><b>TOTAL</b></td> 
        <td class="right" style='font-size:20px;'><b><?php 
        echo number_format($row['GRAND_TOT'], 2, ".", ",");

        ?><b/></td>
    </tr>
     <tr>

       
        <td  class="right" colspan='1' style='font-size:15px;'><b>PAID</b></td> 
        <td class="right" style='font-size:20px;'><b><?php 
        echo number_format($row['TOTPAY'], 2, ".", ",");

        ?><b/></td>
    </tr>
    <tr>

       
        <td  class="right" colspan='1' style='font-size:15px;'><b>BALANCE</b></td> 
        <td class="right" style='font-size:20px;'><b><?php 
        echo number_format($row['GRAND_TOT']-$row['TOTPAY'], 2, ".", ",");

        ?><b/></td>
    </tr>
    <tr> <td colspan='6'>&nbsp;</td></tr>
    <tr>
        <td colspan="12">
            <table class="tb2"   >
         <tr style="background-color:#4aef84" > 
            <th colspan="12">PAYMENT HISTORY</th>  
        </tr>
        <tr > 
           
            <th colspan="2">REFNO</th>
            <th colspan="1">DATE</th>
            <th colspan="3">AMOUNT</th>  
            <th colspan="2">TYPE</th>  
            <th colspan="2">CHK NO</th>  
            <th colspan="2">CHK DATE</th>  
        </tr>
        
        <?php
        $i=1;  
        $part="";
        $qty=0;
        $sql2 = "Select * from s_sttr where ST_INVONO='" . $row['REF_NO'] . "'    order by id asc";   
        foreach ($conn->query($sql2) as $row2) {
            
            ?>
            <tr>
  
                   <td class="left" colspan="2"><?php echo $row2['ST_REFNO']; ?> </td>
                  <td class="center" colspan="1"><?php echo $row2['ST_DATE']; ?> </td>
                    <td class="right" colspan="3"><?php echo number_format($row2['ST_PAID'], 2, ".", ","); ?></td> 
                    <td class="center" colspan="2"><?php 
                        if($row2['ST_FLAG'] =="CAS"){
                            echo "CASH";  
                        }else if($row2['ST_FLAG'] =="CHK"){    
                            echo "CHEQUE";
                        }else{
                            echo "OTHER";
                        } 
                         ?> 
                    </td>
                    <td class="center" colspan="2"><?php 
                      if($row2['ST_FLAG']=="CAS"){
                            echo "";  
                        }else if($row2['ST_FLAG']=="CHK"){    
                           echo $row2['ST_CHNO']; 
                        }else{
                           echo $row2['ST_CHNO']; 
                        } 
                    ?>
                    </td>
                    <td class="center" colspan="2"><?php 
                         if($row2['ST_FLAG']=="CAS"){
                            echo "";  
                        }else if($row2['ST_FLAG']=="CHK"){    
                           echo $row2['st_chdate']; 
                        }else{
                           echo $row2['st_chdate']; 
                        } 
                        ?> 
                 </td>
            </tr>
            
             
        <?php }?>
         
</table> 
 
        </td>
    </tr>
    <tr> <td colspan='6'>&nbsp;</td></tr>
    <tr> <td colspan='6'>&nbsp;</td></tr>
    <tr> <td colspan='6'>&nbsp;</td></tr>
    <tr> <td colspan='6'>&nbsp;</td></tr>
</table>


    



 
    <?php  }
    ?>  
        
                                        </td>
                                    
     </tr > 
    </table>
    <?php  }
    
    ?>
    
    <!--===========================================================================================-->
 
  <?php 
    if($_GET['type']=="INVOICE DETAIL"){
        ?>
        <table class="tb" width="1000px;" >
                <tr >
        
                    <th width="30px;">NO</th>
                    <th width="100px;">INVOICE NO</th>
                    <th width="100px;">INVOICE DATE</th>
                    <th width="400px;">CUSTOMER</th>
                    <th width="120px;">PAY TYPE</th> 
                    <th width="120px;">AMOUNT</th> 
                </tr>
                <?php
                $i=1;  
                $part="";
                $BAL=0;
                $sql1 = "Select * from s_salma  where CANCELL='0'  and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' ";  
                if($_GET['cuscode']!=""){
                     $sql1.=" and C_CODE='".$_GET['cuscode']."'"; 
                }
                
                if($_GET['cus_type'] !="ALL"){
                     if($_GET['cus_type'] =="WHOLESALE"){
                         $sql1.=" and (cus_type='".$_GET['cus_type']."' or cus_type='BOTH' )";
                     }else{
                         $sql1.=" and cus_type='".$_GET['cus_type']."'";
                     }
                }
                
              
                $sql1.=" order by  C_CODE,SDATE asc";
                
                
                foreach ($conn->query($sql1) as $row1) {
                      
                    ?>
                    <tr style="font-size:13px;">
         
        
                        <td class="center"><?php echo $i ?></td>
                        
                        <td class="left" ><?php echo $row1['REF_NO']; ?> </td>
                        <td class="left" ><?php echo $row1['SDATE']; ?> </td>
                         <td class="left" ><?php echo $row1['CUS_NAME']; ?> </td>
                         <td class="left" ><?php echo $row1['TYPE']; ?> </td>
                        <td align="right"><?php echo number_format($row1['GRAND_TOT'], 2, ".", ","); ?></td> 
                    </tr>
                    <?php
                    $i=$i+1;
                      
                     $BAL=$BAL+$row1['GRAND_TOT'] ;
                }
                ?>
          
           
            <tr>
        
                <td></td>
                <td></td> 
                <td  align="right" colspan='3' style='font-size:20px;'><b>TOTAL AMOUNT</b></td> 
                <td align="right" style='font-size:20px;'><b><?php 
                echo number_format($BAL, 2, ".", ",");
        
                ?><b/></td>
            </tr>
        </table>
   <?php  }
    
    ?>
    
      <!--===========================================================================================-->
      
      <?php 
    if($_GET['type']=="SERIAL NO COUNT"){
        ?>
        <table class="tb" width="1000px;" >
                <tr >
        
                    <th width="30px;">NO</th> 
                    <th width="100px;">SERIAL NO</th> 
                    <th width="120px;">COUNT</th> 
                </tr>
                <?php
                $i=1;  
                $part="";
                $BAL=0;
                $sql1 = "Select count(*) as count,serialno from dag_item  where cancel='0'    ";  
                if($_GET['serialno']!=""){
                     $sql1.=" and serialno='".$_GET['serialno']."'"; 
                }
                if($_GET['check'] =="on"){
                         $sql1.=" and   sdate>='" . $_GET["dtfrom"] . "' and sdate<='" . $_GET["dtto"] . "'"; 
                }
                
                
               
              
                $sql1.=" group by  serialno asc";  
                
                
                foreach ($conn->query($sql1) as $row1) {
                      
                    ?>
                    <tr style="font-size:15px;">
         
        
                        <td class="center"><?php echo $i ?></td>
                         
                        <td class="left" ><?php echo $row1['serialno']; ?> </td> 
                        <td class="center" ><?php echo $row1['count']; ?> </td> 
                    </tr>
                    <?php
                    $i=$i+1;
                      
                      
                }
                ?>
          
           
             
        </table>
   <?php  }
    
    ?>
    
      <!--===========================================================================================-->
 
  <?php 
    if($_GET['type']=="CUSTOMER SUMMARY"){
        ?>
        <table class="tb" width="1000px;" >
                <tr >
        
                    <th width="30px;">NO</th>
                    <th width="400px;">CUSTOMER</th>
                    <th width="100px;">TOTAL DAG</th>
                    <th width="100px;">CURRENT ONHAND</th>
                    <th width="100px;">TOTAL ONHAND</th> 
                    <th width="120px;">CURRENT PRODUCTION</th>
                    <th width="120px;">TOTAL PRODUCTION</th> 
                    <th width="120px;">CURRENT COMPLETE</th> 
                    <th width="120px;">TOTAL COMPLETE</th> 
                    <th width="120px;">INVOICED</th> 
                    <th width="120px;">REJECTED & INVOICED</th> 
                    <th width="120px;">REJECTED</th> 
                </tr>
                <?php
                $i=1;  
                    
                    $sql_1 = "SELECT count(*)  as count,cuscode,cusname from dag_item where  cancel='0' and   sdate>='" . $_GET["dtfrom"] . "' and sdate<='" . $_GET["dtto"] . "' ";
                    if($_GET['cuscode'] !=""){ 
                             $sql_1.=" and cuscode='".$_GET['cuscode']."'"; 
                     } 
                    $sql_1.=" order by  cuscode asc"; 
                    $result_1 = $conn->query($sql_1);
                    $row_1 = $result_1->fetch();
                    
                    $sql_2 = "SELECT count(*)  as count,cuscode,cusname from dag_item where    flag='0' and cancel='0' and reject ='0' and  sdate>='" . $_GET["dtfrom"] . "' and sdate<='" . $_GET["dtto"] . "' ";
                    if($_GET['cuscode'] !=""){ 
                             $sql_2.=" and cuscode='".$_GET['cuscode']."'"; 
                    } 
                    $sql_2.=" order by  cuscode asc"; 
                    $result_2 = $conn->query($sql_2);
                    $row_2 = $result_2->fetch();
                     
                    
                     $sql_3 = "SELECT count(*)  as count,cuscode,cusname from dag_item where    flag='1' and cancel='0' and reject ='0'  and  onhand_date>='" . $_GET["dtfrom"] . "' and onhand_date<='" . $_GET["dtto"] . "' ";
                    if($_GET['cuscode'] !=""){ 
                             $sql_3.=" and cuscode='".$_GET['cuscode']."'"; 
                    } 
                    $sql_3.=" order by  cuscode asc";  
                    $result_3 = $conn->query($sql_3);
                    $row_3 = $result_3->fetch();
                    
                      $sql_4 = "SELECT count(*)  as count,cuscode,cusname from dag_item where      flag !='0'  and cancel='0' and reject ='0'  and  onhand_date>='" . $_GET["dtfrom"] . "' and onhand_date<='" . $_GET["dtto"] . "' ";
                    if($_GET['cuscode'] !=""){ 
                             $sql_4.=" and cuscode='".$_GET['cuscode']."'"; 
                    } 
                    $sql_4.=" order by  cuscode asc";  
                    $result_4 = $conn->query($sql_4);
                    $row_4 = $result_4->fetch();
                    
                    $sql_5 = "SELECT count(*) as count,cuscode,cusname from dag_item where (flag !='0' or flag !='1') and cancel='0' and reject ='0' and pro_date>='" . $_GET["dtfrom"] . "' and pro_date<='" . $_GET["dtto"] . "' ";
                    if($_GET['cuscode'] !=""){ 
                             $sql_5.=" and cuscode='".$_GET['cuscode']."'"; 
                    } 
                    $sql_5.=" order by  cuscode asc";    
                    $result_5 = $conn->query($sql_5);
                    $row_5 = $result_5->fetch();
                              
                     $sql_6= "SELECT count(*)  as count,cuscode,cusname from dag_item where    (flag !='0' and flag !='1' and flag !='7' )  and cancel='0' and reject ='0'  and  pro_date>='" . $_GET["dtfrom"] . "' and pro_date<='" . $_GET["dtto"] . "' ";
                    if($_GET['cuscode'] !=""){ 
                             $sql_6.=" and cuscode='".$_GET['cuscode']."'"; 
                    } 
                    $sql_6.=" order by  cuscode asc";  
                    $result_6 = $conn->query($sql_6);
                    $row_6 = $result_6->fetch();
           
           
     
                    $sql_7= "SELECT count(*)  as count,cuscode,cusname from dag_item where  (flag='2' or flag='7') and cancel='0' and reject='0' and  com_date>='" . $_GET["dtfrom"] . "' and com_date<='" . $_GET["dtto"] . "' ";
                    if($_GET['cuscode'] !=""){ 
                             $sql_7.=" and cuscode='".$_GET['cuscode']."'"; 
                    } 
                    $sql_7.=" order by  cuscode asc";  
                    $result_7 = $conn->query($sql_7);
                    $row_7 = $result_7->fetch();
                    
                    $sql_8= "SELECT count(*)  as count,cuscode,cusname from dag_item where flag ='7' and  cancel='0' and reject='0' and  inv_date>='" . $_GET["dtfrom"] . "' and inv_date<='" . $_GET["dtto"] . "' ";
                    if($_GET['cuscode'] !=""){ 
                             $sql_8.=" and cuscode='".$_GET['cuscode']."'"; 
                    } 
                    $sql_8.=" order by  cuscode asc";  
                    $result_8 = $conn->query($sql_8);
                    $row_8 = $result_8->fetch();
                    
                    $sql_9= "SELECT count(*)  as count,cuscode,cusname from dag_item where flag ='7' and  cancel='0' and reject='1' and  inv_date>='" . $_GET["dtfrom"] . "' and inv_date<='" . $_GET["dtto"] . "' ";
                    if($_GET['cuscode'] !=""){ 
                             $sql_9.=" and cuscode='".$_GET['cuscode']."'"; 
                    } 
                    $sql_9.=" order by  cuscode asc";  
                    $result_9 = $conn->query($sql_9);
                    $row_9 = $result_9->fetch();
                    
                    $sql_10= "SELECT count(*)  as count,cuscode,cusname from dag_item where flag!='7' and  cancel='0' and reject='1' and  sdate>='" . $_GET["dtfrom"] . "' and sdate<='" . $_GET["dtto"] . "' ";
                    if($_GET['cuscode'] !=""){ 
                             $sql_10.=" and cuscode='".$_GET['cuscode']."'"; 
                    } 
                    $sql_10.=" order by  cuscode asc";  
                    $result_10 = $conn->query($sql_10);
                    $row_10= $result_10->fetch();
                     
                
                      
                    ?>
                    <tr style="font-size:13px;">
          
                            <td class="center"><?php echo $i ?></td> 
                            <td class="left" ><?php echo $row_1['cusname']; ?> </td>
                            <td class="left" ><?php echo $row_1['count']; ?> </td>
                            <td class="left" ><?php echo $row_2['count']; ?> </td> 
                            <td class="left" ><?php echo $row_4['count']; ?> </td>
                            <td class="left" ><?php echo $row_3['count']; ?> </td>
                            <td class="left" ><?php echo $row_5['count']; ?> </td>
                            <td class="left" ><?php echo $row_6['count']; ?> </td> 
                            <td class="left" ><?php echo $row_7['count']; ?> </td>
                            <td class="left" ><?php echo $row_8['count']; ?> </td> 
                            <td class="left" ><?php echo $row_9['count']; ?> </td> 
                            <td class="left" ><?php echo $row_10['count']; ?> </td> 
                    </tr> 
          
           
           
        </table>
   <?php  }
    
    ?>
    
    
    
    <!--===========================================================================================-->
 
  <?php 
    if($_GET['type']=="SETTLEMENT"){
        ?>
        <table class="tb" width="1000px;" >
                <tr >
        
                    <th width="30px;">NO</th>
                    <th width="100px;">INVOICE NO</th>
                    <th width="100px;">INVOICE DATE</th> 
                    <th width="400px;">CUSTOMER</th>
                    <th width="100px;">INVOICE AMOUNT</th> 
                    <th width="100px;">INVOICE PAID</th> 
                    <th width="100px;">INVOICE BALANCE</th> 
                    <th width="100px;">RECEIPT DATE</th>
                    <th width="100px;">RECEIPT NO</th>
                    <th width="120px;">RECEIPT AMOUNT</th> 
                </tr>
                <?php
                $i=1;  
                $part="";
                $BAL=0;
                $sql1 = "Select * from s_salma  where CANCELL='0' and TOTPAY!='0' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' ";  
                if($_GET['cuscode']!=""){
                     $sql1.=" and C_CODE='".$_GET['cuscode']."'"; 
                }
                
                 if($_GET['cus_type'] !="ALL"){
                     if($_GET['cus_type'] =="WHOLESALE"){
                         $sql1.=" and (cus_type='".$_GET['cus_type']."' or cus_type='BOTH' )";
                     }else{
                         $sql1.=" and cus_type='".$_GET['cus_type']."'";
                     }
                }
              
                $sql1.=" order by  C_CODE,SDATE asc";
                
                $part="";
                $bal=0;
                $invtot=0;
                $paid=0;
                foreach ($conn->query($sql1) as $row1) {
                       $sql2 = "Select * from s_sttr  where ST_INVONO='" . $row1["REF_NO"] . "'   ";  
                       foreach ($conn->query($sql2) as $row2) {
                         ?>
                        
                        
                        <tr style="font-size:13px;"> 
                           
                        <?php   
                          if($part!=$row2['ST_INVONO']){ ?>
                               <td class="center"><?php echo $i ?></td> 
                            <td class="left" ><?php echo $row2['ST_INVONO']; ?> </td>
                            <td class="left" ><?php echo $row1['SDATE']; ?> </td>
                            <td class="left" ><?php echo $row1['CUS_NAME']; ?> </td>
                            <td class="right" ><?php echo $row1['GRAND_TOT']; ?> </td>
                            <td class="right" ><?php echo number_format($row1['TOTPAY'],2); ?> </td>
                            <td class="right" ><?php echo number_format($row1['GRAND_TOT']-$row1['TOTPAY'],2); ?> </td>
                            <td class="left" ><?php echo $row2['ST_DATE']; ?> </td>
                             <td class="left" ><?php echo $row2['ST_REFNO']; ?> </td>
                            <td align="right" style="background-color:#52ebe4"><?php echo number_format($row2['ST_PAID'], 2, ".", ","); ?></td> 
                       <?php  }else{?>
                       <td class="center"><?php echo $i ?></td> 
                          <td class="center" colspan="6"></td>  
                            <td class="left" ><?php echo $row2['ST_DATE']; ?> </td>
                            <td class="left" ><?php echo $row2['ST_REFNO']; ?> </td>
                            <td align="right" style="background-color:#52ebe4"><?php echo number_format($row2['ST_PAID'], 2, ".", ","); ?></td> 
                       <?php  }
                         ?>
                           
                        </tr>
                        <?php
                        $i=$i+1;
                        $part=$row2['ST_INVONO'];
                          
                         $invtot=$invtot+$row1['GRAND_TOT'] ;
                         $bal=$bal+($row1['GRAND_TOT']-$row1['TOTPAY']) ;
                         $paid=$paid+$row2['ST_PAID'] ; 
                    }
                }
                ?>
         
              
           
            <tr>
        
                <td></td>
                <td colspan='3'></td> 
                <td align="right" style='font-size:20px;'><b><?php echo number_format($invtot, 2, ".", ",");?><b/></td>
                 <td align="right" style='font-size:20px;'><b><?php echo number_format($paid, 2, ".", ",");?><b/></td>
                 <td align="right" style='font-size:20px;'><b><?php echo number_format($bal, 2, ".", ",");?><b/></td>
                 <td colspan='2'></td> 
                <td align="right" style='font-size:20px;'><b><?php echo number_format($paid, 2, ".", ",");?><b/></td>
            </tr>
        </table>
   <?php  }
    
    ?>
    
      <!--===========================================================================================-->
 
 <?php 
    if($_GET['type']=="DAGLIST"){
        ?>
         <table   width="1000px;" >
             <?php
             
                    include './connection_sql.php';
 
                    $sql = "select COUNT(*) as count from dag_item WHERE   cancel='0'   ";  
                    if($_GET['cuscode']!=""){
                         $sql.=" and cuscode='".$_GET['cuscode']."'"; 
                    }
                     if($_GET['check'] =="on"){
                         $sql.=" and   sdate>='" . $_GET["dtfrom"] . "' and sdate<='" . $_GET["dtto"] . "'"; 
                    }
                    if($_GET['jobno']!=""){
                         $sql.=" and jobno='".$_GET['jobno']."'"; 
                    } 
                     if($_GET['cus_type'] !="ALL"){
                         if($_GET['cus_type'] =="WHOLESALE"){
                             $sql.=" and (cus_type='".$_GET['cus_type']."' or cus_type='BOTH' )";
                         }else{
                             $sql.=" and cus_type='".$_GET['cus_type']."'";
                         }
                    }
                    $sql.=" order by jobno asc";  
                    $result1 = $conn->query($sql); 
                    $row1 = $result1->fetch();
                    ?>
                    <tr>
                         <th align="right"  >Total Count :</th> 
                         <th align="left"><?php  echo $row1['count'];?></th> 
                         <th>&nbsp;</th> 
                         <th>&nbsp;</th>
                         <th>&nbsp;</th>  
                         <th>&nbsp;</th> 
                         <th>&nbsp;</th> 
                         <th>&nbsp;</th> 
                         <th>&nbsp;</th> 
                         <th>&nbsp;</th> 
                         <th>&nbsp;</th> 
                    </tr>
             </table>       
        <table class="tb" width="1000px;" >
            
                <tr>
                        <th>#</th>
                        <th>JOB NO</th> 
                        <th>INVOICE NO</th>
                        <th>DATE</th>   
                        <th>CUSTOMER</th>
                        <th>MAKE</th> 
                        <th>SIZE</th>  
                        <th>BELT</th>  
                        <th>SERIAL NO</th>  
                        <th>CASING COST</th>  
                        <th>REMARK</th>   
                    </tr>
                <?php
                    $i=1;
                    $cas=0;
                    include './connection_sql.php';
 
                    $sql = "select * from dag_item WHERE     cancel='0'   ";  
                    if($_GET['cuscode']!=""){
                         $sql.=" and cuscode='".$_GET['cuscode']."'"; 
                    }
                     if($_GET['check'] =="on"){
                         $sql.=" and   sdate>='" . $_GET["dtfrom"] . "' and sdate<='" . $_GET["dtto"] . "'"; 
                    }
                    if($_GET['jobno']!=""){
                         $sql.=" and jobno='".$_GET['jobno']."'"; 
                    } 
                     if($_GET['cus_type'] !="ALL"){
                         if($_GET['cus_type'] =="WHOLESALE"){
                             $sql.=" and (cus_type='".$_GET['cus_type']."' or cus_type='BOTH' )";
                         }else{
                             $sql.=" and cus_type='".$_GET['cus_type']."'";
                         }
                    }
                    $sql.=" order by jobno asc"; 
                    foreach ($conn->query($sql) as $row) {


                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>  
                            <td><?php echo $row['jobno']; ?></td>   
                            <td><?php echo $row['refno']; ?></td> 
                            <td><?php echo $row['sdate']; ?></td>   
                            <td><?php echo $row['cuscode'].'-'.$row['cusname']; ?></td> 
                            <td><?php echo $row['marker']; ?></td>   
                            <td><?php echo $row['size']; ?></td>   
                            <td><?php echo $row['belt']; ?></td>   
                            <td><?php echo $row['serialno']; ?></td>   
                            <td><?php echo $row['cascost']; ?></td>  
                            <td><?php echo $row['remark']; ?></td>  
                             
                        </td>   


                    </tr>

                    <?php
                    $i= $i+1;
                    $cas= $cas+$row['cascost'];
                }
                ?>
          
           
            <tr>
        
                <td></td>
                <td></td> 
                <td  align="right" colspan='7' style='font-size:20px;'><b>TOTAL AMOUNT</b></td> 
                <td align="right" style='font-size:20px;'><b><?php 
                echo number_format($cas, 2, ".", ",");
        
                ?><b/></td>
                <td></td>
            </tr>
        </table>
   <?php  }
    
    ?>
    
     <!--===========================================================================================-->
  <?php 
    if($_GET['type']=="ONHANDLIST"){
        ?>
         <table   width="1000px;" >
             <?php
             
                    include './connection_sql.php';
 
                    
                    if($_GET['alltype'] !="ALL"){
                        $sql = "select COUNT(*) as count from dag_item WHERE flag='0' and cancel='0' and reject ='0'   ";  
                        if($_GET['check'] =="on"){
                            $sql.=" and   sdate>='" . $_GET["dtfrom"] . "' and sdate<='" . $_GET["dtto"] . "'"; 
                        } 
                    }else{
                        $sql = "select COUNT(*) as count from dag_item WHERE flag !='0' and cancel='0' and reject ='0'   ";  
                        if($_GET['check'] =="on"){
                            $sql.=" and   onhand_date>='" . $_GET["dtfrom"] . "' and onhand_date<='" . $_GET["dtto"] . "'"; 
                        } 
                    }
                    if($_GET['cuscode']!=""){
                         $sql.=" and cuscode='".$_GET['cuscode']."'"; 
                    }
                   
                    if($_GET['jobno']!=""){
                         $sql.=" and jobno='".$_GET['jobno']."'"; 
                    } 
                     if($_GET['cus_type'] !="ALL"){
                         if($_GET['cus_type'] =="WHOLESALE"){
                             $sql.=" and (cus_type='".$_GET['cus_type']."' or cus_type='BOTH' )";
                         }else{
                             $sql.=" and cus_type='".$_GET['cus_type']."'";
                         }
                    }
                    $sql.=" order by jobno asc";  
                    $result1 = $conn->query($sql); 
                    $row1 = $result1->fetch();
                    ?>
                    <tr>
                         <th align="right"  >Total Count :</th> 
                         <th align="left"><?php  echo $row1['count'];?></th> 
                         <th>&nbsp;</th> 
                         <th>&nbsp;</th>
                         <th>&nbsp;</th>  
                         <th>&nbsp;</th> 
                         <th>&nbsp;</th> 
                         <th>&nbsp;</th> 
                         <th>&nbsp;</th> 
                         <th>&nbsp;</th> 
                         <th>&nbsp;</th> 
                    </tr>
             </table>       
        <table class="tb" width="1000px;" >
            
                <tr>
                        <th>#</th>
                        <th>JOB NO</th> 
                        <th>INVOICE NO</th>
                        <th>DATE</th>   
                        <th>CUSTOMER</th>
                        <th>MAKE</th> 
                        <th>SIZE</th>  
                        <th>BELT</th>  
                        <th>SERIAL NO</th>  
                        <th>CASING COST</th>  
                        <th>REMARK</th>   
                    </tr>
                <?php
                    $i=1;
                    $cas=0;
                    include './connection_sql.php';
 
                    if($_GET['alltype'] !="ALL"){
                         $sql = "select * from dag_item WHERE flag='0' and cancel='0' and reject ='0'   ";  
                         if($_GET['check'] =="on"){
                            $sql.=" and   sdate>='" . $_GET["dtfrom"] . "' and sdate<='" . $_GET["dtto"] . "'"; 
                         }
                    }else{
                        $sql = "select * from dag_item WHERE flag !='0' and cancel='0' and reject ='0'   ";  
                        if($_GET['check'] =="on"){
                            $sql.=" and   onhand_date>='" . $_GET["dtfrom"] . "' and onhand_date<='" . $_GET["dtto"] . "'"; 
                        }
                    }
                    if($_GET['cuscode']!=""){
                         $sql.=" and cuscode='".$_GET['cuscode']."'"; 
                    }
                     
                    if($_GET['jobno']!=""){
                         $sql.=" and jobno='".$_GET['jobno']."'"; 
                    } 
                     if($_GET['cus_type'] !="ALL"){
                         if($_GET['cus_type'] =="WHOLESALE"){
                             $sql.=" and (cus_type='".$_GET['cus_type']."' or cus_type='BOTH' )";
                         }else{
                             $sql.=" and cus_type='".$_GET['cus_type']."'";
                         }
                    }
                    $sql.=" order by jobno asc";   
                    foreach ($conn->query($sql) as $row) {


                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>  
                            <td><?php echo $row['jobno']; ?></td>   
                            <td><?php echo $row['refno']; ?></td> 
                            <td><?php echo $row['sdate']; ?></td>   
                            <td><?php echo $row['cuscode'].'-'.$row['cusname']; ?></td> 
                            <td><?php echo $row['marker']; ?></td>   
                            <td><?php echo $row['size']; ?></td>   
                            <td><?php echo $row['belt']; ?></td>   
                            <td><?php echo $row['serialno']; ?></td>   
                            <td><?php echo $row['cascost']; ?></td>  
                            <td><?php echo $row['remark']; ?></td>  
                             
                        </td>   


                    </tr>

                    <?php
                    $i= $i+1;
                    $cas= $cas+$row['cascost'];
                }
                ?>
          
           
            <tr>
        
                <td></td>
                <td></td> 
                <td  align="right" colspan='7' style='font-size:20px;'><b>TOTAL AMOUNT</b></td> 
                <td align="right" style='font-size:20px;'><b><?php 
                echo number_format($cas, 2, ".", ",");
        
                ?><b/></td>
                <td></td>
            </tr>
        </table>
   <?php  }
    
    ?>
    
     <!--===========================================================================================-->
 
  <?php 
    if($_GET['type']=="PRODUCTIONLIST"){
        ?>
        <?php
                    $i=1;
                    $tot=0;
                    include './connection_sql.php';
                    
                    if($_GET['alltype'] !="ALL"){
                         $sql = "select count(*) as count from dag_item WHERE flag='1' and cancel='0' and reject ='0'  ";  
                         if($_GET['check'] =="on"){
                             $sql.=" and   onhand_date>='" . $_GET["dtfrom"] . "' and onhand_date<='" . $_GET["dtto"] . "'"; 
                        }
                    }else{
                        $sql = "select COUNT(*) as count from dag_item WHERE (flag !='0' or flag !='1') and cancel='0' and reject ='0'  ";  
                        if($_GET['check'] =="on"){
                             $sql.=" and   pro_date>='" . $_GET["dtfrom"] . "' and pro_date<='" . $_GET["dtto"] . "'"; 
                        }
                    }
                     
                    if($_GET['cuscode']!=""){
                         $sql.=" and cuscode='".$_GET['cuscode']."'"; 
                    }
                    
                    if($_GET['jobno']!=""){
                         $sql.=" and jobno='".$_GET['jobno']."'"; 
                    } 
                     if($_GET['cus_type'] !="ALL"){
                         if($_GET['cus_type'] =="WHOLESALE"){
                             $sql.=" and (cus_type='".$_GET['cus_type']."' or cus_type='BOTH' )";
                         }else{
                             $sql.=" and cus_type='".$_GET['cus_type']."'";
                         } 
                    }  
                    $result1 = $conn->query($sql); 
                    $row1 = $result1->fetch();
                    
                    ?>
        <table   width="1000px;" >
          <tr>
                         <th align="right"  >Total Count :</th> 
                         <th align="left"><?php  echo $row1['count'];?></th> 
                         <th>&nbsp;</th> 
                         <th>&nbsp;</th>
                         <th>&nbsp;</th>  
                         <th>&nbsp;</th> 
                         <th>&nbsp;</th> 
                         <th>&nbsp;</th> 
                         <th>&nbsp;</th> 
                         <th>&nbsp;</th> 
                         <th>&nbsp;</th> 
                    </tr>
             </table>   
        <table class="tb" width="1000px;" >
                <tr>
                        <th>#</th>
                        <th>JOB NO</th>
                        <th>INVOICE NO</th>
                        <th>REG DATE</th>   
                        <th>PRODUCTION DATE</th>   
                        <th>CUSTOMER</th>
                        <th>DESIGN</th> 
                        <th>MAKE</th> 
                        <th>SIZE</th>  
                        <th>BELT</th>  
                        <th>SERIAL NO</th>  
                        <th>AD PAY</th>    
                        <th>TOTAL</th>
                        <th>REMARK</th>
                    </tr>
                <?php
                    $i=1;
                    $tot=0;
                    include './connection_sql.php';
 
                    if($_GET['alltype'] !="ALL"){
                         $sql = "select * from dag_item WHERE flag='1' and cancel='0'   and reject ='0' ";  
                         if($_GET['check'] =="on"){
                             $sql.=" and   onhand_date>='" . $_GET["dtfrom"] . "' and onhand_date<='" . $_GET["dtto"] . "'"; 
                        }
                    }else{
                        $sql = "select * from dag_item WHERE (flag !='0' or flag !='1') and cancel='0'  and reject ='0'";  
                        if($_GET['check'] =="on"){
                             $sql.=" and   pro_date>='" . $_GET["dtfrom"] . "' and pro_date<='" . $_GET["dtto"] . "'"; 
                        }
                    }
                     if($_GET['cuscode']!=""){
                         $sql.=" and cuscode='".$_GET['cuscode']."'"; 
                    }
                    if($_GET['jobno']!=""){
                         $sql.=" and jobno='".$_GET['jobno']."'"; 
                    } 
                     if($_GET['cus_type'] !="ALL"){
                         if($_GET['cus_type'] =="WHOLESALE"){
                             $sql.=" and (cus_type='".$_GET['cus_type']."' or cus_type='BOTH' )";
                         }else{
                             $sql.=" and cus_type='".$_GET['cus_type']."'";
                         } 
                    } 
                    
                    foreach ($conn->query($sql) as $row) {


                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>   
                            <td><?php echo $row['jobno']; ?></td> 
                            <td><?php echo $row['refno']; ?></td> 
                            <td><?php echo $row['sdate']; ?></td>
                            <td><?php echo $row['onhand_date']; ?></td>
                            <td><?php echo $row['cusname']; ?></td>   
                            <td><?php echo $row['belt']; ?></td>   
                            <td><?php echo $row['marker']; ?></td>   
                            <td><?php echo $row['size']; ?></td>   
                            <td><?php echo $row['belt']; ?></td>   
                            <td><?php echo $row['serialno']; ?></td>   
                            <td><?php echo $row['adpayment']; ?></td>   
                            <td><?php echo $row['total']; ?></td>  
                            <td><?php echo $row['remark']; ?></td>  
                             
                        </td>   


                    </tr>

                    <?php
                    $i= $i+1;
                    $tot= $tot+$row['total'];
                }
                ?>
          
           
            <tr>
        
                <td></td>
                <td></td> 
                 <td></td> 
                <td  align="right" colspan='9' style='font-size:20px;'><b>TOTAL AMOUNT</b></td> 
                <td align="right" style='font-size:20px;'><b><?php 
                echo number_format($tot, 2, ".", ",");
        
                ?><b/></td>
                <td></td>
            </tr>
        </table>
   <?php  }
    
    ?>
    
    <!--===========================================================================================-->
 
  <?php 
    if($_GET['type']=="COMPLETELIST"){
        ?>
         <?php
                    $i=1;
                    $tot=0;
                    include './connection_sql.php';
                    if($_GET['alltype'] !="ALL"){
                        $sql = "select count(*) as count from dag_item WHERE (flag !='0' and  flag !='1' and  flag !='7') and cancel='0'  and reject ='0'   ";  
                        if($_GET['check'] =="on"){
                             $sql.=" and   pro_date>='" . $_GET["dtfrom"] . "' and pro_date<='" . $_GET["dtto"] . "'"; 
                        }
                    }else{
                        $sql = "select count(*) as count from dag_item WHERE (flag='2' or flag='7') and cancel='0' and reject ='0'  ";  
                        if($_GET['check'] =="on"){
                             $sql.=" and   com_date>='" . $_GET["dtfrom"] . "' and com_date<='" . $_GET["dtto"] . "'"; 
                        }
                    }
                    
                    if($_GET['cuscode']!=""){
                         $sql.=" and cuscode='".$_GET['cuscode']."'"; 
                    }
                    
                    if($_GET['jobno']!=""){
                         $sql.=" and jobno='".$_GET['jobno']."'"; 
                    } 
                     if($_GET['cus_type'] !="ALL"){
                         if($_GET['cus_type'] =="WHOLESALE"){
                             $sql.=" and (cus_type='".$_GET['cus_type']."' or cus_type='BOTH' )";
                         }else{
                             $sql.=" and cus_type='".$_GET['cus_type']."'";
                         }
                    }
                    $result1 = $conn->query($sql); 
                    $row1 = $result1->fetch();
                    
                    ?>
        <table   width="1000px;" >
          <tr>
                         <th align="right"  >Total Count :</th> 
                         <th align="left"><?php  echo $row1['count'];?></th> 
                         <th>&nbsp;</th> 
                         <th>&nbsp;</th>
                         <th>&nbsp;</th>  
                         <th>&nbsp;</th> 
                         <th>&nbsp;</th> 
                         <th>&nbsp;</th> 
                         <th>&nbsp;</th> 
                         <th>&nbsp;</th> 
                         <th>&nbsp;</th> 
                    </tr>
             </table>   
        <table class="tb" width="1000px;" >
                <tr>
                        <th>#</th>
                        <th>JOB NO</th> 
                        <th>DAG NO</th>
                        <th>DAG DATE</th>   
                        <th>DAG CUSTOMER</th>
                        <th>DESIGN</th>
                        <th>MAKE</th> 
                        <th>SIZE</th>  
                        <th>SERIAL NO</th>  
                        <th>WARRENTY</th> 
                        <th>AD PAY</th>   
                        <th>AMOUNT</th>    
                        <th>REPAIR</th>  
                        <th>TOTAL</th>  
                        <th>COM DATE</th> 
                        <th>INVOICE NO</th>  
                        <th>INVOICE DATE</th>  
                        <th>INVOICE CUSTOMER</th>  
                    </tr>
                <?php
                    $i=1;
                    $tot=0;
                    include './connection_sql.php';
                    
                    if($_GET['alltype'] !="ALL"){
                        $sql = "select * from dag_item WHERE (flag !='0' and  flag !='1' and  flag !='7' ) and cancel='0'  and reject ='0'   ";  
                        if($_GET['check'] =="on"){
                             $sql.=" and   pro_date>='" . $_GET["dtfrom"] . "' and pro_date<='" . $_GET["dtto"] . "'"; 
                        }
                    }else{
                        $sql = "select  *  from dag_item WHERE (flag='2' or flag='7') and cancel='0' and reject ='0'  ";  
                        if($_GET['check'] =="on"){
                             $sql.=" and   com_date>='" . $_GET["dtfrom"] . "' and com_date<='" . $_GET["dtto"] . "'"; 
                        }
                    }
                     
                    if($_GET['cuscode']!=""){
                         $sql.=" and cuscode='".$_GET['cuscode']."'"; 
                    }
                      
                    if($_GET['jobno']!=""){
                         $sql.=" and jobno='".$_GET['jobno']."'"; 
                    } 
                     if($_GET['cus_type'] !="ALL"){
                         if($_GET['cus_type'] =="WHOLESALE"){
                             $sql.=" and (cus_type='".$_GET['cus_type']."' or cus_type='BOTH' )";
                         }else{
                             $sql.=" and cus_type='".$_GET['cus_type']."'";
                         }
                    } 
                    
                    foreach ($conn->query($sql) as $row) {
                        $sqlsal = "SELECT CUS_NAME,SDATE FROM s_salma where REF_NO='".$row['invno']."'";
                        $resultsal = $conn->query($sqlsal); 
                        $rowsal = $resultsal->fetch();

                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>    
                            <td><?php echo $row['jobno']; ?></td>  
                            <td><?php echo $row['refno']; ?></td>  
                            <td><?php echo $row['sdate']; ?></td>   
                            <td><?php echo $row['cusname']; ?></td>   
                            <td><?php echo $row['design']; ?></td>   
                            <td><?php echo $row['marker']; ?></td>   
                            <td><?php echo $row['size']; ?></td>   
                            <td><?php echo $row['serialno']; ?></td> 
                            <td><?php echo $row['warrenty']; ?></td> 
                            <td><?php echo $row['adpayment']; ?></td>  
                            <td><?php echo $row['amount']; ?></td>   
                            <td><?php echo $row['repair']; ?></td>  
                            <td><?php echo number_format($row['total'],2); ?></td>   
                            <td><?php echo $row['pro_date']; ?></td>  
                            <td onclick="name(this)"><?php echo $row['invno']; ?></td>  
                            <td onclick="name(this)"><?php echo $rowsal['SDATE']; ?></td>  
                            <td onclick="name(this)"><?php echo $rowsal['CUS_NAME']; ?></td>
                             
                        </td>   


                    </tr>

                    <?php
                    $i= $i+1;
                    $tot= $tot+$row['total'];
                }
                ?>
          
           
            <tr>
        
                <td></td>
                <td></td> 
                 <td></td> 
                <td  align="right" colspan='10' style='font-size:20px;'><b>TOTAL AMOUNT</b></td> 
                <td align="right" style='font-size:20px;'><b><?php 
                echo number_format($tot, 2, ".", ",");
        
                ?><b/></td>
                <td>&nbsp;</td>  <td>&nbsp;</td>  <td>&nbsp;</td>  <td>&nbsp;</td> 
            </tr>
        </table>
   <?php  }
    
    ?>
    
    
     <!--===========================================================================================-->
 
  <?php 
    if($_GET['type']=="ALLLIST"){
        ?>
        <table class="tb" width="1000px;" >
                <tr>
                        <th>#</th>
                        <th>JOB NO</th>
                        <th>INVOICE NO</th>
                        <th>DATE</th>   
                        <th>CUSTOMER</th>
                        <th>MAKE</th> 
                        <th>SIZE</th> 
                        <th>BELT</th> 
                        <th>SERIAL NO</th>  
                        <th>AD PAY</th>  
                        <th>AMOUNT</th>  
                        <th>REPAIR</th>  
                        <th>TOTAL</th>  
                        <th>SEND DATE</th> 
                        <th>FINISH</th>   
                        <th>TYPE</th>   
                    </tr>
                <?php
                    $i=1;
                    $tot=0;
                    include './connection_sql.php';
 
                    $sql = "select * from dag_item WHERE   cancel='0'   ";  
                    if($_GET['cuscode']!=""){
                         $sql.=" and cuscode='".$_GET['cuscode']."'"; 
                    }
                     if($_GET['check'] =="on"){
                         $sql.=" and   sdate>='" . $_GET["dtfrom"] . "' and sdate<='" . $_GET["dtto"] . "'"; 
                    }
                    if($_GET['jobno']!=""){
                         $sql.=" and jobno='".$_GET['jobno']."'"; 
                    } 
                     if($_GET['cus_type'] !="ALL"){
                         if($_GET['cus_type'] =="WHOLESALE"){
                             $sql.=" and (cus_type='".$_GET['cus_type']."' or cus_type='BOTH' )";
                         }else{
                             $sql.=" and cus_type='".$_GET['cus_type']."'";
                         }
                    }
                    foreach ($conn->query($sql) as $row) {


                        ?>
                        <tr>
                            <td ><?php echo $i; ?></td>
                            <td><?php echo $row['jobno']; ?></td> 
                            <td><?php echo $row['refno']; ?></td> 
                            <td><?php echo $row['sdate']; ?></td>   
                            <td><?php echo $row['cusname']; ?></td>   
                            <td><?php echo $row['marker']; ?></td>   
                            <td><?php echo $row['size']; ?></td>  
                            <td><?php echo $row['belt']; ?></td>  
                            <td><?php echo $row['serialno']; ?></td> 
                            <td align="right"><?php echo $row['adpayment']; ?></td> 
                           <?php  if($row['flag']=='7'){
                            ?>
                             <td align="right"><?php echo $row['amount1']; ?></td>  
                            <td align="right"><?php echo $row['repair1']; ?></td>  
                            <td align="right"><?php echo $row['total1']; ?></td>  
                             <?php
                            }else{
                                ?>
                            <td align="right"><?php echo $row['amount']; ?></td>  
                            <td align="right"><?php echo $row['repair']; ?></td>  
                            <td align="right"><?php echo $row['total']; ?></td>  
                            <?php }?>
                            
                           
                            <td><?php echo $row['onhand_date']; ?></td>  
                            <td><?php echo $row['pro_date']; ?></td> 
                            <?php
                             if($row['reject']=='0'){
                                 if($row['flag']=='0'){
                                     echo "<td style='background-color:yellow'>ONHAND </td>"; 
                                }else if($row['flag']=='1'){
                                    echo "<td style='background-color:#acdcf3'>PRODUCTION</td>"; 
                                }else if($row['flag']=='2'){
                                     echo "<td style='background-color:#1ef51e'>COMPLETE</td>"; 
                                }else if($row['flag']=='7'){
                                     echo "<td style='background-color:#eabf5d'>INVOICED</td>"; 
                                }
                             }else{
                                if($row['flag']=='7'){
                                     echo "<td style='background-color:red'>REJECTED & INVOICED</td>"; 
                                }else{
                                    echo "<td style='background-color:red'>REJECTED</td>"; 
                                }
                                 
                             }
                            
                            
                           
                            ?>
                             
                        </td>   


                    </tr>

                    <?php
                    $i= $i+1;
                    $tot= $tot+$row['total']+$row['total1'];
                }
                ?>
          
           
            <tr>
        
                <td></td>
                <td></td>   
                <td  align="right" colspan='10' style='font-size:20px;'><b>TOTAL AMOUNT</b></td> 
                <td align="right" style='font-size:20px;'><b><?php 
                echo number_format($tot, 2, ".", ",");
        
                ?><b/></td>
                <td colspan='4' ></td> 
            </tr>
        </table>
   <?php  }
    
    ?>
    <!--===================================================================================-->
    
    
  <?php 
    if($_GET['type']=="REJECTLIST"){
        ?>
        <table class="tb" width="1000px;" >
                <tr>
                        <th>#</th>
                        <th>JOB NO</th>
                        <th>INVOICE NO</th>
                        <th>DATE</th>   
                        <th>CUSTOMER</th>
                        <th>MAKE</th> 
                        <th>SIZE</th> 
                        <th>BELT</th> 
                        <th>SERIAL NO</th>  
                        <th>AD PAY</th>  
                        <th>AMOUNT</th>  
                        <th>REPAIR</th>  
                        <th>TOTAL</th>  
                        <th>SEND DATE</th> 
                        <th>FINISH</th>    
                    </tr>
                <?php
                    $i=1;
                    $tot=0;
                    include './connection_sql.php';
 
                    $sql = "select * from dag_item WHERE   cancel='0' and  reject='1'   ";  
                    if($_GET['cuscode']!=""){
                         $sql.=" and cuscode='".$_GET['cuscode']."'"; 
                    }
                     if($_GET['check'] =="on"){
                         $sql.=" and   sdate>='" . $_GET["dtfrom"] . "' and sdate<='" . $_GET["dtto"] . "'"; 
                    }
                    if($_GET['jobno']!=""){
                         $sql.=" and jobno='".$_GET['jobno']."'"; 
                    } 
                     if($_GET['cus_type'] !="ALL"){
                         if($_GET['cus_type'] =="WHOLESALE"){
                             $sql.=" and (cus_type='".$_GET['cus_type']."' or cus_type='BOTH' )";
                         }else{
                             $sql.=" and cus_type='".$_GET['cus_type']."'";
                         }
                    }
                    foreach ($conn->query($sql) as $row) {


                        ?>
                        <tr>
                            <td ><?php echo $i; ?></td>
                            <td><?php echo $row['jobno']; ?></td> 
                            <td><?php echo $row['refno']; ?></td> 
                            <td><?php echo $row['sdate']; ?></td>   
                            <td><?php echo $row['cusname']; ?></td>   
                            <td><?php echo $row['marker']; ?></td>   
                            <td><?php echo $row['size']; ?></td>  
                            <td><?php echo $row['belt']; ?></td>  
                            <td><?php echo $row['serialno']; ?></td> 
                            <td align="right"><?php echo $row['adpayment']; ?></td> 
                           <?php  if($row['flag']=='7'){
                            ?>
                             <td align="right"><?php echo $row['amount1']; ?></td>  
                            <td align="right"><?php echo $row['repair1']; ?></td>  
                            <td align="right"><?php echo $row['total1']; ?></td>  
                             <?php
                            }else{
                                ?>
                            <td align="right"><?php echo $row['amount']; ?></td>  
                            <td align="right"><?php echo $row['repair']; ?></td>  
                            <td align="right"><?php echo $row['total']; ?></td>  
                            <?php }?>
                            
                           
                            <td><?php echo $row['onhand_date']; ?></td>  
                            <td><?php echo $row['pro_date']; ?></td> 
                             
 
                    </tr>

                    <?php
                    $i= $i+1;
                    $tot= $tot+$row['total']+$row['total1'];
                }
                ?>
          
           
            <tr>
        
                <td></td>
                <td></td>   
                <td  align="right" colspan='8' style='font-size:20px;'><b>TOTAL AMOUNT</b></td> 
                <td align="right" style='font-size:20px;'><b><?php 
                echo number_format($tot, 2, ".", ",");
        
                ?><b/></td>
                <td colspan='4' ></td> 
            </tr>
        </table>
   <?php  }
    
    ?>
    <!--===================================================================================-->
    
    
    <?php 
    if($_GET['type']=="CANCELLLIST"){
        ?>
        <table class="tb" width="1000px;" >
                <tr>
                        <th>#</th>
                        <th>JOB NO</th>
                        <th>INVOICE NO</th>
                        <th>DATE</th>   
                        <th>CUSTOMER</th>
                        <th>MAKE</th> 
                        <th>SIZE</th> 
                        <th>BELT</th> 
                        <th>SERIAL NO</th>  
                        <th>AD PAY</th>  
                        <th>AMOUNT</th>  
                        <th>REPAIR</th>  
                        <th>TOTAL</th>  
                        <th>SEND DATE</th> 
                        <th>FINISH</th>    
                    </tr>
                <?php
                    $i=1;
                    $tot=0;
                    include './connection_sql.php';
 
                    $sql = "select * from dag_item WHERE   cancel='1'    ";  
                    if($_GET['cuscode']!=""){
                         $sql.=" and cuscode='".$_GET['cuscode']."'"; 
                    }
                     if($_GET['check'] =="on"){
                         $sql.=" and   sdate>='" . $_GET["dtfrom"] . "' and sdate<='" . $_GET["dtto"] . "'"; 
                    }
                    if($_GET['jobno']!=""){
                         $sql.=" and jobno='".$_GET['jobno']."'"; 
                    } 
                     if($_GET['cus_type'] !="ALL"){
                         if($_GET['cus_type'] =="WHOLESALE"){
                             $sql.=" and (cus_type='".$_GET['cus_type']."' or cus_type='BOTH' )";
                         }else{
                             $sql.=" and cus_type='".$_GET['cus_type']."'";
                         }
                    } 
                    foreach ($conn->query($sql) as $row) {


                        ?>
                        <tr>
                            <td ><?php echo $i; ?></td>
                            <td><?php echo $row['jobno']; ?></td> 
                            <td><?php echo $row['refno']; ?></td> 
                            <td><?php echo $row['sdate']; ?></td>   
                            <td><?php echo $row['cusname']; ?></td>   
                            <td><?php echo $row['marker']; ?></td>   
                            <td><?php echo $row['size']; ?></td>  
                            <td><?php echo $row['belt']; ?></td>  
                            <td><?php echo $row['serialno']; ?></td> 
                            <td align="right"><?php echo $row['adpayment']; ?></td> 
                           <?php  if($row['flag']=='7'){
                            ?>
                             <td align="right"><?php echo $row['amount1']; ?></td>  
                            <td align="right"><?php echo $row['repair1']; ?></td>  
                            <td align="right"><?php echo $row['total1']; ?></td>  
                             <?php
                            }else{
                                ?>
                            <td align="right"><?php echo $row['amount']; ?></td>  
                            <td align="right"><?php echo $row['repair']; ?></td>  
                            <td align="right"><?php echo $row['total']; ?></td>  
                            <?php }?>
                            
                           
                            <td><?php echo $row['onhand_date']; ?></td>  
                            <td><?php echo $row['pro_date']; ?></td> 
                             
 
                    </tr>

                    <?php
                    $i= $i+1;
                    $tot= $tot+$row['total']+$row['total1'];
                }
                ?>
          
           
            <tr>
        
                <td></td>
                <td></td>   
                <td  align="right" colspan='8' style='font-size:20px;'><b>TOTAL AMOUNT</b></td> 
                <td align="right" style='font-size:20px;'><b><?php 
                echo number_format($tot, 2, ".", ",");
        
                ?><b/></td>
                <td colspan='4' ></td> 
            </tr>
        </table>
   <?php  }
    
    ?>
    <!--===================================================================================-->
    <?php 
    if($_GET['type']=="PROFIT"){
        ?>
        <table class="tb" width="1000px;" >
                <tr>
                        <th>#</th> 
                        <th>INVOICE NO</th>
                        <th>DATE</th>   
                        <th>CUSTOMER</th> 
                        <th>COST</th>  
                        <th>SELLING</th>   
                        <th>PROFIT</th>   
                        <th>NOTE</th>   
                    </tr>
                <?php
                    $i=1;
                    $tot=0;
                     $selling=0;
                      $cost=0;
                    include './connection_sql.php';
 
                    $sql = "select sum(subtot)as subtot,sum(cost*qty)as cost ,refno,sdate,cuscode,cus_type from t_invo  where cancel='0' and type !='service' ";
                    if($_GET['cuscode']!=""){
                         $sql.=" and cuscode='".$_GET['cuscode']."'"; 
                    }
                     if($_GET['check'] =="on"){
                         $sql.=" and   sdate>='" . $_GET["dtfrom"] . "' and sdate<='" . $_GET["dtto"] . "'"; 
                    }
                    if($_GET['jobno']!=""){
                         $sql.=" and jobno='".$_GET['jobno']."'"; 
                    } 
                     if($_GET['cus_type'] !="ALL"){
                         if($_GET['cus_type'] =="WHOLESALE"){
                             $sql.=" and (cus_type='".$_GET['cus_type']."' or cus_type='BOTH' )";
                         }else{
                             $sql.=" and cus_type='".$_GET['cus_type']."'";
                         }
                    }
                     $sql.=" group by refno ";  
                  
                    foreach ($conn->query($sql) as $row) {

                        $sqlR = "SELECT * FROM s_salma where REF_NO='" . $row['refno'] . "' ";  
                        $resultR = $conn->query($sqlR); 
                        $rowR = $resultR->fetch();
                        
                        $sqld = "select * from dag_item WHERE   cancel='0'    and  invno='" . $row['refno'] . "'";  
                        $resultd = $conn->query($sqld); 
                        $rowd = $resultd->fetch();
                        
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>     
                            <td><?php echo $row['refno']; ?></td> 
                            <td><?php echo $row['sdate']; ?></td>   
                            <td><?php echo $rowR['CUS_NAME']; ?></td>   
                            <td align="right"><?php echo number_format($row['cost']-$rowR['uccost'],2); ?></td>   
                            <td align="right"><?php echo number_format($row['subtot'],2); ?></td>   
                            <td align="right"><?php echo number_format($row['subtot']-$row['cost'],2); ?></td>   
                            <?php
                             $remark="";
                             $color="";
                             $rea="";
                            if($rowd['reject']=='1'){ 
                                 $remark=$rowR['REMARK'].' - '.'Rejected'.'';
                                $color="#0099ab";
                            } else{
                                $remark=$rowR['REMARK'];
                            }
                            
                           
                            ?>
                            <td style="background-color:<?php echo $color ?>"><?php echo $remark ?></td> 
                             
                        </td>   


                    </tr>

                    <?php
                    $i= $i+1;
                    $tot= $tot+$row['subtot']-$row['cost'];
                    $cost= $cost+$row['cost'];
                    $selling= $selling+$row['subtot'];
                }
                ?>
          
           
            <tr>
         
                <td  align="right" colspan='4' style='font-size:20px;'><b>TOTAL AMOUNT</b></td> 
                 <td align="right" style='font-size:20px;'><b><?php 
                echo number_format($cost, 2, ".", ",");
        
                ?><b/></td>
                 <td align="right" style='font-size:20px;'><b><?php 
                echo number_format($selling, 2, ".", ",");
        
                ?><b/></td>
                <td align="right" style='font-size:20px;'><b><?php 
                echo number_format($tot, 2, ".", ",");
        
                ?><b/></td> 
                <td> &nbsp;</td> 
            </tr>
              
        </table>
        
        
        
       
        
        <!--=====================-->
        <table class="tb" width="1000px;" >
            <!--<tr>-->
            <!--      <td colspan="8"><b>EXPENSES</b></td>-->
            <!--        </tr>-->
                <tr>
                        <th>#</th> 
                        <th>REF NO</th>
                        <th>DATE</th>   
                        <th>NAME</th> 
                        <th>REMARK</th> 
                        <th>AMOUNT</th>  
                    </tr>
                <?php
                    $i=1;
                    $tot1=0; 
                    $x=0;
                    include './connection_sql.php';
 
                    $sql = "select * from payment  where cancel='0'  ";
                   
                     if($_GET['check'] =="on"){
                         $sql.=" and   sdate>='" . $_GET["dtfrom"] . "' and sdate<='" . $_GET["dtto"] . "'"; 
                     }
                      $sql.=" order by type,refno";
                     
                 $tot1=0;
                    foreach ($conn->query($sql) as $row) {
            
                        ?>
                       <tr>
                             <?php  
                        
                                if($cat!=$row['type']){
                                    $sql_1 = "SELECT sum(amount) as tot from payment where cancel='0'  and type='".$row['type']."'  ";
                                    if($_GET['check'] =="on"){
                                         $sql_1.=" and   sdate>='" . $_GET["dtfrom"] . "' and sdate<='" . $_GET["dtto"] . "'"; 
                                     }
                                     $sql.=" group by type";
                                    $result_1 = $conn->query($sql_1);
                                    $row_1= $result_1->fetch(); 
                                    
                                    echo "<td colspan='5'><b>  ". $row['type'] ."   </b></td>";
                                    echo "<td colspan='2' style=\"text-align:right\"><b>  ". $row_1['tot'] ."   </b></td>";
                                } 
                        ?>
                             
                      </tr>
                        
                      
                        <tr>
                            
                            <?php  
                            
                            if($row['type']=="SALARY"){
                                if($row['workertype']!="WORKER"){ ?>
                                     <td><?php echo $i; ?></td>     
                                    <td><?php echo $row['refno']; ?></td> 
                                    <td><?php echo $row['sdate']; ?></td>    
                                        <td><?php echo $row['name']; ?></td>    
                                    <td><?php echo $row['remark']; ?></td>   
                                    <td align="right"><?php echo $row['amount']; ?></td>  
                                    <?php  
                                    $tot1= $tot1+$row['amount']; 
                                }
                            }else{?>
                            <td><?php echo $i; ?></td>     
                                <td><?php echo $row['refno']; ?></td> 
                                    <td><?php echo $row['sdate']; ?></td>    
                                    <td><?php echo $row['name']; ?></td>    
                                    <td><?php echo $row['remark']; ?></td>   
                                    <td align="right"><?php echo $row['amount']; ?></td>  
                         <?php
                         $tot1= $tot1+$row['amount']; 
                         } 
                            ?>
                        
                        
                         </tr>
                          
                     
                    <?php
                    $i= $i+1; 
                    
                     $cat=$row['type'];
                }
                ?>
          
           
            <tr>
         
                <td  align="right" colspan='5' style='font-size:20px;'><b>TOTAL AMOUNT</b></td> 
                <td align="right" style='font-size:20px;'><b><?php 
                echo number_format($tot1, 2, ".", ",");
        
                ?><b/></td> 
            </tr>
        </table>
        
        <!--=====================-->
        <table class="tb" width="1000px;" >
             
             <tr>
         
                <td  align="right" colspan='7' style='font-size:29px;'><b>TOTAL PROFIT</b></td> 
                <td align="right" style='font-size:29px;'><b><?php 
                echo number_format($tot-$tot1, 2, ".", ",");
        
                ?><b/></td> 
            </tr>
        </table>
   <?php  }
    
    ?>
    <!--===================================================================================-->
    
      <?php 
    if($_GET['type']=="SERVICES"){
        ?>
        <table class="tb" width="1000px;" >
                <tr>
                        <th>#</th> 
                        <th>INVOICE NO</th>
                        <th>DATE</th>   
                        <th>CUSTOMER</th> 
                        <th>SERVICE</th>  
                        <th>VEHICLE</th>   
                        <th>EMPLOYEE</th>   
                        <th>AMOUNT</th>   
                    </tr>
                <?php
                    $i=1;
                    $tot=0;
                    include './connection_sql.php';
 
                    $sql = "select * from t_invo  where cancel='0' and type='service' ";
                    if($_GET['cuscode']!=""){
                         $sql.=" and cuscode='".$_GET['cuscode']."'"; 
                    }
                     if($_GET['check'] =="on"){
                         $sql.=" and   sdate>='" . $_GET["dtfrom"] . "' and sdate<='" . $_GET["dtto"] . "'"; 
                    }
                    if($_GET['jobno']!=""){
                         $sql.=" and jobno='".$_GET['jobno']."'"; 
                    } 
                    
                    if($_GET['services']!=""){
                         $sql.=" and service='".$_GET['services']."'"; 
                    } 
                    if($_GET['employee']!=""){
                         $sql.=" and employee='".$_GET['employee']."'"; 
                    } 
                    
                 
                    foreach ($conn->query($sql) as $row) {

                        $sqlR = "SELECT * FROM s_salma where REF_NO='" . $row['refno'] . "' ";  
                        $resultR = $conn->query($sqlR); 
                        $rowR = $resultR->fetch();
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>     
                            <td><?php echo $row['refno']; ?></td> 
                            <td><?php echo $row['sdate']; ?></td>   
                            <td><?php echo $rowR['CUS_NAME']; ?></td>     
                            <td><?php echo $row['service']; ?></td>  
                            <td><?php echo $row['vehicleno']; ?></td>  
                            <td><?php echo $row['employee']; ?></td>
                            <td align="right"><?php echo $row['selling']; ?></td>
                             
                        </td>   


                    </tr>

                    <?php
                    $i= $i+1;
                    $tot= $tot+$row['selling'];
                }
                ?>
          
           
            <tr>
         
                <td  align="right" colspan='7' style='font-size:20px;'><b>TOTAL AMOUNT</b></td> 
                <td align="right" style='font-size:20px;'><b><?php 
                echo number_format($tot, 2, ".", ",");
        
                ?><b/></td> 
            </tr>
        </table>
   <?php  }
    
    ?>
    
    <!--===================================================================================-->
    
      <?php 
    if($_GET['type']=="SALARY PAYMENT"){
        ?>
        <table class="tb" width="1000px;" >
                <tr>
                        <th>#</th> 
                        <th>REF NO</th>
                        <th>DATE</th>   
                        <th>NAME</th> 
                        <th>REMARK</th> 
                        <th>AMOUNT</th>  
                    </tr>
                <?php
                    $i=1;
                    $tot=0; 
                    include './connection_sql.php';
 
                    $sql = "select * from payment  where cancel='0' and type='SALARY'    ";
                   
                     if($_GET['check'] =="on"){
                         $sql.=" and   sdate>='" . $_GET["dtfrom"] . "' and sdate<='" . $_GET["dtto"] . "'"; 
                    }
                     
                    if($_GET['employee']!=""){
                         $sql.=" and name='".$_GET['employee']."'"; 
                    }  
                     if($_GET['emtype']!="ALL"){
                         $sql.=" and workertype='".$_GET['emtype']."'"; 
                    } 
                    
                 
                    foreach ($conn->query($sql) as $row) {
 
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>     
                            <td><?php echo $row['refno']; ?></td> 
                            <td><?php echo $row['sdate']; ?></td>   
                            <td><?php echo $row['name']; ?></td>     
                            <td><?php echo $row['remark']; ?></td>   
                            <td align="right"><?php echo $row['amount']; ?></td>  
                             
                        </td>   


                    </tr>

                    <?php
                    $i= $i+1; 
                     $tot= $tot+$row['amount']; 
                }
                ?>
          
           
            <tr>
         
                <td  align="right" colspan='5' style='font-size:20px;'><b>TOTAL AMOUNT</b></td> 
                <td align="right" style='font-size:20px;'><b><?php 
                echo number_format($tot, 2, ".", ",");
        
                ?><b/></td> 
            </tr>
        </table>
   <?php  }
    
    ?>
    
    
    <!--===================================================================================-->
    
      <?php 
    if($_GET['type']=="FUEL PAYMENT"){
        ?>
        <table class="tb" width="1000px;" >
                <tr>
                        <th>#</th> 
                        <th>REF NO</th>
                        <th>DATE</th>   
                        <th>NAME</th> 
                        <th>REMARK</th> 
                        <th>AMOUNT</th>  
                    </tr>
                <?php
                    $i=1;
                    $tot=0; 
                    include './connection_sql.php';
 
                    $sql = "select * from payment  where cancel='0' and type='FUEL'  ";
                   
                     if($_GET['check'] =="on"){
                         $sql.=" and   sdate>='" . $_GET["dtfrom"] . "' and sdate<='" . $_GET["dtto"] . "'"; 
                    }
                     
                    if($_GET['employee']!=""){
                         $sql.=" and name='".$_GET['employee']."'"; 
                    } 
                    
                 
                    foreach ($conn->query($sql) as $row) {
 
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>     
                            <td><?php echo $row['refno']; ?></td> 
                            <td><?php echo $row['sdate']; ?></td>   
                            <td><?php echo $row['name']; ?></td>     
                            <td><?php echo $row['remark']; ?></td>   
                            <td align="right"><?php echo $row['amount']; ?></td>  
                             
                        </td>   


                    </tr>

                    <?php
                    $i= $i+1; 
                     $tot= $tot+$row['amount']; 
                }
                ?>
          
           
            <tr>
         
                <td  align="right" colspan='5' style='font-size:20px;'><b>TOTAL AMOUNT</b></td> 
                <td align="right" style='font-size:20px;'><b><?php 
                echo number_format($tot, 2, ".", ",");
        
                ?><b/></td> 
            </tr>
        </table>
   <?php  }
    
    ?>
    
    
    <!--===================================================================================-->
    
      <?php 
    if($_GET['type']=="ADVANCE PAYMENT"){
        ?>
        <table class="tb" width="1000px;" >
                <tr>
                        <th>#</th> 
                        <th>REF NO</th>
                        <th>DATE</th>   
                        <th>NAME</th> 
                        <th>REMARK</th> 
                        <th>AMOUNT</th>  
                    </tr>
                <?php
                    $i=1;
                    $tot=0; 
                    include './connection_sql.php';
 
                     $sql = "select * from payment  where cancel='0' and type='ADVANCE'  ";
                   
                     if($_GET['check'] =="on"){
                         $sql.=" and   sdate>='" . $_GET["dtfrom"] . "' and sdate<='" . $_GET["dtto"] . "'"; 
                    }
                     
                    if($_GET['employee']!=""){
                         $sql.=" and name='".$_GET['employee']."'"; 
                    } 
                    
                 
                    foreach ($conn->query($sql) as $row) {
 
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>     
                            <td><?php echo $row['refno']; ?></td> 
                            <td><?php echo $row['sdate']; ?></td>   
                            <td><?php echo $row['name']; ?></td>     
                            <td><?php echo $row['remark']; ?></td>   
                            <td align="right"><?php echo $row['amount']; ?></td>  
                             
                        </td>   


                    </tr>

                    <?php
                    $i= $i+1; 
                     $tot= $tot+$row['amount']; 
                }
                ?>
          
           
            <tr>
         
                <td  align="right" colspan='5' style='font-size:20px;'><b>TOTAL AMOUNT</b></td> 
                <td align="right" style='font-size:20px;'><b><?php 
                echo number_format($tot, 2, ".", ",");
        
                ?><b/></td> 
            </tr>
        </table>
   <?php  }
    
    ?>
    
    <!--===================================================================================-->
    
       <?php 
    if($_GET['type']=="OT"){
        ?>
        <table class="tb" width="1000px;" >
                <tr>
                        <th>#</th> 
                        <th>REF NO</th>
                        <th>DATE</th>   
                        <th>NAME</th> 
                        <th>REMARK</th> 
                        <th>AMOUNT</th>  
                    </tr>
                <?php
                    $i=1;
                    $tot=0; 
                    include './connection_sql.php';
 
                     $sql = "select * from payment  where cancel='0' and type='OT'  ";
                   
                     if($_GET['check'] =="on"){
                         $sql.=" and   sdate>='" . $_GET["dtfrom"] . "' and sdate<='" . $_GET["dtto"] . "'"; 
                    }
                     
                    if($_GET['employee']!=""){
                         $sql.=" and name='".$_GET['employee']."'"; 
                    } 
                    
                 
                    foreach ($conn->query($sql) as $row) {
 
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>     
                            <td><?php echo $row['refno']; ?></td> 
                            <td><?php echo $row['sdate']; ?></td>   
                            <td><?php echo $row['name']; ?></td>     
                            <td><?php echo $row['remark']; ?></td>   
                            <td align="right"><?php echo $row['amount']; ?></td>  
                             
                        </td>   


                    </tr>

                    <?php
                    $i= $i+1; 
                     $tot= $tot+$row['amount']; 
                }
                ?>
          
           
            <tr>
         
                <td  align="right" colspan='5' style='font-size:20px;'><b>TOTAL AMOUNT</b></td> 
                <td align="right" style='font-size:20px;'><b><?php 
                echo number_format($tot, 2, ".", ",");
        
                ?><b/></td> 
            </tr>
        </table>
   <?php  }
    
    ?>
    
    
    
    <!--===================================================================================-->
    
    
       <?php 
    if($_GET['type']=="EXPENSE"){
        ?>
        <table class="tb" width="1000px;" >
                <tr>
                        <th>#</th> 
                        <th>REF NO</th>
                        <th>DATE</th>   
                        <th>NAME</th> 
                        <th>REMARK</th> 
                        <th>AMOUNT</th>  
                    </tr>
                <?php
                    $i=1;
                    $tot=0; 
                    include './connection_sql.php';
 
                     $sql = "select * from payment  where cancel='0' and type='EXPENSE'  ";
                   
                     if($_GET['check'] =="on"){
                         $sql.=" and   sdate>='" . $_GET["dtfrom"] . "' and sdate<='" . $_GET["dtto"] . "'"; 
                    }
                     
                    if($_GET['employee']!=""){
                         $sql.=" and name='".$_GET['employee']."'"; 
                    } 
                    
                 
                    foreach ($conn->query($sql) as $row) {
 
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>     
                            <td><?php echo $row['refno']; ?></td> 
                            <td><?php echo $row['sdate']; ?></td>   
                            <td><?php echo $row['name']; ?></td>     
                            <td><?php echo $row['remark']; ?></td>   
                            <td align="right"><?php echo $row['amount']; ?></td>  
                             
                        </td>   


                    </tr>

                    <?php
                    $i= $i+1; 
                     $tot= $tot+$row['amount']; 
                }
                ?>
          
           
            <tr>
         
                <td  align="right" colspan='5' style='font-size:20px;'><b>TOTAL AMOUNT</b></td> 
                <td align="right" style='font-size:20px;'><b><?php 
                echo number_format($tot, 2, ".", ",");
        
                ?><b/></td> 
            </tr>
        </table>
   <?php  }
    
    ?>
    
    <!--===================================================================================-->
    
       <?php 
    if($_GET['type']=="OTHER PAYMENT"){
        ?>
        <table class="tb" width="1000px;" >
                <tr>
                        <th>#</th> 
                        <th>REF NO</th>
                        <th>DATE</th>   
                        <th>NAME</th> 
                        <th>REMARK</th> 
                        <th>AMOUNT</th>  
                    </tr>
                <?php
                    $i=1;
                    $tot=0; 
                    include './connection_sql.php';
 
                     $sql = "select * from payment  where cancel='0' and type='OTHER'  ";
                   
                     if($_GET['check'] =="on"){
                         $sql.=" and   sdate>='" . $_GET["dtfrom"] . "' and sdate<='" . $_GET["dtto"] . "'"; 
                    }
                     
                    if($_GET['employee']!=""){
                         $sql.=" and name='".$_GET['employee']."'"; 
                    } 
                    
                 
                    foreach ($conn->query($sql) as $row) {
 
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>     
                            <td><?php echo $row['refno']; ?></td> 
                            <td><?php echo $row['sdate']; ?></td>   
                            <td><?php echo $row['name']; ?></td>     
                            <td><?php echo $row['remark']; ?></td>   
                            <td align="right"><?php echo $row['amount']; ?></td>  
                             
                        </td>   


                    </tr>

                    <?php
                    $i= $i+1; 
                     $tot= $tot+$row['amount']; 
                }
                ?>
          
           
            <tr>
         
                <td  align="right" colspan='5' style='font-size:20px;'><b>TOTAL AMOUNT</b></td> 
                <td align="right" style='font-size:20px;'><b><?php 
                echo number_format($tot, 2, ".", ",");
        
                ?><b/></td> 
            </tr>
        </table>
   <?php  }
    
    ?>
    
    <!--===================================================================================-->
    
    
    
      <?php 
    if($_GET['type']=="SERVICES & SALARY PROFIT"){
        ?>
        <table class="tb" width="1000px;" >
                <tr>
                        <th>#</th> 
                        <th>INVOICE NO</th>
                        <th>DATE</th>   
                        <th>CUSTOMER</th> 
                        <th>SERVICE</th>  
                        <th>VEHICLE</th>   
                        <th>EMPLOYEE</th>   
                        <th>AMOUNT</th>   
                    </tr>
                <?php
                    $i=1;
                    $tot=0;
                    include './connection_sql.php';
 
                    $sql = "select * from t_invo  where cancel='0' and type='service' ";
                    if($_GET['cuscode']!=""){
                         $sql.=" and cuscode='".$_GET['cuscode']."'"; 
                    }
                     if($_GET['check'] =="on"){
                         $sql.=" and   sdate>='" . $_GET["dtfrom"] . "' and sdate<='" . $_GET["dtto"] . "'"; 
                    } 
                    
                    if($_GET['services']!=""){
                         $sql.=" and service='".$_GET['services']."'"; 
                    } 
                    if($_GET['employee']!=""){
                         $sql.=" and employee='".$_GET['employee']."'"; 
                    } 
                    
                 
                    foreach ($conn->query($sql) as $row) {

                        $sqlR = "SELECT * FROM s_salma where REF_NO='" . $row['refno'] . "' ";  
                        $resultR = $conn->query($sqlR); 
                        $rowR = $resultR->fetch();
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>     
                            <td><?php echo $row['refno']; ?></td> 
                            <td><?php echo $row['sdate']; ?></td>   
                            <td><?php echo $rowR['CUS_NAME']; ?></td>     
                            <td><?php echo $row['service']; ?></td>  
                            <td><?php echo $row['vehicleno']; ?></td>  
                            <td><?php echo $row['employee']; ?></td>
                            <td align="right"><?php echo $row['selling']; ?></td>
                             
                        </td>   


                    </tr>

                    <?php
                    $i= $i+1;
                    $tot= $tot+$row['selling'];
                }
                ?>
                 <tr>
         
                <td  align="right" colspan='7' style='font-size:20px;'><b>Service</b></td> 
                <td align="right" style='font-size:20px;'><b><?php 
                echo number_format($tot, 2, ".", ",");
        
                ?><b/></td> 
            </tr>
                <!--============-->
                
                 <?php
                    $i=1;
                    $tot1=0; 
                    include './connection_sql.php';
 
                    $sql = "select * from payment  where cancel='0'  and type='SALARY'  and workertype='WORKER'";
                   
                     if($_GET['check'] =="on"){
                         $sql.=" and   sdate>='" . $_GET["dtfrom"] . "' and sdate<='" . $_GET["dtto"] . "'"; 
                    }
                     
                    if($_GET['employee']!=""){
                         $sql.=" and name='".$_GET['employee']."'"; 
                    } 
                    
                 
                    foreach ($conn->query($sql) as $row) {
                        
                   
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>     
                            <td><?php echo $row['refno']; ?></td> 
                            <td><?php echo $row['sdate']; ?></td>   
                            <td colspan='4'><?php echo 'SALARY PAYMENT'.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;'.$row['name']; ?></td>  
                            <td align="right"><?php echo $row['amount']; ?></td>  
                             
                        </td>   


                    </tr>

                    <?php
                    $i= $i+1; 
                     $tot1= $tot1+$row['amount']; 
                }
                ?>
           
            <tr>
         
                <td  align="right" colspan='7' style='font-size:20px;'><b>Salary</b></td> 
                <td align="right" style='font-size:20px;'><b><?php 
                echo number_format($tot1, 2, ".", ",");
        
                ?><b/></td> 
            </tr>
           <!--============-->
                
                 <?php
                    $i=1;
                    $tot2=0; 
                    include './connection_sql.php';
 
                    $sql = "select * from payment  where cancel='0' and type='ADVANCE'   and workertype='WORKER'";
                   
                     if($_GET['check'] =="on"){
                         $sql.=" and   sdate>='" . $_GET["dtfrom"] . "' and sdate<='" . $_GET["dtto"] . "'"; 
                    }
                     
                    if($_GET['employee']!=""){
                         $sql.=" and name='".$_GET['employee']."'"; 
                    } 
                    
                 
                    foreach ($conn->query($sql) as $row) {
 
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>     
                            <td><?php echo $row['refno']; ?></td> 
                            <td><?php echo $row['sdate']; ?></td>   
                            <td colspan='4'><?php echo 'ADVANCE PAYMENT'.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;'.$row['name']; ?></td>  
                            <td align="right"><?php echo $row['amount']; ?></td>  
                             
                        </td>   


                    </tr>

                    <?php
                    $i= $i+1; 
                     $tot2= $tot2+$row['amount']; 
                }
                ?>
           
            <tr> 
                <td  align="right" colspan='7' style='font-size:20px;'><b>Advance</b></td> 
                <td align="right" style='font-size:20px;'><b><?php 
                echo number_format($tot2, 2, ".", ",");
        
                ?><b/></td> 
            </tr>
            
            <tr>
         
                <td  align="right" colspan='7' style='font-size:20px;'><b>TOTAL PROFIT</b></td> 
                <td align="right" style='font-size:20px;'><b><?php 
                echo number_format($tot-$tot1-$tot2, 2, ".", ",");
        
                ?><b/></td> 
               
            </tr>
        </table>
   <?php  }
    
    ?>
    
     <!--===========================================================================================-->
 
  <?php 
    if($_GET['type']=="STOCK"){
        ?>
        <table class="tb" width="1000px;" >
                <tr >
        
                    <th width="30px;">NO</th>
                    <th width="100px;">STOCK NO</th>
                    <th width="300px;">DESCRIPTION</th>
                     <th width="200px;">BRAND</th>
                    <th width="100px;">COST</th>
                    <th width="100px;">SELLING</th> 
                    <th width="120px;">QTY INHAND</th>
                    <th width="200px;">TOTAL COST</th>
                </tr>
                <?php
                $i=1;  
                $part="";
                $BAL=0;
                $cat="";
                $COST=0;
                $SELLING=0;
                $QTY=0;
                $TOTQTY=0;
                $sql1 = "Select * from s_mas  where QTYINHAND>0    ";  
                  
                if($_GET['itemtype'] !="ALL"){
                          $sql1.=" and   TYPE ='" . $_GET["itemtype"] . "' "; 
                    }
                     
                if($_GET['brand'] !="ALL"){
                         $sql1.=" and   BRAND_NAME ='" . $_GET["brand"] . "' "; 
                    }
                         $sql1.=" order by BRAND_NAME "; 
                foreach ($conn->query($sql1) as $row1) {
                      
                    ?>
                     <tr>
                             <?php  
                        
                                if($cat!=$row1['BRAND_NAME']){
                                   
                                    echo "<td colspan='8'><b>  ". $row1['BRAND_NAME'] ."   </b></td>";
                                } 
                        ?>
                             
                      </tr>
                    <tr style="font-size:13px;">
         
        
                        <td class="center"><?php echo $i ?></td>
                        
                        <td class="left" ><?php echo $row1['STK_NO']; ?> </td>
                         <td class="left" ><?php echo $row1['DESCRIPT']; ?> </td>
                        <td class="left" ><?php echo $row1['BRAND_NAME']; ?> </td>
                         <td class="right" ><?php echo $row1['COST']; ?> </td>
                         <td class="right" ><?php echo $row1['SELLING']; ?> </td>
                         <?php
                         if($row1['CAT']="KG"){
                            $QTY= $row1['QTYINHAND']/$row1['PERKG'];
                         }else{
                            $QTY= $row1['QTYINHAND'];
                         }
                         ?>
                         
                         <td class="right" style="background-color:#5af15a"><?php echo  number_format($QTY, 2, ".", ",") ; ?> </td>
                        <td align="right"><?php echo number_format($row1['COST']*$row1['QTYINHAND'], 2, ".", ","); ?></td> 
                    </tr>
                    <?php
                    $i=$i+1;
                      
                     $BAL=$BAL+$row1['COST']*$row1['QTYINHAND'] ;
                     $COST=$COST+$row1['COST'] ;
                      $SELLING=$SELLING+$row1['SELLING'] ;
                       $TOTQTY=$TOTQTY+$QTY ;
                      $cat=$row1['BRAND_NAME'];
                }
                ?>
          
           
            <tr>
        
                <td colspan='4'></td>
                <td align="right" style='font-size:20px;'><b><?php 
                echo number_format($COST, 2, ".", ",");
        
                ?><b/></td>
                 <td align="right" style='font-size:20px;'><b><?php 
                echo number_format($SELLING, 2, ".", ",");
        
                ?><b/></td>
                 <td align="right" style='font-size:20px;'><b><?php 
                echo number_format($TOTQTY, 2, ".", ",");
        
                ?><b/></td> 
                <td align="right" style='font-size:20px;'><b><?php 
                echo number_format($BAL, 2, ".", ",");
        
                ?><b/></td>
            </tr>
        </table>
   <?php  }
    
    ?>
    
     <!--===========================================================================================-->
 
  <?php 
    if($_GET['type']=="STOCK QTY"){
        ?>
        <table class="tb" width="1000px;" >
                <tr >
        
                    <th width="30px;">NO</th>
                    <th width="100px;">STOCK NO</th>
                    <th width="300px;">DESCRIPTION</th>
                     <th width="200px;">BRAND</th> 
                    <th width="120px;">QTY INHAND</th> 
                </tr>
                <?php
                $i=1;  
                $part="";
                $BAL=0;
                $cat="";
                $COST=0;
                $SELLING=0;
                $QTY=0;
                $TOTQTY=0;
                $sql1 = "Select * from s_mas  where QTYINHAND>0    ";  
                  
                if($_GET['itemtype'] !="ALL"){
                          $sql1.=" and   TYPE ='" . $_GET["itemtype"] . "' "; 
                    }
                     
                if($_GET['brand'] !="ALL"){
                         $sql1.=" and   BRAND_NAME ='" . $_GET["brand"] . "' "; 
                    }
                    $sql1.=" order by BRAND_NAME "; 
                         
                foreach ($conn->query($sql1) as $row1) {
                      
                    ?>
                     <tr>
                             <?php  
                        
                                if($cat!=$row1['BRAND_NAME']){
                                   
                                    echo "<td colspan='8'><b>  ". $row1['BRAND_NAME'] ."   </b></td>";
                                } 
                        ?>
                             
                      </tr>
                    <tr style="font-size:13px;">
         
        
                        <td class="center"><?php echo $i ?></td>
                        
                        <td class="left" ><?php echo $row1['STK_NO']; ?> </td>
                         <td class="left" ><?php echo $row1['DESCRIPT']; ?> </td>
                        <td class="left" ><?php echo $row1['BRAND_NAME']; ?> </td> 
                        <?php
                         if($row1['CAT']="KG"){
                            $QTY= $row1['QTYINHAND']/$row1['PERKG'];
                         }else{
                            $QTY= $row1['QTYINHAND'];
                         }
                         ?>
                         
                         <td class="right" style="background-color:#5af15a"><?php echo number_format($QTY, 2, ".", ","); ?> </td> 
                    </tr>
                    <?php
                    $i=$i+1;
                      
                     $BAL=$BAL+$row1['COST']*$row1['QTYINHAND'] ;
                     $COST=$COST+$row1['COST'] ;
                      $SELLING=$SELLING+$row1['SELLING'] ;
                       
                       $TOTQTY=$TOTQTY+$QTY ;
                      $cat=$row1['BRAND_NAME'];
                }
                ?>
          
           
            <tr>
        
                <td colspan='4'></td>
                 
                  
                 <td align="right" style='font-size:20px;'><b><?php 
                echo number_format($TOTQTY, 2, ".", ",");
        
                ?><b/></td> 
                 
            </tr>
        </table>
   <?php  }
    
    ?>
    
    <!--=============================================================================-->
     <?php 
    if($_GET['type']=="ALL CHEQUE"){
        ?>
        <table class="tb" width="1000px;" >
                <tr >
        
                    <th width="30px;">NO</th>
                    <th width="100px;">REF NO</th>
                    <th width="100px;">REF DATE</th>
                    <th width="100px;">CHEQUE NO</th>
                    <th width="100px;">CHEQUE DATE</th>
                    <th width="100px;">TYPE</th>
                    <th width="400px;">CUSTOMER</th>
                    <th width="100px;">BANK</th>
                    <th width="120px;">AMOUNT</th> 
                </tr>
                <?php
                $i=1;  
                $part="";
                $BAL=0;
                $sql1 = "Select * from s_invcheq     ";  
                 if($_GET['check'] =="on"){
                    $sql1.="where     Sdate>='" . $_GET["dtfrom"] . "' and Sdate<='" . $_GET["dtto"] . "'"; 
                    if($_GET['cuscode']!=""){
                         $sql1.=" and cus_code='".$_GET['cuscode']."'"; 
                    }
                 }else{
                     
                    if($_GET['cuscode']!=""){
                         $sql1.=" where cus_code='".$_GET['cuscode']."'"; 
                    }
                 }
                
               
              
                $sql1.=" order by  cus_code,che_date asc";
                 
                
                foreach ($conn->query($sql1) as $row1) {
                       $cdate=date('Y-m-d');  
                       $color="";
                       if($row1['che_date']>= $cdate){
                           $color='yellow';
                       }
                    ?>
                    
                    <tr style="font-size:13px;background-color:<?php echo $color ?>">
         
        
                        <td class="center"><?php echo $i ?></td>
                        
                        <td class="left" ><?php echo $row1['refno']; ?> </td>
                        <td class="left" ><?php echo $row1['Sdate']; ?> </td>
                        <td class="left" ><?php echo $row1['cheque_no']; ?> </td>
                      <td class="left" ><?php echo $row1['che_date']; ?> </td>
                       
                       <?php if($row1['trn_type']=="REC"){?>
                       <td class="left" >RECEIPT</td>
                      <?php  }else{?>
                         <td class="left" >ADVANCE</td>
                         <?php  }?>
                         <td class="left" ><?php echo $row1['CUS_NAME']; ?> </td>
                         <td class="left" ><?php echo $row1['bank']; ?> </td>
                        <td align="right"><?php echo number_format($row1['che_amount'], 2, ".", ","); ?></td> 
                    </tr>
                    <?php
                    $i=$i+1;
                      
                     $BAL=$BAL+$row1['che_amount'] ;
                }
                
                ?>
                 <tr>
         
                <td  align="right" colspan='8' style='font-size:20px;'><b>TOTAL AMOUNT</b></td> 
                <td align="right" style='font-size:20px;'><b><?php 
                echo number_format($BAL, 2, ".", ",");
        
                ?><b/></td>
            </tr>
            
            </table>
   <?php  }
    
    ?>
    
    <!--===================================================================================-->
    
     <?php 
    if($_GET['type']=="PENDING CHEQUE"){
        ?>
        <table class="tb" width="1000px;" >
                <tr >
        
                    <th width="30px;">NO</th>
                    <th width="100px;">REF NO</th>
                    <th width="100px;">REF DATE</th>
                    <th width="100px;">CHEQUE NO</th>
                    <th width="100px;">CHEQUE DATE</th>
                    <th width="100px;">TYPE</th>
                    <th width="400px;">CUSTOMER</th>
                    <th width="100px;">BANK</th>
                    <th width="120px;">AMOUNT</th> 
                </tr>
                <?php
                $i=1;  
                $part="";
                $BAL=0;
                $sql1 = "Select * from s_invcheq  where   ret_refno='0' or ret_refno='1'     ";  
                
                if($_GET['cuscode']!=""){
                     $sql1.=" where cus_code='".$_GET['cuscode']."'"; 
                }
               
              
                $sql1.=" order by  cus_code,che_date asc";
                
                
                foreach ($conn->query($sql1) as $row1) {
                       
                    ?>
                    
                    <tr style="font-size:13px;">
         
        
                        <td class="center"><?php echo $i ?></td>
                        
                        <td class="left" ><?php echo $row1['refno']; ?> </td>
                        <td class="left" ><?php echo $row1['Sdate']; ?> </td>
                        <td class="left" ><?php echo $row1['cheque_no']; ?> </td>
                        <?php if($row1['che_date']>=date('Y-m-d')){?>
                       <td class="left" style="background-color:<?php echo $color ?>" ><?php echo $row1['che_date']; ?> </td>
                      <?php  }else{?>
                         <td class="left" ><?php echo $row1['che_date']; ?> </td>
                         <?php  }?>
                      
                       
                       <?php if($row1['trn_type']=="REC"){?>
                       <td class="left" >RECEIPT</td>
                      <?php  }else{?>
                         <td class="left" >ADVANCE</td>
                         <?php  }?>
                         <td class="left" ><?php echo $row1['CUS_NAME']; ?> </td>
                         <td class="left" ><?php echo $row1['bank']; ?> </td>
                        <td align="right"><?php echo number_format($row1['che_amount'], 2, ".", ","); ?></td> 
                    </tr>
                    <?php
                    $i=$i+1;
                      
                     $BAL=$BAL+$row1['che_amount'] ;
                }
                
                ?>
                 <tr>
         
                <td  align="right" colspan='8' style='font-size:20px;'><b>TOTAL AMOUNT</b></td> 
                <td align="right" style='font-size:20px;'><b><?php 
                echo number_format($BAL, 2, ".", ",");
        
                ?><b/></td>
            </tr>
            
            </table>
   <?php  }
    
    ?>
    
    <!--===========================================================================================-->
    
    <?php 
    if($_GET['type']=="DEPOSITED CHEQUE"){
        ?>
        <table class="tb" width="1000px;" >
                <tr >
        
                    <th width="30px;">NO</th>
                    <th width="100px;">REF NO</th>
                    <th width="100px;">REF DATE</th>
                    <th width="100px;">CHEQUE NO</th>
                    <th width="100px;">CHEQUE DATE</th>
                    <th width="120px;">DEPOSITED NO</th> 
                    <th width="120px;">DEPOSITED DATE</th> 
                    <th width="100px;">TYPE</th>
                    <th width="400px;">CUSTOMER</th>
                    <th width="100px;">BANK</th>
                    <th width="120px;">AMOUNT</th> 
                </tr>
                <?php
                $i=1;  
                $part="";
                $BAL=0;
                $sql1 = "Select * from s_invcheq  where   ret_refno !='0' and ret_refno !='1'    ";  
                
                if($_GET['cuscode']!=""){
                     $sql1.=" where cus_code='".$_GET['cuscode']."'"; 
                }
               
              
                $sql1.=" order by  cus_code,che_date asc";
                
                
                foreach ($conn->query($sql1) as $row1) {
                        $sql_1 = "SELECT * from bankdepmas where refno='".$row1['ret_refno']."'";
            $result_1 = $conn->query($sql_1);
            $row_1= $result_1->fetch(); 
                    ?>
                    
                    <tr style="font-size:13px;">
         
        
                        <td class="center"><?php echo $i ?></td>
                        
                        <td class="left" ><?php echo $row1['refno']; ?> </td>
                        <td class="left" ><?php echo $row1['Sdate']; ?> </td>
                        <td class="left" ><?php echo $row1['cheque_no']; ?> </td>
                      <td class="left" ><?php echo $row1['che_date']; ?> </td>
                      <td class="left" ><?php echo $row1['ret_refno']; ?> </td>
                      <td class="left" ><?php echo $row_1['bdate']; ?> </td>
                       
                       <?php if($row1['trn_type']=="REC"){?>
                       <td class="left" >RECEIPT</td>
                      <?php  }else{?>
                         <td class="left" >ADVANCE</td>
                         <?php  }?>
                         <td class="left" ><?php echo $row1['CUS_NAME']; ?> </td>
                         <td class="left" ><?php echo $row1['bank']; ?> </td>
                        <td align="right"><?php echo number_format($row1['che_amount'], 2, ".", ","); ?></td> 
                    </tr>
                    <?php
                    $i=$i+1;
                      
                     $BAL=$BAL+$row1['che_amount'] ;
                }
                
                ?>
                 <tr>
         
                <td  align="right" colspan='10' style='font-size:20px;'><b>TOTAL AMOUNT</b></td> 
                <td align="right" style='font-size:20px;'><b><?php 
                echo number_format($BAL, 2, ".", ",");
        
                ?><b/></td>
            </tr>
            
            </table>
   <?php  }
    
    ?>
    
    <!--===========================================================================================-->
    
<div style='height:12px;'></div>
<table width="1000px;">
    <tr>
        <td> </td>
        <td>Prepared By:  .................     </td>
        <td></td> 
        <td class="center">Checked By:   .................</td>
        <td>&nbsp;&nbsp;&nbsp;</td>
        <td  align="right">&nbsp;&nbsp;&nbsp;&nbsp;Authorised By:.................</td>
    </tr>
</table>
<!-- ************************************************************************** -->
</center>
</body>

</html>
