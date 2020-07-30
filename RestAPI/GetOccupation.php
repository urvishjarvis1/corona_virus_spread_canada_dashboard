<?php
require_once 'db.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods:GET");
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['regionid'])) {
    if ($_GET['regionid'] != '6') {
        $data = getData($_GET['regionid']);
       
        echo json_encode($data);
    }
}

function getData($id)
{
    if ($id == 1) {
        $sql = "SELECT(SELECT COUNT(*) FROM `atlantic` WHERE occupation=1) as healthcare_count,(SELECT COUNT(*) FROM `atlantic` WHERE occupation=2) as schoolworker_count,(SELECT COUNT(*) FROM `atlantic` WHERE occupation=3) as care_count,(SELECT COUNT(*) FROM `atlantic` WHERE occupation=4) as other_count;";
        $result = query($sql);
        $row = dbFetchAssoc($result);
        return $row;
    } else if ($id == 2) {
        $sql = "SELECT(SELECT COUNT(*) FROM `quebec` WHERE occupation=1) as healthcare_count,(SELECT COUNT(*) FROM `quebec` WHERE occupation=2) as schoolworker_count,(SELECT COUNT(*) FROM `quebec` WHERE occupation=3) as care_count,(SELECT COUNT(*) FROM `quebec` WHERE occupation=4) as other_count;";
        $result = query($sql);
        $row = dbFetchAssoc($result);
        return $row;
    } else if ($id == 3) {
        $sql = "SELECT(SELECT COUNT(*) FROM `ontario` WHERE occupation=1) as healthcare_count,(SELECT COUNT(*) FROM `ontario` WHERE occupation=2) as schoolworker_count,(SELECT COUNT(*) FROM `ontario` WHERE occupation=3) as care_count,(SELECT COUNT(*) FROM `ontario` WHERE occupation=4) as other_count;";
        $result = query($sql);
        $row = dbFetchAssoc($result);
        return $row;
    } else if ($id == 4) {
        $sql = "SELECT(SELECT COUNT(*) FROM `prairies` WHERE occupation=1) as healthcare_count,(SELECT COUNT(*) FROM `prairies` WHERE occupation=2) as schoolworker_count,(SELECT COUNT(*) FROM `prairies` WHERE occupation=3) as care_count,(SELECT COUNT(*) FROM `prairies` WHERE occupation=4) as other_count;";
        $result = query($sql);
        $row = dbFetchAssoc($result);
        return $row;
    } else if ($id == 5) {
        $sql = "SELECT(SELECT COUNT(*) FROM `britishcolumbia` WHERE occupation=1) as healthcare_count,(SELECT COUNT(*) FROM `britishcolumbia` WHERE occupation=2) as schoolworker_count,(SELECT COUNT(*) FROM `britishcolumbia` WHERE occupation=3) as care_count,(SELECT COUNT(*) FROM `britishcolumbia` WHERE occupation=4) as other_count;";
        $result = query($sql);
        $row = dbFetchAssoc($result);
        return $row;
    }
}
