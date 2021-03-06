 
<!-- Main content -->
<section class="content">

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Dealer Incentive Info</h3>
        </div>
        <form  name= "form1"  role="form" class="form-horizontal">
            <div class="box-body">

                <div class="form-group">
					<a onclick="location.reload();" class="btn btn-primary btn-sm">
                        <span class="fa fa-plus"></span> &nbsp; New
                    </a>
                   
                </div>

                <div id="msg_box"  class="span12 text-center">

                </div>

                <input type="hidden"  id="id" >
                <div class="form-group">
                    <label class="col-sm-1 control-label">Details</label>
                    <div class="col-sm-2">
                        <input type="text" placeholder="Inv#" id="c_code"disabled class="form-control input-sm">
                    </div>
                    <div class="col-sm-3">
                        <input type="text" placeholder="Dealer" id="c_name" disabled class="form-control input-sm">
                    </div>
                      <div class="col-sm-1">

                        <input type="button" onclick="search();" class="btn btn-default" value="..." id="searchcost" name="searchcost">

                    </div>
					
					
					<div class="col-sm-2">
							&nbsp;
					</div>
 
                    
					
                </div>
                <div class="form-group">
                    <label class="col-sm-1 control-label">Date</label>
                    <div class="col-sm-2">
                        <input type="text" placeholder="Date" id="invdate" value="" class="form-control dt" disabled="">
                    </div>
                    <label class="col-sm-1 control-label">Cheque No</label>
                    <div class="col-sm-2">    
                         <input type="text" placeholder="Cheque" id="chqno" value="" disabled class="form-control">
                    </div>
					
					
					 
                    
					
					
                </div>

                <div class="form-group">
                    <label class="col-sm-1 control-label">Remarks</label>
                    <div class="col-sm-5">
                        <textarea placeholder="Remarks" id="txt_remarks" disabled class="form-control input-sm"></textarea>

                    </div>
					
					
					<div class="col-sm-4">
							&nbsp;
					</div>
                          
                     
                    
					
					
                </div>
				
				
				
				<div class="form-group">
                    <label class="col-sm-1 control-label">Update Remark</label>
                    <div class="col-sm-5">
                        <textarea placeholder="Remarks" id="txt_newremarks" class="form-control input-sm"></textarea>

                    </div>
					
					
					<div class="col-sm-4">
						 <a onclick="update_remarks();" class="btn btn-success btn-sm">
                        <span class="fa fa-save"></span> &nbsp; Update
                    </a>
					</div>
                          
                 
                </div>
				
				<div class="form-group">
                    <label class="col-sm-1 control-label"></label>
                   
					
					
					<div class="col-sm-4">
						<a onclick="unlock();" class="btn btn-primary btn-sm">
							<span class="fa fa-lock"></span> &nbsp; Unlock
						</a>
					</div>
                          
                 
                </div>
				
				
            </div>
            <div id="itemdetails"></div>
        </form>
    </div>

</section>


<script src="js/dealer_insc.js">
</script>
<?php

include 'dealer_insc_search.php';

?>






