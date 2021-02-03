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
</style>
 <section class="content" onload="search1();">

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">ONHAND LIST</h3>
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
                        <th>BELT</th>  
                        <th>SERIAL NO</th>  
                        <th>CASING COST</th>  
                        <th>REMARK</th>  
                        <th></th>  
                    </tr>
                </thead>


                <tbody>
                    <?php
                    $i=1;
                    include './connection_sql.php';

                    $sql = "select * from dag_item WHERE flag='0' and cancel='0' ";


                    foreach ($conn->query($sql) as $row) {


                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>  
                            <td><?php echo $row['jobno']; ?></td>   
                            <td><?php echo $row['refno']; ?></td> 
                            <td><?php echo $row['sdate']; ?></td>   
                            <td><?php echo $row['cuscode'].'-'.$row['cusname']; ?></td> 
                            <td><?php echo $row['marker']; ?></td>   
                            <td><?php echo $row['size']; ?></td>   
                            <td><?php echo $row['belt']; ?></td>   
                            <td><?php echo $row['serialno']; ?></td>   
                            <td><?php echo $row['cascost']; ?></td>  
                            <td><?php echo $row['remark']; ?></td>  
                            <td> <a onclick="sendproduction('<?php echo $row['id']; ?>');" class="btn btn-primary">
                                <span class="fa fa-mail-forward"></span> &nbsp; SEND TO PRODUCTION
                            </a> 
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

<!--<script src="js/medical_approve.js"></script>-->
<script>
 

function re_search()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {


        document.getElementById('dataTables-example').innerHTML = xmlHttp.responseText;



    }
}



function sendproduction(cdate) {
 
    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }
    
    var msg = confirm("Do you want to Continue this ! ");
    if (msg == true) {
        var url = "onhandlist_data.php";
        var params ="Command="+"sendproduction";    
        params = params + "&id=" + cdate; 

        xmlHttp.open("POST", url, true);

        xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlHttp.setRequestHeader("Content-length", params.length);
        xmlHttp.setRequestHeader("Connection", "close");

        xmlHttp.onreadystatechange=item_del;

        xmlHttp.send(params);  

    }
}


function item_del() {

    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {
        alert(xmlHttp.responseText);
        setTimeout("location.reload(true);", 500);
    }
}


</script>

<script type="text/javascript">
                $(document).ready(function() {
          var table = $('#dataTables-example').DataTable( {
             lengthChange: true,
            fixedHeader: true,
            responsive: true,
            "deferRender": true, 
             "order": [[ 0, 'asc' ]], 
               dom: 'Bfrtip',
        lengthMenu: [[ 25, 50,100, -1 ],[ '25 rows', '50 rows', '100 rows', 'Show all' ]],
         "pageLength": -1,
        buttons: [
            'pageLength','print','colvis'
        ]
             
        
            

        } );

$('div.dataTables_filter input', table.table().container()).focus();
          table.buttons().container()
          .appendTo( '#example_wrapper .col-md-6:eq(0)' );
           
      } );
        </script>
