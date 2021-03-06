<link rel="stylesheet" href="css/themes/redmond/jquery-ui-1.10.3.custom.css" />

<!-- Main content -->
<section class="content">

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Defect Movement</h3>
        </div>
        <form role="form" name ="form1" class="form-horizontal">
            <div class="box-body">

                <?php
                include './connection_sql.php';
                $mcode = "";
                $mname = "";
                if (isset($_GET['txtrefno'])) {
                    $sql = "select * from c_clamas where refno ='" . $_GET['txtrefno'] . "'";
                    $result_g = $conn->query($sql);
                    if ($row_g = $result_g->fetch()) {
                        $mcode = $row_g['stk_no'];
                        $mname = $row_g['des'];
                    }
                }
                ?>



                <div class="form-group">

                    <a onclick="new_inv();" class="btn btn-default">
                        <span class="fa fa-user-plus"></span> &nbsp; New
                    </a>

                    <a onclick="save_inv();" class="btn btn-primary">
                        <span class="fa fa-save"></span> &nbsp; Save
                    </a>

                    <a onclick="cancel_inv();" class="btn btn-danger">
                        <span class="fa fa-print"></span> &nbsp; Cancel
                    </a>		

                </div>
                <div id="msg_box"  class="span12 text-center"  ></div>

                <input type="hidden" id="tmpno" class="form-control">
                <input type="hidden" id="item_count" class="form-control">



                <div class="form-group">
                    <label for="invno" class="col-sm-2 control-label">Ref No</label>
                    <div class="col-sm-4">
                        <input type="text" placeholder="Ref No" id="invno" value ="<?php echo $_GET['txtrefno']; ?>" class="form-control"> 
                    </div> 
                </div>


                <div class="form-group">


                    <label for="firstname_hidden" class="col-sm-2 control-label">Item</label>
                    <div class="col-sm-2">
                        <input type="text" placeholder="Stk No" value="<?php echo $mcode; ?>" id="stk_no" class="form-control"> 
                    </div>

                    <div class="col-sm-4">
                        <input type="text" placeholder="Description" value="<?php echo $mname; ?>"  id="descript" class="form-control"> 
                    </div>
                </div>


                <div class="form-group">
                    <label for="invno" class="col-sm-2 control-label">Trn Type</label>
                    <div class="col-sm-4">
                        <select id="trn_type" class="form-control"> 
                            <option value = "GATEIN">Gate Pass IN</option>
                            <option value = "GATEOU">Gate Pass Out</option>
                            <option value = "SCRPOU">Scrap Out</option>
                            <option value = "SCRPIN">Scrap In</option>
                        </select>

                    </div> 
                </div>


                <div  id="itemdetails" >
                    <table class='table'>
                        <tr>
                            <th>Date</th>
                            <th>Tran Type</th>
                            <th></th>
                        </tr>

<?php
$sql = "select * from s_trn_defective where refno ='" . $_GET['txtrefno'] . "'  order by id";
foreach ($conn->query($sql) as $row) {

    echo "<tr>";
    echo "<td onclick=\"getcus('" . $row['SDATE'] . "','" . $row['c_name'] . "')\">" . $row['SDATE'] . "</td>";


    if ($row['LEDINDI'] == "DGRN") {
        $mfrom = "Defect Form";
    }
    if ($row['LEDINDI'] == "GATEIN") {
        $mfrom = "Gate Pass In";
    }
    if ($row['LEDINDI'] == "GATEOU") {
        $mfrom = "Gate Pass Out";
    }
    if ($row['LEDINDI'] == "SCRPOU") {
        $mfrom = "Scrap Out";
    }
    if ($row['LEDINDI'] == "SCRPIN") {
        $mfrom = "Scrap In";
    }

    echo "<td>" . $mfrom . "</td>";

    if ($row['LEDINDI'] != "DGRN") {
        echo "<td><a class=\"btn btn-danger btn-sm\" onClick=\"del_item('" . $row['ID'] . "')\"> <span class='fa fa-remove'></span></a></td>";
    } else {
        echo "<td></td>";
    }

    echo "</tr>";
}
?>

                    </table>

                </div>



            </div>

            <div  class='space' >
                <br>&nbsp;
                <br>&nbsp;
                <br>&nbsp;

            </div>

        </form>
    </div>

</section>

<script src="js/def_inv.js"></script>
<script src="js/common.js"></script>
<script src="js/jquery-1.9.1.js"></script>
<script src="js/jquery-ui.custom.js"></script>
<script src="js/common.js"></script>
<script  type="text/javascript" src="js/jquery-1.6.1.min.js"></script>
<script  type="text/javascript" src="js/jquery-ui-1.8.14.custom.min.js"></script>
<script>

                                            document.getElementById('datatable').style.visibility = "false";




</script>

<script>

    function  new_inv() {


        document.getElementById('msg_box').innerHTML = "";


    }

</script>

<style type="text/css">
    ${demo.css}
</style>
