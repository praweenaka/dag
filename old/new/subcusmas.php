<!-- Main content -->

<section class="content">

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Sub Customer</h3>
        </div>
        <form role="form" name="form1" class="form-horizontal">
            <div class="box-body">

                
                <div class="container">
				  
				<div class="form-group">

                    <?php
					include './connection_sql.php';
					$mcode = "";
					$mname = "";
					if (isset($_GET['c_code'])) {
						$sql = "select * from vendor where code ='"  . $_GET['c_code'] . "'";
						$result_g = $conn->query($sql);
						if($row_g = $result_g->fetch()) {
							$mcode = $row_g['CODE'];
							$mname = $row_g['NAME'];	
						}
						
						
					}
					
					
					
					?>
					 <div id="msg_box"  class="span12 text-center"  >

                </div>
					

                    <label class="col-sm-1 control-label" for="name">Customer</label>
                    <div class="col-sm-2">
                        <input placeholder="Code" disabled="disabled" id="c_code" value="<?php echo $mcode; ?>" class="form-control input-sm" type="text">
                    </div>
                    <div class="col-sm-4">
                        <input placeholder="Name" id="c_name" value="<?php echo $mname; ?>" class="form-control input-sm" type="text">
                    </div>
                    <div class="col-sm-1">
                        <a onfocus="this.blur()" onclick="window.location.reload()">
                            <input class="btn btn-default" value="New" id="searchcust" name="searchcust" type="button">
                        </a>
                    </div>

                </div>
				
				
				 <table class="table table-striped">
                    <tr><th>Sub Code</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Vat No</th>
						<th>SVat No</th>
                        <th>Tele No</th>
                    </tr>

                    <tr>
                        <td>
							<?php
							$sql = "select * from vender_sub where c_main ='"  . $_GET['c_code'] .  "' and type = 'S' order by id desc limit 1";
							
							$result_g = $conn->query($sql);
							if($row_g = $result_g->fetch()) {
								$mrefno = substr($row_g['c_code'], -2); 
								$mrefno = $_GET['c_code'] . "/" . (str_replace("/","",$mrefno) +1); 
						 
							} else {
								 
								$mrefno = $_GET['c_code'] . "/1"; 
							}
							
							?>
						
                            <input type="text" placeholder="Code" disabled="disabled" id="txt_code" value = "<?php echo $mrefno; ?>"  class="form-control input-sm">
						</td>
                        <td>
                            <input type="text" placeholder="Name" id="txt_name"   class="form-control input-sm"> 
                        </td>
                        <td>
                            <input type="text" placeholder="Address" id="txt_add"  class="form-control input-sm">
                        </td>
                        <td>
                            <input type="text" placeholder="Vat No" id="txt_vat"   class="form-control input-sm">
                        </td>
						<td>
                            <input type="text" placeholder="SVat No" id="txt_svat"   class="form-control input-sm">
                        </td>
                         <td>
                            <input type="text" placeholder="Tele No" id="txt_tele"   class="form-control input-sm">
                        </td>
						<td><a onclick="add_sub();" class="btn btn-default btn-sm"> <span class="fa fa-plus"></span> &nbsp; </a></td>
                         
                    </tr>
					
					<?php
					$sql = "select * from vender_sub where c_main ='"  . $_GET['c_code'] .  "'  and type = 'S' order by id";
					foreach ($conn->query($sql) as $row) {
						echo "<tr>";
						echo "<td onclick=\"getcus('". $row['c_code']  . "','". $row['c_name']  . "','". $row['c_add']  . "','". $row['c_vatno']  . "','". $row['c_svatno']  . "','". $row['c_tele']  . "')\">" . $row['c_code'] . "</td>";
						echo "<td>" . $row['c_name'] . "</td>";
						echo "<td>" . $row['c_add'] . "</td>";
						
						echo "<td>" . $row['c_vatno'] . "</td>";
						echo "<td>" . $row['c_svatno'] . "</td>";
						echo "<td>" . $row['c_tele'] . "</td>";
						echo "<td><a class=\"btn btn-danger btn-xs\" onClick=\"del_item('" . $row['c_code'] . "')\"> <span class='fa fa-remove'></span></a></td>";
						echo "</tr>";
						
						
						
						
					}
					?>
					
					

                </table>
				
				 
                    
                </div>
                
 


            </div>
        </form>
    </div>

</section>

<script src="js/cusmas.js"></script>

 