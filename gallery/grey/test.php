<!doctype html>
<html lang="en">
<head>
    <style>
    </style>
</head>
<body>
<?php
function genImageName()
{
$way = "../img/";

for($i=0; $i < 12; $i++)
{
$way .= rand(0,99);
}

$way .= '.jpg';

return $way;
}

var_dump(genImageName());
?>

</body>
</html>