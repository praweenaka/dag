 
<!-- Main content -->

<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.5/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.5/js/fileinput.min.js"></script>
<style>
    img{
        max-width:280px;
    }
    input[type=file]{
        padding:10px;
        background:white;
    }
</style>
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Add Files</h3>
            <h4 style="float: right;height: 3px;"><b id="time"></b></h4>
        </div>
        <form method='post' action='' enctype='multipart/form-data'>
            <div class="box-body">
                <div class="form-group">
                    <a onclick="new_inv();" class="btn btn-default">
                        <span class="fa fa-user-plus"></span> &nbsp; New
                    </a>

                </div>
                <input type="hidden" id="uniq" class="form-control">

                <div id="msg_box"  class="span12 text-center"  >  </div>

                <div class="form-group">
                    <label class="col-md-2" for="txt_usernm">Batch No</label>
                    <div class="col-sm-2">
                        <input type="text" placeholder="Batch No" disabled="" id="batchno" class="form-control">
                    </div>
                </div>

                <div class="form-group">

                    <!-- <div id="errorBlock" class="help-block"></div> -->
                    <div class="col-sm-7">
                        <input type="file" name="file[]" id="file" class="file"  data-preview-file-type="text" multiple>
                        <input type='submit' name='submit' value='Upload'>
                    </div>
                </div>  



                <div class="form-group" id="filup" style="visibility: visible;">
                    <label class="col-sm-2" for="file-3">Files</label>&nbsp;&nbsp;&nbsp;
                    <label class="btn btn-default" for="file-3">
                        <input id="file-3" onchange="readURL(this);" name="file-3" multiple="true" type="file">
                        Select Files

                    </label>
                    <a class="btn btn-primary" onclick="imgup('img');">Upload</a>
                </div>

            </form>
        </div>

        <?php 
        if(isset($_POST['submit'])){
 // Count total files
            $countfiles = count($_FILES['file']['name']);
 // Looping all files
            for($i=0;$i<$countfiles;$i++){
             $filename = $_FILES['file']['name'][$i];
   // Upload file
             move_uploaded_file($_FILES['file']['tmp_name'][$i],'upload/'.$filename);

         }
     } 


     ?>
 </section>
 <script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#blah')
                .attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>


<script src="js/addfiles.js" ></script> 
<script>new_inv();</script>




