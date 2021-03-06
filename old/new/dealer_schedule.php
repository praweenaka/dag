<?php
include './connection_sql.php';
?>

<!-- Main content -->

<section class="content">



    <div class="box box-primary">

        <div class="box-header with-border">

            <h3 class="box-title">Dealer Visit Schedule</h3>

        </div>

        <form  name= "form1"  role="form" class="form-horizontal">

            <div class="box-body">



                <div class="form-group">

                    <a onclick="new_inv();" class="btn btn-primary btn-sm">
                        <span class="fa fa-user-plus"></span> &nbsp; New
                    </a>
                    <a onclick="save();" class="btn btn-success btn-sm">
                        <span class="fa fa-save"></span> &nbsp; Save
                    </a>
					<a onclick="email();" class="btn btn-success btn-sm">
                        <span class="fa fa-save"></span> &nbsp; Email
                    </a>
                </div>



                <div id="msg_box"  class="span12 text-center"  >



                </div>
				 <input type="hidden" value=""  id="tmp_no" >
                <div class="form-group">

                    <label class="col-sm-1 control-label">Date</label>

                    <div class="col-sm-2">

                        <input type="date" placeholder="Date" id="invdate" value="<?php echo date('Y-m-d'); ?>" class="form-control dt">

                    </div>

                    <label class="col-sm-1 control-label">Rep</label>

                    <div class="col-sm-2">    

                        <select id="sal_ex" class="form-control" onchange="setRep()">

<?php
require_once ("connectioni.php");

//                            $_SESSION["CURRENT_REP"] = 64;

if ($_SESSION["CURRENT_REP"] != "") {

    $_SESSION["refRep"] = $_SESSION["CURRENT_REP"];

    $sql = "select * from s_salrep where cancel='1' and REPCODE = '" . $_SESSION["CURRENT_REP"] . "' order by REPCODE";

    $result = mysqli_query($GLOBALS['dbinv'], $sql) or die("select :" . mysqli_error($GLOBALS['dbinv']));

    $row = mysqli_fetch_array($result);

    echo "<option value='" . $row["REPCODE"] . "'>" . $row["REPCODE"] . " " . $row["Name"] . "</option>";
} else {

    //welcome; manager

    $_SESSION["refRep"] = "All";

    $sql = "select * from s_salrep where cancel='1' order by REPCODE";

    $result = mysqli_query($GLOBALS['dbinv'], $sql) or die("select :" . mysqli_error($GLOBALS['dbinv']));

    echo "<option value='All'>All</option>";

    while ($row = mysqli_fetch_array($result)) {

        echo "<option value='" . $row["REPCODE"] . "'>" . $row["REPCODE"] . " " . $row["Name"] . "</option>";
    }
}
?>

                        </select>

                    </div>

                    <!--                    <div class="col-sm-1">
                    
                                            <a onfocus="this.blur()" onclick="NewWindow('serach_remark.php', 'mywin', '800', '700', 'yes', 'center');
                    
                                                    return false" href="">
                    
                                                <input type="button" class="btn btn-default" value="Find" id="searchRecords" name="searchRecords">
                    
                                            </a>
                    
                                        </div>-->

                </div>

                <input type="hidden"  id="tmpno" >

                <table class="table">
				<tr>
					 
					<th style="width : 320px;">Dealer Name</th>	
					<th style="width : 50px;"></th>		
			 
					<th style="width : 120px;">Outstanding Amount</th>				
					<th style="width : 120px;">Return Cheqe</th>	
					<th style="width : 50px;"></th>		
				</tr>
				
				<tr>
				
					<td>
					<input type="hidden" placeholder="Name" id="c_code" class="form-control input-sm">
					<input type="text" placeholder="Name" id="c_name" class="form-control input-sm"></td>
					<td><a onfocus="this.blur()" onclick="NewWindow('serach_customer.php?stname=dlr_sch', 'mywin', '800', '700', 'yes', 'center');

                                return false" href="">

                            <input type="button" class="btn btn-default" value="..." id="searchcust" name="searchcust">

                        </a>
					</td>	
					<td><input type="text" placeholder="Invoice Amt" id="outst" value="" class="form-control input-sm"></td>
					<td><input type="text" placeholder="Outstanding Amt" id="retch" value="" class="form-control input-sm"></td>				
					<td><a onclick="add_tmp();" class="btn btn-default btn-sm"> <span class="fa fa-plus"></span> &nbsp; </a></td>
					
				</tr>
				
				
				
				
				</table>

            <div id="itemdetails"></div>

        </form>

    </div>



</section>



<script src="js/dealer_sch.js">



</script>





