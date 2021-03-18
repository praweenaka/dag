<!-- Main content -->
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">CREATE CREDIT NOTE</h3>
            <h4 style="float: right;height: 3px;"><b id="time"></b></h4>
        </div>
        <form role="form" class="form-horizontal">
            <div class="box-body">
                <div class="form-group">
                    <a onclick="new_inv();" class="btn btn-default">
                        <span class="fa fa-user-plus"></span> &nbsp; New
                    </a>
                    <a onclick="save_inv();" class="btn btn-success">
                        <span class="fa fa-save"></span> &nbsp; Save
                    </a> 
                    <a onclick="print_inv();" class="btn btn-default btn-sm">
                        <span class="fa fa-print"></span> &nbsp; Print
                    </a>
                    <a onclick="delete_crn();" class="btn btn-danger">
                        <span class="fa fa-trash"></span> &nbsp; Cancel
                    </a>
                    <a onclick="NewWindow('creditnote_search.php', 'mywin', '800', '700', 'yes', 'center');" class="btn btn-info btn-sm">
                        <span class="glyphicon glyphicon-search"></span> &nbsp; FIND
                    </a> 

                </div>

                <input type="hidden" id="uniq" class="form-control">

                <div id="msg_box"  class="span12 text-center"  >  </div>

            </div>

            <div class="form-group">
                <label class="col-sm-1 control-label" for="txt_usernm">CRN NO</label>
                <div class="col-sm-2">
                    <input type="text" placeholder="CRN NO" id="crnno" disabled class="form-control">
                </div>

                <label class="col-sm-1 control-label" for="txt_usernm">DEPARTMENT</label>
                <div class="col-sm-2">
                    <select name="department" id="department" onchange="setjobno();"   class="text_purchase3 col-sm-9 form-control" > 
                        <?php
                        require_once("./connection_sql.php");

                        $sql = "Select * from s_stomas order by code";
                        foreach ($conn->query($sql) as $row) {
                            echo "<option value=\"" . $row["CODE"] . "\">" . $row["DESCRIPTION"] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-sm-2"></div>
                <label class="col-sm-1 control-label" for="txt_usernm">DATE</label>
                <div class="col-sm-2">
                    <input type="text" placeholder="DATE" id="crndate" value="<?php echo date('Y-m-d')?>"  class="form-control dt">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-1 control-label" for="txt_usernm">CUSTOMER CODE</label>
                <div class="col-sm-2">
                    <input type="text" placeholder="CUSTOMER CODE" id="cus_code" disabled   class="form-control">
                </div>
                <label class="col-sm-1 control-label" for="txt_usernm">CUSTOMER NAME</label>
                <div class="col-sm-2">
                    <input type="text" placeholder="NAME" id="cus_name" disabled=""  class="form-control">
                </div> 
                <div class="col-sm-1">
                    <a onfocus="this.blur()" onclick="NewWindow('creditnote_cus_search.php', 'mywin', '800', '700', 'yes', 'center');
                    return false" href="">
                    <input type="button" class="btn btn-danger" value="..." id="searchcust" name="searchcust">
                </a>
            </div>  

            <label class="col-sm-1  " for="txt_usernm">INVOICE NO</label>
            <div class="col-sm-2">
                <input type="number" placeholder="INVOICE NO" id="invno" disabled  class="form-control">
            </div>
            <div class="col-sm-1">
                <a onfocus="this.blur()" onclick="NewWindow('creditnote_inv_search.php', 'mywin', '800', '700', 'yes', 'center');
                return false" href="">
                <input type="button" class="btn btn-danger" value="..." id="searchcust" name="searchcust">
            </a>
        </div>  
    </div>

    <div class="form-group"> 

        <label class="col-sm-1 control-label" for="txt_usernm">SALES.EX</label>
        <div class="col-sm-2"> 
            <select id="salesrep" class="form-control input-sm" >
                <?php 
                include './connection_sql.php';
                $sql = "select * from s_salrep WHERE cancel='0' order by REPCODE "; 
                foreach ($conn->query($sql) as $row) {
                    echo "<option value='" . $row["REPCODE"] . "'>" . $row["REPCODE"] . " " . $row["Name"] . "</option>";
                }


                ?>
            </select>
        </div> 
              
        <div class="col-sm-1"></div>
        <div class="col-sm-3"></div>
        <label class="col-sm-1  " for="txt_usernm">INVOICE DATE</label>
        <div class="col-sm-2">
            <input type="number" placeholder="INVOICE DATE" id="inv_date" disabled  class="form-control">
        </div> 
    </div>



    <div class="form-group">
        <label class="col-sm-1 control-label" for="invno">AMOUNT</label> 
        <div class="col-sm-2"> 
            <input type="number" placeholder="AMOUNT" id="amount" class="form-control input-sm">
        </div> 
        <div class="col-sm-1"></div>
        <div class="col-sm-3"></div>
        <label class="col-sm-1  " for="txt_usernm">INVOICE AMOUNT</label>
        <div class="col-sm-2">
            <input type="number" placeholder="INVOICE AMOUNT" id="invamount" disabled  class="form-control">
        </div> 
    </div> 

    <div class="form-group">
        <label class="col-sm-1 control-label" for="txt_usernm">REMARK</label>
        <div class="col-sm-2">
            <textarea name="C" id="remarks" cols="60" rows="3" class="form-control"></textarea>
        </div>   
        <div class="col-sm-1"></div>
        <div class="col-sm-3"></div>
        <label class="col-sm-1  " for="txt_usernm">INVOICE BALANCE</label>
        <div class="col-sm-2">
            <input type="number" placeholder="INVOICE BALANCE" id="invbal" disabled  class="form-control">
        </div> 
    </div>

    <div class="form-group"></div>
    <div class="form-group"></div>

    <div id="itemdetails"></div>

</div>

</form>
</div>

</section>

<script src="js/creditnote.js"></script>
<script>new_inv();</script>