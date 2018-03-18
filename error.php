<?php
header("content-type:application/json");
$response=array("Message"=>"invalid URL","Error"=>"error");
echo json_encode($response);
?>