<?php
	require_once 'db.php';

	header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods:GET");
    
    if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['regionid'])){
        if($_GET['regionid']!='6'){
            $data=getData($_GET['regionid']);
            $hospitalData=gethospitalData($_GET['regionid']);
            $notHpData=getNotHospitalData($_GET['regionid']);
            $dataToSend=Array('icu'=>$data,'hospital'=>$hospitalData,'nothospital'=>$notHpData);
            echo json_encode($dataToSend);
            
        }
    }

    function getData($id){
        if($id==1){
            $sql="SELECT COUNT(*) as count,onsetweekofsym FROM `atlantic` WHERE hospitalstatus=1 AND onsetweekofsym!=99 GROUP BY onsetweekofsym ASC;";
            $result=query($sql);
            $rows=Array();
            while($row=dbFetchAssoc($result)){
                $rows[]=$row;
            }
            return $rows;
        }else if($id==2){
            $sql="SELECT COUNT(*) as count,onsetweekofsym FROM `quebec` WHERE hospitalstatus=1 AND onsetweekofsym!=99 GROUP BY onsetweekofsym ASC;";
            $result=query($sql);
            $rows=Array();
            while($row=dbFetchAssoc($result)){
                $rows[]=$row;
            }
            return $rows;
        }else if($id==3){
            $sql="SELECT COUNT(*) as count,onsetweekofsym FROM `quebec` WHERE hospitalstatus=1 AND onsetweekofsym!=99 GROUP BY onsetweekofsym ASC;";
            $result=query($sql);
            $rows=Array();
            while($row=dbFetchAssoc($result)){
                $rows[]=$row;
            }
            return $rows;
        }else if($id==4){
            $sql="SELECT COUNT(*) as count,onsetweekofsym FROM `prairies` WHERE hospitalstatus=1 AND onsetweekofsym!=99 GROUP BY onsetweekofsym ASC;";
            $result=query($sql);
            $rows=Array();
            while($row=dbFetchAssoc($result)){
                $rows[]=$row;
            }
            return $rows;

        }else if($id==5){
            $sql="SELECT COUNT(*) as count,onsetweekofsym FROM `britishcolumbia` WHERE hospitalstatus=1 AND onsetweekofsym!=99 GROUP BY onsetweekofsym ASC;";
            $result=query($sql);
            $rows=Array();
            while($row=dbFetchAssoc($result)){
                $rows[]=$row;
            }
            return $rows;
        }
    }
    function gethospitalData($id){
        if($id==1){
            $sql="SELECT COUNT(*) as count,onsetweekofsym FROM `atlantic` WHERE hospitalstatus=2 AND onsetweekofsym!=99 GROUP BY onsetweekofsym ASC;";
            $result=query($sql);
            $rows=Array();
            while($row=dbFetchAssoc($result)){
                $rows[]=$row;
            }
            return $rows;
        }else if($id==2){
            $sql="SELECT COUNT(*) as count,onsetweekofsym FROM `quebec` WHERE hospitalstatus=2 AND onsetweekofsym!=99 GROUP BY onsetweekofsym ASC;";
            $result=query($sql);
            $rows=Array();
            while($row=dbFetchAssoc($result)){
                $rows[]=$row;
            }
            return $rows;
        }else if($id==3){
            $sql="SELECT COUNT(*) as count,onsetweekofsym FROM `ontario` WHERE hospitalstatus=2 AND onsetweekofsym!=99 GROUP BY onsetweekofsym ASC;";
            $result=query($sql);
            $rows=Array();
            while($row=dbFetchAssoc($result)){
                $rows[]=$row;
            }
            return $rows;
        }else if($id==4){
            $sql="SELECT COUNT(*) as count,onsetweekofsym FROM `prairies` WHERE hospitalstatus=2 AND onsetweekofsym!=99 GROUP BY onsetweekofsym ASC;";
            $result=query($sql);
            $rows=Array();
            while($row=dbFetchAssoc($result)){
                $rows[]=$row;
            }
            return $rows;

        }else if($id==5){
            $sql="SELECT COUNT(*) as count,onsetweekofsym FROM `britishcolumbia` WHERE hospitalstatus=2 AND onsetweekofsym!=99 GROUP BY onsetweekofsym ASC;";
            $result=query($sql);
            $rows=Array();
            while($row=dbFetchAssoc($result)){
                $rows[]=$row;
            }
            return $rows;
        }
    }
    function getNotHospitalData($id){
        if($id==1){
            $sql="SELECT COUNT(*) as count,onsetweekofsym FROM `atlantic` WHERE hospitalstatus=3 AND onsetweekofsym!=99 GROUP BY onsetweekofsym ASC;";
            $result=query($sql);
            $rows=Array();
            while($row=dbFetchAssoc($result)){
                $rows[]=$row;
            }
            return $rows;
        }else if($id==2){
            $sql="SELECT COUNT(*) as count,onsetweekofsym FROM `quebec` WHERE hospitalstatus=3 AND onsetweekofsym!=99 GROUP BY onsetweekofsym ASC;";
            $result=query($sql);
            $rows=Array();
            while($row=dbFetchAssoc($result)){
                $rows[]=$row;
            }
            return $rows;
        }else if($id==3){
            $sql="SELECT COUNT(*) as count,onsetweekofsym FROM `ontario` WHERE hospitalstatus=3 AND onsetweekofsym!=99 GROUP BY onsetweekofsym ASC;";
            $result=query($sql);
            $rows=Array();
            while($row=dbFetchAssoc($result)){
                $rows[]=$row;
            }
            return $rows;
        }else if($id==4){
            $sql="SELECT COUNT(*) as count,onsetweekofsym FROM `prairies` WHERE hospitalstatus=3 AND onsetweekofsym!=99 GROUP BY onsetweekofsym ASC;";
            $result=query($sql);
            $rows=Array();
            while($row=dbFetchAssoc($result)){
                $rows[]=$row;
            }
            return $rows;

        }else if($id==5){
            $sql="SELECT COUNT(*) as count,onsetweekofsym FROM `britishcolumbia` WHERE hospitalstatus=3 AND onsetweekofsym!=99 GROUP BY onsetweekofsym ASC;";
            $result=query($sql);
            $rows=Array();
            while($row=dbFetchAssoc($result)){
                $rows[]=$row;
            }
            return $rows;
        }

    }

?>