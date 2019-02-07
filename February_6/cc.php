<?php

class Find
{
    public $words;
    public $letters;

    public function __construct()
    {
        $this->load();
    }

    public function getEqualSets()
    {
        $this->basicFind();
        print_r($this->words);
    }

    private function load()
    {
        $this->words = explode("\n", file_get_contents("words.txt"));
        unset($this->words[count($this->words)-1]);

        $this->letters = explode("\n", file_get_contents("letters.txt"));
        unset($this->letters[count($this->letters)-1]);
    }

    //O(n*k) time complexity
    //reduced O(n) space complexity
    private function basicFind()
    {
        foreach($this->words as $index => $word){
            $found = [];
            foreach(str_split($word) as $part){
                if(in_array($part, $this->letters)){
                    $found[] = $part;
                }
            }
            if(strlen($word) != count($found)){
                unset($this->words[$index]);
            }
        }
    }
}

$test = new Find();
$test->getEqualSets();
