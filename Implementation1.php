<?php
//Coding Challenge Solution 1 Implementation

require("Sol'n1_IntervalTree/SchoolTree.php");

$json = file_get_contents('entries.json');
$data = json_decode($json,true);


$db = new School();



foreach($data as $id => $range){
    $param = [
        'startDate' => $range[0],
        'endDate'   => $range[1],
        'studentId' => $id,
    ];
    $leaf = new Student($param);
    $db->insert($leaf);
}

$db->showCalendar();