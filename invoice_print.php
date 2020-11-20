
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
           width: 800px;
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

$sql = "Select * from s_salma where tmp_no='" . $_GET["tmp_no"] . "'";
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
    <table width="800px;"  style="margin-top: 150px;" cellspacing="0" align="center" border="0">



        <tr>

            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>

            <td> <?php echo $row['CUS_NAME'] ?></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="right"><?php echo $row['REF_NO']; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $row['SDATE'] ?></td>
        </tr>
        <tr>

            <td>City :<?php echo $row1['ADD1'] ?></td>
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

    <table class="tb" align="center">

        <?php
        $i=1;
        $part="";
        $sql1 = "Select * from t_invo where REF_NO='" . $row['REF_NO'] . "' order by CardNO desc";
        foreach ($conn->query($sql1) as $row1) {

            ?>
            <tr> 


                <td class="left" ><?php echo $row1['jobno']; ?> </td>
                <td class="left" ><?php echo $row1['t_size']; ?> </td>
                <td class="left" > </td>
                <td class="left" > </td>
                <td class="left" ><?php echo $row1['make']; ?> </td>
                <td class="right"><?php echo number_format($row1['prec_amo'], 0, ".", ","); ?></td>
                <td class="right"><?php echo number_format($row1['repair'], 2, ".", ","); ?></td> 
                <td class="right"><?php echo number_format($row1['subtot'], 2, ".", ","); ?></td> 
            </tr>
            <?php
            $i=$i+1;
            $part=$row1['PART_NO'];
        }
        ?>

        <?php

        $t=20;
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

         </tr>";
         $i=$i+1;
     }

     ?>


     <tr>

        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td> 
        <td></td> 
        <td class="right"><?php 
        echo number_format($row['GRAND_TOT'], 2, ".", ",");

        ?></td>
    </tr>
</table>


</table>
<div style='height:150px;'></div>
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
