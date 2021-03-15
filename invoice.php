<?php
session_start();
include './connection_sql.php';
if ($_SESSION["CURRENT_USER"] == "") {
 echo "Please Logging Again..";
 
}
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> 
<!-- Main content -->
<section class="content">

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Invoice</h3>
            <h4 style="float: right;height: 3px;"><b id="time"></b></h4>
        </div>
        <form name= "form1" role="form" class="form-horizontal">
            <div class="box-body">

                <input type="hidden" id="tmpno" class="form-control">

                <input type="hidden" id="item_count" class="form-control">

                <div class="form-group">

                    <a onclick="new_inv();" class="btn btn-default btn-sm">
                        <span class="fa fa-user-plus"></span> &nbsp; New
                    </a>

                    <a onclick="save_inv();" class="btn btn-success btn-sm">
                        <span class="fa fa-save"></span> &nbsp; Save
                    </a>

                    <a onclick="print_inv('');" class="btn btn-default btn-sm">
                        <span class="fa fa-print"></span> &nbsp; Print
                    </a>
                    
                    <a onclick="cancel_inv();" class="btn btn-danger btn-sm">
                        <span class="fa fa-trash-o"></span> &nbsp; Cancel
                    </a>

                </div>

                <div id="msg_box"  class="span12 text-center"  ></div>

                <label style="background-color: #00CCCC"><input type="radio" name="paymethod" onclick="cashpay('paymethod_1');" value="credit" id="paymethod_1" />&nbsp;CASH&nbsp;&nbsp;&nbsp;</label> 
                <label style="background-color: #00CCCC"><input type="radio" name="paymethod" onclick="cashpay('paymethod_0');" value="credit" id="paymethod_0" />&nbsp;CREDIT&nbsp;&nbsp;&nbsp;</label>

                

                <div class="form-group">
                    <label class="col-sm-1 control-label" for="invno">Invoice No</label>
                    <div class="col-sm-2">
                        <input type="text" placeholder="PO NO" disabled id="txt_entno" class="form-control  input-sm">
                    </div>
                    <div class="col-sm-1">
                        <a onfocus="this.blur()" onclick="NewWindow('serach_inv.php', 'mywin', '800', '700', 'yes', 'center');
                        return false" href="">
                        <input type="button" class="btn btn-default" value="..." id="searchcust" name="searchcust">
                    </a>
                </div>
                <label class="col-sm-2 control-label" for="invdate">Date</label>
                <div class="col-sm-2">
                    <input type="date"    placeholder="Date" id="invdate" value="<?php echo date('Y-m-d'); ?>" class="form-control   input-sm">
                </div>
                <label class="col-sm-1 control-label" for="invno">VEHICLE NO</label>
                <div class="col-sm-2">
                    <input type="text" placeholder="DA NO" id="DANO" class="form-control  input-sm">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-1 control-label" for="c_code">Customer</label>
                <div class="col-sm-2">
                    <input type="text" placeholder="Code" name="c_code" id="c_code" disabled class="form-control  input-sm">
                </div>
                <div class="col-sm-3">
                    <input type="text" placeholder="Name" disabled name = "c_name" id="c_name" class="form-control input-sm">
                </div>
                <div class="col-sm-1">


                    <a onfocus="this.blur()" onclick="NewWindow('serach_customer.php?stname=inv', 'mywin', '800', '700', 'yes', 'center');
                    return false" href="">
                    <input type="button" class="btn btn-default" value="..." id="searchcust" name="searchcust">
                </a> 
            </div>
            <div class="col-sm-5 hidden">

                <label  class="col-sm-4 control-label" ><input type="radio" onclick="del_item('.');"  id="nonvat" name="optradio" value="nonvat">&nbsp;Non Vat</label>

                <label  class="col-sm-3 control-label" ><input type="radio" disabled  onclick="del_item('.');" id="vat"name="optradio" value="vat">&nbsp;VAT</label>

            </div>

        </div>



        <div class="form-group">
            <label class="col-sm-1 control-label" for="cus_address">Address</label>
            <div class="col-sm-2">
                <input type="text" placeholder="Address" id="cus_address" class="form-control input-sm">
            </div>

            <label class="col-sm-1 control-label" for="txt_remarks">Remark</label>
            <div class="col-sm-2">
                <input type="text" placeholder="Remarks" id="txt_remarks" class="form-control input-sm">
            </div>

            <div class="col-sm-1">
                &nbsp;
            </div> 
        </div>
        <input id='currency' type='hidden' value='LKR'>
        <input id='txt_rate' type='hidden' value='1'>

        <div class="form-group">
            <label class="col-sm-1 control-label" for="invno">Sales Ex.</label> 
            <div class="col-sm-2"> 
                <select id="salesrep" class="form-control input-sm" >
                    <?php 
                    include './connection_sql.php';
                    $sql = "select * from s_salrep WHERE cancel='0' order by REPCODE "; 
                    foreach ($conn->query($sql) as $row) {
                     echo "<option value='" . $row["REPCODE"] . "'>" . $row["REPCODE"] . " " . $row["Name"] . "</option>";
                 }


                 ?>
             </select>
         </div> 
        <label class="col-sm-1 control-label" for="invno">Reject Dag</label> 
            <div class="col-sm-2"> 
            <input type="checkbox" class=" input-sm" id="rejectdag" name="rejectdag" onclick="rejectdag1();" />
            
            </div>
             <label class="col-sm-1 control-label" for="invno">RECEIVED DETAILS :</label> 
            <div class="col-sm-5">
               
                <textarea class="form-control" placeholder="RECEIVED DETAILS" rows="2" name="recv_details" id="recv_details" required></textarea>
            </div> 

     </div>
     
     <!--======================================================================================================================-->
     
    <div class="form-group"> 
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#home" >DAG</a></li>
            <li><a data-toggle="tab" href="#menu1">PRODUCT</a></li>
            <li><a data-toggle="tab" href="#menu2">SERVICE</a></li>
        </ul>
    </div>
     
     
    <div class="tab-content">
        <div id="home" class="tab-pane fade in active"> 
           <div class="row">
               <table class="table table-bordered">
                    <tr class='info'> 
                        <th style="width: 100px;">JOB NO</th> 
                        <th style="width: 10px;"></th>
                        <th style="width: 100px;">MAKE</th> 
                        <th style="width: 100px;">DESIGN</th> 
                        <th style="width: 70px;">SIZE</th> 
                        <th style="width: 100px;">SERIAL NO</th> 
                        <th style="width: 90px;">AD PAY</th> 
                        <th style="width: 90px;">COST</th>
                        <th style="width: 120px;">SELLING</th>
                        <th style="width: 90px;">REPAIR</th>
                        <th style="width: 60px;">Dis</th>
                        <th style="width: 120px;">SubTotal</th>
                        <th style="width: 50px;"></th>
                    </tr>
                
                    <tr>
                        <td>
                            <input type="text" placeholder="JOB REF" id="jobno" disabled class="form-control input-sm">
                        </td>
                        <td>
                            <a href="" onclick="NewWindow('invoice_search_item.php', 'mywin', '800', '700', 'yes', 'center');
                            return false" onfocus="this.blur()">
                            <input type="button" name="searchcusti" id="searchcusti" value="..." class="btn btn-default btn-sm">
                        </a>
                        </td>
                        <td>
                            <input type="text" placeholder="MAKE" id="make" disabled class="form-control input-sm">
                        </td>
                        <td>
                            <input type="text" placeholder="DESIGN" id="design" disabled class="form-control input-sm">
                        </td>
                
                        <td>
                            <input type="text" placeholder="SIZE" id="size" disabled class="form-control input-sm">
                        </td>
                        <td>
                            <input type="text" placeholder="SERIAL NO" id="serialno" disabled class="form-control input-sm">
                        </td> 
                        <td>
                            <input type="text" placeholder="AD PAY" id="adpay" onkeyup="calc();" disabled class="form-control input-sm">
                        </td> 
                        <td>
                            <input type="number" placeholder="COST" id="cost" disabled onkeyup="calc();"  class="form-control input-sm">
                        </td>
                        <td>
                            <input type="number" placeholder="SELLING" id="selling" onkeyup="calc();" class="form-control input-sm">
                        </td>
                        <td>
                            <input type="number" placeholder="REPAIR" id="repair" onkeyup="calc();" class="form-control input-sm">
                        </td>
                        <td>
                            <input type="number" placeholder="Dis" id="dis" disabled  onkeyup="calc();" class="form-control input-sm">
                        </td>
                        <td>
                            <input type="number" placeholder="Subtotal" id="subtotal" disabled="" class="form-control input-sm">
                        </td>
                
                        <td><a onclick="add_tmp();" class="btn btn-default btn-sm"> <span class="fa fa-plus"></span> &nbsp; </a></td>
                    </tr> 
                </table>
                
                <div id="itemdetails" >
                
                </div>
           </div> 
           
       </div> 
       <!--=========================================-->
       
       <div id="menu1" class="tab-pane fade">
           <div class="row">
                <table class="table table-bordered">
                    <tr class='info'> 
                        <th style="width: 100px;">CODE</th> 
                        <th style="width: 10px;"></th>
                        <th style="width: 100px;">NAME</th> 
                        <th style="width: 100px;">QTY</th> 
                        <th style="width: 70px;">COST</th> 
                        <th style="width: 100px;">SELLING</th> 
                        <th style="width: 90px;">DIS</th>   
                        <th style="width: 120px;">SubTotal</th>
                        <th style="width: 50px;"></th>
                    </tr>
            
                    <tr>
                        <td>
                            <input type="text" placeholder="CODE" id="code" disabled class="form-control input-sm">
                        </td>
                        <td>
                            <a href="" onclick="NewWindow('invoice_search_proitem.php', 'mywin', '800', '700', 'yes', 'center');
                            return false" onfocus="this.blur()">
                            <input type="button" name="searchcusti" id="searchcusti" value="..." class="btn btn-default btn-sm">
                        </a>
                        </td>
                         <td>
                            <input type="text" placeholder="NAME" id="name" disabled     class="form-control input-sm">
                        </td>
                        <td>
                            <input type="number" placeholder="QTY" id="qty1"    onkeyup="calc1();"   class="form-control input-sm">
                             <input type="number" placeholder="QTYINHAND" id="qtyhand"   disabled   class="form-control input-sm">
                        </td>
                         
                           
                        
                        <td>
                            <input type="number" placeholder="COST" id="cost1" disabled onkeyup="calc1();"  class="form-control input-sm">
                        </td>
                        <td>
                            <input type="number" placeholder="SELLING" id="selling1" onkeyup="calc1();" class="form-control input-sm">
                        </td> 
                        <td>
                            <input type="number" placeholder="Dis" id="dis1"    onkeyup="calc1();" class="form-control input-sm">
                        </td>
                        <td>
                            <input type="number" placeholder="Subtotal" id="subtotal1" disabled="" class="form-control input-sm">
                        </td>
                
                        <td><a onclick="add_product();" class="btn btn-default btn-sm"> <span class="fa fa-plus"></span> &nbsp; </a></td>
                     </tr>
            
                 </table>
            
                <div id="itemdetails1" >
                
                </div>
           </div> 
       </div> 
        <!--=========================================-->
       <div id="menu2" class="tab-pane fade">
           <div class="row">
               <table class="table table-bordered">
                <tr class='info'> 
                    <th style="width: 100px;">VEHI NO</th>  
                    <th style="width: 100px;">EMPLAYEE</th> 
                    <th style="width: 100px;">SERIVES</th> 
                    <th style="width: 70px;">AMOUNT</th>  
                    <th style="width: 50px;"></th>
                </tr>
            
                <tr> 
                    <td>
                        <input type="text" placeholder="VEHI NO" id="vehino"   class="form-control input-sm">
                    </td>
                    <td>
                        <select id="employee"  class="form-control input-sm"  >
            
                                <?php 
                                $sql = "select * from workers where cancel ='0' and type='WORKER' order by name";
                                  foreach ($conn->query($sql) as $row) {
                                    echo "<option value='" . $row["name"] . "'>" . $row["name"] . "</option>";
                                }
                                ?>
                            </select>
                    </td> 
                    <td>
                         <select id="services"  class="form-control input-sm"  >
            
                                <?php 
                                $sql = "select * from services where cancel ='0' order by name";
                                  foreach ($conn->query($sql) as $row) {
                                    echo "<option value='" . $row["name"] . "'>" . $row["name"] . "</option>";
                                }
                                ?>
                            </select>
                    </td>  
                    <td>
                        <input type="number" placeholder="AMOUNT" id="amount"   class="form-control input-sm">
                    </td>
                     
            
                    <td><a onclick="add_service();" class="btn btn-default btn-sm"> <span class="fa fa-plus"></span> &nbsp; </a></td>
                </tr> 
            </table>
            
            <div id="itemdetails2" >
            
            </div>
           </div> 
       </div> 
    </div> 
     
     
     
      <!--======================================================================================================================-->
     
     
