 <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>-->
     <link rel="stylesheet" href="css/bootstrap.min.css"> 
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
         <!--Validate -->
         <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script> 
         <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.min.js"></script> 
 
        <!-- Bootstrap -->
         <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script> 
 
        <!-- Bootstrap Date Picker-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>   
         <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script> 
 
        <!-- DataTables -->
        <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<?php
require_once("./connection_sql.php");
?>

<style>

    .view-cell{
        background-color: red;
        color: white; 
    }
    .table-hover tbody tr:hover td {
        background: aqua;
    }

</style>
<section class="content" onload="search1();">

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">REJECT LIST</h3>
            <h4 style="float: right;height: 3px;"><b id="time"></b></h4>
        </div>
        <form role="form" class="form-horizontal">
            <div class="box-body"> 
                <div class="panel-body" style="overflow-x: auto">
                     
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example" style="width:auto">
                    <thead> 

                     <tr>
                        <th>#</th>
                        <th>JOB NO</th>
                        <th>INVOICE NO</th>
                        <th>DATE</th>   
                        <th>CUSTOMER</th>
                        <th>MAKE</th> 
                        <th>SIZE</th>  
                        <th>SERIAL NO</th>  
                        <th>AMOUNT</th>  
                        <th>REPAIR</th>  
                        <th>TOTAL</th>  
                        <th>SEND DATE</th> 
                        <th>FINISH</th>   
                        <th>REMARK</th> 
                        <th></th>  
                    </tr>
                </thead>
 
                <tbody>
                    <?php
                    $i=1;
                    include './connection_sql.php';

                    $sql = "select * from dag_item WHERE   reject='1' ";


                    foreach ($conn->query($sql) as $row) {


                        ?>
                        <tr>
                            <td ><?php echo $i; ?></td>
                            <td onclick="name(this)"><?php echo $row['jobno']; ?></td> 
                            <td onclick="name(this)"><?php echo $row['refno']; ?></td> 
                            <td onclick="name(this)"><?php echo $row['sdate']; ?></td>   
                            <td onclick="name(this)"><?php echo $row['cusname']; ?></td>   
                            <td onclick="name(this)"><?php echo $row['marker']; ?></td>   
                            <td onclick="name(this)"><?php echo $row['size']; ?></td>   
                            <td onclick="name(this)"><?php echo $row['serialno']; ?></td>  
                            <td onclick="name(this)"><?php echo $row['amount']; ?></td>  
                            <td onclick="name(this)"><?php echo $row['repair']; ?></td>  
                            <td onclick="name(this)"><?php echo $row['total']; ?></td>  
                            <td onclick="name(this)"><?php echo $row['onhand_date']; ?></td>  
                            <td onclick="name(this)"><?php echo $row['pro_date']; ?></td>  
                            <td onclick="name(this)"><?php echo $row['remark']; ?></td>  
                            <td onclick="name(this)"  >
                                <button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-fullscreen"></span> &nbsp;VIEW</button>
                            </td>
                        </td>   


                    </tr>

                    <?php
                    $i= $i+1;
                }
                ?>
                 <tr>
                                                <td>100</td>
                                                <td>100</td>
                                                <td>100</td>
                                                <td>100</td>
                                                <td>30</td>
                                                <td>100</td>
                                                <td>100</td>
                                                <th   style="text-align:right">Page Total: </th>
                                                <td>100</td> 
                                                 <td>100</td> 
                                                  <td>100</td> 
                                                   <td>100</td> 
                                                    <td>100</td> 
                                                     <td>100</td> 
                                                      <td>100</td> 
                                            </tr>
            </tbody>
        </table>

    </div>

    <!-- =============================== -->


    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <div class="col-sm-5">
                 <center><h4 class="modal-title" id="myModalLabel">COMPLETE</h4></center>
                 
                
                 <input type="hidden" id="size"  disabled>
                 <!--<input type="text" id="make"  disabled>-->
                 <input type="hidden" id="id" disabled >
             </div>
             <div class="col-sm-3">
              <a onclick="sendproduction();" class="btn btn-primary">
                <span class="fa fa-save"></span> &nbsp; SEND TO PRODUCTION
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

            <span class="pull-left">Customer:&nbsp;&nbsp;&nbsp;&nbsp;  <strong> <input type="text" id="cusname"  disabled></strong></span>

            <span class="pull-right">SEND DATE: <strong><?php echo ucwords($row['sdate']); ?></strong></span>
        </div>
        <div class="col-lg-12">
            <span class="pull-left">JOB NO: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><input type="text" id="refno"  disabled></strong></span>
            
            <span class="pull-right">REG.DATE: <strong><?php echo $row['sdate']; ?></strong></span>
        </div>
        <div class="col-lg-12">
            <span class="pull-left">MAKE: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><input type="text" id="make"  disabled> </strong></span>
            <span class="pull-right">TYPE: <strong><?php echo ""; ?></strong></span>
        </div>
        <div class="col-lg-12">
            <span class="pull-left">SERIAL NO: <strong><input type="text" id="serialno"  disabled></strong></span>
            <span class="pull-right">TOTAL AMOUNT <strong><input type="text" id="total"  disabled></strong></span>
        </div>

    </div>
     <div class="form-group"> </div>
    <!-- ============================ -->
    <div class="form-group"> 
        <ul class="nav nav-tabs">
          <li class="active"><a data-toggle="tab" onclick=" add_spareview();" href="#home">SPARE ITEM</a></li>
          <li><a data-toggle="tab" href="#menu1" onclick=" add_workersview();">JOB WORKERS</a></li>
          <li><a data-toggle="tab" href="#menu3" onclick=" add_buildersview();">JOB BILDERS</a></li>
          <li><a data-toggle="tab" href="#menu2" onclick=" add_finishview();">FINISH</a></li>
      </ul>
  </div>
  <div class="tab-content">
      <div id="home" class="tab-pane fade in active"> 

       <div class="row">
           <table width="100%" class="table table-striped table-bordered table-hover">
           <thead>
         
         
    </thead> 
           <tbody>

                <tr>
                   <div id="itemdetails" > </div>
               </tr>

            <tr>
                <td align="right" colspan="4"><strong>Total</strong></td> 
                <td align="right" colspan="1"><strong><?php echo number_format($total, 2); ?></strong></td>
                <td align="right" colspan="2"> </td>
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
         
         
    </thead>
    <tbody>

        <div id="itemdetails1" > </div>
        
    </tbody>
