<link rel="stylesheet" href="css/themes/redmond/jquery-ui-1.10.3.custom.css" />

<!-- Main content -->
<section class="content">

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Vehicle Report</h3>
        </div>
        <form id="form1" name="form1" action="report_vehicle1.php" target="_blank" method="get">
            <div class="box-body">

                <div class="form-group">
                    <a onclick="location.reload();" class="btn btn-default">
                        <span class="fa fa-user-plus"></span> &nbsp; New
                    </a>

                </div> 

                <div class="form-group">
                    <label   class="col-sm-1">Date From</label>
                    <div class="col-sm-2">
                        <input type="text" id="from" name="from" value="<?php echo date("Y-m-d"); ?>" class="form-control dt">
                    </div>					
                    <label   class="col-sm-1 ">Date To</label>
                    <div class="col-sm-2">
                        <input type="text" id="to" name="to" value="<?php echo date("Y-m-d"); ?>" class="form-control dt">
                    </div> 	

                </div>

                <div class="form-group">
                    <label   class="col-sm-1  ">Vehicle</label>
                    <div class="col-sm-2">
                        <select id="vehicle" name="vehicle"   class="form-control input-sm" width='120' >
                            <option value='All'>All</option>
                            <option value='QY-4344'>QY-4344</option>
                            <option value='AAI-3491'>AAI-3491</option>
                            <option value='AAA-4869'>AAA-4869</option>
                            <option value='QY-4907'>QY-4907</option>

                        </select>
                    </div>					
                </div>
                <div class="form-group">
                    <label   class="col-sm-1  "> </label>
                    <input type="submit" name="button" id="button" value="View" class="btn btn-primary">					
                </div>



            </div>
        </form>
    </div>


</section>
