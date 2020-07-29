<?php
	require_once 'db.php';

	header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods:GET");
    
    if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['regionid'])){
        if($_GET['regionid']!='6'){
            $data=getData($_GET['regionid']);
            $femaleData=getFemaleData($_GET['regionid']);
            $dataToSend=Array('male'=>$data,'female'=>$femaleData);
            echo json_encode($dataToSend);
            
        }
    }
    function getData($id){
        if($id==1){
            $sql="SELECT COUNT(*) as male_count,agegroup FROM `atlantic` WHERE agegroup!=99 AND gender=1 GROUP BY agegroup ASC";
            $result=query($sql);
            $rows=Array();
            while($row=dbFetchAssoc($result)){
                $rows[]=$row;
            }
            return $rows;
        }else if($id==2){
            $sql="SELECT COUNT(*) as male_count,agegroup FROM `quebec` WHERE agegroup!=99 AND gender=1 GROUP BY agegroup ASC";
            $result=query($sql);
            $rows=Array();
            while($row=dbFetchAssoc($result)){
                $rows[]=$row;
            }
            return $rows;
        }else if($id==3){
            $sql="SELECT COUNT(*) as male_count,agegroup FROM `ontario` WHERE agegroup!=99 AND gender=1 GROUP BY agegroup ASC";
            $result=query($sql);
            $rows=Array();
            while($row=dbFetchAssoc($result)){
                $rows[]=$row;
            }
            return $rows;
        }else if($id==4){
            $sql="SELECT COUNT(*) as male_count,agegroup FROM `prairies` WHERE agegroup!=99 AND gender=1 GROUP BY agegroup ASC";
            $result=query($sql);
            $rows=Array();
            while($row=dbFetchAssoc($result)){
                $rows[]=$row;
            }
            return $rows;

        }else if($id==5){
            $sql="SELECT COUNT(*) as male_count,agegroup FROM `britishcolumbia` WHERE agegroup!=99 AND gender=1 GROUP BY agegroup ASC";
            $result=query($sql);
            $rows=Array();
            while($row=dbFetchAssoc($result)){
                $rows[]=$row;
            }
            return $rows;
        }
    }

    function getFemaleData($id){
        if($id==1){
            $sql="SELECT COUNT(*) as male_count,agegroup FROM `atlantic` WHERE agegroup!=99 AND gender=2 GROUP BY agegroup ASC";
            $result=query($sql);
            $rows=Array();
            while($row=dbFetchAssoc($result)){
                $rows[]=$row;
            }
            return $rows;
        }else if($id==2){
            $sql="SELECT COUNT(*) as male_count,agegroup FROM `quebec` WHERE agegroup!=99 AND gender=2 GROUP BY agegroup ASC";
            $result=query($sql);
            $rows=Array();
            while($row=dbFetchAssoc($result)){
                $rows[]=$row;
            }
            return $rows;
        }else if($id==3){
            $sql="SELECT COUNT(*) as male_count,agegroup FROM `ontario` WHERE agegroup!=99 AND gender=2 GROUP BY agegroup ASC";
            $result=query($sql);
            $rows=Array();
            while($row=dbFetchAssoc($result)){
                $rows[]=$row;
            }
            return $rows;
        }else if($id==4){
            $sql="SELECT COUNT(*) as male_count,agegroup FROM `prairies` WHERE agegroup!=99 AND gender=2 GROUP BY agegroup ASC";
            $result=query($sql);
            $rows=Array();
            while($row=dbFetchAssoc($result)){
                $rows[]=$row;
            }
            return $rows;

        }else if($id==5){
            $sql="SELECT COUNT(*) as male_count,agegroup FROM `britishcolumbia` WHERE agegroup!=99 AND gender=2 GROUP BY agegroup ASC";
            $result=query($sql);
            $rows=Array();
            while($row=dbFetchAssoc($result)){
                $rows[]=$row;
            }
            return $rows;
        }
    }
    

?>