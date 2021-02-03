
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">


    <title>Invoice Print</title>

    <style>
        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        .tb  {
           width: 750px;
           border: 0px solid black;


           border-collapse: collapse;
       }
       .tb td  {

           border-top: 0px solid black;
           border-left: 0px solid black;


           border-collapse: collapse;
       }
       .tb th  {

           border-top: 1px solid black;
           border-left: 1px solid black;


           border-collapse: collapse;
       }

       .tb1 {

           border: 0px solid #000000;
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
    <table width="750px;"  style="margin-top: 150px;" cellspacing="0" align="center" border="0">

 
      
 <tr>

            <td>&nbsp;</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr> 
        <tr>

            <td>&nbsp;</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr> 
        <tr>


            <td>&nbsp;</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr> 
        <tr>

            <td>&nbsp;</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        
        <tr>

            <td> <?php echo $row['CUS_NAME'] ?></td>
            <td></td>
            <td class="right"><?php echo $row['REF_NO']; ?> </td>
            <td></td>
            <td class="right"> <?php echo $row['SDATE'] ?></td>
             
        </tr>
        
        <tr>

            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        
        <tr>

            <td>&nbsp;</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        
        <tr>

            <td>&nbsp;</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>

            <td>&nbsp;</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
         
        
    </table>

    <table class="tb" align="center"   >

        <?php
        $i=1;
        $part="";
        $sql1 = "Select * from t_invo where refno='" . $row['REF_NO'] . "' order by refno desc";
        foreach ($conn->query($sql1) as $row1) {

            ?>
            <tr> 


                <td class="left" ><?php echo $row1['jobno']; ?> </td>
                <td class="left" ><?php echo $row1['size']; ?> </td>  
                <td class="left" ><?php echo $row1['serialno']; ?> </td>
                <td class="left" ><?php echo $row1['design']; ?> </td>
                <td class="left" ><?php echo $row1['make']; ?> </td>
            <?php if($row1['reject'] =="0"){?>
                 <td class="right"><?php echo number_format($row1['selling'], 0, ".", ","); ?></td>
                <td class="right"><?php echo number_format($row1['repair1'], 2, ".", ","); ?></td> 
                <td class="right"><?php echo number_format($row1['subtot'], 2, ".", ","); ?></td> 
              <?php  }else{?>
                     <td class="right"><?php  echo "REJECTED"; ?></td> 
               <?php }
                ?>
               
            </tr>
            <?php
            $i=$i+1; 
        }
        ?>

        <?php

        $t=34;
        while ($i <$t) {

         echo "<tr>

         <td>&nbsp;</td>
         <td></td>
         <td></td>
         <td></td>
         <td></td> 
         <td></td> 
         <td></td> 
         <td></td> 
        <td></td> 
         </tr>";
         $i=$i+1;
     }

     ?>
         

     <tr>

        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>   <td></td>   <td></td> 
        <td class="right"><?php 
        echo number_format($row['GRAND_TOT'], 2, ".", ",");

        ?></td>
         <td></td>   <td></td>    <td></td>  
    </tr>
</table>


</table>
 
<table width="800px;" align="center">
    <tr>
        <td> </td>
        <td><?php echo   $_SESSION["CURRENT_USER"] ;?> </td>
        <td></td> 
        <td></td> 
        <td></td> 
        <td></td> 
    </tr>
</table>
<!-- ************************************************************************** -->
</body>

</html>
