<?php

class School
{
    public $root;
    protected $overlap = 0;
    protected $enrollment_limit = 5;

    public function __construct()
    {
        $this->root = null;
    }
    
    public function isEmpty()
    {
        return $this->root === null;
    }
    
    public function insert(Student $node)
    {
        print "Attempting to insert student @ ".date("Y-m-d", $node->startDate)." to ".date("Y-m-d", $node->endDate). PHP_EOL;
        if($this->isEmpty()){
            $this->root = $node;
            return true;
        }else{
            if($this->canEnroll($node)){
                $this->insertStudent($node, $this->root);
                return true;
            }
        }
        print "\tStudent limit reached for the desired date range." . PHP_EOL;
        return false;
    }

    private function insertStudent(Student $node, &$pointer)
    {
        if(is_null($pointer)){
            $pointer = $node;
        }else{
            if($node->startDate >= $pointer->startDate){
                $this->insertStudent($node, $pointer->right);
            } else {
                $this->insertStudent($node, $pointer->left);
            }
        }
    }
    
    private function canEnroll(Student $node)
    {
        $this->overlap = 0;
        $this->countOverlapping($node, $this->root);
        return $this->overlap < $this->enrollment_limit ?: false;
    }

    private function countOverlapping(Student $node, $pointer)
    {
        if ($pointer->left !== null) {
            $this->countOverlapping($node, $pointer->left);
        }
        
        if($node->startDate <= $pointer->endDate && $pointer->startDate <= $node->endDate){
            $this->overlap++;
        }
        
        if ($pointer->right !== null) {
            $this->countOverlapping($node, $pointer->right);
        }
    }

    public function showCalendar()
    {
        if($this->isEmpty()){
            print "Enrollment is empty!";
            return;
        }
            
        $this->root->walk($this->root);
    }

    public function childOf(Student $node)
    {
        $node->getChildStudents();
    }
}

class Student
{
    public $startDate;
    public $endDate;
    public $studentId;
    public $left;
    public $right;
    
    public function __construct($given)
    {
        $this->startDate = strtotime($given['startDate']);
        $this->endDate = strtotime($given['endDate']);
        $this->studentId = $given['studentId'];
        $this->left = null;
        $this->right = null;
    }
    
    
    public function walk()
    {
        if ($this->left !== null) {
            $this->left->walk();
        }
        
        $out = "Student# {$this->studentId} @ ".date("Y-m-d", $this->startDate)." to ".date("Y-m-d", $this->endDate);
        print $out . PHP_EOL;
        
        if ($this->right !== null) {
            $this->right->walk();
        }
    }
    
    public function getChildStudents()
    {
        $out = "Student ID {$this->studentId} ";
        if($this->left !== null){
            $out .= " has a left node of Student ID {$this->left->studentId}";
        }else{
            $out .= " has no left node";
        }
        
        if($this->right !== null){
            $out .= " and has a right node of Student ID {$this->right->studentId}";
        }else{
            $out .= " and has no right node";
        }
        
        echo $out . PHP_EOL;
    }
}
