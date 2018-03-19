<?php
//   /from/Rohit Kundu  

        header("content-type:application/json");

		 $from="";
		 if(isset($_GET['from']))
		{
			$from=validate($_GET['from']);
			if(!preg_match('/^[a-zA-Z ]*$/',$from))
			{
			    $response=array("Message"=>"Use only alphabets and spaces","Error"=>"Invalid Name");
    		    echo json_encode($response,JSON_PRETTY_PRINT);
    		    return;
			}
			$con=mysqli_connect("localhost","id4871014_tsftasks","12345","id4871014_dummy_database");
			if (!$con) 
			{
    		    $response=array("Message"=>"Database not connected","Error"=>"No error .There is some internal fault.");
        	    json_encode($response,JSON_PRETTY_PRINT);
        	    return;
            }
    		$sql="SELECT * FROM transfer WHERE fromUser='".$from."';";
			$result=mysqli_query($con,$sql);
			if($result->num_rows==0)
			{
			    $sql="SELECT * FROM users WHERE name='".$from."';";
			    $result2=mysqli_query($con,$sql);
			    if($result2->num_rows==0)
			    {
			         $response=array("Message"=>"User does not exist.Please give a valid user name","Error"=>"Invalid Name");
        		    echo json_encode($response,JSON_PRETTY_PRINT);
        		    return;
			    }
			    else
			    {
			        $response=array("Message"=>"No transaction has been made from this user","Error"=>"No error");
        		    echo json_encode($response,JSON_PRETTY_PRINT);
        		    return;
			    }
			    
			}
			else
			{
				$history=array();
				while($row= $result->fetch_assoc())
				{
					$hist=array("No"=>$row['no'],
								"From User"=>$row['fromUser'],
								"To User"=>$row['toUser'],
								"Credit"=>$row['credit'],
								"Date"=>$row['dateTimeNow']);
					array_push($history,$hist);			
				}			
				echo json_encode($history,JSON_PRETTY_PRINT);
			}
		}
		function validate($data)
		{
		    $data=trim($data);
		    $data=stripslashes($data);
		    $data=htmlspecialchars($data);
		    return $data;
		}
			    
?>    	
            