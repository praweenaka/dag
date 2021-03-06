<?php
ini_set('session.gc_maxlifetime', 30 * 60 * 60 * 60);
session_start();
$_SESSION["brand"] = "";
if ($_SESSION["CURRENT_USER"] == "") {
    echo "Please Loging Again !!!";
    exit();
}
?>
 
<!-- Main content -->
<section class="content">

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Transport Payment Approval</h3>
        </div>

        <form role="form" name ="form1" class="form-horizontal">
            <div class="box-body">
                <br>               
                <div class="form-group">
                    <a onclick="new_inv();" class="btn btn-default">
                        <span class="fa fa-user-plus"></span> &nbsp; New

                    </a>
                    <a onclick="save_inv();" class="btn btn-primary">
                        <span class="fa fa-save"></span> &nbsp; Save
                    </a>
                    <a onclick="print_inv();" class="btn btn-default">
                        <span class="fa fa-print"></span> &nbsp; Print
                    </a>
                    <a onclick="cancel_inv();" class="btn btn-danger">
                            <span class="fa fa-print"></span> &nbsp; Cancel
                     </a>    
                    

                </div>
                <div id="msg_box"  class="span12 text-center"  ></div>
                <div class="form-group">  
                	<label class="col-sm-1 control-label talign" for="invno">Ref No</label>
                    <div class="col-sm-2">
                        <input type="text"  class="form-control input-sm"  disabled="" id="ref_no">
                    </div>
                    <div class="col-sm-1">
                        <a href=""  class="btn btn-primary btn-sm" onClick="NewWindow('search_trans_pay.php?stname=transpay', 'mywin', '800', '700', 'yes', 'center');
                                return false" onFocus="this.blur()">
                            ...
                        </a>
                    </div>

                    <label class="col-sm-1 control-label" for="sdate">Date</label>
                    <div class="col-sm-2">
                        <input type="text" name="sdate" disabled=""   id="sdate" value="<?php echo date('yy-m-d')?>"  class="form-control dt input-sm">    
                    </div>
                </div>   

                <div class="form-group">  
                    <label class="col-sm-1 control-label talign" for="invno">Dealer</label>
                    <div class="col-sm-2">
                        <input type="text"  class="form-control input-sm" disabled="disabled"   id="code">
                    </div>
                    <div class="col-sm-4">
                        <input type="text" class="form-control input-sm" disabled id="name" name="name" />
                    </div>
                    <div class="col-sm-1">
                        <a href=""  class="btn btn-primary btn-sm" onClick="NewWindow('serach_customer.php?stname=transpaycus', 'mywin', '800', '700', 'yes', 'center');
                                return false" onFocus="this.blur()">
                            ...
                        </a>
                    </div> 
                 </div> 
                 <div class="form-group">  
                    <label class="col-sm-1 control-label talign" for="invno">Town</label>
                    <div class="col-sm-2">
                       <textarea placeholder="Town" style="width: 450px;height: 50px;" disabled="" id="town" class="form-control input-sm"></textarea> 
                    </div> 
                 </div> 
                

                 <table class="table">
                    <tr>
                        <th style="width: 20px;"></th>
                        <th style="width: 200px;">Inv.No</th>
                        <th style="width: 200px;">Inv.Date</th>
                        <th style="width: 200px;">Transport Amount</th>
                        <th style="width: 200px;">THT Pay Amount</th>
                        <th style="width: 200px;">Type</th>
                        <th style="width: 200px;">Remark</th>
                        <th></th>
                    </tr>


                    <tr>
                        
                        <td><a href="search_invoice.php"   onclick="NewWindow(this.href, 'mywin', '800', '700', 'yes', 'center');
                                return false" onfocus="this.blur()">
                                <input type="button" name="searchitem" id="searchitem" value="..." class="btn btn-primary btn-sm" >
                            </a>
                        </td> 
                        <td>
                            <input type="text"   disabled="disabled" id="invno" value=""  class="form-control input-sm">
                        </td> 
                        <td>
                            <input type="text"   disabled="disabled"  id="invdate" value=""  class="form-control input-sm">
                        </td> 
                        <td>
                            <input type="number"   id="transamou" value=""  class="form-control input-sm">
                        </td>  
                        <td>
                            <input type="number"   id="transthtamou" value=""  class="form-control input-sm">
                        </td> 
                        <td>
                            <select id="type" class="form-control input-sm">
                            <option value="Paid">Paid</option>
                            <option value="Not Paid">Not Paid</option>           
                                 </select>
                        </td>
                         <td>
                            <input type="text"   id="remark"    class="form-control input-sm">
                        </td>  
                        <td><input type="button" name="additem_tmp" id="additem_tmp" value="Add" onclick="add_tmp('add');" class="btn btn-primary"></td>
                    </tr>

                </table>
 
                <div id="itemdetails"></div>

        </form>
    </div>

</section>

<script src="js/trans_pay.js"></script>


<script> 
         new_inv();
                            
</script> 