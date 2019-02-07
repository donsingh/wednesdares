<?php

/**
Complexity

Insert O(365);
Traverse O(365 * K)
where K is the dates enrolled by a given student

This implementation plots an array map for each calendar date that
a student has enrolled in. This will then add a tally for each date of
how many students are enrolled.

**/

class School
{
    protected $calendar = [];
    // $calendar = [
    //     "2009-01-01" => [
    //         "totalStudents" => 2,
    //         "students"      =>  [2,4],
    //     ],
    // ];
    protected $lastId;
    protected $totalEnrolled;
    protected $enrollmentLimit = 10;
    
    public function __construct()
    {
        $this->lastId = 0;
        $this->totalEnrolled = 0;
    }
    
    public function insert($start, $end)
    {
        if($dates = $this->validEnrollment($start, $end)){
            $newId = ++$this->lastId;
            foreach($dates as $date){
                if(!isset($this->calendar[$date])){
                    $this->calendar[$date]["students"] = [$newId];
                    $this->calendar[$date]["totalStudents"] = 1;
                }else{
                    $this->calendar[$date]["students"][] = $newId;
                    $this->calendar[$date]["totalStudents"]++;
                }
            }
            $this->totalEnrolled++;
        }else{
            print "Student limit reached for the desired date range." . PHP_EOL;
        }
    }
    
    //Gets all the dates in the date range and checks if one of dates has enrollement
    // reaching the limit. If not, get the list of all the dates where the student will
    // be enrolled.
    public function validEnrollment($start, $end)
    {
        $dates = [];
        $range = new DatePeriod(new DateTime($start), DateInterval::createFromDateString('1 day'), new DateTime($end));
        foreach ($range as $date) {
            $date = $date->format("Y-m-d");
            $dates[] = $date;
            if(isset($this->calendar[$date]) && $this->calendar[$date]["totalStudents"] == $this->enrollmentLimit){
                return false;
            }
        }
        return $dates;
    }
    
    public function getCalendar()
    {
        return $this->calendar;
    }
}
