
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">


    <title>DAG Print</title>

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

$sql = "Select * from dag where refno='" . $_GET["refno"] . "' and cancel='0'";
$result = $conn->query($sql);
$row = $result->fetch();

$sql1 = "Select * from vendor where CODE='" . $row["cuscode"] . "'";
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
            <td> <?php echo $row['cusname'] ?></td>
            <td></td>
            <td class="right"><?php echo $row['refno']; ?> </td>  
        </tr>
         <tr> 
            <td>&nbsp;</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr> 
             <td> <?php echo $row['cuscode'] ?></td>
            <td></td>
             <td class="right"> <?php echo $row['sdate'] ?></td>
        </tr>
        <tr> 
            <td>&nbsp;</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
         <tr> 
             <td> <?php echo $row1['ADD1'] ?></td>
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
        $sql1 = "Select * from dag_item where refno='" . $row['refno'] . "' order by refno desc";
        foreach ($conn->query($sql1) as $row1) {

            ?>
            <tr> 

                 <td class="left" ><?php echo $row1['jobno']; ?> </td> 
                <td class="left" ><?php echo $row1['size']; ?> </td>  
                <td class="left" ><?php echo $row1['marker']; ?> </td>
                <td class="left" ><?php echo $row1['serialno']; ?> </td> 
                 <td class="left" ><?php echo $row1['warrenty']; ?> </td> 
                <td class="left" ><?php echo $row1['belt']; ?> </td>
                <td class="left" ><?php echo $row1['remark']; ?> </td>
             
               
            </tr>
            <?php
            $i=$i+1; 
        }
        ?>

        <?php

        $t=36;
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

        <td><?php if($row['TYPE']=="CA"){
             echo "PAID";
        }
       

        ?></td>
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
