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
            <h3 class="box-title">PRODUCTION LIST VIEW</h3>
            <h4 style="float: right;height: 3px;"><b id="time"></b></h4>
        </div>
        <form role="form" class="form-horizontal">
            <div class="box-body"> 
                <div class="panel-body" style="overflow-x: auto">
                     
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example" style="width:auto">
                    <thead> 

                     <tr class="danger">
                        <th>#</th>
                        <th>JOB NO</th>
                        <th>INVOICE NO</th>
                        <th>REG DATE</th>   
                        <th>ONHAND DATE</th>   
                        <th>CUSTOMER</th>
                        <th>DESIGN</th> 
                        <th>MAKE</th> 
                        <th>SIZE</th>  
                        <th>BELT</th>  
                        <th>SERIAL NO</th>  
                        <th>AD PAY</th>  
                        <th class="hidden">CASING COST</th>  
                        <th>TOTAL</th>
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
                            <td onclick="name(this)" > </td>
                            <td onclick="name(this)" ><?php echo $row['jobno']; ?></td> 
                            <td onclick="name(this)" ><?php echo $row['refno']; ?></td> 
                            <td onclick="name(this)" ><?php echo $row['sdate']; ?></td>
                            <td onclick="name(this)" ><?php echo $row['onhand_date']; ?></td>
                            <td onclick="name(this)" ><?php echo $row['cusname']; ?></td>   
                            <td onclick="name(this)" ><?php echo $row['belt']; ?></td>   
                            <td onclick="name(this)" ><?php echo $row['marker']; ?></td>   
                            <td onclick="name(this)" ><?php echo $row['size']; ?></td>   
                            <td onclick="name(this)" ><?php echo $row['belt']; ?></td>   
                            <td onclick="name(this)" ><?php echo $row['serialno']; ?></td>   
                            <td onclick="name(this)" ><?php echo $row['adpayment']; ?></td>  
                            <td onclick="name(this)" class="hidden"><?php echo $row['cascost']; ?></td>  
                            <td onclick="name(this)" ><?php echo $row['total']; ?></td>  
                            <td onclick="name(this)" ><?php echo $row['remark']; ?></td>  
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
                 <input type="hidden" id="id" disabled >
                 <input type="hidden" id="size" disabled >
                 <input type="hidden" id="cascost" disabled >
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

            <span class="pull-left">CUSTOMER:&nbsp;&nbsp;&nbsp;&nbsp;  <strong> <input type="text" id="cusname"  disabled></strong></span>

            <span class="pull-right">SEND DATE: <strong><input type="text" id="onhanddate"  disabled></strong></span>
        </div>
        <div class="col-lg-12">
            <span class="pull-left">REF NO: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><input type="text" id="refno"  disabled></strong></span>
            
            <span class="pull-right">REG.DATE: <strong><input type="text" id="regdate"  disabled></strong></span>
        </div>
        <div class="col-lg-12">
            <span class="pull-left">JOBNO: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><input type="text" id="jobno"  disabled></strong></span>
            <span class="pull-right">AD PAY: <strong><input type="text" id="adpay"  disabled> </strong></span>
            
        </div>
        <div class="col-lg-12">
            <span class="pull-left">SERIAL NO:  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><input type="text" id="serialno"  disabled></strong></span>
            <span class="pull-right">TOTAL AMOUNT <strong><input type="text" id="totalamou"  disabled> </strong></span>
        </div>

    </div>
    <div class="form-group"> </div>
    <div id="msg_box"  class="span12 text-center"  ></div>
    <!-- ============================ -->
    <div class="form-group"> 
        <ul class="nav nav-tabs">
          <li class="active"><a data-toggle="tab" href="#home">SPARE ITEM</a></li>
          <li><a data-toggle="tab" href="#menu1" onclick=" add_workersview();">JOB WORKERS</a></li>
          <li><a data-toggle="tab" href="#menu3" onclick=" add_buildersview();">JOB BILDERS</a></li>
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
                    <td> <select name="spareitem" id="spareitem" onchange="spareprice();"   class="text_purchase3 col-sm-9 form-control" > 
                            <option value=""></option>
                        <?php 
                        
                        $sql = "Select * from spareitem order by code";
                        foreach ($conn->query($sql) as $row) {
                            echo "<option value=\"" . $row["name"] . "\">" . $row["name"] . "</option>";
                        }
                        ?>

                    </select></td>

                    <td><input type="number" onchange="totqty();" disabled placeholder="PRICE" id="price"   class="form-control"></td>
                    <td><input type="number" onchange="totqty();" placeholder="QTY" id="qty"   class="form-control"></td>
                    <td><input type="number" placeholder="TOTAL" id="total" disabled=""   class="form-control"></td>
                    <td><a onclick="add_spare();" class="btn btn-default btn-sm"> <span class="fa fa-plus"></span>ADD &nbsp; </a></td>
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
            <option value=""></option>
                <?php
                require_once("./connection_sql.php");

                $sql = "Select * from workers where type='FACTORY' order by code";
                foreach ($conn->query($sql) as $row) {
                    echo "<option value=\"" . $row["name"] . "\">" . $row["name"] . "</option>";
                }
                ?>
            </select></td> 
            <td><input type="number" placeholder="HOURS" id="hours"   class="form-control"></td>
            <td><a onclick="add_workers();" class="btn btn-default btn-sm"> <span class="fa fa-plus"></span> ADD&nbsp; </a></td>
        </tr>
    </thead>
    <tbody>

        <div id="itemdetails1" > </div>
        <tr>
            <td align="right" colspan="2"><strong>Total</strong></td>
            <td align="right"><strong><?php echo number_format($total, 2); ?></strong></td>
        </tr>
    </tbody>
