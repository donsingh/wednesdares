<?php

class Brute
{
    public $words = [];
    public $letters = [];

    public function load($word_file, $letter_file)
    {

        $handle = fopen($word_file, "r");

        while (($line = fgets($handle)) !== false) {
            $this->words[] = strtolower(trim($line));
        }

        fclose($handle);

        foreach (explode("\n", file_get_contents($letter_file)) as $letter) {

            if ($letter != "") {
                $this->letters[] = strtolower(trim(preg_replace('/\s\s+/', ' ', $letter)));
            }

        }

    }

    //O(n*k) time complexity
    //reduced O(n) space complexity
    public function bruteFind()
    {
        $counter = 0;
        $bag = [];

        foreach ($this->words as $word) {
            $found = [];

            foreach (str_split($word) as $part) {
                $counter++;
                if (in_array($part, $this->letters)) {
                    $found[] = $part;
                }
            }

            if (strlen($word) == count($found)) {
                $bag[] = $word;
            }
        }
        return ["results"=>$bag,"count"=>$counter];
    }

}
