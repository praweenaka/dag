<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<section class="content">
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
                <td onclick="name(this);">
                    gdfgdf
                </td>
            </td>   


        </tr>

        <?php
        $i= $i+1;
    }
    ?>
</tbody>
</table>




<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  Launch demo modal
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>



</section>


<script>
    function name(subNode) {


        var row = subNode.parentNode;

        // console.log(row.cells[0]);

        var cell_0 = row.cells[0].innerHTML;
        console.log(cell_0);
        var cell_1 = row.cells[1].innerHTML;
        console.log(cell_1);
        var cell_2 = row.cells[2].innerHTML;
        console.log(cell_2);
        var cell_3 = row.cells[3].innerHTML;
        console.log(cell_3);
        var cell_4 = row.cells[4].innerHTML;
        console.log(cell_4);
        var cell_5 = row.cells[5].innerHTML;
        console.log(cell_5);
        var cell_6 = row.cells[6].innerHTML;
        console.log(cell_6);
        var cell_7 = row.cells[7].innerHTML;
        console.log(cell_7);
         // $("#exampleModal").modal("show");
    }
</script>