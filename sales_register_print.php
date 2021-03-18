
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

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
           width: 1050px;
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
    <table width="1050px;" cellspacing="0" border="0">

        <tr>
            <th class="center"  colspan=5 ><?php echo "AKEESHA DAG" ?></th>
        </tr> 
        
        <tr> 
            <th class='center' colspan='5'> <?php echo $_GET['type']?> REPORT</th> 
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
    if($_GET['type']=="OUTSTANDING"){
        ?>
                <table class="tb" width="1050px;" >
                <tr >
        
                    <th width="30px;">NO</th>
                    <th width="100px;">INVOICE NO</th>
                    <th width="100px;">INVOICE DATE</th>
                    <th width="400px;">CUSTOMER</th>
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
                    <tr style="font-size:13px;">
         
        
                        <td class="center"><?php echo $i ?></td>
                        
                        <?php  
                        
                        // if($part!=$row1['C_CODE']){
                           
                        //     echo "<td><b>  ". $row1['CUS_NAME'] ."   </b></td>";
                        // }else{
                        //      echo "<td  >  </td>";
                        // }
                        ?>
                        
                        <td class="left" ><?php echo $row1['REF_NO']; ?> </td>
                        <td class="left" ><?php echo $row1['SDATE']; ?> </td>
                         <td class="left" ><?php echo $row1['CUS_NAME']; ?> </td>
                        <td align="right"><?php echo number_format($row1['GRAND_TOT'], 0, ".", ","); ?></td>
                        <td align="right"><?php echo number_format($row1['TOTPAY'], 2, ".", ","); ?></td> 
                        <td align="right"><?php echo number_format($row1['GRAND_TOT']-$row1['TOTPAY'], 2, ".", ","); ?></td> 
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
                <td  align="right" colspan='4' style='font-size:20px;'><b>Total Balance</b></td> 
                <td align="right" style='font-size:20px;'><b><?php 
                echo number_format($BAL, 2, ".", ",");
        
                ?><b/></td>
            </tr>
        </table>
  <?php  }
    
    ?>
    
    <!--=================================================================================-->
    
    
    <?php 
    if($_GET['type']=="RECEIPT"){
        ?>
        <table class="tb" width="1050px;" >
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
                $sql1 = "Select * from s_crec  where CANCELL='0'  and  CA_DATE>='" . $_GET["dtfrom"] . "' and CA_DATE<='" . $_GET["dtto"] . "' ";  
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
                        <td align="right"><?php echo number_format($row1['CA_AMOUNT'], 0, ".", ","); ?></td> 
                    </tr>
                    <?php
                    $i=$i+1;
                      
                     $BAL=$BAL+$row1['CA_AMOUNT'] ;
                }
                ?>
         
             
             
             
           
            <tr>
        
                <td></td>
                <td></td> 
                <td  align="right" colspan='3' style='font-size:20px;'><b>Total AMOUNT</b></td> 
                <td align="right" style='font-size:20px;'><b><?php 
                echo number_format($BAL, 2, ".", ",");
        
                ?><b/></td>
            </tr>
        </table>
   <?php  }
    
    ?>
    
    <!--===========================================================================================-->
 
  <?php 
    if($_GET['type']=="INVOICE"){
        ?>
        <table class="tb" width="1050px;" >
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
                
              
                $sql1.=" order by  C_CODE,SDATE asc";
                
                
                foreach ($conn->query($sql1) as $row1) {
                      
                    ?>
                    <tr style="font-size:13px;">
         
        
                        <td class="center"><?php echo $i ?></td>
                        
                        <td class="left" ><?php echo $row1['REF_NO']; ?> </td>
                        <td class="left" ><?php echo $row1['SDATE']; ?> </td>
                         <td class="left" ><?php echo $row1['CUS_NAME']; ?> </td>
                         <td class="left" ><?php echo $row1['TYPE']; ?> </td>
                        <td align="right"><?php echo number_format($row1['GRAND_TOT'], 0, ".", ","); ?></td> 
                    </tr>
                    <?php
                    $i=$i+1;
                      
                     $BAL=$BAL+$row1['GRAND_TOT'] ;
                }
                ?>
         
             
             
             
           
            <tr>
        
                <td></td>
                <td></td> 
                <td  align="right" colspan='3' style='font-size:20px;'><b>Total AMOUNT</b></td> 
                <td align="right" style='font-size:20px;'><b><?php 
                echo number_format($BAL, 2, ".", ",");
        
                ?><b/></td>
            </tr>
        </table>
   <?php  }
    
    ?>
    
    <!--===========================================================================================-->
 
  <?php 
    if($_GET['type']=="SETTLEMENT"){
        ?>
        <table class="tb" width="1050px;" >
                <tr >
        
                    <th width="30px;">NO</th>
                    <th width="100px;">INVOICE NO</th>
                    <th width="100px;">INVOICE DATE</th> 
                    <th width="400px;">CUSTOMER</th>
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
                
              
                $sql1.=" order by  C_CODE,SDATE asc";
                
                
                foreach ($conn->query($sql1) as $row1) {
                       $sql2 = "Select * from s_sttr  where ST_INVONO='" . $row1["REF_NO"] . "'   ";  
                       foreach ($conn->query($sql2) as $row2) {
                         ?>
                        
                        
                        <tr style="font-size:13px;"> 
                            <td class="center"><?php echo $i ?></td> 
                            <td class="left" ><?php echo $row2['ST_INVONO']; ?> </td>
                            <td class="left" ><?php echo $row1['SDATE']; ?> </td>
                             <td class="left" ><?php echo $row1['CUS_NAME']; ?> </td>
                              <td class="left" ><?php echo $row2['ST_REFNO']; ?> </td>
                            <td align="right"><?php echo number_format($row2['ST_PAID'], 0, ".", ","); ?></td> 
                        </tr>
                        <?php
                        $i=$i+1;
                          
                         $BAL=$BAL+$row2['ST_PAID'] ;
                    }
                }
                ?>
         
             
             
             
           
            <tr>
        
                <td></td>
                <td></td> 
                <td  align="right" colspan='3' style='font-size:20px;'><b>Total AMOUNT</b></td> 
                <td align="right" style='font-size:20px;'><b><?php 
                echo number_format($BAL, 2, ".", ",");
        
                ?><b/></td>
            </tr>
        </table>
   <?php  }
    
    ?>
    
      <!--===========================================================================================-->
 
  <?php 
    if($_GET['type']=="ONHANDLIST"){
        ?>
        <table class="tb" width="1050px;" >
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
 
                    $sql = "select * from dag_item WHERE flag='0' and cancel='0'   ";  
                    if($_GET['cuscode']!=""){
                         $sql.=" and cuscode='".$_GET['cuscode']."'"; 
                    }
                     if($_GET['check'] =="on"){
                         $sql.=" and   sdate>='" . $_GET["dtfrom"] . "' and sdate<='" . $_GET["dtto"] . "'"; 
                    }
                    if($_GET['jobno']!=""){
                         $sql.=" and jobno='".$_GET['jobno']."'"; 
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
                <td  align="right" colspan='7' style='font-size:20px;'><b>Total</b></td> 
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
        <table class="tb" width="1050px;" >
                <tr>
                        <th>#</th>
                        <th>JOB NO</th>
                        <th>INVOICE NO</th>
                        <th>REG DATE</th>   
                        <th>ONHAND DATE</th>   
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
 
                    $sql = "select * from dag_item WHERE flag='1' and cancel='0'   ";  
                    if($_GET['cuscode']!=""){
                         $sql.=" and cuscode='".$_GET['cuscode']."'"; 
                    }
                     if($_GET['check'] =="on"){
                         $sql.=" and   sdate>='" . $_GET["dtfrom"] . "' and sdate<='" . $_GET["dtto"] . "'"; 
                    }
                    if($_GET['jobno']!=""){
                         $sql.=" and jobno='".$_GET['jobno']."'"; 
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
                <td  align="right" colspan='9' style='font-size:20px;'><b>Total</b></td> 
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
        <table class="tb" width="1050px;" >
                <tr>
                        <th>#</th>
                        <th>JOB NO</th> 
                        <th>INV NO</th>   
                        <th>DATE</th>   
                        <th>CUSTOMER</th>
                        <th>DESIGN</th>
                        <th>MAKE</th> 
                        <th>SIZE</th>  
                        <th>SERIAL NO</th>  
                        <th>WARRENTY</th> 
                        <th>AD PAY</th>   
                        <th>AMOUNT</th>    
                        <th>REPAIR</th>  
                        <th>TOTAL</th>  
                        <th>PRO DATE</th> 
                    </tr>
                <?php
                    $i=1;
                    $tot=0;
                    include './connection_sql.php';
 
                    $sql = "select * from dag_item WHERE flag='2' and cancel='0'   ";  
                    if($_GET['cuscode']!=""){
                         $sql.=" and cuscode='".$_GET['cuscode']."'"; 
                    }
                     if($_GET['check'] =="on"){
                         $sql.=" and   sdate>='" . $_GET["dtfrom"] . "' and sdate<='" . $_GET["dtto"] . "'"; 
                    }
                    if($_GET['jobno']!=""){
                         $sql.=" and jobno='".$_GET['jobno']."'"; 
                    } 
                    foreach ($conn->query($sql) as $row) {


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
                <td  align="right" colspan='10' style='font-size:20px;'><b>Total</b></td> 
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
    if($_GET['type']=="ALLLIST"){
        ?>
        <table class="tb" width="1050px;" >
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
                <td  align="right" colspan='10' style='font-size:20px;'><b>Total</b></td> 
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
        <table class="tb" width="1050px;" >
                <tr>
                        <th>#</th> 
                        <th>INVOICE NO</th>
                        <th>DATE</th>   
                        <th>CUSTOMER</th> 
                        <th>COST</th>  
                        <th>SELLING</th>   
                        <th>PROFIT</th>   
                    </tr>
                <?php
                    $i=1;
                    $tot=0;
                     $selling=0;
                      $cost=0;
                    include './connection_sql.php';
 
                    $sql = "select sum(subtot)as subtot,sum(cost*qty)as cost ,refno,sdate from t_invo  where cancel='0' and type !='service' ";
                    if($_GET['cuscode']!=""){
                         $sql.=" and cuscode='".$_GET['cuscode']."'"; 
                    }
                     if($_GET['check'] =="on"){
                         $sql.=" and   sdate>='" . $_GET["dtfrom"] . "' and sdate<='" . $_GET["dtto"] . "'"; 
                    }
                    if($_GET['jobno']!=""){
                         $sql.=" and jobno='".$_GET['jobno']."'"; 
                    } 
                     $sql.=" group by refno "; 
                   
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
                            <td align="right"><?php echo $row['cost']; ?></td>   
                            <td align="right"><?php echo $row['subtot']; ?></td>   
                            <td align="right"><?php echo number_format($row['subtot']-$row['cost'],2); ?></td>   
                             
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
         
                <td  align="right" colspan='4' style='font-size:20px;'><b>Total</b></td> 
                 <td align="right" style='font-size:20px;'><b><?php 
                echo number_format($cost, 2, ".", ",");
        
                ?><b/></td>
                 <td align="right" style='font-size:20px;'><b><?php 
                echo number_format($selling, 2, ".", ",");
        
                ?><b/></td>
                <td align="right" style='font-size:20px;'><b><?php 
                echo number_format($tot, 2, ".", ",");
        
                ?><b/></td> 
            </tr>
        </table>
   <?php  }
    
    ?>
    <!--===================================================================================-->
    
      <?php 
    if($_GET['type']=="SERVICES"){
        ?>
        <table class="tb" width="1050px;" >
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
         
                <td  align="right" colspan='7' style='font-size:20px;'><b>Total</b></td> 
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
        <table class="tb" width="1050px;" >
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
                     $tot= $tot+$row['amount']; 
                }
                ?>
          
           
            <tr>
         
                <td  align="right" colspan='5' style='font-size:20px;'><b>Total</b></td> 
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
        <table class="tb" width="1050px;" >
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
         
                <td  align="right" colspan='5' style='font-size:20px;'><b>Total</b></td> 
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
        <table class="tb" width="1050px;" >
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
         
                <td  align="right" colspan='5' style='font-size:20px;'><b>Total</b></td> 
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
        <table class="tb" width="1050px;" >
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
         
                <td  align="right" colspan='5' style='font-size:20px;'><b>Total</b></td> 
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
        <table class="tb" width="1050px;" >
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
         
                <td  align="right" colspan='5' style='font-size:20px;'><b>Total</b></td> 
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
        <table class="tb" width="1050px;" >
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
 
                    $sql = "select * from payment  where cancel='0'  and type='SALARY' ";
                   
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
         
                <td  align="right" colspan='7' style='font-size:20px;'><b>Profit Total</b></td> 
                <td align="right" style='font-size:20px;'><b><?php 
                echo number_format($tot-$tot1-$tot2, 2, ".", ",");
        
                ?><b/></td> 
            </tr>
        </table>
   <?php  }
    
    ?>
    
    <!--===================================================================================-->
    
    
    
<div style='height:12px;'></div>
<table width="750px;">
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
</body>

</html>
