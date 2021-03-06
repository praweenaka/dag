<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>jQuery UI Progressbar - Default functionality</title>
<link rel="stylesheet" href="css/jquery-ui.css">
<script src="js/jquery-1.10.2.js"></script>
<script src="js/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css">
<script>
function progress_bar() {
$( "#progressbar" ).progressbar({
value: 10
});
}
</script>
</head>
<body onLoad="progress_bar();">
<div id="progressbar" style="width:200px; height:15px;"></div>
</body>
</html>