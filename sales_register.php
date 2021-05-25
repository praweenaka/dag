<!-- Main content -->
<?php 
session_start();
 
 require_once ('connection_sql.php');

?>
 <style>
    .opt {font-weight:bold;
        font-size:20px;
    }
   </style>
 
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">ALL REPORT</h3>
            <h4 style="float: right;height: 3px;"><b id="time"></b></h4>
        </div>
        <form role="form" name ="form1" class="form-horizontal" target="_blank" action="sales_register_print.php">
            <div class="box-body">
                <div class="form-group">
                    <a onclick="location.reload();" class="btn btn-default">
                        <span class="fa fa-user-plus"></span> &nbsp; NEW
                    </a>  
                    <button><a onclick="print_inv();" class="btn btn-primary btn-sm">
                        <span class="fa fa-print"></span> &nbsp; VIEW REPORT
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
                    <label class="col-sm-1 control-label" for="txt_usernm">REPORT TYPE</label>
                    <div class="col-sm-2">
                       <select id="type" name="type" class="form-control input-sm"> 
                            <option value="DAGLIST" class="opt">DAG LIST</option>
                            <option value="SETTLEMENT" class="opt">SETTLEMENT</option>
                            <option value="INVOICE" class="opt">INVOICE</option>
                            <option value="RECEIPT" class="opt">RECEIPT</option>      
                            <option value="OUTSTANDING" class="opt">OUTSTANDING</option>    
                            <option value="ONHANDLIST" class="opt">ONHAND LIST</option>    
                            <option value="PRODUCTIONLIST" class="opt">PRODUCTION LIST</option> 
                            <option value="COMPLETELIST" class="opt">COMPLETE LIST</option> 
                            <option value="ALLLIST" class="opt">ALL LIST</option>   
                            <option value="REJECTLIST" class="opt">REJECT LIST</option>   
                            <option value="CANCELLLIST" class="opt">CANCELL LIST</option>   
                        <?php    if($_SESSION['user_type']=="ADMIN"){?>
                            <option value="PROFIT" class="opt">PROFIT REPORT</option> 
                          <?php   }?>
                            
                            <option value="SERVICES" class="opt">SERVICES REPORT</option> 
                            <option value="SALARY PAYMENT" class="opt">SALARY PAYMENT REPORT</option> 
                            <option value="ADVANCE PAYMENT" class="opt">ADVANCE PAYMENT REPORT</option> 
                            <option value="OT" class="opt">OT REPORT</option> 
                            <option value="EXPENSE" class="opt">EXPENSE REPORT</option> 
                            <option value="OTHER PAYMENT" class="opt">OTHER PAYMENT REPORT</option> 
                            <option value="SERVICES & SALARY PROFIT" class="opt">SERVICES & SALARY PROFIT REPORT</option> 
                        </select>
                    </div>
                    <label class="col-sm-1 control-label" for="txt_usernm">TYPE</label>
                    <div class="col-sm-2">
                       <select id="alltype" name="alltype" class="form-control input-sm"> 
                            <option value="ALL" class="opt">ALL</option>    
                            <option value="CURRENT" class="opt">CURRENT</option>  
                        </select>
                    </div> 
                    
                </div>
                <div class="form-group">
                    <label class="col-sm-1 control-label" for="txt_usernm">EMPLOYEE</label>
                    <div class="col-sm-2">
                       <select id="employee" name="employee"  class="form-control input-sm"  >
                                <option value="">SELECT EMPLOYEE</option>
                                <?php 
                                $sql = "select * from workers where cancel ='0'   order by name";
                                  foreach ($conn->query($sql) as $row) {
                                    echo "<option value='" . $row["name"] . "' class=\"opt\">" . $row["name"] . "</option>";
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
                                    echo "<option value='" . $row["name"] . "' class=\"opt\">" . $row["name"] . "</option>";
                                }
                                ?>
                            </select>
                    </div> 
                </div>
                <div class="form-group">
                    <label class="col-sm-1 control-label" for="txt_usernm">CUSTOMER TYPE</label>
                    <div class="col-sm-2">
                       <select id="cus_type" name="cus_type" class="form-control input-sm"> 
                            <option value="ALL" class="opt">ALL</option>    
                            <option value="WHOLESALE" class="opt">WHOLESALE</option>
                            <option value="RETAIL" class="opt">RETAIL</option>   
                        </select>
                    </div> 
                     <label class="col-sm-1 control-label" for="txt_usernm">JOB NO</label>
                    <div class="col-sm-2">
                        <input type="text" id="jobno" name="jobno"  placeholder="JOB NO"  class="form-control">
                    </div> 
                </div>
                
                
            </div>
 
</div>

</form>
</div>

</section> 
  