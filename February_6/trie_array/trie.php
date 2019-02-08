<?php
/**
* Author : Don Bhrayan M. Singh
*
* This is a Trie data structure with PHP Assoc array implementation.
* We use multidimensional arrays because a full OOP application is too
* resource hungry and slower than brute force!
*
* Complexity:
* Insertion is O(m)  where m is the size of the word
* Search is O(m * log N) where is N is the amount of total words
*/
class Trie
{
    //Root of Trie
    public $node = [
        "child" => [],
        "last"  => false,
    ];
    
    public $search_keys = [];
    public $search_results = [];
    
    //Just for testing...
    public $counter = 0;

    /*
     * We use fopen implementation because loading 150k lines
     * in one go lags my shitty PC. This allows us to read
     * 1 line at a time.
    */    
    public function loadWords($filename)
    {
        $handle = fopen($filename, "r");

        while (($line = fgets($handle)) !== false) {
            $this->insert(strtolower(trim($line)));
        }

        fclose($handle);
    }

    public function loadLetters($filename)
    {
        $handle = fopen($filename, "r");
        $this->search_keys = [];

        while (($line = fgets($handle)) !== false) {
            $this->search_keys[] = (strtolower(trim($line)));
        }

        fclose($handle);
    }

    private function insert($word)
    {
        $trav = &$this->node;

        foreach (str_split($word) as $letter) {
            if (!isset($trav["child"][$letter])) {
                $trav["child"][$letter] = [
                    "child" => [],
                    "last"  => false,
                ];
            }
            $trav = &$trav["child"][$letter];
        }

        //Since we exit the foreach, trav now has the last letter,
        //so we add the stopper to tell us that this is a full word
        $trav["last"] = true;
    }

    /*
     * Finds all the words in the Trie that matches ALL
     * letters in the given array
     * @return array of words that matches
    */
    public function findWords()
    {
        $trav = &$this->node;
        $string = "";
        $this->search_results = [];
        $this->counter = 0;

        foreach ($this->search_keys as $letter) {
            if (isset($trav["child"][$letter])) {
                $string .= $letter;
                $this->traverse($trav["child"][$letter], $string);
                $string = "";
            }
        }

        return ["results"=>$this->search_results,"count"=>$this->counter];
    }

    public function traverse(&$trav, $string)
    {
        //If last flag is true, then this is the end of A word
        if ($trav["last"] === true) {
            $this->search_results[] = $string;
        }

        //Go deeper, pass the next child letter array
        foreach ($this->search_keys as $letter) {
            $this->counter++;
            if (isset($trav["child"][$letter])) {
                $this->traverse($trav["child"][$letter], $string . $letter);
            }
        }
    }
}
