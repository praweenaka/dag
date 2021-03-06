<?php session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


        <title>Search Item</title>



        <link rel="stylesheet" href="css/bootstrap.min.css">


            <script language="JavaScript" src="js/reqdata_modification.js"></script>


    </head>

    <body>

        <table width="735"   class="table table-bordered">

            <?php
            if (isset($_GET["stname"])) {
                $stname = $_GET["stname"];
            } else {
                $stname = "";
            }
            ?>

            <tr>

                <td width="182" ><input type="text" size="20" name="cusno" id="cusno" value=""  class="form-control" tabindex="1" onkeyup="<?php echo "update_cust_list('$stname')"; ?>"/></td>
                <td width="403" ><input type="text" size="70" name="customername" id="customername" value=""  class="form-control dt" onkeyup="<?php echo "update_cust_list('$stname')"; ?>"/></td>
                <td width="503" ><input type="text" size="70" name="des" id="des" value=""  class="form-control dt" onkeyup="<?php echo "update_cust_list('$stname')"; ?>"/></td>
        </table>    
        <div id="filt_table" class="CSSTableGenerator">  <table width="735"    class="table table-bordered">
                <tr>
                    <td width="121"  >Code </td>
                    <td width="100"  > Req By</td>
                    <td width="100"  >Description</td>
                    <td width="100"  > Sdate </td>

                </tr>
                <?php
                include_once './connectioni.php';

                $stname = "";
                if (isset($_GET['stname'])) {
                    $stname = $_GET["stname"];
                }


                $sql = "SELECT * from requestdatamodi where cancel='0' group by id limit 50";

                $result = mysqli_query($GLOBALS['dbinv'], $sql);

                while ($row = mysqli_fetch_array($result)) {

                    echo "<tr>
                              <td onclick=\"custno('" . $row['code'] . "','" . $stname . "');\">" . $row['code'] . "</a></td>
                                  <td onclick=\"custno('" . $row['code'] . "','" . $stname . "');\">" . $row['reqby'] . "</a></td>
                              <td onclick=\"custno('" . $row['code'] . "','" . $stname . "');\">" . $row['des'] . "</a></td>
                              <td onclick=\"custno('" . $row['code'] . "','" . $stname . "');\">" . $row['sdate'] . "</a></td>
                                  
                   
                            </tr>";
                }
                ?>
            </table>
        </div>

    </body>
</html>
