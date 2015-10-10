<?php

$res = $_POST['firstQuestion'] . $_POST['secondQuestion'];

echo json_encode(array('summ'=>$res)); // {summ: 25}

