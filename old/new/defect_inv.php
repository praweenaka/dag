<!-- Main content -->

<section class="content">

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Defect Inventry</h3>
        </div>
        <form role="form" name="form1" action="report_def_inv.php" target="_blank" method="GET" class="form-horizontal">
            <div class="box-body">


                <div class="container">

                    <div class="form-group">
                        <div id="msg_box"  class="span12 text-center"  >
                        </div>


                        <label class="col-sm-1 control-label" for="name">Item</label>
                        <div class="col-sm-2">
                            <input placeholder="Code" disabled="disabled" id="itemCode"   class="form-control input-sm" type="text">
                        </div>
                        <div class="col-sm-4">
                            <input placeholder="Description" id="itemDesc"   class="form-control input-sm" type="text">
                        </div>
                        <div class="col-sm-1">
                            <td>
                                <a href="" onclick="NewWindow('serach_item.php?stname=DEFINV', 'mywin', '800', '700', 'yes', 'center');
                                    return false" onfocus="this.blur()">
                                    <input name="searchcusti" id="searchcusti" value="..." class="btn btn-default btn-sm" type="button">
                                </a>
                            </td>
                        </div>

                        <div class="span6 col-sm-3 pull-right">
                            <div id="submas"> 
                                <table class="table table-bordered">
                                    <tbody><tr>
                                            <th  colspan='2' width="160">Report</th>

                                        </tr><tr>
                                            <td>Brand</td>
                                            <td  align="right">
                                                <select name="cmbbrand" id="cmbbrand"  class="form-control input-sm">
                                                    <option value='All'>All</option>
                                                    <?php
                                                    if (($_SESSION["CURRENT_DEP"] != "") and (!is_numeric($_SESSION["CURRENT_DEP"]))) {
                                                        $sql="select * from brand_mas where act ='1' and costcenter='".$_SESSION["CURRENT_DEP"]."' order by barnd_name"; 
                                                    }else{
                                                        $sql="select * from brand_mas where act ='1' order by barnd_name";
                                                    } 
                                                    $result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
                                                    while($row = mysqli_fetch_array($result)){
                                                         echo "<option value='".$row["barnd_name"]."'>".$row["barnd_name"]."</option>";
                                                    }
                                                    ?>
                                                </select>

                                            </td></tr>
                                        <tr><td><input name="button" id="button" value="View" type="submit"></td></tr>	
                                    </tbody>
                                </table></div>
                        </div>
                        <br><br>
                        <div id="itemdetail" class="col-sm-8">



                        </div>
                    </div>







                </div>
        </form>
    </div>

</section>

<script src="js/cusmas.js"></script>

