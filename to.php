<?php
//   /from/Rohit Kundu  

        header("content-type:application/json");

		 $from="";
		 if(isset($_GET['to']))
		{
			$to=validate($_GET['to']);
			if(!preg_match('/^[a-zA-Z ]*$/',$to))
			{
			    $response=array("Message"=>"Use only alphabets and spaces","Error"=>"Invalid Name");
    		    echo json_encode($response);
    		    return;
			}
			$con=mysqli_connect("localhost","id4871014_tsftasks","12345","id4871014_dummy_database");
    		$sql="SELECT * FROM transfer WHERE toUser='".$to."';";
			$result=mysqli_query($con,$sql);
			if($result->num_rows==0)
			{
			    $sql="SELECT * FROM users WHERE name='".$to."';";
			    $result2=mysqli_query($con,$sql);
			    if($result2->num_rows==0)
			    {
			         $response=array("Message"=>"User does not exist.Please give a valid user name","Error"=>"Invalid Name");
        		    echo json_encode($response);
        		    return;
			    }
			    else
			    {
			        $response=array("Message"=>"No transaction has been made to this user","Error"=>"No error");
        		    echo json_encode($response);
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
				echo json_encode($history);
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
            