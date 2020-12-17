<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<?php
require_once("./connection_sql.php");
?>

<style>

    .view-cell{
        background-color: red;
        color: white; 
    }

</style>
<section class="content" onload="search1();">

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">PRODUCTION LIST</h3>
        </div>
        <form role="form" class="form-horizontal">
            <div class="box-body"> 
                <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example1">
                     <thead>   
                        <tr>
                            <th width="80%"> </th>    
                            <th><input type="text" name="search" placeholder="Search" id="search"  class="form-control input-sm"></th>  
                        </tr>
                    </thead>
                </table>
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead> 

                     <tr>
                        <th>#</th>
                        <th>DATE</th>   
                        <th>CUSTOMER</th>
                        <th>JOB NO</th>
                        <th>MAKE</th> 
                        <th>SIZE</th>  
                        <th>SERIAL NO</th>  
                        <th>REMARK</th>  
                        <th></th>  
                    </tr>
                </thead>


                <tbody>
                    <?php
                    $i=1;
                    include './connection_sql.php';

                    $sql = "select * from dag_item WHERE flag='1' and cancel='0' ";


                    foreach ($conn->query($sql) as $row) {


                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $row['sdate']; ?></td>   
                            <td><?php echo $row['cuscode'].'-'.$row['cusname']; ?></td>   
                            <td><?php echo $row['refno']; ?></td> 
                            <td><?php echo $row['marker']; ?></td>   
                            <td><?php echo $row['size']; ?></td>   
                            <td><?php echo $row['serialno']; ?></td>   
                            <td><?php echo $row['remark']; ?></td>  
                            <td onclick="name(this)"  >
                                <button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-fullscreen"></span> &nbsp;VIEW</button>
                            </td>
                        </td>   


                    </tr>

                    <?php
                    $i= $i+1;
                }
                ?>
            </tbody>
        </table>

    </div>

    <!-- =============================== -->


    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <div class="col-sm-5">
                 <center><h4 class="modal-title" id="myModalLabel">PRODUCTION</h4></center>
                 <input type="text" id="refno"  >
                 <input type="text" id="serialno"  >
                 <input type="text" id="id"  >
             </div>
             <div class="col-sm-3">
              <a onclick="sendonhand();" class="btn btn-primary">
                <span class="fa fa-save"></span> &nbsp; SEND TO ONHAND
            </a> 
        </div> 
        <div class="col-sm-3">
          <a onclick="sendreject();" class="btn btn-primary">
            <span class="fa fa-save"></span> &nbsp; SEND TO REJECT
        </a> 
    </div>
    <div class="col-sm-1"> 
     <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
 </div>
</div>
<div class="modal-body">

 <div class="container-fluid">
    <div class="row">
        <div class="col-md-12">

            <span class="pull-left">Customer: <?php echo $row['sdate']; ?></strong></span>
            <span class="pull-right">REG.DATE: <strong><?php echo $row['sdate']; ?></strong></span>

        </div>
        <div class="col-lg-12">
            <span class="pull-left">JOB NO: <strong><?php echo ucwords($row['refno']); ?></strong></span>
            <span class="pull-right">SERIAL NO: <strong><?php echo $row['serialno']; ?></strong></span>
        </div>
        <div class="col-lg-12">
            <span class="pull-left">MAKE: <strong><?php echo ucwords($row['marker']); ?></strong></span>
            <span class="pull-right">TYPE: <strong><?php echo ""; ?></strong></span>
        </div>
        <div class="col-lg-12">
            <span class="pull-left">SEND DATE: <strong><?php echo ucwords($row['sdate']); ?></strong></span>
            <span class="pull-right">TOTAL AMOUNT <strong><?php echo number_format($row['adpayment'],2); ?></strong></span>
        </div>

    </div>
    <!-- ============================ -->
    <div class="form-group"> 
        <ul class="nav nav-tabs">
          <li class="active"><a data-toggle="tab" href="#home">SPARE ITEM</a></li>
          <li><a data-toggle="tab" href="#menu1" onclick=" add_workersview();">JOB WORKERS</a></li>
          <li><a data-toggle="tab" href="#menu2">FINISH</a></li>
      </ul>
  </div>
  <div class="tab-content">
      <div id="home" class="tab-pane fade in active"> 

       <div class="row">
           <table width="100%" class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>SPARE ITEM</th>
                    <th>PRICE</th>
                    <th>QTY</th> 
                    <th>TOTAL</th> 
                    <th>#</th> 
                </tr>
                <tr>
                    <td> <select name="spareitem" id="spareitem"    class="text_purchase3 col-sm-9 form-control" > 
                        <?php


                        $sql = "Select * from size order by code";
                        foreach ($conn->query($sql) as $row) {
                            echo "<option value=\"" . $row["name"] . "\">" . $row["name"] . "</option>";
                        }
                        ?>

                    </select></td>

                    <td><input type="number" onkeyup="totqty();" placeholder="PRICE" id="price"   class="form-control"></td>
                    <td><input type="number" onkeyup="totqty();" placeholder="QTY" id="qty"   class="form-control"></td>
                    <td><input type="number" placeholder="TOTAL" id="total" disabled=""   class="form-control"></td>
                    <td><a onclick="add_spare();" class="btn btn-default btn-sm"> <span class="fa fa-plus"></span> &nbsp; </a></td>
                </tr>
                <tr>
                   <div id="itemdetails" > </div>
               </tr>
           </thead>
           <tbody>



            <tr>
                <td align="right" colspan="3"><strong>Total</strong></td>
                <td align="right"><strong><?php echo number_format($total, 2); ?></strong></td>
            </tr>

        </tbody>
    </table> 
