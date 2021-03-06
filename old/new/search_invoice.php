
<?php
session_start();
include_once './connection_sql.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href="style.css" rel="stylesheet" type="text/css" media="screen" />


        <title>Search Customer</title>
        <link rel="stylesheet" href="css/bootstrap.min.css">

        
        <script language="JavaScript" src="js/trans_pay.js"></script>



    </head>

    <body>

        <table width="735"   class="table table-bordered">

            <tr>
                <?php
                $stname = "";
                if (isset($_GET['stname'])) {
                    $stname = $_GET["stname"];
                }
 
                ?>
                <td width="122" ><input type="text" size="20" name="cusno" id="cusno" value=""  class="form-control" tabindex="1" onkeyup="<?php echo "update_cust_list('$stname')"; ?>"/></td>
                <td width="122" ><input type="text" size="20" name="cusno1" id="cusno1" value=""  class="form-control" tabindex="1" onkeyup="<?php echo "update_cust_list('$stname')"; ?>"/></td>
                <td width="424" ><input type="text" size="70" name="customername" id="customername" value=""  class="form-control" onkeyup="<?php echo "update_cust_list('$stname')"; ?>"/></td>
        </table>    
        <div id="filt_table" class="CSSTableGenerator">  <table width="735"   class="table table-bordered">
                <tr>
                    <th width="160"  >Invoice No</th>
                    <th width="424"  >Customer Code</th>
                    <th width="424"  >Customer Name</th>
                    <th width="424"  >Inv.Date</th>
                    <th width="300"  >Address</th>

                </tr>
                <?php
                if($_SESSION["trans_user"]==""){
                     $sql = "SELECT * from s_salma where cancell='0'  ";
                }else{
                    $sql = "SELECT * from s_salma where cancell='0' and C_CODE='".$_SESSION["trans_user"]."' ";
                }
               


                $sql = $sql . " order by sdate desc limit 50";
 
                $stname = "";
                if (isset($_GET['stname'])) {
                    $stname = $_GET["stname"];
                } 
                 echo $_SESSION["trans_user"];  
                foreach ($conn->query($sql) as $row) {
                    $cuscode = $row['REF_NO'];
                    if($row['transamou']=="0.00"){
                        $stname="NotPaid";
                         echo "<tr >               
                              <td onclick=\"custno('$cuscode', '$stname');\">" . $row['REF_NO'] . "</a></td>
                              <td onclick=\"custno('$cuscode', '$stname');\">" . $row['C_CODE'] . "</a></td>
                              <td onclick=\"custno('$cuscode', '$stname');\">" . $row['CUS_NAME'] . "</a></td>
                              <td onclick=\"custno('$cuscode', '$stname');\">" . $row['SDATE'] . "</a></td>
                              <td onclick=\"custno('$cuscode', '$stname');\">" . $row['C_ADD1'] . "</a></td>
                            </tr>";
                    }else{
                        $stname="Paid";
                         echo "<tr bgcolor=\"red\">               
                              <td onclick=\"custno('$cuscode', '$stname');\">" . $row['REF_NO'] . "</a></td>
                              <td onclick=\"custno('$cuscode', '$stname');\">" . $row['C_CODE'] . "</a></td>
                              <td onclick=\"custno('$cuscode', '$stname');\">" . $row['CUS_NAME'] . "</a></td>
                              <td onclick=\"custno('$cuscode', '$stname');\">" . $row['SDATE'] . "</a></td>
                              <td onclick=\"custno('$cuscode', '$stname');\">" . $row['C_ADD1'] . "</a></td>
                            </tr>";
                    }
                   
                }
                ?>
            </table>
        </div>

    </body>
</html>
