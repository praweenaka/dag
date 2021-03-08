
<?php
include './connection_sql.php';
?>
<!-- Main content -->
<section class="content">

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">ADVANCE</h3>
            <h4 style="float: right;height: 3px;"><b id="time"></b></h4>
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
                         <a onclick="NewWindow('advance_search.php', 'mywin', '800', '700', 'yes', 'center');" class="btn btn-info btn-sm">
                        <span class="glyphicon glyphicon-search"></span> &nbsp; FIND
                    </a> 
                  
                       
                    <a onclick="cancel_inv();" class="btn btn-danger">
                        <span class="fa fa-print"></span> &nbsp; Cancel
                    </a>	

                </div>
                <div id="msg_box"  class="span12 text-center"  ></div>

                <input type="hidden" id="uniq" class="form-control">
                <input type="hidden" id="item_count" class="form-control">

                <div class="form-group">
                    <label class="col-sm-2 control-label" for="firstname_hidden">Ref No</label>
                    <div class="col-sm-2">
                        <input type="text"  id="invno" disabled class="form-control">
                    </div> 
                    <div class="col-sm-2">
                         
                    </div> 
                    <label class="col-sm-2 control-label" for="firstname_hidden">Date</label>
                    <div class="col-sm-2">
                        <input type="date"  id="sdate"  value="<?php echo date('Y-m-d')?>" class="form-control">
                    </div> 

                </div>

               
                 <div class="form-group">
                    <label class="col-sm-2 control-label" for="firstname_hidden">NAME</label>
                    <div class="col-sm-3">
                       <select id="name"  class="form-control input-sm" >
                        <!--<option></option>-->
                        <?php
                        
                            $sql="select * from workers  where cancel='0'  order by name";
                            foreach ($conn->query($sql) as $row) {
                                echo "<option value='".$row["name"]."'>".$row["name"]."  </option>";
                            }
                        
                        
                        ?>
                    </select>
                </div> 
                    

                </div>
                 <div class="form-group">
                    <label class="col-sm-2 control-label" for="firstname_hidden">Amount</label>
                    <div class="col-sm-3">
                        <input type="number"  id="amount"   class="form-control">
                    </div> 

                </div>
                 <div class="form-group">
                    <label class="col-sm-2 control-label" for="firstname_hidden">Remark</label>
                    <div class="col-sm-3">
                        <input type="text"  id="remark"   class="form-control">
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

<script src="js/advance.js"></script>

<script>
     new_inv();
</script>

    