</div>
</div>
<!-- ======================== -->
<div id="menu1" class="tab-pane fade">
 <div class="row">
  <table width="100%" class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th>NAME</th> 
            <th>HOURS</th> 
            <th>#</th> 
        </tr>
        <tr>
            <td> <select name="workers" id="workers"    class="text_purchase3 col-sm-9 form-control" > 
                <?php
                require_once("./connection_sql.php");

                $sql = "Select * from workers order by code";
                foreach ($conn->query($sql) as $row) {
                    echo "<option value=\"" . $row["name"] . "\">" . $row["name"] . "</option>";
                }
                ?>
            </select></td> 
            <td><input type="number" placeholder="HOURS" id="hours"   class="form-control"></td>
            <td><a onclick="add_workers();" class="btn btn-default btn-sm"> <span class="fa fa-plus"></span> &nbsp; </a></td>
        </tr>
    </thead>
    <tbody>

        <div id="itemdetails1" > </div>
        <tr>
            <td align="right" colspan="3"><strong>Total</strong></td>
            <td align="right"><strong><?php echo number_format($total, 2); ?></strong></td>
        </tr>
    </tbody>
</table>
</div>
</div>
<!-- =================== -->
<div id="menu2" class="tab-pane fade">
  <div class="row">
    <div class="form-group">

        <label class="col-sm-2 control-label" for="txt_usernm">WARRANTY</label>
        <div class="col-sm-3">
            <select name="warranty" id="warranty"    class="text_purchase3 col-sm-9 form-control" > 
                <option value="YES">YES</option>
                <option value="NO">NO</option>
            </select> 
        </div> 


    </div> 
    <div class="form-group">

        <label class="col-sm-2 control-label" for="txt_usernm">DAG DESIGN</label>
        <div class="col-sm-3">
         <select name="design" id="design"    class="text_purchase3 col-sm-9 form-control" > 
            <?php
            require_once("./connection_sql.php");

            $sql = "Select * from workers order by code";
            foreach ($conn->query($sql) as $row) {
                echo "<option value=\"" . $row["name"] . "\">" . $row["name"] . "</option>";
            }
            ?>
        </select>
    </div> 

    <div class="col-sm-1">
      <a onclick="sendfinish();" class="btn btn-primary">
        <span class="fa fa-save"></span> &nbsp; SEND TO FINISH
    </a> 
</div> 
</div> 
</div>
<!-- ======================== -->
</div>

<!-- ========================= -->






</div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    
</div>
</div>
</div>
</div>


<!-- =============================== -->



</div>
</form>
</div>
</section>

<script src="js/sample.js"></script>
<script>



    function name(subNode) {


        var row = subNode.parentNode;

        // console.log(row.cells[0]);

        var cell_0 = row.cells[0].innerHTML; 
        var cell_1 = row.cells[1].innerHTML; 
        var cell_2 = row.cells[2].innerHTML; 
        var cell_3 = row.cells[3].innerHTML; 
        var cell_4 = row.cells[4].innerHTML; 
        var cell_5 = row.cells[5].innerHTML; 
        var cell_6 = row.cells[6].innerHTML; 
        var cell_7 = row.cells[7].innerHTML; 

        document.getElementById("id").value=cell_0; 
         document.getElementById("refno").value=cell_3; 
        document.getElementById("serialno").value=cell_6;

        $("#exampleModal").modal("show");
        add_spareview();
        // add_workersview();
    }



</script>