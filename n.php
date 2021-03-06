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
 
  
 
 

<section class="content" onload="search1();">

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">REJECT LIST</h3>
            <h4 style="float: right;height: 3px;"><b id="time"></b></h4>
        </div>
         
 
        <form data-toggle="validator" role="form" id="showActivityTableForm">
            <div class="box-body"> 
                <div class="panel-body" style="overflow-x: auto">
            <div class="row">
             
                             
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
                                        <tbody >
                                               <?php
                    $i=1;
                    include './connection_sql.php';

                    $sql = "select * from dag_item WHERE (flag='1' or flag='2' ) and cancel='1' ";


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
                                        </tbody>
 
                                        <tfoot>
                                            <tr>
                                                <th colspan="9" style="text-align:right">Page Total: </th>
                                                <th colspan="1" style="text-align:right"></th>
                                            </tr>
                                        </tfoot>
 
                                    </table>
  
                                 
                        
            </div><!-- /row -->
 
            
            </div>
            </div>
        </form>
    </div> <!-- /container -->
 
    <div id="ajaxGetUserServletResponse"></div>
            
    </div>    
</section>            
  <script src="resources/bootstrap-3.3.7-dist/js/bootstrap-tooltip.js"></script>
    <script src="resources/bootstrap-3.3.7-dist/js/bootstrap-popover.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>
 
    <!--<script src="js/hikeList.js"></script>-->
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
         
        "footerCallback": function (row, data, start, end, display ) {
            
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
            
            