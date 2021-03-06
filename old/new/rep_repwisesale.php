<link rel="stylesheet" href="css/themes/redmond/jquery-ui-1.10.3.custom.css" />

<!-- Main content -->
<section class="content">

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Sales Summery Report - Repwise</h3>
        </div>
        <form role="form" name ="form1" action="../report_repwise_sales_summeryN.php" target="_blank" method="get" class="form-horizontal">
            <div class="box-body">

                 
               <div id="msg_box"  class="span12 text-center"  ></div>
			   
			   
			   
			   
                <input type="hidden" id="tmpno" class="form-control">
                <input type="hidden" id="item_count" class="form-control">

				<div class="form-group">
                    <label class="col-sm-2 control-label" for="from">From</label> 
                    <div class="col-sm-2">
                        <input value="<?php echo date('Y-m-d');  ?>" placeholder="From" id="DT1" name="DT1" class="form-control dt" type="text">
                    </div>
                    <label class="col-sm-1 control-label" for="from">To</label> 
                    <div class="col-sm-2">
                        <input value="<?php echo date('Y-m-d');  ?>" placeholder="To" id="DT2" name="DT2" class="form-control dt" type="text">
                    </div>
					
					<label class="col-sm-1 control-label" for="chktar">Target</label>
					<div class="col-sm-1">
					<input type="checkbox" name="chktar" id="chktar"/> 
					</div>
					
					<label class="col-sm-1 control-label" for="chktar">Defective</label>
					<div class="col-sm-1">
					<input type="checkbox" name="chkdef" id="chkdef"/> 
					</div>
					
					
                </div>
				
				
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="firstname_hidden">Marketing Executive</label>
                    <div class="col-sm-2">
						<select name="salesrep" id="salesrep" onkeypress="keyset('dte_dor',event);" onchange="setord();" class="form-control">
            <?php
                if ($_SESSION["CURRENT_REP"]=="") {
                    echo "<option value='All'>All</option>";			 						
                    $sql="select * from s_salrep where cancel='1' order by REPCODE";
                    $result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
                    while($row = mysqli_fetch_array($result)){
                        echo "<option value='".$row["REPCODE"]."'>".$row["REPCODE"]." ".$row["Name"]."</option>";
                    }
		} else {
                    $sql="select * from s_salrep where cancel='1' and repcode = '" . $_SESSION["CURRENT_REP"] ."' order by REPCODE";
                    echo $sql;
                    $result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
                    while($row = mysqli_fetch_array($result)){
                    echo "<option value='".$row["REPCODE"]."'>".$row["REPCODE"]." ".$row["Name"]."</option>";
                    }
                }
                ?>
    </select>
                         
                    </div> 
					
					 
                </div>
				
                <div class="form-group">
                    <label for="firstname_hidden" class="col-sm-2 control-label">Brand</label>
                    <div class="col-sm-2">
                        <select name="cmbbrand" id="cmbbrand"   class="form-control">
						<option value='All'>All</option>
						<?php
	  		 
																	$sql="select * from brand_mas where act ='1' order by barnd_name";
																	$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
																	while($row = mysqli_fetch_array($result)){
                        												echo "<option value='".$row["barnd_name"]."'>".$row["barnd_name"]."</option>";
                       												}
																?>
						</select>
                    </div> 
					
                </div>
                
				
				<div class="form-group">
					<label for="firstname_hidden" class="col-sm-2 control-label">Cat</label>
					<div class="col-sm-2">
					<select name="cmbtype" id="cmbtype" class="form-control">
      <option selected="selected" value='All'>All</option>
      <option value='PCR'>PCR</option>
      <option value='LTR'>LTR</option>
      <option value='OTR'>OTR</option>
      <option value='TBR'>TBR</option>
      <option value='BIAS TYRES'>BIAS TYRES</option>
                       					
    </select>
					
				</div>
				
				
				
				</div>
				 
                <div class="form-group">
					<label for="firstname_hidden" class="col-sm-2 control-label">Type</label>
					<div class="col-sm-2">
					<select name="cmbbrand1" id="cmbbrand1"   class="form-control">
        <option value="All">All</option> 
            <?php
																	$sql="select class from brand_mas group by class ";
																	$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
																	while($row = mysqli_fetch_array($result)){
                        												echo "<option value='".$row["class"]."'>".$row["class"]."</option>";
                       												}
																?>
        </select>
					
				</div>
				
				
				
				</div> 	

				
				<div class="form-group">
				<div class="col-sm-5">
					<input type="submit" id="button" class="btn btn-primary pull-right" value="View">
				</div>
				</div>


					

            </div>

   

    <div  class='space' >
        <br>&nbsp;
        <br>&nbsp;
        <br>&nbsp;

    </div>

</form>
</div>

</section>

 