<table id='subtotal' class="table">
    <tr>
        <td></td>
        <td></td><td></td><td></td><td></td>
        <th style="width:  120px;">Sub Total</th> 
        <td style="width:  190px;" ><input type="text" disabled placeholder="Sub Total" id="subtot" class="form-control input-sm"></td>
    </tr>
    <tr>
       <td></td>
       <td></td><td></td><td></td><td></td>
       <th style="width:  120px;">Discount</th>                     
       <td  style="width:  190px;"><input type="text" disabled placeholder="Discount" id="discount" class="form-control input-sm"></td>
   </tr>
   <tr class="hidden">
    <td></td>
    <td></td><td></td><td></td><td></td>
    <th style="width:  120px;">VAT</th>                       
    <td  style="width:  190px;"><input type="text" disabled placeholder="VAT" id="vattot" class="form-control input-sm"></td>
</tr>
<tr>
    <td></td>
    <td></td><td></td><td></td><td></td>
    <th style="width:  120px;">Grand Total</th>

    <td  style="width:  190px;"><input type="text"disabled  placeholder="Grand Total" id="gtot" class="form-control input-sm"></td>
</tr>
<tr>
    <td></td>
    <td></td><td></td><td></td><td></td>
    <th style="width:  120px;">CASH PAY BY</th>

    <td  style="width:  190px;"><input type="number"   placeholder="CASH PAY BY" id="cpay" class="form-control input-sm"></td>
</tr>
</table>        

</div>
</form>
</div>

</section>
<script src="js/invoice.js?v1.1"></script>
<script>
    new_inv();
    
</script>
<?php
include 'login.php';
include './cancell.php';
?>
