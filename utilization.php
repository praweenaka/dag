 <!--Main content  settle_inv-->
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">CREATE UTILIZATION</h3>
            <h4 style="float: right;height: 3px;"><b id="time"></b></h4>
        </div>
        <form role="form" class="form-horizontal">
            <div class="box-body">
                <div class="form-group">
                    <a onclick="new_inv();" class="btn btn-default">
                        <span class="fa fa-user-plus"></span> &nbsp; New
                    </a>
                    <a onclick="save_crec();" class="btn btn-success">
                        <span class="fa fa-save"></span> &nbsp; Save
                    </a> 
                    <a onclick="print_inv();" class="btn btn-default btn-sm">
                        <span class="fa fa-print"></span> &nbsp; Print
                    </a>
                    <a onclick="delete_rec();" class="btn btn-danger">
                        <span class="fa fa-trash"></span> &nbsp; Cancel
                    </a>
                    <a onclick="NewWindow('utilization_search.php', 'mywin', '800', '700', 'yes', 'center');" class="btn btn-info btn-sm">
                        <span class="glyphicon glyphicon-search"></span> &nbsp; FIND
                    </a> 

                </div>

                <input type="hidden" id="uniq" class="form-control">
                <input type="hidden" name="mcount_chq" id="mcount_chq" />
                <input type="hidden" id="mcount" class="form-control">
                <input type="hidden"  class="label_purchase" name="lblcah" id="lblcah" value="Cash" disabled="disabled" style="visibility:hidden"/>
                 <input type="hidden" size="20" name="txtcash" id="txtcash" value="" onblur="settot();"  class="text_purchase3" style="visibility:hidden"/>
                 <input type="hidden" size="20" name="txtchno" id="txtchno" value="" class="text_purchase3" style="visibility:hidden"/>
                 <input type="hidden"  class="label_purchase" name="lblchqno" id="lblchqno" value="Cheque No" disabled="disabled" style="visibility:hidden"/>
                 <input type="hidden"  class="label_purchase" value="Amount" disabled="disabled" name="lblamt" id="lblamt" style="visibility:hidden"/> 
                 <input type="hidden" size="20" name="txtamount" id="txtamount" value="" class="text_purchase3" onblur="set_cash_pay();" style="visibility:hidden"/>
                 <input type="hidden"  class="label_purchase" value="Bank" name="lblchbank" id="lblchbank" disabled="disabled" style="visibility:hidden"/> 
                 <input type="hidden"  class="label_purchase" name="lblchqno" id="lblchqno" value="Cheque No" disabled="disabled" style="visibility:hidden"/> 
                <input type="hidden" size="20" name="txtchno" id="txtchno" value="" class="text_purchase3" style="visibility:hidden"/> 
        
                 <input type="hidden"  class="label_purchase" value="Cheque Date" disabled="disabled" name="lblchqdate" id="lblchqdate" style="visibility:hidden"/> 
                 <input type="hidden"  class="text_purchase3" size="10" id="DTPicker1" name="DTPicker1" onfocus="load_calader('DTPicker1')" style="visibility:hidden"/>
                 <input type="hidden" size="20" name="txtchbank" id="txtchbank" value="" class="text_purchase3" style="visibility:hidden"/>

                <div id="msg_box"  class="span12 text-center"  >  </div>

            </div>

            <div class="form-group">
                <label class="col-sm-1 control-label" for="txt_usernm">REF NO</label>
                <div class="col-sm-2">
                    <input type="text" placeholder="REF NO" id="txtrefno" disabled class="form-control">
                </div>

                
                <label class="col-sm-1 control-label" for="txt_usernm">DATE</label>
                <div class="col-sm-2">
                    <input type="text" placeholder="DATE" id="dtdate" value="<?php echo date('Y-m-d')?>"  class="form-control dt">
                </div>
                 <div class="col-sm-1"></div>
                 <label class="col-sm-1 control-label" for="txt_usernm">GRN/CRN/PAY</label>
         <div class="col-sm-2">
                <input type="text" placeholder="GRN/CRN/PAY" id="txtcrnno" name="txtcrnno"  disabled  class="form-control">
            </div>
         <div class="col-sm-1">
                <a onfocus="this.blur()" onclick="NewWindow('utilization_bal_search.php', 'mywin', '800', '700', 'yes', 'center');
                return false" href="">
                <input type="button" class="btn btn-danger" value="..." id="searchcust" name="searchcust">
            </a>
        </div> 
            </div>

            <div class="form-group">
                <label class="col-sm-1 control-label" for="txt_usernm">CUSTOMER CODE</label>
                <div class="col-sm-2">
                    <input type="text" placeholder="CUSTOMER CODE" id="Txtcusco" disabled   class="form-control">
                </div>
                <label class="col-sm-1 control-label" for="txt_usernm">CUSTOMER NAME</label>
                <div class="col-sm-2">
                    <input type="text" placeholder="NAME" id="txt_cusname" disabled=""  class="form-control">
                </div> 
                <div class="col-sm-1">
                    <a onfocus="this.blur()" onclick="NewWindow('utilization_cus_search.php', 'mywin', '800', '700', 'yes', 'center');
                    return false" href="">
                    <input type="button" class="btn btn-danger" value="..." id="searchcust" name="searchcust">
                </a>
            </div>  
            <label class="col-sm-1 control-label" for="invno">PENDING BALANCE</label> 
        <div class="col-sm-2"> 
            <input type="number" placeholder="PENDING BALANCE" id="txtcrnamount" disabled class="form-control input-sm">
        </div> 
           
    </div>

     

    <div class="form-group">
        <label class="col-sm-1 control-label" for="invno"> </label> 
        <div class="col-sm-2"> </div>  <div class="col-sm-2"></div><div class="col-sm-2"></div>
         
     
        <label class="col-sm-1 control-label" for="invno">REMAINING BALANCE</label> 
        <div class="col-sm-2"> 
            <input type="number" placeholder="REMAINING BALANCE" disabled id="txtrem_bal" class="form-control input-sm">
        </div>  
         
    </div> 

    
    <div class="form-group"></div>

   <div  id="invdetails" ></div>
        <div id="chkdetails"></div>
    
     <div class="form-group">
        <label class="col-sm-1 control-label" for="invno"> </label> 
        <div class="col-sm-2"> </div>  <div class="col-sm-2"></div><div class="col-sm-2"></div>
         
     
        <label class="col-sm-1 control-label" for="invno">TOTAL</label> 
        <div class="col-sm-2"> 
            <input type="number" placeholder="TOTAL" disabled id="lblPaid" class="form-control input-sm">
        </div>  
         
    </div> 

</div>

</form>
</div>

</section>

<script src="js/utilization.js"></script>
<script>new_inv();</script>