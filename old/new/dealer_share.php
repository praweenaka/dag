<?php
include './connection_sql.php';
?>

<!-- Main content -->

<section class="content">



    <div class="box box-primary">

        <div class="box-header with-border">

            <h3 class="box-title">Sales Commition</h3>

        </div>

        <form  name= "form1"  role="form" class="form-horizontal">

            <div class="box-body">



                <div class="form-group">

					<a onclick="new_inv();" class="btn btn-default btn-sm">
                        <span class="fa fa-user-plus"></span> &nbsp; New
                    </a>
					
                    <a onclick="save();" class="btn btn-success btn-sm">
                        <span class="fa fa-save"></span> &nbsp; Save
                    </a>
					
					<a onclick="cancell();" class="btn btn-danger btn-sm">
                        <span class="fa fa-remove"></span> &nbsp; Delete
                    </a>
					
                </div>



                <div id="msg_box"  class="span12 text-center"  >
				</div>


				
				 <input type="hidden" value=""  id="tmp_no" >
               

                <div class="form-group">

                    <label class="col-sm-1 control-label">Date</label>

                    <div class="col-sm-2">

                        <input type="text" placeholder="Date" id="invdate" value="<?php echo date('Y-m-d'); ?>" class="form-control dt">

                    </div>

					
                     <div class="col-sm-1">
                      <a onfocus="this.blur()" onclick="NewWindow('search_salcom.php', 'mywin', '800', '700', 'yes', 'center');
                                return false" href="">
                            <input type="button" class="btn btn-default" value="..." id="searchcust" name="searchcust">
                        </a>
                    </div>

                </div>
				
				
				<div class="form-group">

                    <label class="col-sm-1 control-label">Remarks</label>

                    <div class="col-sm-5">

                        <textarea placeholder="Remarks" id="txt_remarks" class="form-control input-sm"></textarea>



                    </div>

                </div>
				
				
				<table class="table">
				<tr>
					<th style="width : 120px;">Invoioce No</th>
					<th style="width : 50px;"></th>
					<th style="width : 320px;">Dealer Name</th>		
					<th style="width : 120px;">Invoice Amount</th>
					<th style="width : 120px;">Outstanding Amount</th>				
					<th style="width : 120px;">Incentive Amount</th>	
					<th style="width : 50px;"></th>		
				</tr>
				
				<tr>
				
					<td><input type="text" placeholder="Reference" id="ref" value="" class="form-control input-sm"></td>
					<td><a onfocus="this.blur()" onclick="NewWindow('serach_invoice.php?stname=dlr_shr', 'mywin', '800', '700', 'yes', 'center');

                                return false" href="">

                            <input type="button" class="btn btn-default" value="..." id="searchcust" name="searchcust">

                        </a>
					</td>
					<td>
					<input type="hidden" placeholder="Name" id="c_code" class="form-control input-sm">
					<input type="text" placeholder="Name" id="c_name" class="form-control input-sm"></td>		
					<td><input type="text" placeholder="Invoice Amt" id="inv_amount" value="" class="form-control input-sm"></td>
					<td><input type="text" placeholder="Outstanding Amt" id="out_amount" value="" class="form-control input-sm"></td>				
					<td><input type="text" placeholder="Amount" id="amt" value="" class="form-control input-sm"></td>	
					<td><a onclick="add_tmp();" class="btn btn-default btn-sm"> <span class="fa fa-plus"></span> &nbsp; </a></td>
					
				</tr>
				
				
				
				
				</table>
				

               

                 

                <div class="form-group">
                    <label class="col-sm-1 control-label">Total</label>

                    <div class="col-sm-2">

							

                    </div>
                </div>

                




            </div>

            <div id="itemdetails"></div>

        </form>

    </div>



</section>



<script src="js/dealer_shr.js">



</script>

<script>
new_inv();
</script>