<?php
	require_once 'db.php';

	header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods:GET");
    
    if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['regionid'])){
        if($_GET['regionid']!='6'){
            $data=getData($_GET['regionid']);
            $deathData=getDeathData($_GET['regionid']);
            $dataToSend=Array('jsonarray'=>$data,'deathdata'=>$deathData);
            echo json_encode($dataToSend);
            
        }
    }

    function getData($id){
        if($id==1){
            $sql="SELECT COUNT(*) as count ,onsetweekofsym FROM `atlantic` WHERE onsetweekofsym!=99 GROUP BY onsetweekofsym ASC";
            $result=query($sql);
            $rows=Array();
            while($row=dbFetchAssoc($result)){
                $rows[]=$row;
            }
            return $rows;
        }else if($id==2){
            $sql="SELECT COUNT(*) as count,onsetweekofsym FROM `quebec` WHERE onsetweekofsym!=99 GROUP BY onsetweekofsym ASC";
            $result=query($sql);
            $rows=Array();
            while($row=dbFetchAssoc($result)){
                $rows[]=$row;
            }
            return $rows;
        }else if($id==3){
            $sql="SELECT COUNT(*) as count,onsetweekofsym FROM `ontario` WHERE onsetweekofsym!=99 GROUP BY onsetweekofsym ASC";
            $result=query($sql);
            $rows=Array();
            while($row=dbFetchAssoc($result)){
                $rows[]=$row;
            }
            return $rows;
        }else if($id==4){
            $sql="SELECT COUNT(*) as count,onsetweekofsym FROM `prairies` WHERE onsetweekofsym!=99 GROUP BY onsetweekofsym ASC";
            $result=query($sql);
            $rows=Array();
            while($row=dbFetchAssoc($result)){
                $rows[]=$row;
            }
            return $rows;

        }else if($id==5){
            $sql="SELECT COUNT(*) as count,onsetweekofsym FROM `britishcolumbia` WHERE onsetweekofsym!=99 GROUP BY onsetweekofsym ASC";
            $result=query($sql);
            $rows=Array();
            while($row=dbFetchAssoc($result)){
                $rows[]=$row;
            }
            return $rows;
        }
    }
    function getDeathData($id){
        if($id==1){
            $sql="SELECT COUNT(*) as count,onsetweekofsym FROM `atlantic` WHERE death=1 AND onsetweekofsym!=99 GROUP BY onsetweekofsym ASC";
            $result=query($sql);
            $rows=Array();
            while($row=dbFetchAssoc($result)){
                $rows[]=$row;
            }
            return $rows;
        }else if($id==2){
            $sql="SELECT COUNT(*) as count,onsetweekofsym FROM `quebec` WHERE death=1 AND onsetweekofsym!=99 GROUP BY onsetweekofsym ASC";
            $result=query($sql);
            $rows=Array();
            while($row=dbFetchAssoc($result)){
                $rows[]=$row;
            }
            return $rows;
        }else if($id==3){
            $sql="SELECT COUNT(*) as count,onsetweekofsym FROM `ontario` WHERE death=1 AND onsetweekofsym!=99 GROUP BY onsetweekofsym ASC";
            $result=query($sql);
            $rows=Array();
            while($row=dbFetchAssoc($result)){
                $rows[]=$row;
            }
            return $rows;
        }else if($id==4){
            $sql="SELECT COUNT(*) as count,onsetweekofsym FROM `prairies` WHERE death=1 AND onsetweekofsym!=99 GROUP BY onsetweekofsym ASC";
            $result=query($sql);
            $rows=Array();
            while($row=dbFetchAssoc($result)){
                $rows[]=$row;
            }
            return $rows;

        }else if($id==5){
            $sql="SELECT COUNT(*) as count,onsetweekofsym FROM `britishcolumbia` WHERE death=1 AND onsetweekofsym!=99 GROUP BY onsetweekofsym ASC";
            $result=query($sql);
            $rows=Array();
            while($row=dbFetchAssoc($result)){
                $rows[]=$row;
            }
            return $rows;
        }
    }

?>