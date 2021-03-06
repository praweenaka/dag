<?php
date_default_timezone_set('Asia/Colombo');
include ("connection_sql.php");
ini_set('session.gc_maxlifetime', 30 * 60 * 60 * 60);
session_start();

if ($_SESSION["CURRENT_USER"] == "") {
 echo "Please Logging Again..";

 // exit();
}
if ($_SESSION['company'] !="THT") {
  echo "Please Loging Again.. Different Company !!!";
  exit();
}
?>
<link rel="stylesheet" href="css/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="css/bootstrap_custom.css">
<section class="content-header">

  <h1>

    Dashboard

    <small>Home Page</small>

    <b><p style="float: right; color: black" id="time"></p></b> 

  </h1>

  <style type="text/css">
    #nav-pills>li>a, .nav-pills>li>a:focus, .nav-pills>li>a:hover {
      background-color:#7eaad6 ; 
    }
  </style>

</section>



<section class="content">

  <div class="row">



    <!-- </div> -->
    <div class="form-group"></div>
    <!--<div class="col-sm-9">-->

     <?php
     session_start();
     include './connection_sql.php';

     $sql = "select * from view_userpermission where username ='" . $_SESSION["CURRENT_USER"] . "' and doc_view='1' and block='0'   order by grp";

     $grp = "";



     foreach ($conn->query($sql) as $row) {

      if ($grp != $row['grp']) {

        if ($grp!="") {
         echo "</div>";
       }
       


       echo "<div class='col-xs-12'>";
       echo "<h1>&nbsp;&nbsp;" . $row["grp"] . "</h1>";
       echo "<div class='col-lg-3 col-xs-12'>";
       echo "<div class='" . $row['color'] . "'>";
       echo "<div class='inner'>";
       if($row['id']=="1"){
        echo"<h3 style=\"display: inline-block;
        width: 100%;\"><a href='home.php?url=" . trim($row['name']) . "' style=\"color: white; font-size:20PX;font-family: Verdana,Sans-serif;\" class=\"small-box-footer\">" . trim($row['docname']) . "</a></h3></font>";
      }else{
        echo"<h3 style=\"display: inline-block;
        width: 100%;\"><a  href=\"../" . $row['name'] . "\"   style=\"color: white; font-size:20PX;font-family: Verdana,Sans-serif;\" class=\"small-box-footer\">" . trim($row['docname']) . "</a></h3></font>";
      }

      echo "</div>";
      echo "<div class='icon'>";
      echo "<i class='".trim($row['icon'])."'></i>";
      echo "</div>";

      if($row['id']=="1"){
       echo "<a href='home.php?url=" . $row["name"] . "' target='_blank' class='small-box-footer'><i class='fa fa-arrow-circle-right'></i></a>";
     }else{
      if($row['grp']=="Stores"){
        echo "<a  href=\"../stores/" . $row['name'] . ".php\" target='_blank' class='small-box-footer'><i class='fa fa-arrow-circle-right'></i></a>";
      }else{
        echo "<a  href=\"../" . $row['name'] . ".php\" target='_blank' class='small-box-footer'><i class='fa fa-arrow-circle-right'></i></a>";
      }
      
    }
    
    echo "</div>";
    echo "</div>";
    $grp = $row['grp'];
  }else{
   echo "<div class='col-lg-3 col-xs-12'>";
   echo "<div class='" . $row['color']. "'>";
   echo "<div class='inner'>";
   if($row['id']=="1"){
    echo"<h3 style=\"display: inline-block;
    width: 100%;\"><a href='home.php?url=" . trim($row['name']) . "' style=\"color: white; font-size:20PX;font-family: Verdana,Sans-serif;\" class=\"small-box-footer\">" . trim($row['docname']) . "</a></h3></font>";
  }else{
    echo"<h3 style=\"display: inline-block;
    width: 100%;\"><a  href=\"../" . $row['name'] . "\"   style=\"color: white; font-size:20PX;font-family: Verdana,Sans-serif;\" class=\"small-box-footer\">" . trim($row['docname']) . "</a></h3></font>";
  }
  echo "</div>";
  echo "<div class='icon'>";
  echo "<i class='".trim($row['icon'])."'></i>";
  echo "</div>";
  if($row['id']=="1"){
   echo "<a href='home.php?url=" . $row["name"] . "' target='_blank' class='small-box-footer'><i class='fa fa-arrow-circle-right'></i></a>";
 }else{
  if($row['grp']=="Stores"){
   echo "<a  href=\"../stores/" . $row['name'] . ".php\" target='_blank' class='small-box-footer'><i class='fa fa-arrow-circle-right'></i></a>";
 }else{
   echo "<a  href=\"../" . $row['name'] . ".php\" target='_blank' class='small-box-footer'><i class='fa fa-arrow-circle-right'></i></a>";
 }
 
}
echo "</div>";
echo "</div>";
}


                // echo"<div class=\"col-lg-3 col-xs-12\">";
                // echo"<div class=\"" . $row['color'] . "\">";
                // echo"<div class=\"inner\">";
                // if($row['id']=="1"){
                //     echo"<h3 style=\"display: inline-block;
                //     width: 100%;\"><a href='home.php?url=" . trim($row['name']) . "' style=\"color: white; font-size:25PX;font-family: Verdana,Sans-serif;\" class=\"small-box-footer\">" . trim($row['docname']) . "</a></h3></font>";
                // }else{
                //     echo"<h3 style=\"display: inline-block;
                //     width: 100%;\"><a  href=\"../" . $row['name'] . "\"   style=\"color: white; font-size:25PX;font-family: Verdana,Sans-serif;\" class=\"small-box-footer\">" . trim($row['docname']) . "</a></h3></font>";
                // }
                // echo"</div>";
                // echo"<div class=\"icon\">";
                // echo"<i class=\"" . trim($row['icon']) . "\"></i>";
                // echo"</div>";
                // if($row['id']=="1"){
                //     echo"<a href='home.php?url=" . trim($row['name']) . "'  class=\"small-box-footer\"><i class=\"fa fa-arrow-circle-right\"></i>" . trim($row['docname']) . "</a>";
                // }else{
                //     echo"<a  href=\"../" . trim($row['name']) . ".php\"  class=\"small-box-footer\"><i class=\"fa fa-arrow-circle-right\"></i>" . trim($row['docname']) . "</a>";
                // }
                // echo"</div>";
                // echo"</div>";


}


echo "</ul>";

echo "</li>";

?>

<!--</div>-->

<!--=================-->

</div>
</section>



