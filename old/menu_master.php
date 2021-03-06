
<style type="text/css">
    #display_selected a {
        color:#000;
    }

    #display_notSelected a{
        color:#fff;
    }
</style>
<script src="js/user.js"></script>
<?php
require_once("connectioni.php");
?>
<div id="menus_wrapper">





    <div id="main_menu">
        <ul>
            <li><a href="home.php"><span><span>Home</span></span></a></li>
            <?php
            $sql = "select * from userpermission where username='" . $_SESSION['UserName'] . "' and grp='Master Files' and doc_view=1"; 
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
 
            if ($row = mysqli_fetch_array($result)) {
               echo "<li><a href=\"masterfiles.php\" class=\"selected\"><span><span>Master Files</span></span></a></li>";
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
            <li class="last" onclick="logout();"><a href="#"><span><span>Logout</span></span></a></li>
        </ul>
    </div>



    <div id="sec_menu">
        <ul>
            <?php
            $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Item Master File' and grp='Master Files' and doc_view=1 and block='0'";
 
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($row = mysqli_fetch_array($result)) {
                echo "<li><a href=\"itemmast.php\" target=\"_blank\" class=\"sm1\" >Item Master File</a></li>";
            }
            $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Customer Master File' and grp='Master Files' and doc_view=1 and block='0'";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($row = mysqli_fetch_array($result)) {
                echo "<li><a href=\"cust_mast.php\" target=\"_blank\" class=\"sm2\" >Customer Master File</a></li>";
            }

            $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Marketing Executive' and grp='Master Files' and doc_view=1 and block='0'";

            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($row = mysqli_fetch_array($result)) {
                echo "<li><a href=\"rep_mast.php\" target=\"_blank\" class=\"sm2\" >Marketing Executive</a></li>";
            }

            $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Brand Master' and grp='Master Files' and doc_view=1 and block='0'";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($row = mysqli_fetch_array($result)) {
                echo "<li><a href=\"brandmast.php\" target=\"_blank\" class=\"sm4\">Brand Master</a></li>";
            }
            $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Store Master' and grp='Master Files' and doc_view=1 and block='0'";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($row = mysqli_fetch_array($result)) {
                echo "<li><a href=\"storesmaster.php\" target=\"_blank\" class=\"sm5\">Store Master</a></li>";
            }

            $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Commission Rates' and grp='Master Files' and doc_view=1 and block='0'";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($row = mysqli_fetch_array($result)) {
                echo "<li><a href=\"commission.php\" target=\"_blank\" class=\"sm6\">Commission Rates</a></li>";
            }

            $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Balance Commission Schedule' and grp='Master Files' and doc_view=1 and block='0'";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($row = mysqli_fetch_array($result)) {
                echo "<li><a href=\"balance_commission.php\" target=\"_blank\" class=\"sm7\">Balance Commission Schdule</a></li>";
            }

            $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Bank Master' and grp='Master Files' and doc_view=1 and block='0'";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($row = mysqli_fetch_array($result)) {
                echo "<li><a href=\"bankmast.php\" target=\"_blank\" class=\"sm7\">Bank Master</a></li>";
            }


            $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Price Control' and grp='Master Files' and doc_view=1 and block='0'";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($row = mysqli_fetch_array($result)) {
                echo "<li><a href=\"new/home.php?url=price_control\" target=\"_blank\" class=\"sm7\">Price Control</a></li>";
            }
            ?>

        </ul>
    </div>
</div>