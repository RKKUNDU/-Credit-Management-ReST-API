<?php
header("content-type:application/json");
$response=array("Message"=>"Invalid URL","Error"=>"Error ","Status"=>"404");
echo json_encode($response,JSON_PRETTY_PRINT);
?>