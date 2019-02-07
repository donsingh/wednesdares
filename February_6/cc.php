<?php

class Find
{
    public $words = NULL;
    public $letters = NULL;

    public function __construct()
    {
        $this->load();
    }

    public function load($word_file = "words.txt", $letter_file = "letters.txt")
    {
        $this->words = explode("\n", file_get_contents($word_file));
        unset($this->words[count($this->words)-1]);

        $this->letters = explode("\n", file_get_contents($letter_file));
        unset($this->letters[count($this->letters)-1]);
    }

    //O(n*k) time complexity
    //reduced O(n) space complexity
    public function basicFind()
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
        return $this->words;
    }
}
