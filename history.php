<?php
		header("content-type:application/json");
		$con=mysqli_connect("localhost","id4871014_tsftasks","12345","id4871014_dummy_database");
		$sql="SELECT * FROM transfer";
		$result=mysqli_query($con,$sql);
		if($result->num_rows >0)
		{
			$history["history"]=array();
			while($row= $result->fetch_assoc())
			{
				$hist=array("Sl No"=>$row['no'],
							"From User"=>$row['fromUser'],
							"To User"=>$row['toUser'],
							"Credit"=>$row['credit'],
							"Date"=>$row['dateTimeNow']);
				array_push($history["history"],$hist);			
			}			
			echo json_encode($history);
		}
			    
?>    	
            