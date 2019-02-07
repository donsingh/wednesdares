<?php

class Find
{
    public $words = [];
    public $letters = [];

    public function __construct()
    {
        $this->load();
    }

    public function load($word_file = "words_alpha.txt", $letter_file = "letters.txt")
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
    public function basicFind()
    {
        $timer = 0;

        foreach ($this->words as $index => $word) {
            $found = [];

            foreach (str_split($word) as $part) {

                $timer++;

                if (in_array($part, $this->letters)) {

                    $found[] = $part;

                }

            }

            if (strlen($word) != count($found)) {
                unset($this->words[$index]);
            }

        }

        echo $timer;
    }

}

$test = new Find();

$executionStartTime = microtime(true);
$test->basicFind();
$executionEndTime = microtime(true);

//The result will be in seconds and milliseconds.
$seconds = $executionEndTime - $executionStartTime;

//Print it out
echo "This script took $seconds to execute.";