</table>
</div>
</div>
<!-- ======================== -->
<div id="menu3" class="tab-pane fade">
 <div class="row">
  <table width="100%" class="table table-striped table-bordered table-hover">
    <thead>
        
    </thead>
    <tbody>

        <div id="itemdetails2" > </div>
       
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
            <select name="warrenty" id="warrenty"  disabled  class="text_purchase3 col-sm-9 form-control" > 
                <option value="YES">YES</option>
                <option value="NO">NO</option>
            </select> 
        </div> 


    </div> 
    <div class="form-group">

        <label class="col-sm-2 control-label" for="txt_usernm">DAG DESIGN</label>
        <div class="col-sm-3">
         <select name="design" id="design"  disabled   class="text_purchase3 col-sm-9 form-control" > 
            <?php
            require_once("./connection_sql.php");

            $sql = "Select * from design order by code";
            foreach ($conn->query($sql) as $row) {
                echo "<option value=\"" . $row["design"] . "\">" . $row["design"] . "</option>";
            }
            ?>
        </select>
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
</div> <div id="ajaxGetUserServletResponse"></div>
</section>

<script src="js/reject_list.js"></script>
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
        var cell_8 = row.cells[8].innerHTML; 
        var cell_9 = row.cells[9].innerHTML; 
        var cell_10 = row.cells[10].innerHTML;  

        document.getElementById("id").value=cell_0; 
         document.getElementById("refno").value=cell_2; 
        document.getElementById("cusname").value=cell_4;
        document.getElementById("make").value=cell_5;
         document.getElementById("size").value=cell_6;
         document.getElementById("serialno").value=cell_7;
         document.getElementById("total").value=cell_10;
         

        $("#exampleModal").modal("show");
        add_spareview();
        // add_workersview();
    }



</script>
 <script src="resources/bootstrap-3.3.7-dist/js/bootstrap-tooltip.js"></script>
    <script src="resources/bootstrap-3.3.7-dist/js/bootstrap-popover.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>
    
<script type="text/javascript">
     $(document).ready(function() {
    $('#dataTables-example').DataTable( {
        
              lengthChange: true,
            fixedHeader: true,
            responsive: true,
            "deferRender": true, 
             "order": [[ 0, 'asc' ]], 
               dom: 'Bfrtip',
         "pageLength": -1,
         
        "footerCallback": function ( row, data, start, end, display ) {
            
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // Total over all pages
            total = api
                .column( 10 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal = api
                .column( 10, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 4 ).footer() ).html(
                pageTotal +'' 
            );
        }
    } );
} );
 </script>     