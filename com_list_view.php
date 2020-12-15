
<!-- Full Details -->
<?php
date_default_timezone_set("Asia/Colombo");
include './connection_sql.php';
$sql1 = "Select * from dag_item where id='".$row['id']."'";
$result1 = $conn->query($sql1);
$row1 = $result1->fetch();

?>
<div class="modal fade" id="detail<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div class="col-sm-5">
                 <center><h4 class="modal-title" id="myModalLabel">PRODUCTION</h4></center>
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
                <span class="pull-left">Customer: <strong><?php echo ucwords($row['cusname']); ?></strong></span>
                <span class="pull-right">REG.DATE: <strong><?php echo $row['sdate']; ?></strong></span>

            </div>
            <div class="col-lg-12">
                <span class="pull-left">JOB NO: <strong><?php echo ucwords($row['refno']); ?></strong></span>
                <span class="pull-right">SERIAL NO: <strong><?php echo $row['serialno']; ?></strong></span>
            </div>
            <div class="col-lg-12">
                <span class="pull-left">MAKE: <strong><?php echo ucwords($row['marker']); ?></strong></span>
                <span class="pull-right">TYPE: <strong><?php echo ""; ?></strong></span>
            </div>
            <div class="col-lg-12">
                <span class="pull-left">SEND DATE: <strong><?php echo ucwords($row['sdate']); ?></strong></span>
                <span class="pull-right">TOTAL AMOUNT <strong><?php echo number_format($row['adpayment'],2); ?></strong></span>
            </div>

        </div>
        <div style="height:10px;"></div>





        <div class="form-group"> 

            <ul class="nav nav-tabs" id="myTab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">SPARE ITEM</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">JOB WORKERS</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">FINISH</a>
            </li>
        </ul>
    </div>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
         <div class="row">
            <div class="col-lg-12">
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
                            <td> <select name="spareitem" id="spareitem"    class="text_purchase3 col-sm-9 form-control" > 
                                <?php
                                require_once("./connection_sql.php");

                                $sql = "Select * from size order by code";
                                foreach ($conn->query($sql) as $row) {
                                    echo "<option value=\"" . $row["name"] . "\">" . $row["name"] . "</option>";
                                }
                                ?>
                            </select></td>
                            <td><input type="number" placeholder="PRICE" id="price"   class="form-control"></td>
                            <td><input type="number" placeholder="QTY" id="qty"   class="form-control"></td>
                            <td><input type="number" placeholder="TOTAL" id="total"    class="form-control"></td>
                            <td><a onclick="add_spare('g/56','test');" class="btn btn-default btn-sm"> <span class="fa fa-plus"></span> &nbsp; </a></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php



                        $total = 0;
                        $pd = "select * from produ_spareitem where refno='" . $row1['refno'] . "' and  serialno='".$row1['serialno']."'";
                        foreach ($conn->query($pd) as $pdrow) {
                            ?>
                            <tr> 
                                <td align="right"><?php echo $row['spareitem'] ; ?></td>  
                                <td align="right"><?php echo number_format($pdrow['price'], 2); ?></td> 
                                <td align="right"><?php echo number_format($pdrow['qty'], 2); ?></td> 
                                <td align="right"><?php echo number_format($pdrow['total'], 2); ?></td> 

                                <?php
                                $subtotal = $pdrow['total']; 
                                $total += $subtotal;
                                ?>

                            </tr>
                            <?php
                        }
                        ?>
                        <div id="itemdetails" > </div>
                        <tr>
                            <td align="right" colspan="3"><strong>Total</strong></td>
                            <td align="right"><strong><?php echo number_format($total, 2); ?></strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div> 
    </div>

    <!-- =================================================================================== -->
    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">

     <div class="row">
        <div class="col-lg-12">
            <table width="100%" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>NAME</th> 
                        <th>HOURS</th> 
                        <th>#</th> 
                    </tr>
                    
                </thead>
                <tbody>
                    <?php



                    $total = 0;
                    $pd = "select * from produ_workers where refno='" . $row1['refno'] . "' and  serialno='".$row1['serialno']."'"; 
                    foreach ($conn->query($pd) as $pdrow) {
                        ?>
                        <tr>  
                            <td align="right"><?php echo number_format($pdrow['workers'], 2); ?></td> 
                            <td align="right"><?php echo number_format($pdrow['hours'], 2); ?></td>  

                            <?php
                            $subtotal = $pdrow['hours']; 
                            $total += $subtotal;
                            ?>

                        </tr>
                        <?php
                    }
                    ?>
                    <div id="itemdetails1" > </div>
                    <tr>
                        <td align="right" colspan="3"><strong>Total</strong></td>
                        <td align="right"><strong><?php echo number_format($total, 2); ?></strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div> 
</div>

</div>



<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
</div>
</div>
</div>
</div>
