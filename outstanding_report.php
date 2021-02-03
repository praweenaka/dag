
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">


    <title>OUTSTANDING PRINT</title>

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
            <th class='center' colspan='5'> OUTSTANDING REPORT</th> 
        </tr>
        <tr>

            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="right">&nbsp;</td>
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
        if($_GET['cuscode']!=""){
             $sql1.=" and C_CODE='".$_GET['cuscode']."'"; 
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
                <td class="right"><?php echo number_format($row1['GRAND_TOT'], 0, ".", ","); ?></td>
                <td class="right"><?php echo number_format($row1['TOTPAY'], 2, ".", ","); ?></td> 
                <td class="right"><?php echo number_format($row1['GRAND_TOT']-$row1['TOTPAY'], 2, ".", ","); ?></td> 
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
        <td  class="right" colspan='4' style='font-size:20px;'><b>Total Balance</b></td> 
        <td class="right" style='font-size:20px;'><b><?php 
        echo number_format($BAL, 2, ".", ",");

        ?><b/></td>
    </tr>
</table>


</table> 
<div style='height:12px;'></div>
<table width="750px;">
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
