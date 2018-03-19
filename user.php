<?php
//   /user/Rohit Kundu  

        header("content-type:application/json");

		 $name="";
		 if(isset($_GET['name']))
		{
			$name=validate($_GET['name']);
			if(!preg_match('/^[a-zA-Z ]*$/',$name))
			{
			    $response=array("Message"=>"Use only alphabets and spaces","Error"=>"Invalid Name");
    		    echo json_encode($response,JSON_PRETTY_PRINT);
    		    return;
			}
			//echo $name;
			$con=mysqli_connect("localhost","id4871014_tsftasks","12345","id4871014_dummy_database");
			if (!$con) 
			{
    		    $response=array("Message"=>"Database not connected","Error"=>"No error .There is some internal fault.");
        	    json_encode($response,JSON_PRETTY_PRINT);
        	    return;
    		
            }
    		$sql="SELECT * FROM users WHERE name='".$name."';";
    		$result=mysqli_query($con,$sql);
    		if($result->num_rows ==0)
    		{
    		    $response=array("Message"=>"User  name '".$name. "' does not exist","Error"=>"error");
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
            