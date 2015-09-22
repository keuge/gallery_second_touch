<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="/scripts/jquery-2.1.3.js"></script>
    <script src="../js/jd.js"></script>

</head>

<body>

<div class="progress progress-striped">
    <div class="bar" style="width: 20%;"></div>
</div>

<div id="progressbar">
    <div style="width: <?php echo $percentage; ?>%;"></div>
</div>
</body>
</html>
