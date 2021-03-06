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
            <h3 class="box-title">AUDIT TRAIL</h3>
        </div>
        <form role="form" class="form-horizontal">
            <div class="box-body"> 
                <div class="panel-body" style="overflow-x: auto">
                     
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example" style="width:auto">
                    <thead> 

                     <tr class="danger">
                        <th>#</th> 
                        <th>REF NO</th>
                        <th>DATE/TIME</th>   
                        <th>USER</th> 
                        <th>TYPE</th>  
                        <th>TASK</th>         
                    </tr>
                </thead>


                <tbody>
                    <?php
                    $i=1;
                    include './connection_sql.php';

                    $sql = "select * from entry_log  ";


                    foreach ($conn->query($sql) as $row) {
                        

                        ?>
                        <tr>
                            <td> </td> 
                            <td onclick="name(this)"><?php echo $row['refno']; ?></td> 
                            <td onclick="name(this)"><?php echo $row['stime']; ?></td>   
                            <td onclick="name(this)"><?php echo $row['username']; ?></td>   
                            <td onclick="name(this)"><?php echo $row['trnType']; ?></td>   
                            <td onclick="name(this)"><?php echo $row['docname']; ?></td>     
                            
                        </td>   


                    </tr>

                    <?php
                    $i= $i+1;
                }
                ?>
            </tbody>
        </table>

    </div>

     



</div>
</form>
</div>
</section>

<!--<script src="js/all_list.js"></script>-->
<script>



    
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