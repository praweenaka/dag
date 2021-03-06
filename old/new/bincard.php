<link rel="stylesheet" href="css/themes/redmond/jquery-ui-1.10.3.custom.css" />

<!-- Main content -->
<section class="content">

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Bin Card</h3>
        </div>
        <form role="form" name ="form1" class="form-horizontal">
            <div class="box-body">

                <div class="form-group">
 
                    <div class="col-sm-4">

                        <a onclick="print_inv();" class="btn btn-default">
                            <span class="fa fa-print"></span> &nbsp; Print Bin Card
                        </a>
                        <a onclick="print_inv1();" class="btn btn-default">
                            <span class="fa fa-print"></span> &nbsp; Print Sup. Card
                        </a>
                    </div>
                    <div class="col-sm-2"> 
                    </div>

                    <div class="col-sm-2">
                        <input type="text" placeholder="Discount 1"  id="dis1" onkeyup="cal();" class="form-control input-sm ">
                    </div>
                    <div class="col-sm-2">
                        <input type="text"  placeholder="Discount 2"  id="dis2" onkeyup="cal();" class="form-control input-sm ">
                    </div>

                    <div class="col-sm-2">
                        <input type="text" disabled  placeholder="Total"  id="tot" class="form-control input-sm ">
                    </div>
                </div>
                <div id="msg_box"  class="span12 text-center"  ></div>

                <input type="hidden" id="tmpno" class="form-control">
                <input type="hidden" id="item_count" class="form-control">

                <div class="form-group">
                    <label class="col-sm-1 control-label" for="firstname_hidden">Item No</label>
                    <div class="col-sm-2">
                        <input type="text"  id="stk_no" onblur="load_item();" class="form-control input-sm">
                    </div> 

                    <div class="col-sm-1">
                        <input type="button" onclick="search();" class="btn btn-primary btn-sm" value="..." id="searchcost" name="searchcost">
                    </div>


                    <label class="col-sm-1 control-label" for="firstname_hidden">Item Name</label>
                    <div class="col-sm-3">
                        <input type="text"  id="descript" disabled class="form-control input-sm">
                    </div>
                    <div id="day90" class="col-sm-1">

                    </div>
                    <div class="col-sm-1">

                    </div>					
                    <div id="stk" class="col-sm-1">

                    </div>	 

                </div>

                <div class="form-group">
                    <label class="col-sm-1 control-label" for="firstname_hidden">Part No</label>
                    <div class="col-sm-2">
                        <input type="text" disabled  id="part_no" class="form-control input-sm">
                    </div> 

                    <div class="col-sm-1">

                    </div>
                    <label class="col-sm-1 control-label" for="firstname_hidden">Selling</label>
                    <div class="col-sm-2">
                        <input type="text"   id="selling"  disabled onblur="cal();" class="form-control input-sm">
                    </div>

                    <div class="col-sm-1">

                    </div>
                    <div id="unsold" class="col-sm-1">

                    </div>
                    <div class="col-sm-1">

                    </div>					 
                    <div id="stkinhand" class="col-sm-1">

                    </div>						 
                </div>

                <div class="form-group">
                    <label for="firstname_hidden" class="col-sm-1 control-label">Department</label>
                    <div class="col-sm-2">
                        <select id="to_dep"  onclick="load_item();" width='120' class="form-control input-sm" >
                            <option value='All'>All</option>
                            <?php
                            $sql = "select * from s_stomas order by CODE";
                            $result = mysqli_query($GLOBALS['dbinv'], $sql);
                            while ($row = mysqli_fetch_array($result)) {
                                //echo "<option value='" . $row["barnd_name"] . "'>" . $row["barnd_name"] . "</option>";

                                echo "<option value='" . $row["CODE"] . "'>" . $row["CODE"] . "-" . $row["DESCRIPTION"] . "</option>";
                            }
                            ?>
                        </select>
                    </div> 
                    <div class="col-sm-1">

                    </div> 
                    <label class="col-sm-1 control-label" for="firstname_hidden">From</label>
                    <div class="col-sm-2">
                        <?php
                        $sqlt = "Select * from invpara";
                        $resultt = mysqli_query($GLOBALS['dbinv'], $sqlt);
                        $rowt = mysqli_fetch_array($resultt);
                        ?>

                        <input type="text" value="<?php echo $rowt['last_invdata']; ?>"   onchange="load_item();" id="dtfrom" class="form-control input-sm dt">
                    </div>
                    <div class="col-sm-1">

                    </div>
                    <div id="active" class="col-sm-1">

                    </div>

                </div>

                <div class="form-group">
                    <div class="col-md-3">

                        <table class="table table-striped" style="width:240px;" ><tr class='info'><th>Monthly Consumtion</th></tr>
                            <tr><td> <select id="yer"  onclick="load_item();"  class="form-control input-sm" >
                                <?php
                                $sql = "select year(sdate) as yer from s_trn group by year(sdate) order by year(sdate) desc";
                                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                                while ($row = mysqli_fetch_array($result)) {
                                    echo "<option value='" . $row["yer"] . "'>" . $row["yer"] . "</option>";
                                }
                                ?>
                            </select>
                        </td></tr>
                    </table>
                </div>

                <div id="consum"  class="col-sm-9">

                </div>
            </div>



            <div class="form-group">
                <div class="checkbox col-sm-9">
                    <label ><input id="chk_trns" onclick="load_item();" type="checkbox" value="">Show Transcations</label>
                </div>
                <div id="pending" class="">

                </div>	
            </div>

            <div id="itemdetails" style="height:600px;overflow:scroll;"  class="col-md-9" >

            </div>

            <div id="itemdetails1" class="col-md-3" >

            </div>

            <div id="itemdetails2"  class="col-sm-7"></div>

        </div>






        <div  class='space' >
            <br>&nbsp;
            <br>&nbsp;
            <br>&nbsp;
        </div>

    </form>
</div>

</section>

<script src="js/bincard.js"></script>



<?php
include 'search_item_form.php';
?>
