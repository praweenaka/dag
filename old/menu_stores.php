<style type="text/css">
    #display_selected a {
        color: #000;
    }

    #display_notSelected a {
        color: #fff;
    }

</style>
<script src="js/user.js"></script>
<?php
require_once ("connectioni.php");
require_once ("DBConnector.php");
?>
<div id="menus_wrapper">

    <div id="main_menu">
        <ul>
            <li>
                <a href="home.php"><span><span>Home</span></span></a>
            </li>
            <?php
            $sql = "select * from userpermission where username='" . $_SESSION['UserName'] . "' and grp='Master Files' and doc_view=1";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);

            if ($row = mysqli_fetch_array($result)) {
                echo "<li><a href=\"masterfiles.php\" ><span><span>Master Files</span></span></a></li>";
            }

            $sql = "select * from userpermission where username='" . $_SESSION['UserName'] . "' and grp='Data Capture' and doc_view=1";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($row = mysqli_fetch_array($result)) {
                echo "<li><a href=\"datacapture.php\"><span><span>Data Capture</span></span></a></li>";
            }
            $sql = "select * from userpermission where username='" . $_SESSION['UserName'] . "' and grp='Costing' and doc_view=1";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($row = mysqli_fetch_array($result)) {
                echo "<li><a href=\"#\"><span><span>Costing</span></span></a></li>";
            }

            $sql = "select * from userpermission where username='" . $_SESSION['UserName'] . "' and grp='Inquiries' and doc_view=1";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($row = mysqli_fetch_array($result)) {
                echo "<li><a href=\"inquiry.php\" ><span><span>Inquiries</span></span></a></li>";
            }

            $sql = "select * from userpermission where username='" . $_SESSION['UserName'] . "' and grp='Analysis' and doc_view=1";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($row = mysqli_fetch_array($result)) {
                echo "<li><a href=\"#\"><span><span>Analysis</span></span></a></li>";
            }

            $sql = "select * from userpermission where username='" . $_SESSION['UserName'] . "' and grp='Delivery' and doc_view=1";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($row = mysqli_fetch_array($result)) {
                echo "<li><a href=\"#\"><span><span>Delivery</span></span></a></li>";
            }

            $sql = "select * from userpermission where username='" . $_SESSION['UserName'] . "' and (grp='Reports-Sales' or grp='Reports-Customer' or grp='Reports-Other' or grp='Reports-Stock') and doc_view=1";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($row = mysqli_fetch_array($result)) {
                echo "<li><a href=\"reports.php\"><span><span>Reports</span></span></a></li>";
            }

            $sql = "select * from userpermission where username='" . $_SESSION['UserName'] . "' and grp='System Utilities' and doc_view=1";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($row = mysqli_fetch_array($result)) {
                echo "<li><a href=\"utility.php\"><span><span>System Utilities</span></span></a></li>";
            }

            // $sql = "select * from userpermission where username='" . $_SESSION['UserName'] . "' and grp='Stores' and doc_view=1";
            // $result = mysqli_query($GLOBALS['dbinv'], $sql);
            // if ($row = mysqli_fetch_array($result)) {
            //     echo "<li><a href=\"stores.php\" class=\"selected\"><span><span>Stores</span></span></a></li>";
            // }

            $sql = "select * from userpermission where username='" . $_SESSION['UserName'] . "' and grp='Administration' and doc_view=1";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($row = mysqli_fetch_array($result)) {
                echo "<li><a href=\"administration.php\"><span><span>Administration</span></span></a></li>";
            }

            $sql = "select * from userpermission where username='" . $_SESSION['UserName'] . "' and grp='Inventory' and doc_view=1";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($row = mysqli_fetch_array($result)) {
                echo "<li><a href=\"inventory.php\"><span><span>Inventory</span></span></a></li>";
            }
            ?>

            <li class="last" onclick="logout();"><a href="#"><span><span>Logout</span></span></a></li>
        </ul>
    </div>

    <div id="sec_menu">
        <ul>
<?php
$sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='ARN' and grp='Stores' and doc_view=1 and block='0'";
$result = mysqli_query($GLOBALS['dbinv'], $sql);
if ($row = mysqli_fetch_array($result)) {
    echo "<li><a href=\"stores/arn.php\" target=\"_blank\" class=\"sm1\" >ARN</a></li>";
}

$sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Sales Invoice' and grp='Stores' and doc_view=1 and block='0'";
$result = mysqli_query($GLOBALS['dbinv'], $sql);
if ($row = mysqli_fetch_array($result)) {
    echo "<li><a href=\"stores/sales_inv.php\" target=\"_blank\" class=\"sm1\" >Sales Invoice</a></li>";
}

$sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='GRN' and grp='Stores' and doc_view=1 and block='0'";
$result = mysqli_query($GLOBALS['dbinv'], $sql);
if ($row = mysqli_fetch_array($result)) {
    echo "<li><a href=\"stores/grn.php\" target=\"_blank\" class=\"sm1\" >GRN</a></li>";
}

$sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Purchase Return' and grp='Stores' and doc_view=1 and block='0'";
$result = mysqli_query($GLOBALS['dbinv'], $sql);
if ($row = mysqli_fetch_array($result)) {
    echo "<li><a href=\"stores/purchase_ret.php\" target=\"_blank\" class=\"sm1\" >Purchase Return</a></li>";
}

$sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Stock Adjustment' and grp='Stores' and doc_view=1 and block='0'";
$result = mysqli_query($GLOBALS['dbinv'], $sql);
if ($row = mysqli_fetch_array($result)) {
    echo "<li><a href=\"stores/stock_adjustment.php\" target=\"_blank\" class=\"sm1\" >Stock Adjustment</a></li>";
}

$sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Bin Card' and grp='Stores' and doc_view=1 and block='0'";
$result = mysqli_query($GLOBALS['dbinv'], $sql);
if ($row = mysqli_fetch_array($result)) {
    echo "<li><a href=\"stores/bin_card.php\" target=\"_blank\" class=\"sm1\" >Bin Card</a></li>";
}

$sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Delivery Date Report' and grp='Stores' and doc_view=1 and block='0'";
$result = mysqli_query($GLOBALS['dbinv'], $sql);
if ($row = mysqli_fetch_array($result)) {
    echo "<li><a href=\"stores/rep_stores_del_date.php\" target=\"_blank\" class=\"sm1\" >Delivery Date Report</a></li>";
}

$sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='View Serial No' and grp='Stores' and doc_view=1 and block='0'";
$result = mysqli_query($GLOBALS['dbinv'], $sql);
if ($row = mysqli_fetch_array($result)) {
    echo "<li><a href=\"stores/rep_serial.php\" target=\"_blank\" class=\"sm1\" >View Serial No</a></li>";
}

$sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='GIN Stores' and grp='Stores' and doc_view=1 and block='0'";
$result = mysqli_query($GLOBALS['dbinv'], $sql);
if ($row = mysqli_fetch_array($result)) {
    echo "<li><a href=\"stores/gin.php\" target=\"_blank\" class=\"sm1\" >GIN</a></li>";
}


$sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Card' and grp='Stores' and doc_view=1 and block='0'";
$result = mysqli_query($GLOBALS['dbinv'], $sql);
if ($row = mysqli_fetch_array($result)) {
    echo "<li><a href=\"stores/batt_card.php\" target=\"_blank\" class=\"sm1\" >Card</a></li>";
}
$sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Vehicle Report' and grp='Stores' and doc_view=1 and block='0'";
$result = mysqli_query($GLOBALS['dbinv'], $sql);
if ($row = mysqli_fetch_array($result)) {
    echo "<li><a class=\"sm6\" href=\"new/home.php?url=report_vehicle\" target=\"_blank\">Vehicle Report</a></li>"; 
}

$sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and admin='1'";
$result = mysqli_query($GLOBALS['dbinv'], $sql);
if ($row = mysqli_fetch_array($result)) {
    echo "<li><a href=\"stores/stk_update_stk_take_stores.php\" target=\"_blank\" class=\"sm1\" >Stock Update (Stock Take)</a></li>";
    echo "<li><a href=\"stores/stk_update_stores.php\" target=\"_blank\" class=\"sm1\" >Stock Update</a></li>'";
}
?>

        </ul>
    </div>
</div>