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
        $sql = "SELECT(SELECT COUNT(*) FROM `atlantic` WHERE transmission=1 GROUP BY transmission ASC) as transmission_count,(SELECT COUNT(*) FROM `atlantic` WHERE transmission=2 GROUP BY transmission ASC) as transmission2_count,(SELECT COUNT(*) FROM `atlantic` WHERE transmission=9 GROUP BY transmission ASC) as transmission3_count";
        $result = query($sql);
        $row = dbFetchAssoc($result);
        return $row;
    } else if ($id == 2) {
        $sql = "SELECT(SELECT COUNT(*) FROM `quebec` WHERE transmission=1 GROUP BY transmission ASC) as transmission_count,(SELECT COUNT(*) FROM `quebec` WHERE transmission=2 GROUP BY transmission ASC) as transmission2_count,(SELECT COUNT(*) FROM `quebec` WHERE transmission=9 GROUP BY transmission ASC) as transmission3_count";
        $result = query($sql);
        $row = dbFetchAssoc($result);
        return $row;
    } else if ($id == 3) {
        $sql = "SELECT(SELECT COUNT(*) FROM `ontario` WHERE transmission=1 GROUP BY transmission ASC) as transmission_count,(SELECT COUNT(*) FROM `ontario` WHERE transmission=2 GROUP BY transmission ASC) as transmission2_count,(SELECT COUNT(*) FROM `ontario` WHERE transmission=9 GROUP BY transmission ASC) as transmission3_count";
        $result = query($sql);
        $row = dbFetchAssoc($result);
        return $row;
        
    } else if ($id == 4) {
        $sql = "SELECT(SELECT COUNT(*) FROM `prairies` WHERE transmission=1 GROUP BY transmission ASC) as transmission_count,(SELECT COUNT(*) FROM `prairies` WHERE transmission=2 GROUP BY transmission ASC) as transmission2_count,(SELECT COUNT(*) FROM `prairies` WHERE transmission=9 GROUP BY transmission ASC) as transmission3_count";
        $result = query($sql);
        $row = dbFetchAssoc($result);
        return $row;
    } else if ($id == 5) {
        $sql = "SELECT(SELECT COUNT(*) FROM `britishcolumbia` WHERE transmission=1 GROUP BY transmission ASC) as transmission_count,(SELECT COUNT(*) FROM `britishcolumbia` WHERE transmission=2 GROUP BY transmission ASC) as transmission2_count,(SELECT COUNT(*) FROM `britishcolumbia` WHERE transmission=9 GROUP BY transmission ASC) as transmission3_count";
        $result = query($sql);
        $row = dbFetchAssoc($result);
        return $row;
    }
}

function getFemaleData($id)
{
    if ($id == 1) {
        $sql = "SELECT COUNT(*) as female_count,agegroup FROM `atlantic` WHERE agegroup!=99 AND gender=2 GROUP BY agegroup ASC";
        $result = query($sql);
        $rows = array();
        while ($row = dbFetchAssoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    } else if ($id == 2) {
        $sql = "SELECT COUNT(*) as female_count,agegroup FROM `quebec` WHERE agegroup!=99 AND gender=2 GROUP BY agegroup ASC";
        $result = query($sql);
        $rows = array();
        while ($row = dbFetchAssoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    } else if ($id == 3) {
        $sql = "SELECT COUNT(*) as female_count,agegroup FROM `ontario` WHERE agegroup!=99 AND gender=2 GROUP BY agegroup ASC";
        $result = query($sql);
        $rows = array();
        while ($row = dbFetchAssoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    } else if ($id == 4) {
        $sql = "SELECT COUNT(*) as female_count,agegroup FROM `prairies` WHERE agegroup!=99 AND gender=2 GROUP BY agegroup ASC";
        $result = query($sql);
        $rows = array();
        while ($row = dbFetchAssoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    } else if ($id == 5) {
        $sql = "SELECT COUNT(*) as female_count,agegroup FROM `britishcolumbia` WHERE agegroup!=99 AND gender=2 GROUP BY agegroup ASC";
        $result = query($sql);
        $rows = array();
        while ($row = dbFetchAssoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    }
}
