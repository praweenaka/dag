<link rel="stylesheet" href="css/themes/redmond/jquery-ui-1.10.3.custom.css" />

<!-- Main content -->
<section class="content">

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Dealer Comman Code</h3>
        </div>
        <form role="form" name ="form1" class="form-horizontal">
            <div class="box-body">

                <div class="form-group">
                    <a onclick="new_inv();" class="btn btn-default">
                        <span class="fa fa-user-plus"></span> &nbsp; New
                    </a>
                    <a onclick="save_inv();" class="btn btn-primary">
                        <span class="fa fa-save"></span> &nbsp; Save
                    </a>
					<a onclick="print_inv();" class="btn btn-default">
                        <span class="fa fa-print"></span> &nbsp; Print
                    </a>	
                </div>
               <div id="msg_box"  class="span12 text-center"  ></div>
			   
                <input type="hidden" id="tmpno" class="form-control">
                <input type="hidden" id="item_count" class="form-control">

				
          
                <table class="table">
				<tr><td>Code</td><td>Name</td><td>Town</td><td>Comm. Code</td></tr>
				
				<?php
				$sql = "select * from vendor order by code";
				$result = mysqli_query($GLOBALS['dbinv'], $sql);
                while ($row = mysqli_fetch_array($result)) {  
			 

				echo  "<tr>               
                              <td>" . $row['CODE'] . "</a></td>
                              <td>" . $row['NAME'] . "</a></td>
							  <td>" . $row['ADD2'] . "</a></td>
                              <td><input id='" . $row['CODE'] . "' value='".  $row['commoncode'] . "'></td>
							  <td><a onfocus=\"this.blur()\" onclick=\"set_inv('" . trim($row['CODE']) . "'); return false\" >
								<input type=\"button\" class=\"btn btn-default\" value=\"...\" id=\"searchcust\" name=\"searchcust\">
							  </a></td>
                            </tr>";
				}
				
				
				
				?>
				
				</table>
				
				 

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
 
<script>

function set_inv() {
    var url = "serach_customer.php?stname=rec&cur=" +  document.getElementById('currency').value;
    NewWindow(url, 'mywin', '800', '700', 'yes', 'center');                          
}

</script> 
 
<script src="js/common.js"></script>
<script src="js/jquery-1.9.1.js"></script>
<script src="js/jquery-ui.custom.js"></script>
<script src="js/common.js"></script>
<script  type="text/javascript" src="js/jquery-1.6.1.min.js"></script>
<script  type="text/javascript" src="js/jquery-ui-1.8.14.custom.min.js"></script>
 
