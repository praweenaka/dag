<!-- Main content -->
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">SALES REGISTER</h3>
            <h4 style="float: right;height: 3px;"><b id="time"></b></h4>
        </div>
        <form role="form" name ="form1" class="form-horizontal" target="_blank" action="sales_register_print.php">
            <div class="box-body">
                <div class="form-group">
                    <a onclick="location.reload();" class="btn btn-default">
                        <span class="fa fa-user-plus"></span> &nbsp; New
                    </a>  
                    <button><a onclick="print_inv();" class="btn btn-primary btn-sm">
                        <span class="fa fa-print"></span> &nbsp; Print
                    </a></button>
                    
                   
                </div>

                <input type="hidden" id="uniq" class="form-control">

                <div id="msg_box"  class="span12 text-center"  >  </div>

            </div>

            <div class="row">
                <div class="form-group">
                    <label class="col-sm-1 control-label" for="txt_usernm">CUSTOMER CODE</label>
                    <div class="col-sm-2">
                        <input type="text" placeholder="CUSTOMER CODE" id="cuscode" name="cuscode"     class="form-control">
                    </div>
                    <label class="col-sm-1 control-label" for="txt_usernm">CUSTOMER NAME</label>
                    <div class="col-sm-2">
                        <input type="text" placeholder="NAME" id="cusname" disabled=""  class="form-control">
                    </div> 
                    <div class="col-sm-1">
                        <a onfocus="this.blur()" onclick="NewWindow('customer_search.php?stname=dag', 'mywin', '800', '700', 'yes', 'center');
                        return false" href="">
                        <input type="button" class="btn btn-danger" value="..." id="searchcust" name="searchcust">
                    </a>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-1 control-label" for="txt_usernm">DATE FROM</label>
                    <div class="col-sm-2">
                        <input type="date" id="dtfrom" name="dtfrom"  value="<?php echo date('Y-m-d');?>"   class="form-control">
                    </div>
                    <label class="col-sm-1 control-label" for="txt_usernm">DATE TO</label>
                    <div class="col-sm-2">
                        <input type="date"   id="dtto" name="dtto"  value="<?php echo date('Y-m-d');?>"  class="form-control">
                    </div>  
                    <div class="col-sm-2">
                       <input type="checkbox"   id="check" name="check"    >
                    </div>  
                    
                </div>
                
                <div class="form-group">
                    <label class="col-sm-1 control-label" for="txt_usernm">TYPE</label>
                    <div class="col-sm-2">
                       <select id="type" name="type" class="form-control input-sm"> 
                            <option value="SETTLEMENT">SETTLEMENT</option>
                            <option value="INVOICE">INVOICE</option>
                            <option value="RECEIPT">RECEIPT</option>      
                            <option value="OUTSTANDING">OUTSTANDING</option>    
                            <option value="ONHANDLIST">ONHAND LIST</option>    
                            <option value="PRODUCTIONLIST">PRODUCTION LIST</option> 
                            <option value="COMPLETELIST">COMPLETE LIST</option> 
                            <option value="ALLLIST">ALL LIST</option>   
                            <option value="PROFIT">PROFIT REPORT</option> 
                            <option value="SERVICES">SERVICES REPORT</option> 
                            <option value="SALARY">SALARY REPORT</option> 
                        </select>
                    </div>
                     <label class="col-sm-1 control-label" for="txt_usernm">JOB NO</label>
                    <div class="col-sm-2">
                        <input type="text" id="jobno" name="jobno"  placeholder="JOB NO"  class="form-control">
                    </div> 
                </div>
                <div class="form-group">
                    <label class="col-sm-1 control-label" for="txt_usernm">EMPLOYEE</label>
                    <div class="col-sm-2">
                       <select id="employee" name="employee"  class="form-control input-sm"  >
                                <option value="">SELECT EMPLOYEE</option>
                                <?php 
                                $sql = "select * from workers where cancel ='0' and type='WORKER' order by name";
                                  foreach ($conn->query($sql) as $row) {
                                    echo "<option value='" . $row["name"] . "'>" . $row["name"] . "</option>";
                                }
                                ?>
                            </select>
                    </div>
                    
                    <label class="col-sm-1 control-label" for="txt_usernm">SERVICES</label>
                    <div class="col-sm-2">
                       <select id="services" name="services"  class="form-control input-sm"  >
                                <option value="">SELECT SERVICE</option>
                                <?php 
                                $sql = "select * from services where cancel ='0'     order by name";
                                  foreach ($conn->query($sql) as $row) {
                                    echo "<option value='" . $row["name"] . "'>" . $row["name"] . "</option>";
                                }
                                ?>
                            </select>
                    </div> 
                </div>
                <div class="form-group">
                    <label class="col-sm-1 control-label" for="txt_usernm">CUSTOMER TYPE</label>
                    <div class="col-sm-2">
                       <select id="cus_type" name="cus_type" class="form-control input-sm"> 
                            <option value="ALL">ALL</option>    
                            <option value="WHOLESALE">WHOLESALE</option>
                            <option value="RETAIL">RETAIL</option>   
                        </select>
                    </div> 
                </div>
                
                
            </div>
 
</div>

</form>
</div>

</section>
  