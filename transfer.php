<?php
header("content-type:application/json");
//   /transfer/from/to/credit

    
	$response=array();
	if(isset($_GET['from'])&&isset($_GET['to'])&&isset($_GET['credit']))
	{
		$from=validate($_GET['from']);
		$to=validate($_GET['to']);
		$credit=validate($_GET['credit']);
		
		if(!preg_match('/^[a-zA-Z ]*$/',$from)||!preg_match('/^[a-zA-Z ]*$/',$to)||!preg_match('/^[0-9]*$/',$credit))
		{
	    	if(!preg_match('/^[a-zA-Z ]*$/',$from))
    		{
    		    $res=array("Message"=>"Use only alphabets and spaces","Error"=>"Invalid Sender Name");
    		    array_push($response,$res);
    		}
    	    if(!preg_match('/^[a-zA-Z ]*$/',$to))
    		{
    		    $res=array("Message"=>"Use only alphabets and spaces","Error"=>"Invalid Recipient Name ");
    		    array_push($response,$res);
    		}
    		if(!preg_match('/^[0-9]*$/',$credit))
    		{
    		    $res=array("Message"=>"Use numbers only.","Error"=>"Invalid Credit");
    		    array_push($response,$res);
    		}
    		echo json_encode($response,JSON_PRETTY_PRINT);
    		return;
		}
	
		
		
//sender and recipient same		
		if($from==$to)
		{
			$res=array("Message"=>"Both sender and recipient is same","error"=>"error");
			array_push($response,$res);
			echo json_encode($response,JSON_PRETTY_PRINT);
			return;
		}
		
//credit is negative 
		
		if($credit<=0)
		{
			$res=array("Message"=>"Please Choose value of credit greater than zero","error"=>"error");
			array_push($response,$res);
        	echo json_encode($response,JSON_PRETTY_PRINT);
			return;
		}
//database coonection		
		$con=mysqli_connect("localhost","id4871014_tsftasks","12345","id4871014_dummy_database");
		if (!$con) 
		{
		    $response=array("Message"=>"Database not connected","Error"=>"No error .There is some internal fault.");
    	    json_encode($response,JSON_PRETTY_PRINT);
    	    return;
		
        }			
		$sender_credit=$recipient_credit=0;		
		
//query statement		
		$sql2="SELECT credit FROM users WHERE name ='".$from."';";
		$sql3="SELECT credit FROM users WHERE name = '".$to."';";
		
//query results		
		$sender_result=mysqli_query($con,$sql2);
		$recipient_result=mysqli_query($con,$sql3);
		
		
		if($sender_result->num_rows==0)
		{
			$res=array("Message"=>"Sender does not exist","error"=>"Invalid Sender Name");
			array_push($response,$res);
			echo json_encode($response,JSON_PRETTY_PRINT);
	return;
		}
		if($recipient_result->num_rows==0)
		{
			$res=array("Message"=>"Recipient does not exist","error"=>"Invalid Recipient Name");
			array_push($response,$res);
			echo json_encode($response,JSON_PRETTY_PRINT);
			return;
		}
		
//fetch amounts		
		while($row=$sender_result->fetch_assoc())
		{
			$sender_credit=$row['credit'];
		}
		while($row=$recipient_result->fetch_assoc())
		{
			$recipient_credit=$row['credit'];
		}
		
//sender does not have enough credits		
		if($sender_credit<$credit)
		{
			$res=array("Message"=>"Sender does not have enough credits","error"=>"error");
			array_push($response,$res);	
		}
		else
		{
			
//update database			
			$recipient_credit=$recipient_credit+$credit;
			$sender_credit=$sender_credit-$credit;
			$con=mysqli_connect("localhost","id4871014_tsftasks","12345","id4871014_dummy_database");
			$sql4="UPDATE users SET credit=".$recipient_credit." WHERE name = '".$to."';";
			$sql5="UPDATE users SET credit=".$sender_credit." WHERE name = '".$from."';";
			mysqli_query($con,$sql4);
			mysqli_query($con,$sql5);
			
//confirmation			
			$res=array("Message"=>$credit." credit is transferred from ".$from." to ".$to,"error"=>"No Error");
			array_push($response,$res);	
			date_default_timezone_set('Asia/kolkata');
			$dt=time();
			$date=date("d-m-Y H:i:s",$dt);
			
//add in the history table
			
			$sql6="INSERT INTO transfer (fromUser,toUser,credit,dateTimeNow) VALUES ('".$from."','".$to."',".$credit.",'".$date."');";
			mysqli_query($con,$sql6);
			
		}
		
			
	}
	else
	{
	    $res=array("Message"=>"Some values are missing","error"=>"error");
			array_push($response,$res);
	}
	echo json_encode($response,JSON_PRETTY_PRINT);
	function validate($data)
	{
	    $data=trim($data);
	    $data=stripslashes($data);
	    $data=htmlspecialchars($data);
	    return $data;
	}
?>
