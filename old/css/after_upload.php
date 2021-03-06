<script src="js/inv.js"></script>

<body >

<?php

$allowedExts = array("gif", "jpeg", "jpg", "png", "GIF", "JPEG", "JPG", "PNG", "tif", "TIF");
$extension = end(explode(".", $_FILES["file"]["name"]));
//if ((($_FILES["file"]["type"] == "image/gif")
//|| ($_FILES["file"]["type"] == "image/jpeg")
//|| ($_FILES["file"]["type"] == "image/jpg")
//|| ($_FILES["file"]["type"] == "image/pjpeg")
//|| ($_FILES["file"]["type"] == "image/x-png")
//|| ($_FILES["file"]["type"] == "image/png"))
//&& ($_FILES["file"]["size"] < 50000)
//&& in_array($extension, $allowedExts))
//  {
 // if ($_FILES["file"]["error"] > 0)
 //   {
  //  echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
  //  }
  //else
  //  {
   /* echo "Upload: " . $_FILES["file"]["name"] . "<br>";
    echo "Type: " . $_FILES["file"]["type"] . "<br>";
    echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
    echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";*/
	
		
	//if (!file_exists('path/to/directory')) {
   // mkdir('path/to/directory', 0777, true);
	//}
	
	
	if ($_POST["cou"]=="idcopy"){	
    	//if (file_exists("upload/id_copy/" . $_FILES["file"]["name"]))
      	//{
      	//	echo $_FILES["file"]["name"] . " already exists. ";
      //	}
    	//else
      //	{
	  		$type=substr($_FILES["file"]["type"],6);
      		move_uploaded_file($_FILES["file"]["tmp_name"],
      		"upload/id_copy/" .$_POST["cus_id"].".".$type);
			//echo "upload/id_copy/" .$_POST["cus_id"].".".$type;
	   		echo "<img src=\"upload/id_copy/" .$_POST["cus_id"].".".$type."\" >";

      //	}
	}	
	
	if ($_POST["cou"]=="signature"){	
    	
	  	$type=substr($_FILES["file"]["type"],6);
      	move_uploaded_file($_FILES["file"]["tmp_name"], "upload/signature/" .$_POST["cus_id"].".".$type);
		echo "<img src=\"upload/signature/" .$_POST["cus_id"].".".$type."\" >";

	}
	
	if ($_POST["cou"]=="application"){	
    	
	  	$type=substr($_FILES["file"]["type"],6);
      	move_uploaded_file($_FILES["file"]["tmp_name"], "upload/application/" .$_POST["cus_id"].".".$type);
		echo "<img src=\"upload/application/" .$_POST["cus_id"].".".$type."\" >";

	}
	
	if ($_POST["cou"]=="br_copy"){	
    	
	  	$type=substr($_FILES["file"]["type"],6);
      	move_uploaded_file($_FILES["file"]["tmp_name"], "upload/br_copy/" .$_POST["cus_id"].".".$type);
		echo "<img src=\"upload/br_copy/" .$_POST["cus_id"].".".$type."\" >";

	}	
//    }
//  }
//else
//  {
 // echo "Invalid file";
 // }
  
?> 


</body>