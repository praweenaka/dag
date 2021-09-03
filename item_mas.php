<?php
session_start();
?> 
<style type="text/css">
	@import url(https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css);

</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> 
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.full.min.js"></script> 
<script type="text/javascript">
	$(function () {
		$("select").select2();
	});

</script>
<section class="content">
	<div class="box box-primary">
		<div class="box-header with-border">
			<h3 class="box-title"><b>ITEM MASTER FILE</b></h3>
			<h4 style="float: right;height: 3px;"><b id="time"></b></h4>

		</div>
		<form name= "form1" role="form" class="form-horizontal">
			<div class="box-body">
				<input type="hidden" id="uniq" class="form-control">
				<input type="hidden" id="item_count" class="form-control">
				<div class="form-group">
					<div class="col-sm-9">
							<a onclick="new_ent();" class="btn btn-default  ">
							<span class="fa fa-user-plus"></span> &nbsp; New
						</a>
						<a onclick="save_inv();" class="btn btn-success  ">
							<span class="fa fa-save"></span> &nbsp; Save
						</a>
						<a onclick="print_inv();" class="btn btn-primary  ">
							<span class="fa fa-print"></span> &nbsp; Print
						</a>
						<a onclick="cancel_inv();" class="btn btn-danger  ">
							<span class="fa fa-trash"></span> &nbsp; Cancel
						</a>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
							<label class="col-md-5" for="txt_usernm">DATE</label>
							<div class="col-md-6">
								<input type="text"   value="<?php echo date('Y-m-d'); ?>"  disabled  id="sdate" class="form-control dt input-sm  ">
							</div>
						</div>
					</div>

				</div>
				<div class="form-group"></div>
				<div class="form-group"></div>
				<div id="msg_box"  class="span12 text-center"  ></div>
				<div class="form-group"> 
					<label class="col-md-1 " for="txt_usernm">CODE</label>
					<div class="col-md-2">
						<input type="text" placeholder="CODE" id="code" name="code" class="form-control  input-sm" disabled="">
					</div>
					<div class="col-md-1">
						<a href="item_mas_search.php" onclick="NewWindow(this.href, 'mywin', '800', '700', 'yes', 'center');
						return false" onfocus="this.blur()">
						<input type="button" name="searchitem" id="searchitem" value="..." class="btn btn-primary btn-sm">
					</a>
				</div>

				<label class="col-md-1" for="txt_usernm">DESCRIPTION</label>
				<div class="col-md-3">
					<input type="text" placeholder="DESCRIPTION" id="des" name="des" class="form-control  input-sm"  >
				</div>
			</div>

			<div class="form-group" >
				<label class="col-sm-1" for="txt_usernm">BRAND</label>
				<div class="col-sm-2">
					<select name="brand" id="brand" class="form-control input-sm" >
						<?php
						require_once("./connection_sql.php");
						$sql = "Select * from marker  where cancel ='0'";
						foreach ($conn->query($sql) as $row) {
							echo "<option value='" . $row["name"] . "'>" . $row["name"] . "</option>";
						}
						?> 
					</select>
				</div>
				<div class="col-sm-1"></div>
				<label class="col-sm-1 " for="cus_address">PART NO</label>
				<div class="col-sm-3">
					<input type="text" placeholder="PART NO" id="partno" class="form-control input-sm">
				</div> 
				<label class="col-sm-1  " for="cus_address">COUNTRY</label>
				<div class="col-sm-2">
					<input type="text" placeholder="COUNTRY" id="country" class="form-control input-sm">
				</div>
			</div> 


			<div class="form-group">
				<label class="col-sm-1  " for="cus_address">COST</label>
				<div class="col-sm-2">
					<input type="number" placeholder="COST" id="cost" class="form-control input-sm">
				</div>
				<div class="col-sm-1"></div>
				<label class="col-sm-1 " for="txt_remarks">RETAIL PRICE</label>
				<div class="col-sm-2">
					<input type="number" placeholder="SELLING" id="rprice" class="form-control input-sm">
				</div>
				
				<div class="col-sm-1"></div>
				<label class="col-sm-1 " for="txt_remarks">WHOLESALE PRICE</label>
				<div class="col-sm-2">
					<input type="number" placeholder="SELLING" id="whprice" class="form-control input-sm">
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-1" for="invno">TYPE</label> 
				<div class="col-sm-2"> 
					<select id="type" class="form-control input-sm" >
						<option value=""></option>

					</select>
				</div> 
				
				<div class="col-sm-1"></div>
				<label class="col-sm-1 " for="txt_remarks">RETAIL DIS</label>
				<div class="col-sm-2">
					<input type="number" placeholder="RETAIL DIS" id="rdis" class="form-control input-sm">
				</div>
				<div class="col-sm-1"></div>
				<label class="col-sm-1 " for="txt_remarks">WHOLESALE DIS</label>
				<div class="col-sm-2">
					<input type="number" placeholder="WHOLESALE DIS" id="whdis" class="form-control input-sm">
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-1  " for="invno">RACK</label> 
				<div class="col-sm-2"> 
					<select id="rack" name="rack"  class="form-control input-sm" > 
						<?php 
						for($i = 1; $i<=20; $i++) {
							echo "<option value='" . $i. "'>" . $i . "</option>";
						}

						?>
					</select>
				</div> 
				<div class="col-sm-1"></div>
				<label class="col-sm-1  " for="invno">ROWS</label> 
				<div class="col-sm-2"> 
					<select id="rows" class="form-control input-sm" > 
						<?php 
						for($i = 1; $i<=20; $i++) {
							echo "<option value='" . $i. "'>" . $i . "</option>";
						}

						?>
					</select>
				</div> 
				<div class="col-sm-1"></div>
				<label class="col-sm-1  " for="invno">COLUMN</label> 
				<div class="col-sm-2"> 
					<select id="column" class="form-control input-sm" > 
						<?php 
						for($i = 1; $i<=20; $i++) {
							echo "<option value='" . $i. "'>" . $i . "</option>";
						}

						?>
					</select>
				</div> 
			</div>





		</div>
	</form>
</div>
</section>
<script src="js/item_mas.js" type="text/javascript"></script>
<script>
$(document).ready(function(){
	// setTimeout(function(){ new_ent(); }, 500);
	new_ent();
	setInterval(function () {  
			$('#rack,#rows,#column,#brand').trigger('change');	 
		}, 50);

});



</script>
 



