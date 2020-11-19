 <!-- Main content -->

 <section class="content" onload="search1();">

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">JOB CART LIST</h3>
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
                        <th>CARD NO</th>
                        <th>JOB NO</th>  
                        <th>CUSTOMER</th>
                        <th>MAKE</th>
                        <th>SIZE</th> 
                        <th>SERIAL NO</th>  
                        <th>TYPE</th>  
                        <th>PEN</th>  
                    </tr>
                </thead>


                <tbody>
                    <?php
                    $i=1;
                    include './connection_sql.php';

                    $sql = "select * from t_jobcard WHERE STEP='0'  ";


                    foreach ($conn->query($sql) as $row) {




                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $row['cardno']; ?></td>
                            <td><?php echo $row['jobno']; ?></td>   
                            <td><?php echo $row['cuscode'].'-'.$row['cusname']; ?></td>   
                            <td><?php echo $row['make']; ?></td> 
                            <td><?php echo $row['tsize']; ?></td>   
                            <td><?php echo $row['serialno']; ?></td>   
                            <td><?php echo $row['j_type']; ?></td>  
                            <td><select id='pen' onblur="uptype(<?php echo $row['id']; ?>);"  class ="form-control input-sm" >
                                <option value="YES">YES</option>";
                                <option value="NO">NO</option>";

                            </select>
                        </td>   
                        <td><?php echo $row['PEN']; ?></td>    



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
    var url = "credit_note_app_data.php";                                 
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



function uptype(cdate) {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }
    alert('s');
    var msg = confirm("Do you want to Continue this ! ");
    if (msg == true) {
        var url = "tyremanufacture_data.php";
        var params ="Command="+"uptype";    
        params = params + "&id=" + cdate;
        params = params + "&pen=" + document.getElementById('pen').value;

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



function uptype1() {
    // var msg = confirm("Do you want to Insert This ! ");
    // if (msg == true) {
        xmlHttp = GetXmlHttpObject();
        if (xmlHttp == null) {
            alert("Browser does not support HTTP Request");
            return;
        }
        // document.getElementById('msg_box').innerHTML = "";

        var url = "tyremanufacture_data.php";
        var params = "Command=" + "uptype1";

        var count = document.getElementById('item_count').value;
        params = params + "&count=" + count;
        var i = 1;
        while (count > i) {

            var id = "id" + i;
            var pen = "pen" + i; 


            params = params + '&' + id + '=' + document.getElementById(id).value;
            params = params + '&' + pen + '=' + document.getElementById(pen).value; 

            i = i + 1;
        }

        xmlHttp.open("POST", url, true);

        xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlHttp.setRequestHeader("Content-length", params.length);
        xmlHttp.setRequestHeader("Connection", "close");

        // xmlHttp.onreadystatechange = salessaveresult;

        xmlHttp.send(params);
    }
// }

</script>
