<?php
//Coding Challenge Solution 2 Implementation

require("Sol'n2_Array/SchoolArraymap.php");

$json = file_get_contents('entries.json');
$data = json_decode($json,true);

$db = new School();

foreach($data as $student){
    echo $student[0] . " - " . $student[1] . PHP_EOL;
    $db->insert($student[0], $student[1]);
}
