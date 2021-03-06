<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <title><?php 
   require_once ('connection_sql.php');

   $sqlinv = "select * from  doc where name = '". $_GET['url'] ."'";
   $resultinv = $conn->query($sqlinv);
   if ($rowlurl = $resultinv->fetch()) {

     echo $rowlurl['docname'];
 }else{
    echo "HOME";
}



?></title>


<!-- Font Awesome -->
<link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css">
<!-- Ionicons -->
<link rel="stylesheet" href="css/ionicons/css/ionicons.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="css/AdminLTE.min.css">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
            folder instead of downloading all of them to reduce the load. -->
            <link rel="stylesheet" href="css/skins/skin-blue.min.css">
            <link rel="stylesheet" href="css/home.css">
            <!-- iCheck -->
            <link rel="stylesheet" href="plugins/iCheck/flat/blue.css">
            <!-- Bootstrap core CSS -->
            <link rel="stylesheet" href="css/bootstrap.min.css">
            <link rel="stylesheet" href="css/info.css">
            <!-- daterange picker -->
            <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker-bs3.css">
            <!-- jvectormap -->
            <link rel="stylesheet" href="plugins/jvectormap/jquery-jvectormap-1.2.2.css">
            <!-- Date Picker -->
            <link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
            <!-- Daterange picker -->
            <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker-bs3.css">
            <!-- bootstrap wysihtml5 - text editor -->
            <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
            
            <style>
              .box-body {
                background-color : #ecf0f5;
            }	
        </style>
    </head>

    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">


 


            <header class="main-header">


                <a href="home.php" class="logo">  
                    <span class="logo-mini"><b>E</b>RP</span>  <span class="logo-lg"><b>E</b>RP</span> </a>

                    <nav class="navbar navbar-static-top" role="navigation">

                        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button"> <span class="sr-only">Toggle navigation</span> </a>
                        <div class="navbar-custom-menu">
                            <ul class="nav navbar-nav"> 
                                <li class="dropdown user user-menu">
                                    <a href="" class="dropdown-toggle" data-toggle="dropdown">
                                        <img src="images/user.png" class="user-image" alt="User Image">
                                        <span class="hidden-xs"><?php echo $_SESSION['UserName']; ?></span> 
                                    </a>

                                    
                                    <ul class="dropdown-menu">

                                        <li class="user-header">
                                            <img src="images/user.png" class="img-circle" alt="User Image">

                                            <p>
                                            </p>
                                        </li>

                                        <li class="user-body">
                                            <div class="well-sm"></div>    

                                        </li> 
                                        <li class="user-footer">
                                            <div class="pull-left">


                                            </div>
                                            <div class="pull-right">
                                                <a onclick="logout();" class="btn btn-success btn-file">Sign out</a>
                                            </div>
                                        </li>
                                    </ul>
                                </li> 
                                <li>
                                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </header>


 


                <!-- Left side column. contains the logo and sidebar -->
                <aside class="main-sidebar">
                    <!-- sidebar: style can be found in sidebar.less -->
                    <section class="sidebar">
                        <!-- Sidebar user panel -->
                        <div class="user-panel">
                            <div class="pull-left image">
                                <img src="images/user.png" class="img-circle" alt="User Image">
                            </div>
                            <div class="pull-left info">
                                <p>
                                    <?php 
                                    echo $_SESSION['UserName']
                                    ?>
                                </p>
                                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                            </div>
                        </div>
                        <!-- search form -->
                        <form action="#" method="get" class="sidebar-form">
                            <div class="input-group">
                                <input type="text" name="q" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                    <button type="submit" name="search" id="search-btn" class="btn btn-flat">
                                        <i class="fa fa-search"></i>
                                    </button> </span>
                                </div>
                            </form>
                            <!-- /.search form -->
                            <!-- sidebar menu: : style can be found in sidebar.less -->
                            <ul class="sidebar-menu">
                                <li class="header">
                                    MAIN MENU
                                </li>
                                <?php
                                if (isset($_GET['url'])) {
                                    $murl = $_GET['url'];
                                } else {
                                    $murl = "";
                                }

                                $mgroup = "";
                                session_start();
                                include './connection_sql.php';
                                $sql = "select * from view_userpermission where username ='" . $_SESSION["CURRENT_USER"] . "' and doc_view='1' and  block='0'   order by grp,docid";

                                foreach ($conn->query($sql) as $row1) {
                                    if ($mgroup != $row1['grp']) {
                                        if ($mgroup != "") {
                                            echo "</ul>";
                                            echo "</li>";
                                        }
                                        echo "<li class='treeview'>
                                        <a href='#'><i class='" . trim($row1['icon']) . "'></i> <span>" . $row1['grp'] . "</span> <i class='fa fa-angle-left pull-right'></i> </a>
                                        <ul class='treeview-menu'>";
                                    }

                                    $mgroup = $row1['grp'];
                                    if ($murl == $row1['name']) {
                                        echo "<li class='active'>";
                                    } else {
                                        echo "<li>";
                                    }
                                    if($row1['id']=="1"){
                                        echo "<a href='home.php?url=" . trim($row1['name']) . "'><i class='fa fa-circle-o'></i>" . trim($row1['docname']) . "</a></li>";
                                    }else{
                                        echo "<a href=\"../" . trim($row1['name']) . ".php\"><i class='fa fa-circle-o'></i>" . trim($row1['docname']) . "</a></li>";
                                    }

                                }
                                echo "</ul>";
                                echo "</li>";
                                ?>

                            </ul>
                        </section>
                        <!-- /.sidebar -->
                    </aside>

                    <!-- Content Wrapper. Contains page content -->
                    <div class="content-wrapper">