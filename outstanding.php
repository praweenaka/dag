<!-- Main content -->
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">OUTSTANDNG VIEW</h3>
            <h4 style="float: right;height: 3px;"><b id="time"></b></h4>
        </div>
        <form role="form" name ="form1" class="form-horizontal" target="_blank" action="outstanding_report.php">
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

        
         
    
</div>
 

</div>

</form>
</div>

</section>
  