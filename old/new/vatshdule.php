<!-- Main content -->

<section class="content">

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">VAT Shedule Report</h3>
        </div>
        <form role="form" name="form1" class="form-horizontal">
            <div class="box-body">

                
                <div class="container">
				 <div class="form-group">
                    <div class="col-sm-2">
                        <label class="control-label">Date Range :</label>
                    </div>  					
                    <div class="col-sm-2">
                        <input type="text" name="dtfrom" class="form-control dt" id="dtfrom" value="<?php echo date('Y-m-d'); ?>" />
                    </div>
                    <div class="col-sm-2">
                        <input type="text" name="dtto" class="form-control dt" id="dtto" value="<?php echo date('Y-m-d'); ?>" />
                    </div>
				</div>
				
				<div class="form-group">
					<div class="col-sm-5">
                        <input type="radio" name="optype"  checked=checked id="sh1" value="sh1" />Shedule 1
						<input type="radio" name="optype"  id="sh4" value="sh4" />Shedule 4
                    </div>
				</div>
				
                    <a onclick="view_dett();" class="btn btn-primary">Print Report</a>
                    <!--<a onclick="view_summ();" class="btn btn-primary">Download CSV</a>-->
                </div>
                
 


            </div>
        </form>
    </div>

</section>

<script src="js/vatshdule.js"></script>

 