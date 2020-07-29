<?php
	require_once 'db.php';

	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Methods:GET");

	if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['regionid'])){
			
		
	if($_GET['regionid']!='6'){
		$data=getData($_GET['regionid']);
		$send_date=array('total_count'=>$data[0],'active_count'=>$data[1],'recovered_count'=>$data[2]);
		echo json_encode($send_date);
	}else{
			$temp1=0;
			$temp2=0;
			$temp3=0;
			
			for($i=1;$i<6;$i++){
				
				$temp=getData($i);
				$temp1+=$temp[0];
				$temp2+=$temp[1];
				$temp3+=$temp[2];
			}
			$total = array('total_count'=>$temp1,'active_count'=>$temp2,'recovered_count'=>$temp3);
			echo json_encode($total);
		}
	}else{
		$sql= "SELECT(SELECT reg_id from atlantic LIMIT 1) AS region, (SELECT COUNT(*)  FROM atlantic) AS total_count, (SELECT COUNT(*)  FROM atlantic where recovered =2 or recovered = 9) AS active_count ,
		(SELECT COUNT(*) FROM atlantic where recovered =1) AS recoverd_count";
		$result = query($sql);
		$row=dbFetchAssoc($result);
		$mapData=Array();
		array_push($mapData,$row);
		$sql= "SELECT(SELECT reg_id from quebec LIMIT 1) AS region, (SELECT COUNT(*)  FROM quebec) AS total_count, (SELECT COUNT(*)  FROM quebec where recovered =2 or recovered = 9) AS active_count ,
		(SELECT COUNT(*) FROM quebec where recovered =1) AS recoverd_count";
		$result = query($sql);
		$row=dbFetchAssoc($result);
		array_push($mapData,$row);
		$sql= "SELECT(SELECT reg_id from ontario LIMIT 1) AS region, (SELECT COUNT(*)  FROM ontario) AS total_count, (SELECT COUNT(*)  FROM ontario where recovered =2 or recovered = 9) AS active_count ,
		(SELECT COUNT(*) FROM ontario where recovered =1) AS recoverd_count";
		$result = query($sql);
		$row=dbFetchAssoc($result);
		array_push($mapData,$row);
		$sql= "SELECT(SELECT reg_id from prairies LIMIT 1) AS region, (SELECT COUNT(*)  FROM prairies) AS total_count, (SELECT COUNT(*)  FROM prairies where recovered =2 or recovered = 9) AS active_count ,
		(SELECT COUNT(*) FROM prairies where recovered =1) AS recoverd_count";
		$result = query($sql);
		$row=dbFetchAssoc($result);
		array_push($mapData,$row);
		$sql= "SELECT(SELECT reg_id from britishcolumbia LIMIT 1) AS region, (SELECT COUNT(*)  FROM britishcolumbia) AS total_count, (SELECT COUNT(*)  FROM britishcolumbia where recovered =2 or recovered = 9) AS active_count ,
		(SELECT COUNT(*) FROM britishcolumbia where recovered =1) AS recoverd_count";
		$result = query($sql);
		$row=dbFetchAssoc($result);
		array_push($mapData,$row);

		echo json_encode($mapData);
			
	}

	function getData($id){
		if($id=='1'){
			$sql= "SELECT COUNT(case_id) as total_count FROM atlantic";
			$result = query($sql);
			$row=dbFetchAssoc($result);
			$data=array($row['total_count']); 
			$sql= "SELECT COUNT(case_id) as active_count FROM atlantic where recovered =2 or recovered = 9";
			$result = query($sql);
			$row=dbFetchAssoc($result);
			array_push($data,$row['active_count']);
			$sql= "SELECT COUNT(case_id) as recoverd_count FROM atlantic where recovered =1";
			$result = query($sql);
			$row=dbFetchAssoc($result);
			array_push($data,$row['recoverd_count']);
			return $data;
		}else if($id=='2'){
			$sql= "SELECT COUNT(case_id) as total_count FROM quebec";
			$result = query($sql);
			$row=dbFetchAssoc($result);
			$data=array($row['total_count']); 
			$sql= "SELECT COUNT(case_id) as active_count FROM quebec where recovered =2 or recovered = 9";
			$result = query($sql);
			$row=dbFetchAssoc($result);
			array_push($data,$row['active_count']);
			$sql= "SELECT COUNT(case_id) as recoverd_count FROM quebec where recovered =1";
			$result = query($sql);
			$row=dbFetchAssoc($result);
			array_push($data,$row['recoverd_count']);
			return $data;
		} else if($id=='3'){
			$sql= "SELECT COUNT(case_id) as total_count FROM ontario";
			$result = query($sql);
			$row=dbFetchAssoc($result);
			$data=array($row['total_count']); 
			$sql= "SELECT COUNT(case_id) as active_count FROM ontario where recovered =2 or recovered = 9";
			$result = query($sql);
			$row=dbFetchAssoc($result);
			array_push($data,$row['active_count']);
			$sql= "SELECT COUNT(case_id) as recoverd_count FROM ontario where recovered =1";
			$result = query($sql);
			$row=dbFetchAssoc($result);
			array_push($data,$row['recoverd_count']);
			return $data;
		}else if($id=='4'){
			$sql= "SELECT COUNT(case_id) as total_count FROM prairies";
			$result = query($sql);
			$row=dbFetchAssoc($result);
			$data=array($row['total_count']); 
			$sql= "SELECT COUNT(case_id) as active_count FROM prairies where recovered =2 or recovered = 9";
			$result = query($sql);
			$row=dbFetchAssoc($result);
			array_push($data,$row['active_count']);
			$sql= "SELECT COUNT(case_id) as recoverd_count FROM prairies where recovered =1";
			$result = query($sql);
			$row=dbFetchAssoc($result);
			array_push($data,$row['recoverd_count']);
			return $data;
		}else if($id=='5'){
			$sql= "SELECT COUNT(case_id) as total_count FROM britishcolumbia";
			$result = query($sql);
			$row=dbFetchAssoc($result);
			$data=array($row['total_count']); 
			$sql= "SELECT COUNT(case_id) as active_count FROM britishcolumbia where recovered =2 or recovered = 9";
			$result = query($sql);
			$row=dbFetchAssoc($result);
			array_push($data,$row['active_count']);
			$sql= "SELECT COUNT(case_id) as recoverd_count FROM britishcolumbia where recovered =1";
			$result = query($sql);
			$row=dbFetchAssoc($result);
			array_push($data,$row['recoverd_count']);
			return $data;
	}
}

?>