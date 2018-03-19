<?php
//   user/id/   

        header("content-type:application/json");

		 $id=0;
		 if(isset($_GET['id']))
		{
			$id=validate($_GET['id']);
			//echo $id;
			if(!preg_match('/^[0-9]*$/',$id))
			{
			    $response=array("Message"=>"Use numbers only.Dont use any alphabet ,space,underscore,hyphen etc","Error"=>"Invalid ID");
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
    		$sql="SELECT * FROM users WHERE no=".$id.";";
    		$result=mysqli_query($con,$sql);
     		if($result->num_rows ==0)
   		    {
   		        $response=array("Message"=>"User with  ID ".$id." does not exist","Error"=>"error");
    		    echo json_encode($response,JSON_PRETTY_PRINT);
   		    }
        	else
    		{
    			while($row= $result->fetch_assoc())
    			{
    				
    				$user=array(
    					"ID"=>$row['no'],
    					"Name"=>$row['name'],
    					"Email"=>$row['email'],
    					"Credit"=>$row['credit']);    							
    			}
    			echo json_encode($user,JSON_PRETTY_PRINT);
    		}
		}
		function validate($data)
		{
		    $data=trim($data);
		    $data=stripslashes($data);
		    $data=htmlspecialchars($data);
		    return $data;
		}
	//	echo "name".$name;
		
			    
?>    	
            