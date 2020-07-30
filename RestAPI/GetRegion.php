<?php
require_once 'db.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods:GET");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $data = getData();
    $dataToSend = array('reg' => $data);
    echo json_encode($dataToSend);
}
function getData()
{
    $sql = "SELECT region_name FROM `region_table` ";
    $result = query($sql);
    $rows = array();
    while ($row = dbFetchAssoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}
