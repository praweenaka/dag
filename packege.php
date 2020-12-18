<!-- Main content -->
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">PACKEGE MASTER</h3>
            <h4 style="float: right;height: 3px;"><b id="time"></b></h4>
        </div>
        <form role="form" class="form-horizontal">
            <div class="box-body">
                <div class="form-group">
                    <a onclick="location.reload();" class="btn btn-default">
                        <span class="fa fa-user-plus"></span> &nbsp; New
                    </a>

                </div>

                <input type="hidden" id="uniq" class="form-control">

                <div id="msg_box"  class="span12 text-center"  >  </div>

            </div>
            

            <div class="row">
                <div class="col-md-6">
                 <table class="table INFO">
                     <thead> 
                         <tr>
                            <th>#</th>
                            <th>SIZE</th>   
                            <th>DESIGN</th>
                            <th>REMARK</th>
                            <th>COST</th> 
                            <th>WHOLESALE PRICE</th>  
                            <th>RETAIL PRICE</th>    
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i=1;
                        include './connection_sql.php';

                        $sql = "select * from packegelist WHERE  cancel='0' ";


                        foreach ($conn->query($sql) as $row) {


                            ?>
                            <tr onclick="setrow()">
                                <td onclick="getcode('<?php echo $row['code']; ?>','<?php echo $row['design']; ?>','<?php echo $row['size']; ?>')"><?php echo $i; ?></td>
                                <td onclick="getcode('<?php echo $row['code']; ?>','<?php echo $row['design']; ?>','<?php echo $row['size']; ?>')"><?php echo $row['size']; ?></td> 
                                <td onclick="getcode('<?php echo $row['code']; ?>','<?php echo $row['design']; ?>','<?php echo $row['size']; ?>')"><?php echo $row['design']; ?></td> 
                                <td onclick="getcode('<?php echo $row['code']; ?>','<?php echo $row['design']; ?>','<?php echo $row['size']; ?>')"><?php echo $row['des']; ?></td>   
                                <td onclick="getcode('<?php echo $row['code']; ?>','<?php echo $row['design']; ?>','<?php echo $row['size']; ?>')"><?php echo $row['cost']; ?></td>   
                                <td onclick="getcode('<?php echo $row['code']; ?>','<?php echo $row['design']; ?>','<?php echo $row['size']; ?>')"><?php echo $row['wprice']; ?></td> 
                                <td onclick="getcode('<?php echo $row['code']; ?>','<?php echo $row['design']; ?>','<?php echo $row['size']; ?>')"><?php echo $row['rprice']; ?></td>  

                            </tr>

                            <?php
                            $i= $i+1;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <!-- ==================================== -->

            <div class="col-md-6">
                <div class="form-group col-sm-4"> 
                    <input type="text"  id="packegename" class="col-sm-4" disabled="">
                    <input type="text"  id="packegecode" class="col-sm-4" disabled="">
                </div>
                <div class="form-group"> 
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#home" >SUMMARY</a></li>
                        <li><a data-toggle="tab" href="#menu1"  onclick="add_spareview();">SPARE ITEM</a></li>
                        <li><a data-toggle="tab" href="#menu2" onclick="add_expenseview();">FIXED EXPENSES</a></li>
                    </ul>
                </div>
                <!-- ==================== -->
                <div class="tab-content">
                  <div id="home" class="tab-pane fade in active"> 

                   <div class="row">
                       <div class="form-group">
                        <label class="col-sm-3  " for="txt_usernm">Spare Item Cost</label>
                        <div class="col-sm-5">
                            <input type="text" placeholder="Spare Item Cost" id="spcost" disabled class="form-control">
                        </div>
                    </div> 
                    <div class="form-group">
                        <label class="col-sm-3  " for="txt_usernm">Fixed Expenses</label>
                        <div class="col-sm-5">
                            <input type="text" placeholder="Fixed Expenses" id="fix_expen" disabled class="form-control">
                        </div>
                    </div> 
                    <div class="form-group">
                        <label class="col-sm-3  " for="txt_usernm">Wholesale Margin</label>
                        <div class="col-sm-5">
                            <input type="number" placeholder="Margin" id="w_margin" onkeyup="wpricecal();"  class="form-control">
                        </div>
                    </div> 
                    <div class="form-group">
                        <label class="col-sm-3  " for="txt_usernm">Wholesale PRICE</label>
                        <div class="col-sm-5">
                            <input type="text" placeholder="Wholesale PRICE"  id="wprice" disabled class="form-control">
                        </div>
                    </div> 
                    <div class="form-group">
                        <label class="col-sm-3  " for="txt_usernm">RETAIL Margin</label>
                        <div class="col-sm-5">
                            <input type="number" placeholder="Margin" id="r_margin"  onkeyup="rpricecal();" class="form-control">
                        </div>
                    </div> 
                    <div class="form-group">
                        <label class="col-sm-3  " for="txt_usernm">RETAIL PRICE</label>
                        <div class="col-sm-5">
                            <input type="text" placeholder="Code" id="rprice" disabled class="form-control">
                        </div>
                        <div class="col-sm-3">
                          <a onclick="updatepackege();" class="btn btn-primary">
                            <span class="fa fa-save"></span> &nbsp; UPDATE
                        </a> 
                    </div>
                </div> 
            </div> 
        </div>
        <!-- ======================= -->
        <div id="menu1" class="tab-pane fade">
         <div class="row">
          <table width="100%" class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>NAME</th> 
                    <th>COST</th> 
                    <th>QTY</th> 
                    <th>TOTAL</th> 
                    <th>#</th> 
                </tr>
                <tr>
                    <td> <select name="spareitem" id="spareitem"    class="form-control" > 
                        <?php
                        require_once("./connection_sql.php");

                        $sql = "Select * from workers order by code";
                        foreach ($conn->query($sql) as $row) {
                            echo "<option value=\"" . $row["name"] . "\">" . $row["name"] . "</option>";
                        }
                        ?>
                    </select></td> 
                    <td><input type="number" placeholder="COST" id="cost" onblur="sparecal();"  class="form-control"></td>
                    <td><input type="number" placeholder="QTY" id="qty"  onblur="sparecal();" class="form-control"></td>
                    <td><input type="number" placeholder="TOTAL" id="total" disabled=""  class="form-control"></td>
                    <td><a onclick="add_spare();" class="btn btn-default btn-sm"> <span class="fa fa-plus"></span> &nbsp; </a></td>
                </tr>
                <tbody>
                 <div id="itemdetails" > </div>
             </tbody>
         </thead>
     </table>
 </div>
</div>
<!-- ========================= -->
<div id="menu2" class="tab-pane fade">
 <div class="row">
  <table width="100%" class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th>NAME</th> 
            <th>COST</th>  
            <th>#</th> 
        </tr>
        <tr>
            <td> <select name="name" id="name"    class="form-control" > 
                <?php
                require_once("./connection_sql.php");

                $sql = "Select * from expenses order by code";
                foreach ($conn->query($sql) as $row) {
                    echo "<option value=\"" . $row["name"] . "\">" . $row["name"] . "</option>";
                }
                ?>
            </select></td> 
            <td><input type="number" placeholder="COST" id="cost1"   class="form-control"></td> 
            <td><a onclick="add_expense();" class="btn btn-default btn-sm"> <span class="fa fa-plus"></span> &nbsp; </a></td>
        </tr>
        <tbody>
         <div id="itemdetails1" > </div>
     </tbody>
 </thead>
</table>
</div>
</div>

<!-- ======================================== -->
</div>
<!-- ========== -->
</div>





<!-- =================== -->
</div>

</form>
</div>

</section>

<script src="js/packege.js"></script>
<script>new_inv();</script>