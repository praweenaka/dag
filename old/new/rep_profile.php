<link rel="stylesheet" href="css/themes/redmond/jquery-ui-1.10.3.custom.css" />



<!-- Main content -->
<section class="content">

	<div class="box box-primary">
		<div class="box-header with-border">
			<h3 class="box-title">Profile</h3>
		</div>
		<form role="form" name ="form1" class="form-horizontal">
			<div class="box-body">
				
				
				
				
				
				<div class="form-group">
					
					<a onclick="new_inv();" class="btn btn-default">
						<span class="fa fa-user-plus"></span> &nbsp; New
					</a>
					
					
					
				</div>
				<div id="msg_box"  class="span12 text-center"  ></div>
				
				<input type="hidden" id="tmpno" class="form-control">
				<input type="hidden" id="item_count" class="form-control">

				
				
				<div class="form-group">
					<label for="invno" class="col-sm-2 control-label">Sales Executive</label>
					<div class="col-sm-4">
						
						
						<select id="rep" onclick='getrep();'  class='form-control'>

							<?php
							
							$sql="select * from s_salrep where cancel='1'";
							$result = mysqli_query($GLOBALS['dbinv'], $sql);
							while ($row = mysqli_fetch_array($result)) {
                                //echo "<option value='" . $row["barnd_name"] . "'>" . $row["barnd_name"] . "</option>";
								if ($row["REPCODE"]=="01"){
									echo "<option selected value='".$row["REPCODE"]."'>".$row["Name"]."</option>";
								}	else {
									echo "<option value='".$row["REPCODE"]."'>".$row["Name"]."</option>";
								}	
							}
							?>
						</select>
						
					</div> 
				</div>
				
				
				<div class="form-group">
					
					<div class="col-sm-6 col-md-offset-0">

						<div class="panel panel-primary">

							<div class="panel-heading">Details</div>

							<div class="panel-body">



								<div class="form-group">

									<img class='img' id ="pic" src=''>

								</div>
								
								<div class="form-group">

									<label class="col-sm-3 control-label">Name : </label>

									<label class="control-label" id="name"></label>

								</div>

								<div class="form-group">

									<label class="col-sm-3 control-label">Join Date : </label>

									<label  class="control-label" id ="join_dt"></label>

								</div>

								<div class="form-group">

									<label class="col-sm-3 control-label">Remark : </label>

									<label  class="control-label" id = "remark"></label>

								</div> 
								
							</div>
						</div>

















					</div>
					
					
					
					
				</div>
				
				
				
				

				<div id="container" >
					
					
				</div>
				
				
				
				<div id="filt_table">
					
					
					
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

<script src="js/rep_profile.js"></script>

<script src="js/jquery-1.9.1.js"></script>
<script src="js/jquery-ui.custom.js"></script>
<script src="js/comman.js"></script>
<script  type="text/javascript" src="js/jquery-1.6.1.min.js"></script>
<script  type="text/javascript" src="js/jquery-ui-1.8.14.custom.min.js"></script>


<script>
	
	
	//	document.getElementById('filt_table').style.visibility = "hidden";
	
	
	
	
</script>

<script>

	function  new_inv() {
		
		
		document.getElementById('msg_box').innerHTML = "";
		
		
	}

</script>

<style type="text/css">
	${demo.css}
</style>
