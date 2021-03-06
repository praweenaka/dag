<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title></title>
    <script src="js/jquery-1.4.2.min.js" type="text/javascript"></script>
    <script src="js/jquery.autoScroll.js" type="text/javascript"></script>
    <script src="js/jquery.timers.js" type="text/javascript"></script>
</head>
<body>

    <div style="display:none">
        <div id="template">
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam lacinia imperdiet iaculis. Curabitur fermentum est vitae leo lobortis tempus. Donec vitae felis turpis, ac porttitor orci. In sit amet odio mauris, sit amet convallis tortor. Maecenas quis lectus augue, sed lobortis nibh. Mauris vehicula convallis viverra. Nullam eleifend risus a sem commodo a fringilla nunc pharetra. Nam ut lectus ut metus commodo blandit quis non lorem. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Mauris aliquam orci sed sem volutpat id commodo dui fermentum. Proin lacinia tellus id leo accumsan rhoncus blandit nisl malesuada. Cras sit amet ipsum odio, quis facilisis lorem. Nunc ornare mauris id mi laoreet dictum. Aliquam ac aliquet risus.
        <br />
        Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Quisque semper, enim a posuere consequat, magna felis porta lectus, et commodo sapien mi vel ipsum. Nunc eget augue vel turpis aliquam commodo at et arcu. Vestibulum nec nisi dignissim mi sagittis convallis nec quis sem. Nam convallis sem at urna cursus volutpat. Aliquam fermentum cursus ultricies. Nunc ac felis velit, vitae placerat dolor. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nulla convallis imperdiet tincidunt. Pellentesque nibh ligula, dapibus sed pharetra ut, gravida eget nisl. Proin varius aliquam tortor quis eleifend. In massa diam, tempor vel aliquam vitae, suscipit sagittis turpis. Ut aliquet tempus dui id adipiscing. Sed ut tellus justo. Integer ultrices pulvinar adipiscing. Sed vel est nisi, at placerat dolor. Nulla tempus adipiscing risus sit amet fermentum. Morbi pretium placerat orci eu pharetra.
        <br />
        In auctor, lacus quis scelerisque tincidunt, magna mauris feugiat leo, ac pellentesque nisi libero id metus. Fusce et risus justo, eu ornare lorem. Curabitur sit amet sapien sed nunc suscipit suscipit vitae vel tortor. Duis augue enim, tincidunt non varius blandit, ullamcorper eu leo. Nunc at tellus a dolor lobortis gravida. Nulla sed ante sit amet quam rhoncus suscipit. Nullam tempor euismod ligula eget tristique. Sed nec porttitor ligula. Praesent id dolor urna. Donec lacus mauris, volutpat quis tempus id, ornare id mauris. Suspendisse eget nisi risus. Praesent imperdiet suscipit urna nec feugiat. Sed in eros eu orci aliquet blandit. Sed sit amet eros ligula. Sed ac neque id massa malesuada dictum et vitae magna. Curabitur id diam tortor. Aliquam lacus orci, aliquet non adipiscing non, dapibus sed libero. Suspendisse mollis convallis nisi. Praesent fringilla massa et velit luctus quis consectetur lorem commodo. Aliquam erat volutpat.
        </div>
    
    </div>
    
    <div id="a" class="test" style="overflow-x:scroll; height:400px; width:200px; display:inline-block;"></div>
    <div id="b" class="test" style="overflow-x:scroll; height:400px; width:200px; display:inline-block;"></div>
    <div id="c" class="test" style="overflow:scroll; white-space:nowrap; height:400px; width:200px; display:inline-block;"></div>
    <div id="d" class="test" style="overflow:scroll; white-space:nowrap; height:400px; width:200px; display:inline-block;"></div><br />
    <a href='javascript:$(".test").autoscroll({ action:"rewind", step:1000 });'>Rewind All</a>
    <a href='javascript:start();'>Play All</a>
    <a href='javascript:$(".test").autoscroll({ action:"stop"});'>Stop All</a>
    <a href='javascript:$(".test").autoscroll({ action:"fastforward", step:1000 });'>Fast Forward All</a>
    <a href='javascript:$(".test").autoscroll({ action:"delay"});'>Delay All</a>
    <a href='javascript:$(".test").autoscroll({ action:"pause"});'>Pause All</a>
    <a href='javascript:$(".test").autoscroll({ action:"resume"});'>Resume All</a>
    <a href='javascript:$(".test").autoscroll({ action:"toggle"});'>Toggle All</a>
    <a href='javascript:$(".test").autoscroll({ action:"reverse"});'>Reverse All</a>
    

</body>
</html>
<script type="text/javascript">
    // start|stop|delay|fastfoward|rewind|update|pause|resume|reverse|toggle
    $(".test").append($("#template").html());
    $(".test").append($("#template").html());
    for (var i = 0; i < 100; ++i)
        $(".test").append($("#template").html());
    start = function () {
        $("#a").autoscroll();
        $("#b").autoscroll({ step: 200 });
        $("#c").autoscroll({ step: 100, direction: "right" });
        $("#d").autoscroll({ step: 100, direction: "downright" });
    }
        
</script>