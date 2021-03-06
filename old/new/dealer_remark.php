<?php
include './connection_sql.php';
?>

<!-- Main content -->

<section class="content">



    <div class="box box-primary">

        <div class="box-header with-border">

            <h3 class="box-title">Sales Ex. Daily Routine</h3>

        </div>

        <form  name= "form1"  role="form" class="form-horizontal">

            <div class="box-body">



                <div class="form-group">

                    <a onclick="location.reload();" class="btn btn-primary btn-sm">
                        <span class="fa fa-user-plus"></span> &nbsp; New
                    </a>
                    <a onclick="save();" class="btn btn-success btn-sm">
                        <span class="fa fa-save"></span> &nbsp; Save
                    </a>

                </div>



                <div id="msg_box"  class="span12 text-center"  >



                </div>

                <div class="form-group">



                    <label class="col-sm-1 control-label">Rep</label>

                    <div class="col-sm-5">    

                        <select id="sal_ex" class="form-control" onchange="setRep()">

                            <?php
                            require_once ("connectioni.php");

//                            $_SESSION["CURRENT_REP"] = 64;
                            if ($_SESSION["MANAGER"] != "") {
                                $sql = "select * from s_salrep where cancel='1' and manager='".$_SESSION["MANAGER"]."' order by REPCODE";
                                $result = mysqli_query($GLOBALS['dbinv'], $sql) or die("select :" . mysqli_error($GLOBALS['dbinv']));
                                $row = mysqli_fetch_array($result);
                                echo "<option value='" . $row["REPCODE"] . "'>" . $row["REPCODE"] . " " . $row["Name"] . "</option>";
                            } else if ($_SESSION["CURRENT_REP"] != "") {
                                $_SESSION["refRep"] = $_SESSION["CURRENT_REP"];
                                $sql = "select * from s_salrep where cancel='1' and REPCODE = '" . $_SESSION["CURRENT_REP"] . "' order by REPCODE";
                                $result = mysqli_query($GLOBALS['dbinv'], $sql) or die("select :" . mysqli_error($GLOBALS['dbinv']));
                                $row = mysqli_fetch_array($result);
                                echo "<option value='" . $row["REPCODE"] . "'>" . $row["REPCODE"] . " " . $row["Name"] . "</option>";
                            } else {
                                $_SESSION["refRep"] = "All";
                                $sql = "select * from s_salrep where cancel='1' order by REPCODE";
                                $result = mysqli_query($GLOBALS['dbinv'], $sql) or die("select :" . mysqli_error($GLOBALS['dbinv']));
                                while ($row = mysqli_fetch_array($result)) {
                                    echo "<option value='" . $row["REPCODE"] . "'>" . $row["REPCODE"] . " " . $row["Name"] . "</option>";
                                }
                            }
                            ?>

                        </select>

                    </div>

                    <!--                    <div class="col-sm-1">
                    
                                            <a onfocus="this.blur()" onclick="NewWindow('serach_remark.php', 'mywin', '800', '700', 'yes', 'center');
                    
                                                    return false" href="">
                    
                                                <input type="button" class="btn btn-default" value="Find" id="searchRecords" name="searchRecords">
                    
                                            </a>
                    
                                        </div>-->

                                    </div>

                                    <input type="hidden"  id="tmpno" >


                                    <div class="form-group">

                                        <label class="col-sm-1 control-label">Date</label>

                                        <div class="col-sm-2">

                                            <input type="date" placeholder="Date" id="invdate" value="<?php echo date('Y-m-d'); ?>" class="form-control dt">

                                        </div>


                                        <label class="col-sm-1 control-label">Start Time</label>

                                        <div class="col-sm-2">

                                            <input type="time" placeholder="Date" id="stime"   class="form-control">

                                        </div>

                                    </div>

                                    <div class="form-group">

                                        <label class="col-sm-1 control-label"></label>

                                        <div class="col-sm-2">


                                        </div>


                                        <label class="col-sm-1 control-label">Finish Time</label>

                                        <div class="col-sm-2">

                                            <input type="time" placeholder="Date" id="ftime"  class="form-control">

                                        </div>

                                    </div>

                                    <div class="form-group">

                                        <label class="col-sm-1 control-label">Route</label>



                                        <div class="col-sm-5">

                                            <textarea id="txt_remarks" class="form-control input-sm"></textarea>
                                        </div>


                                    </div>





                                    <div class="form-group">

                                        <label class="col-sm-1 control-label">Total Visited Dealers</label>

                                        <div class="col-sm-5">

                                            <input type="text" placeholder="Dealer Count" id="loc" value="" class="form-control input-sm">

                                        </div>





                                    </div>

                                    <div class="form-group">



                                        <label class="col-sm-2 control-label">Meter Reading</label>


                                        <label class="col-sm-2 control-label">Starting</label>
                                        <div class="col-sm-2">

                                            <input type="text" placeholder=""  id="mstart" value="" class="form-control input-sm">

                                        </div>
                                    </div>
                                    <div class="form-group">

                                        <div class="col-sm-2"></div>
                                        <label class="col-sm-2 control-label">Finish</label>

                                        <div class="col-sm-2">

                                            <input type="text" placeholder="" id="mfini" value="" class="form-control input-sm">

                                        </div>

                                    </div>




                                    <div class="form-group">



                                        <label class="col-sm-2 control-label">Sales Orders Collected</label>


                                        <label class="col-sm-2 control-label">By Visting Dealer</label>
                                        <div class="col-sm-2">

                                            <input type="text" placeholder=""  id="target" value="" class="form-control input-sm">

                                        </div>
                                    </div>
                                    <div class="form-group">

                                        <div class="col-sm-2"></div>
                                        <label class="col-sm-2 control-label">Over The Phone</label>

                                        <div class="col-sm-2">

                                            <input type="text" placeholder="" id="ord" value="" class="form-control input-sm">

                                        </div>

                                    </div>




                                    <div class="form-group">



                                        <label class="col-sm-2 control-label">Total Outstanding Collected</label>


                                        <label class="col-sm-2 control-label">By Visting Dealer</label>
                                        <div class="col-sm-2">

                                            <input type="text" placeholder="" id="outst" value="" class="form-control input-sm">
                                        </div>
                                    </div>
                                    <div class="form-group">

                                        <div class="col-sm-2"></div>
                                        <label class="col-sm-2 control-label">Pronto/Post/Collector</label>

                                        <div class="col-sm-2">

                                            <input type="text" placeholder="" id="outstCltd" value="" class="form-control input-sm">

                                        </div>

                                    </div>



                                    <div class="form-group">



                                        <label class="col-sm-2 control-label">Total RTn Chq Collected</label>


                                        <label class="col-sm-2 control-label">By Visting Dealer</label>
                                        <div class="col-sm-2">

                                            <input type="text" placeholder="" id="retch" value="" class="form-control input-sm">
                                        </div>
                                    </div>
                                    <div class="form-group">

                                        <div class="col-sm-2"></div>
                                        <label class="col-sm-2 control-label">Pronto/Post/Collector</label>

                                        <div class="col-sm-2">

                                            <input type="text" placeholder="" id="retchStld" value="" class="form-control input-sm">

                                        </div>

                                    </div>




                                </div>

                                <div id="itemdetails"></div>

                            </form>

                        </div>



                    </section>



                    <script src="js/dealer_rmk.js">



                    </script>



                    <script>

                        function getLocation() {

                            if (navigator.geolocation) {

                                navigator.geolocation.getCurrentPosition(savePosition, positionError, {timeout: 20000});

                            } else {

            //Geolocation is not supported by this browser

        }

    }



    // handle the error here

    function positionError(error) {

        var errorCode = error.code;

        var message = error.message;



        alert(message);

    }



    function savePosition(position) {

        $.post("geocoordinates.php", {fun: 'getloc', lat: position.coords.latitude, lng: position.coords.longitude})
        .done(function(data) {
            document.getElementById('loc').value = data;
        });
    }
    setRep();
    </script><?php
    include './cancell.php';
    ?>



