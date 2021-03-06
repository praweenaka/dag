<?php
session_start();
include_once './connection_sql.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href="style.css" rel="stylesheet" type="text/css" media="screen" />


        <title>Search Remark</title>
        <link rel="stylesheet" href="css/bootstrap.min.css">
            <script language="JavaScript" src="js/dealer_rmk.js"></script>
    </head>

    <body>

        <table width="735"   class="table table-bordered">

            <tr>
                <?php
//                $stname = "";
//                if (isset($_GET['stname'])) {
//                    $stname = $_GET["stname"];
//                }
                ?>
<!--                <td width="122" ><input type="text" size="20" name="cusno" id="cusno" value=""  class="form-control" tabindex="1" onkeyup="<?php echo "update_cust_list('$stname')"; ?>"/></td>
                <td width="424" ><input type="text" size="70" name="customername" id="customername" value=""  class="form-control" onkeyup="<?php echo "update_cust_list('$stname')"; ?>"/></td>-->
        </table>    
        <div id="filt_table" class="CSSTableGenerator">  <table width="735"   class="table table-bordered">
                <tr>
                    <th width="121">Date</th>
                    <th width="424">Rep</th>
                    <th width="300">Location</th>
                </tr>
                <?php

                $sql = "SELECT * from dlr_rmk where rep = '".$_SESSION["refRep"]."' order by date desc";
                echo $sql;

//                $stname = "";
//                if (isset($_GET['stname'])) {
//                    $stname = $_GET["stname"];
//                }

                foreach ($conn->query($sql) as $row) {
                        echo "<tr>               
                              <td onclick=\"remarkno('".$row['id']."');\">" . $row['date'] . "</a></td>
                              <td onclick=\"remarkno('".$row['id']."');\">" . $row['rep'] . "</a></td>
                              <td onclick=\"remarkno('".$row['id']."');\">" . $row['loc'] . "</a></td>
                            </tr>";
                }
                ?>
            </table>
        </div>

    </body>
</html>
