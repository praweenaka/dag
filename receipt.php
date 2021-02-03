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
            <h3 class="box-title">Receipt</h3>
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

                    <a onclick="save_crec();" class="btn btn-success btn-sm">
                        <span class="fa fa-save"></span> &nbsp; Save
                    </a>

                    <a onclick="print_inv();" class="btn btn-default btn-sm">
                        <span class="fa fa-print"></span> &nbsp; Print
                    </a>
                     <a onclick="utilization();" class="btn btn-default btn-sm">
                        <span class="fa fa-print"></span> &nbsp; Utilization
                    </a>
                    
                    <a onclick="delete_rec();" class="btn btn-danger btn-sm">
                        <span class="fa fa-trash-o"></span> &nbsp; Cancel
                    </a>

                </div>

                <div id="msg_box"  class="span12 text-center"  ></div>

                 <input type="hidden" name="cmd_new" id="cmd_new" value="1" />
		<input type="hidden" name="cmd_save" id="cmd_save" value="0"/>
		<input type="hidden" name="cmd_cancel" id="cmd_cancel" value="0"/>
		<input type="hidden" name="cmd_print" id="cmd_print" value="0"/>
		<input type="hidden" name="cmd_utilization" id="cmd_utilization" value="0"/>
		<input type="hidden" name="hiddencount" id="hiddencount" />
                

                <div class="form-group">
                    <label class="col-sm-1 control-label" for="invno">Invoice No</label>
                    <div class="col-sm-2">
                        <input type="text" placeholder="PO NO" disabled id="invno" class="form-control  input-sm">
                    </div>
                    <div class="col-sm-1">
                        <a onfocus="this.blur()" onclick="NewWindow('receipt_search.php', 'mywin', '800', '700', 'yes', 'center');
                        return false" href="">
                        <input type="button" class="btn btn-default" value="..." id="searchcust" name="searchcust">
                    </a>
                </div>
                 <label class="col-sm-2 control-label" for="invdate">Entry Date</label>
                <div class="col-sm-2">
                    <input type="text"     name="invdate" id="invdate" disabled="disabled" value="<?php echo date("Y-m-d"); ?>"  class="form-control   input-sm">
                </div>
                
                <label class="col-sm-1 control-label" for="invno">Cheque Collected</label>
                <div class="col-sm-2">
                    <select name="chqcollect" id="chqcollect" onkeypress="keyset('dte_dor',event);" onchange="setord();" class="form-control   input-sm">
		<?php
	 
              
                     $sql="select * from s_salrep where cancel='0'  order by REPCODE";
                     foreach ($conn->query($sql) as $row) {
                     echo "<option value='".$row["REPCODE"]."'>".$row["REPCODE"]." ".$row["Name"]."</option>";
                     }
                 
		?>
		</select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-1 control-label" for="c_code">Customer</label>
                <div class="col-sm-2">
                    <input type="text" placeholder="Code" name="cuscode" disabled onblur="search_cust_ind();" id="cuscode"  class="form-control  input-sm">
                </div>
                <div class="col-sm-3">
                    <input type="text" placeholder="Name"   name = "cusname" disabled id="cusname" class="form-control input-sm">
                </div>
                <div class="col-sm-1">


                    <a onfocus="this.blur()" onclick="NewWindow('receipt_customer_search.php', 'mywin', '800', '700', 'yes', 'center');
                    return false" href="">
                    <input type="button" class="btn btn-default" value="..." id="searchcust" name="searchcust">
                </a> 
               </div>
           <label class="col-sm-2 control-label" for="invdate">Marketing Executive</label>
                <div class="col-sm-2">
                    <select name="salesrep" id="salesrep"  onblur="custno('cash_rec_rep');" onkeypress="keyset('chqno',event);" class="form-control   input-sm">
		<?php
	 
              
                     $sql="select * from s_salrep where cancel='0'   order by REPCODE";
                     foreach ($conn->query($sql) as $row) {
                     echo "<option value='".$row["REPCODE"]."'>".$row["REPCODE"]." ".$row["Name"]."</option>";
                     }
                 
		?>
		</select>
                </div>
                
            

        </div>

 

     <!--=========================-->
     
      <div class="form-group">
            <label class="col-sm-1  " for="invno">Payment Type</label> 
            <div class="col-sm-2"> 
               <select name="paytype" id="paytype"   onchange="chng_type();" class="form-control input-sm" >
            		<option value="Cash">Cash</option>
            		<option selected="selected" value="Cheque">Cheque</option>
            		<option value="J/Entry">J/Entry</option>
            		<option value="Cash TT">Cash TT</option>
	        	</select>
            </div>  
            <label class="col-sm-1  " for="invno">Debit Account</label> 
            <div class="col-sm-2"> 
              <select name="accno" id="accno" onkeypress="keyset('dte_dor',event);" onchange="setord();"  class="form-control   input-sm">
		<?php
	 
              
                     $sql="select * from lcodes where cat='B' or cat='C' or c_code='220504' or c_code='120900'";
                     foreach ($conn->query($sql) as $row) {
                     echo "<option value='" . $row["c_code"] . "'>" . $row["c_code"] . " " . $row["c_name"] . "</option>";
                     }
                 
		?>
		</select></div> 
             
            <label class="col-sm-1 " for="invdate">Credit Account</label>
            <div class="col-sm-2">
               <input type="text"   name="accno2" id="accno2" size="10" value="120100" onkeypress="keyset('chqdate',event);"  disabled     class="form-control   input-sm">
            </div>
             
            <div class="col-sm-2">
               <input type="text"    size="10" id="acc_name2" name="acc_name2" value="Trade Debtors" disabled onkeypress="keyset('bank',event);" class="form-control   input-sm">
            </div>
         </div>
     
     
     
     <!--============================-->
        <div class="form-group">
              
            
             
            
		<input type="hidden"    size="10" id="acc_name" name="acc_name" value="" onkeypress="keyset('bank',event);" class="form-control   input-sm">
            
            <label class="col-sm-1 hidden " for="invdate">T/T No</label>
            <div class="col-sm-2">
                <input type="text"  name="ca_refno" id="ca_refno" class="form-control hidden  input-sm">
            </div>
             <div class="col-sm-2">
                <input type="text"  name="ledg_ref_no" id="ledg_ref_no" class="form-control hidden  input-sm">
            </div>
            <label class="col-sm-1 hidden" for="invdate">T/T Date</label>
            <div class="col-sm-2">
                <input type="text"     name="dt" id="dt" value="<?php echo date("Y-m-d"); ?>" onfocus="load_calader('dt')" disabled="disabled" class="form-control  hidden input-sm">
            </div>
            <label class="col-sm-1 control-label hidden" for="txt_remarks">Cost Center</label>
            <div class="col-sm-2">
                <select name="costcenter" id="costcenter"  class="form-control hidden input-sm">
		<?php
		for ($i = 1; $i < 51; $i++) {
			echo "<option value=" . $i . ">" . $i . "</option>";
		}
		?>
		</select>
            </div>
         </div>
         
         
         
         
         
     
     <div class="row">
         <div class="form-group col-md-6 ">
             <legend>
        		<div class="text_forheader">
        			Cheque Details
        		</div>
         	</legend>
         	
             <table class="table table-bordered">
            <tr class='info'> 
                <th style="width: 100px;">Cheque No</th> 
                <th style="width: 10px;">Cheque No</th>
                <th style="width: 100px;">Bank</th> 
                <th style="width: 100px;">#</th> 
                <th style="width: 70px;">Amount</th>  
                <th style="width: 50px;"></th>
            </tr>
            <tr>
                 <td>
                  	<input type="text"   name="chqno" id="chqno" size="10" onkeypress="keyset('chqdate',event);"  onblur="chk_chqno();" class="form-control input-sm">
                </td>
                <td>
                   	<input type="date"   id="chqdate" name="chqdate" onblur="chk_calader();"  onkeypress="keyset('bank',event);"   class="form-control input-sm">
                </td>
                <td>
                   	<input type="text" size="15" name="bank" id="bank" value=""   onblur="get_bank();" onkeypress="eyset('chqamt',event);" class="form-control input-sm">
                </td>
                <td>
                   
                </td>
                 <td>
                   	<input type="text" size="15" name="chqamt" id="chqamt" value="" onblur="calc1();"   onkeypress="keyset('additem_tmp',event);" class="form-control input-sm">
                </td>
                <td>
                   <input type="button" name="additem_tmp" id="additem_tmp" value="Add" onclick="addchq_cash_rec();" class="form-control input-sm">
                </td>
            </tr>
            </table>
            	<div class="CSSTableGenerator" id="chq_table" ></div>
            <div id="itemdetails1111" style="overflow:scroll;  height:170px" >
               <table class="table table-bordered">
            <tr class='info'> 
                
            </tr>
             
            </table>
            </div>
         </div>
         
         <div class="form-group col-md-6 "> 
             <legend>
        		<div class="text_forheader">
        			Utilization Details
        		</div>
         	</legend>
	<div class="CSSTableGenerator"  id="utilization" style="overflow:scroll; height:270px"></div>
         </div>
     </div>
     
     
     
  <div class="form-group">
            <label class="col-sm-1  " for="invno">Cheque Total</label> 
            <div class="col-sm-2"> 
               <input type="text" size="20" name="chqtot" id="chqtot" value="" disabled="disabled" class="form-control   input-sm">
            </div>  
            
            <label class="col-sm-1  " for="invno">Cash Total</label> 
            <div class="col-sm-2"> 
               <input type="number" size="20" name="cashtot" id="cashtot" value=""   class="form-control   input-sm">
            </div>  
         </div>
         
         
           <div class="form-group">
         <legend>
        		<div class="text_forheader">
        			Invoice  Details
        		</div>
         	</legend>
         		<div  id="inv_details" ></div>
				<div  id="itemdetails" ></div>
				    
         	<table class="table table-bordered">
             
             	<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td><b>Selected Invoice Amount</b> 
			</td>
			<td>
			<input type="text" size="20" name="txtpaytot" id="txtpaytot" value="" disabled="disabled" class="form-control   input-sm"/>
			</td> 
		</tr>
		<tr>
			<td width="17%">&nbsp;</td>
			<td width="16%">&nbsp;</td>
			<td width="21%">&nbsp;</td>
			<td width="11%">&nbsp;</td>
			<td width="1%">&nbsp;</td>
			<td width="17%">
			<b>Over Payment</b>
			</td>
			<td width="17%">
			<input type="text" size="20" name="txtoverpay" id="txtoverpay" value="" disabled="disabled" class="form-control   input-sm"/>
			</td>
		</tr>
            </table>
            
            
</div>
 
</div>
</form>
</div>

</section>
<script src="js/receipt.js"></script>
<script>
    new_inv();
    
</script>
<?php
include 'login.php';
include './cancell.php';
?>
