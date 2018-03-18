<?php

//   /users
		 
		header("content-type:application/json");
		$con=mysqli_connect("localhost","id4871014_tsftasks","12345","id4871014_dummy_database");
		$sql="SELECT * FROM users";
		$result=mysqli_query($con,$sql);
		if($result->num_rows >0)
		{
			$users["users"]=array();
			while($row= $result->fetch_assoc())
			{
				
				$user=array(
					"Sl No"=>$row['no'],
					"Name"=>$row['name'],
					"Email"=>$row['email'],
					"Credit"=>$row['credit']);
				array_push($users["users"],$user);
							
			}
			echo json_encode($users);
		}
?>
       