 <!-- Main content -->
 
    <link rel="stylesheet" href="css/bootstrap.min.css"> 
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css"> 
    <script language="JavaScript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script language="JavaScript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script language="JavaScript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>-->
     
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.colVis.min.js"></script>

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
    .printer table{
    counter-reset: rowNumber;
}
 
.printer tr {
    counter-increment: rowNumber;
}
 
.printer tr td:first-child::before {
    content: counter(rowNumber);
    min-width: 1em;
    margin-right: 0.5em;
}
</style>
<section class="content" onload="search1();">

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">COMPLETE LIST</h3>
        </div>
        <form role="form" class="form-horizontal">
            <div class="box-body"> 
                <div class="panel-body" style="overflow-x: auto">
                     
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example" style="width:auto">
                    <thead> 

                     <tr class="danger">
                        <th>#</th>
                        <th>JOB NO</th> 
                        <th>INV NO</th>   
                        <th>DATE</th>   
                        <th>CUSTOMER</th>
                        <th>DESIGN</th>
                        <th>MAKE</th> 
                        <th>SIZE</th>  
                        <th>SERIAL NO</th>  
                        <th>WARRENTY</th> 
                        <th>AD PAY</th>   
                        <th>AMOUNT</th>    
                        <th>REPAIR</th>  
                        <th>TOTAL</th>  
                        <th>PRO DATE</th>  
                        <th></th>  
                    </tr>
                </thead>


                <tbody>
                    <?php
                    $i=1;
                    include './connection_sql.php';

                    $sql = "select * from dag_item WHERE flag='2' and cancel='0' ";


                    foreach ($conn->query($sql) as $row) {


                        ?>
                        <tr>
                            <td onclick="name(this)" > </td>
                            <td onclick="name(this)" ><?php echo $row['jobno']; ?></td>  
                            <td onclick="name(this)" ><?php echo $row['refno']; ?></td>  
                            <td onclick="name(this)" ><?php echo $row['sdate']; ?></td>   
                            <td onclick="name(this)" ><?php echo $row['cusname']; ?></td>   
                            <td onclick="name(this)" ><?php echo $row['design']; ?></td>   
                            <td onclick="name(this)" ><?php echo $row['marker']; ?></td>   
                            <td onclick="name(this)" ><?php echo $row['size']; ?></td>   
                            <td onclick="name(this)" ><?php echo $row['serialno']; ?></td> 
                            <td onclick="name(this)" ><?php echo $row['warrenty']; ?></td> 
                            <td onclick="name(this)" ><?php echo $row['adpayment']; ?></td>  
                            <td onclick="name(this)" ><?php echo $row['amount']; ?></td>  
                            
                            <td onclick="name(this)" ><?php echo $row['repair']; ?></td>  
                            <td onclick="name(this)" style="background-color:#f39c12"><?php echo number_format($row['total'],2); ?></td>   
                            <td onclick="name(this)" ><?php echo $row['pro_date']; ?></td>  
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
                 <center><h4 class="modal-title" id="myModalLabel">COMPLETE</h4></center>
                 <input type="hidden" id="make"  disabled>
                 
                 <input type="hidden" id="size"  disabled>
                 <input type="hidden" id="id" disabled >
             </div>
             <div class="col-sm-3">
              <a onclick="sendproduction();" class="btn btn-primary">
                <span class="fa fa-save"></span> &nbsp; SEND TO PRODUCTION
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

            <span class="pull-left">CUSTOMER: <strong><input type="text" id="cusname"  disabled></strong></span>
            <span class="pull-right">REG.DATE: <strong><input type="text" id="regdate"  disabled></strong></span>

        </div>
        <div class="col-lg-12">
            <span class="pull-left">REF NO:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong><input type="text" id="refno" disabled ></strong></span>
            <span class="pull-right">PRO DATE: <strong><input type="text" id="prodate"  disabled></strong></span>
        </div>
        <div class="col-lg-12">
            <span class="pull-left">JOB NO: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><input type="text" id="jobno" disabled > </strong></span>
            <span class="pull-right">AD PAY: <strong><input type="text" id="adpay"  disabled></strong></span>
        </div>
        <div class="col-lg-12">
            <span class="pull-left">SERIAL NO: <strong><input type="text" id="serialno"  disabled></strong></span>
            <span class="pull-right">TOTAL AMOUNT <strong><input type="text" id="totalamou"  disabled></strong></span>
        </div>

    </div>
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
</div>
</section>

<script src="js/comp_list.js"></script>
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
        var cell_11 = row.cells[11].innerHTML; 
        var cell_12 = row.cells[12].innerHTML; 
        var cell_13 = row.cells[13].innerHTML; 
        var cell_14 = row.cells[14].innerHTML;
        var cell_15 = row.cells[15].innerHTML;

        document.getElementById("id").value=cell_0; 
        document.getElementById("jobno").value=cell_1; 
        document.getElementById("refno").value=cell_2; 
        document.getElementById("regdate").value=cell_3; 
        document.getElementById("cusname").value=cell_4;
        document.getElementById("make").value=cell_6; 
        document.getElementById("size").value=cell_7; 
        document.getElementById("serialno").value=cell_8;
        document.getElementById("adpay").value=cell_10;
        
        document.getElementById("totalamou").value=cell_14;
        document.getElementById("prodate").value=cell_15;
         

        $("#exampleModal").modal("show");
        add_spareview();
        // add_workersview();
    }



</script>

<script type="text/javascript">
      $(document).ready(function() {
      var table =  $('#dataTables-example').DataTable( {
            dom: 'Bfrtip',
            lengthChange: true,
            fixedHeader: true,
            responsive: true,
            "deferRender": true,
            "pageLength": -1,
            
            buttons: ['pageLength','colvis',
                {
                    extend: 'print',
                    customize: function ( win ) {
                         $(win.document.body).find('table').addClass('printer');
     
                        
                    }
                }
            ]
        } );
        
            table.on( 'order.dt search.dt', function () {
            table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
             } ) 
              $('div.dataTables_filter input', table.table().container()).focus();
          table.buttons().container()
          .appendTo( '#example_wrapper .col-md-6:eq(0)' );
    } );

        </script>
        
        