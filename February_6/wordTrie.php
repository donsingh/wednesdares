<?php
class Node
{
    public $children = [];
    public $last = false;
}

class Trie
{
    public $root = null;
    public $timer = 0;

    public function __construct()
    {
        $this->root = new Node();
    }

    public function loadFile($filename)
    {
        $handle = fopen($filename, "r");

        while (($line = fgets($handle)) !== false) {
            $this->insert(strtolower(trim($line)));
        }

    }

    public function insert($word)
    {
        $trav = $this->root;
        $prev = null;

        foreach (str_split($word) as $letter) {

            if (!isset($trav->children[$letter])) {
                $trav->children[$letter] = new Node();
            }

            $trav = $trav->children[$letter];
        }

        $trav->last = true;
    }

    public function printValid($given)
    {
        $trav = $this->root;
        $string = "";

        foreach ($given as $letter) {

            if (isset($trav->children[$letter])) {
                $string .= $letter;
                $this->searchDown($trav->children[$letter], $given, $string);
                $string = "";
            }

        }

    }

    public function searchDown($trav, $given, $string)
    {

        if ($trav->last === true) {
            // print $string . PHP_EOL;
        }

        foreach ($given as $letter) {
            $this->timer++;

            if (isset($trav->children[$letter])) {
                $this->searchDown($trav->children[$letter], $given, $string . $letter);
            }

        }

    }

}

//WHAT IF DILI KA MAG OOP BOANGA KA!?
//Trie is O(n)
$test = new Trie();

$test->loadFile("words_alpha.txt");
$allow = ['e', 'o', 'b', 'a', 'm', 'g', 'l'];

$executionStartTime = microtime(true);
$test->printValid($allow);
$executionEndTime = microtime(true);
echo $test->timer;
//The result will be in seconds and milliseconds.
$seconds = $executionEndTime - $executionStartTime;

//Print it out
echo "This script took $seconds to execute.";
