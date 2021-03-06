 <!-- Main content -->
 <section class="content" onload="search1();">

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Credit Note Approve</h3>
        </div>
        <form role="form" class="form-horizontal">
            <div class="box-body">


                <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example1">
                     <thead>   
                        <tr>
                        <th width="80%"></th>    
                           <th><input type="text" name="search" placeholder="Search" id="search" onkeyup="search1();" class="form-control input-sm"></th>  
                       </tr>
                   </thead>
               </table>
               <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead> 

                   <tr>
                    <th>#</th>
                    <th>Ref No</th>
                    <th>Date</th>  
                    <th>Customer</th>
                    <th>Remark</th>
                    <th>Amount</th> 
                    <th>Balance</th>  
                    <th>Brand</th>  
                    <th>Action</th>  
                </tr>
            </thead>


            <tbody>
                <?php
                $i=1;
                include './connection_sql.php';

                $sql3 = "Select * from userpermission where username='".$_SESSION["CURRENT_USER"]."' and docid='134' " ;
                $result3 = $conn->query($sql3);
                $row3 = $result3->fetch();

                if($row3['doc_feed']=='1'){
                    $sql = "select * from c_bal WHERE BALANCE>0 and Cancell='0' and trn_type='CNT' and block='1'";
                }else if($row3['doc_mod']=='1'){
                    $sql = "select * from c_bal WHERE BALANCE>0 and Cancell='0' and trn_type='CNT' and block='2'";
                }

                foreach ($conn->query($sql) as $row) {
                    $sql1 = "Select c_name from vender_sub where c_code='".$row['c_code1']."'";
                    $result1 = $conn->query($sql1);
                    $row1 = $result1->fetch();

                    $sql2 = "Select C_REMARK from cred where C_REFNO='".$row['REFNO']."'";
                    $result2 = $conn->query($sql2);
                    $row2 = $result2->fetch();



                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $row['REFNO']; ?></td>
                        <td><?php echo $row['SDATE']; ?></td>   
                        <td><?php echo $row['c_code1'].'-'.$row1['c_name']; ?></td>   
                        <td><?php echo $row2['C_REMARK']; ?></td> 
                        <td><?php echo $row['AMOUNT']; ?></td>   
                        <td><?php echo $row['BALANCE']; ?></td>   
                        <td><?php echo $row['brand']; ?></td>    

                        <td>

                            <?php 
                            
                            if($row3['doc_feed']=='1'){?>
                             <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" onclick="forward1('<?php echo $row['REFNO']; ?>');"  ><i class="fa fa-share"></i> Forward Acc</button>
                         <?php }
                         ?>
                         <?php
                         if($row3['doc_mod']=='1'){?>
                          <button type="button" class="btn btn-success btn-sm" data-toggle="modal" onclick="approve('<?php echo $row['REFNO']; ?>');"  ><i class="fa fa-check "></i> Approve</button> 
                      <?php }
                      ?>


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

function forward1(cdate) {
   
    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }
    var url = "credit_note_app_data.php";                                 
    var params ="Command="+"forward";    
    params = params + "&REFNO=" + cdate;

    xmlHttp.open("POST", url, true);

    xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlHttp.setRequestHeader("Content-length", params.length);
    xmlHttp.setRequestHeader("Connection", "close");

    xmlHttp.onreadystatechange=item_del;

    xmlHttp.send(params);  

}

function approve(cdate) {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

    var msg = confirm("Do you want to Approve this ! ");
    if (msg == true) {
        var url = "credit_note_app_data.php";
        var params ="Command="+"approve";    
        params = params + "&REFNO=" + cdate;

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