</table>
</div>
</div>
<!-- ======================== -->
<div id="menu3" class="tab-pane fade">
 <div class="row">
  <table width="100%" class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th>NAME</th> 
            <th>HOURS</th> 
            <th>#</th> 
        </tr>
        <tr>
            <td> <select name="builders" id="builders"    class="text_purchase3 col-sm-9 form-control" > 
            <option value=""></option>
                <?php
                require_once("./connection_sql.php");

                $sql = "Select * from workers where type='FACTORY' order by code";
                foreach ($conn->query($sql) as $row) {
                    echo "<option value=\"" . $row["name"] . "\">" . $row["name"] . "</option>";
                }
                ?>
            </select></td> 
            <td><input type="number" placeholder="HOURS" id="hours1"   class="form-control"></td>
            <td><a onclick="add_builders();" class="btn btn-default btn-sm"> <span class="fa fa-plus"></span>ADD &nbsp; </a></td>
        </tr>
    </thead>
    <tbody>

        <div id="itemdetails2" > </div>
        <tr>
            <td align="right" colspan="2"><strong>Total</strong></td>
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

            $sql = "Select * from design order by code";
            foreach ($conn->query($sql) as $row) {
                echo "<option value=\"" . $row["design"] . "\">" . $row["design"] . "</option>";
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

<script src="js/pro_list.js"></script>
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

         document.getElementById("id").value=cell_0; 
         document.getElementById("jobno").value=cell_1;
         document.getElementById("refno").value=cell_2;
         document.getElementById("onhanddate").value=cell_3;
         document.getElementById("regdate").value=cell_4;
         document.getElementById("cusname").value=cell_5; 
         document.getElementById("size").value=cell_8;
         document.getElementById("serialno").value=cell_10;
         document.getElementById("adpay").value=cell_11;
         document.getElementById("cascost").value=cell_12;
         document.getElementById("totalamou").value=cell_13;
         

        $("#exampleModal").modal("show");
        add_spareview();
        // add_workersview();
    }



</script>

<script type="text/javascript">
//                 $(document).ready(function() {
//           var table = $('#dataTables-example').DataTable( {
//              lengthChange: true,
//             fixedHeader: true,
//             responsive: true,
//             "deferRender": true, 
//              "order": [[ 0, 'asc' ]], 
//               dom: 'Bfrtip',
//         lengthMenu: [[ 25, 50,100, -1 ],[ '25 rows', '50 rows', '100 rows', 'Show all' ]],
//          "pageLength": -1,
//         buttons: [
//             'pageLength','print','colvis'
//         ]
              

//         } );

// $('div.dataTables_filter input', table.table().container()).focus();
//           table.buttons().container()
//           .appendTo( '#example_wrapper .col-md-6:eq(0)' );
           
//       } );
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