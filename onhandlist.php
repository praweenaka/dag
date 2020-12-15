 <!-- Main content -->

 <section class="content" onload="search1();">

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">ONHAND LIST</h3>
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

                    $sql = "select * from dag_item WHERE flag='0' and cancel='0' ";


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

   function search1() {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }
    var url = "onhandlist_data.php";                                 
    var params ="Command="+"search";    
    params = params + "&search=" + document.getElementById('search').value;


    xmlHttp.open("POST", url, true);

    xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlHttp.setRequestHeader("Content-length", params.length);
    xmlHttp.setRequestHeader("Connection", "close");

    xmlHttp.onreadystatechange=re_search;

    xmlHttp.send(params);  

}

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
