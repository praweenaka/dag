
<script src="js/user.js"></script>
<?php
require_once("connectioni.php");
?>
<div id="menus_wrapper">





    <div id="main_menu">
        <?php
        ?>
        <ul>
            <li><a href="home.php" class="selected"><span><span>Home</span></span></a></li>
            <?php
            $sql = "select * from userpermission where username='" . $_SESSION['UserName'] . "' and grp='Master Files' and doc_view=1";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);

            if ($row = mysqli_fetch_array($result)) {
                echo "<li><a href=\"masterfiles.php\"  ><span><span>Master Files</span></span></a></li>";
            }

            $sql = "select * from userpermission where username='" . $_SESSION['UserName'] . "' and grp='Data Capture' and doc_view=1";

            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($row = mysqli_fetch_array($result)) {
                echo "<li><a href=\"datacapture.php\"><span><span>Data Capture</span></span></a></li>";
            }



            $sql = "select * from userpermission where username='" . $_SESSION['UserName'] . "' and grp='Costing' and doc_view=1";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($row = mysqli_fetch_array($result)) {
                echo "<li><a href=\"costing.php\"><span><span>Costing</span></span></a></li>";
            }

            $sql = "select * from userpermission where username='" . $_SESSION['UserName'] . "' and grp='Inquiries' and doc_view=1";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($row = mysqli_fetch_array($result)) {
                echo "<li><a href=\"inquiry.php\"><span><span>Inquiries</span></span></a></li>";
            }
            $sql = "select * from userpermission where username='" . $_SESSION['UserName'] . "' and (grp='Reports-Sales' or grp='Reports-Customer' or grp='Reports-Other' or grp='Reports-Stock') and doc_view=1";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($row = mysqli_fetch_array($result)) {
                echo "<li><a href=\"reports.php\"><span><span>Reports</span></span></a></li>";
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
            $sql = "select * from userpermission where username='" . $_SESSION['UserName'] . "' and grp='System Utilities' and doc_view=1";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($row = mysqli_fetch_array($result)) {
                echo "<li><a href=\"utility.php\"><span><span>System Utilities</span></span></a></li>";
            }

            // $sql = "select * from userpermission where username='" . $_SESSION['UserName'] . "' and grp='Stores' and doc_view=1";
            // $result = mysqli_query($GLOBALS['dbinv'], $sql);
            // if ($row = mysqli_fetch_array($result)) {
            //     echo "<li><a href=\"stores.php\"><span><span>Stores</span></span></a></li>";
            // }
            $sql = "select * from userpermission where username='" . $_SESSION['UserName'] . "' and grp='Administration' and doc_view=1";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($row = mysqli_fetch_array($result)) {
                echo "<li><a href=\"administration.php\"><span><span>Administration</span></span></a></li>";
            }



            $sql = "select * from userpermission where username='" . $_SESSION['UserName'] . "' and grp='Inventory' and doc_view=1";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($row = mysqli_fetch_array($result)) {
                echo "<li><a href=\"Inventory.php\"><span><span>Inventory</span></span></a></li>";
            }
            
            ?>	
            <li class="last" onclick="logout()
                            ;"><a href="#"><span><span>Logout</span></span></a></li>
        </ul>
    </div>



    <div id="sec_menu">
        <ul>
            <?php
            $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Dealer Remark' and grp='home' and doc_view=1 and block='0'";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($row = mysqli_fetch_array($result)) {
                echo "<li><a class=\"sm6\" href=\"new\home.php?url=dealer_remark\" target=\"_blank\">Sales Ex. Checkin</a></li>";
            }
            $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Rep Profile' and grp='home' and doc_view=1 and block='0'";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($row = mysqli_fetch_array($result)) {
                echo "<li><a class=\"sm6\" href=\"new\home.php?url=rep_profile\" target=\"_blank\">Rep Profile</a></li>";
            }
            $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Stock Report' and grp='Reports-Stock' and doc_view=1 and block='0'";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($row = mysqli_fetch_array($result)) {
                echo "<li><a class=\"sm6\" href=\"rep_stock.php\" target=\"_blank\">Stock Report</a></li>";
            }

            $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Customer Current Status' and grp='Reports-Customer' and doc_view=1 and block='0'";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($row = mysqli_fetch_array($result)) {
                echo "<li><a class=\"sm6\" href=\"rep_customer_current.php\" target=\"_blank\">Customer Currnet Status</a></li>";
            }

            $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Return Cheque' and  grp='Reports-Customer' and doc_view=1 and block='0'";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($row = mysqli_fetch_array($result)) {
                echo "<li><a class=\"sm6\" href=\"rep_ret_chq.php\" target=\"_blank\">Return Cheque</a></li>";
            }

            $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Outstanding Report' and grp='Reports-Sales' and doc_view=1 and block='0'";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($row = mysqli_fetch_array($result)) {
                echo "<li><a class=\"sm6\" href=\"rep_outstanding.php\" target=\"_blank\">Outstanding Report</a></li>";
            }

            $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Rep Wise Sales Summery' and grp='Reports-Sales' and doc_view=1 and block='0'";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($row = mysqli_fetch_array($result)) {
                echo "<li><a class=\"sm6\" href=\"rep_rep_wise_sales.php\" target=\"_blank\">Repwise Sales Summery</a></li>";
            }

            $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Bin Card' and grp='Inquiries' and doc_view=1 and block='0'";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($row = mysqli_fetch_array($result)) {
                echo "<li><a href=\"bin_card.php\" target=\"_blank\" class=\"sm1\" >Bin Card</a></li>";
            }

            $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Sales Register' and grp='Inquiries' and doc_view=1 and block='0'";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($row = mysqli_fetch_array($result)) {
                echo "<li><a href=\"sales_register.php\" target=\"_blank\" class=\"sm1\" >Sales Register</a></li>";
            }
            $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Problems' and grp='Reports-New' and doc_view=1 and block='0'";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($row = mysqli_fetch_array($result)) {
                echo "<li><a class=\"sm6\" href=\"new\home.php?url=problems\" target=\"_blank\">Problems</a></li>";
            }
            
            ?>


        </ul>
    </div>
</div>