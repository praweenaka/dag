<?php
ini_set('session.gc_maxlifetime', 30 * 60 * 60 * 60);
session_start();
$_SESSION["brand"] = "";
if ($_SESSION["dev"] == "") {
    echo "Invalid User Session";
    exit();
}
?>

<link rel="stylesheet" href="css/themes/redmond/jquery-ui-1.10.3.custom.css" />

<!-- Main content -->
<section class="content">

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Login Report</h3>


            <form role="form" name ="form1" action="login_report_data.php"  target="_blank" method="GET" class="form-horizontal">

                <br>               
                <div style="margin-left: 10px;"class="form-group">
                    <a onclick="myFunction()" class="btn btn-default">
                        <span class="fa fa-user-plus"></span> &nbsp; New

                    </a>
                    <!--                        <a onfocus="this.blur()" onclick="NewWindow('search_tourPlan.php', 'mywin', '800', '700', 'yes', 'center');
                                                    return false" href="">
                                                <input type="button" class="btn btn-find" value="Find" id="searchcust" name="searchcust">
                                            </a>-->

                </div>
                <div id="msg_box"  class="span12 text-center"  ></div>

                <input type="hidden" id="tmpno" class="form-control">
                <input type="hidden" id="item_count" class="form-control">
                <input type="hidden" name="c_subcode" id="c_subcode">

                <input type="hidden" name="balance" id="balance">

                <input type="hidden" name="creditlimit" id="creditlimit">




                <div class="form-group">
                    <div class="col-sm-12">
                        
                        <div class="form-group">
                            <label class="col-sm-1 control-label" for="invno">From Date</label>
                            <div class="col-sm-2">
                                <input type="text" value="<?php echo date('Y-m-d'); ?>" name="from_date" id="from_date" class="form-control input-sm dt">  
                            </div>
                            
                            <label class="col-sm-1 control-label" for="invno">To Date</label>
                            <div class="col-sm-2">
                                <input type="text" value="<?php echo date('Y-m-d'); ?>" name="to_date" id="to_date" class="form-control input-sm dt">  
                            </div>
                            <div class="col-sm-1">
                                <input type="checkbox" name="logchk"    id="logchk" >
                                <input style="margin-left: 50px;" type="submit" name="button" id="button" value="View"   class="btn btn-primary">
                            </div>


                        </div> 


                        <input type="hidden" name="ordno" id="ordno">
                        <input id="uniq" type="hidden" >    
                    </div>
                </div>
                <hr>
                <div class="form-group"></div>
                <div  class='space' >
                    <br>&nbsp;

                </div>
                

            </form>
        </div>
    </div>
</section>
<script>
    function myFunction() {
        location.reload();
    }
</script>
