<!-- Modal -->
<div class="container">
    <div class="modal fade" id="myModal_search" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-dialog1" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Search Item</h4>
                </div>
                <div class="modal-body">


                    <div class="modal-body" >


                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="firstname_hidden">Brand Name</label>
                            <div class="col-sm-4">
                                <select id="cmbbrand" onchange="search_itm('');" width='120' class="form-control input-sm" >
                                    <option value='All'>All</option>
                                    <?php
                                    if (($_SESSION["CURRENT_DEP"] != "") and (!is_numeric($_SESSION["CURRENT_DEP"]))) {
                                        $sql = "select * from brand_mas where act ='1' and costcenter='" . $_SESSION["CURRENT_DEP"] . "' order by barnd_name";
                                    } else {
                                        $sql = "select * from brand_mas where act ='1' order by barnd_name";
                                    }
                                    $result = mysqli_query($GLOBALS['dbinv'], $sql);
                                    while ($row = mysqli_fetch_array($result)) {
                                        echo "<option value='" . $row["barnd_name"] . "'>" . $row["barnd_name"] . "</option>";
                                    }
                                     
                                    ?>
                                </select>
                            </div> 

                            <div class="checkbox">
                                <label class="col-sm-3 pull-right"><input onclick="search_itm('');" id="chk_stockall" type="checkbox" value="">All Item</label>
                                <label class="col-sm-3 pull-right"><input onclick="search_itm('');" id="chk_stock" type="checkbox" value="">Stock Item Only</label>
                            </div>


                        </div><br>

                        <div class="form-group">
                            <table style="table-layout: fixed;word-wrap: break-word;" class="table table-striped">
                                <tr>
                                    <th style="width: 11%">Item Code</th>
                                    <th>Item Description</th>
                                    <th style="width: 30%">Brand</th>
                                    <th style="width: 10%">Qty In Hand</th>
                                    <th style="width: 10%">Price</th>
                                </tr>
                                <tr>
                                    <td><input class="form-control input-sm" onkeyup="search_itm('');" id="sstk_no"></td>
                                    <td><input class="form-control input-sm" onkeyup="search_itm('');" id="sdescript"></td>
                                    <td><input class="form-control input-sm" onkeyup="search_itm('');" id="sbrand"></td>
                                    <td></td>
                                    <td></td>
                                </tr>

                            </table>


                        </div> 
                        <div style="height: 350px;overflow: scroll;" id="search_res">

                        </div>


                    </div>
                    <input type="hidden" id="action">
                    <input type="hidden" id="form">


                    <span   id="txterror">

                    </span>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>