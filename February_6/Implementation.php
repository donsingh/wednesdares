<?php
/**
  *
  *
  * Just run me via "php Implementation.php" in CLI please!
  *
  *
**/

require_once("brute_force/brute.php");
require_once("trie_array/trie.php");
$correct_results = ["bee", "go", "goal", "me"];

echo "Testing and Comparing the two answers for codechallenge...\n\n";

//Testing Brute
echo "Testing Brute-force implementation first: ".PHP_EOL;
$brute = new Brute();
echo "\tLoading Files..." . PHP_EOL;
$brute->load("words.txt", "letters.txt");
echo "\tExecuting search... " . PHP_EOL;

$output = $brute->bruteFind();
sort($output["results"]);

if($correct_results === $output["results"]){
    echo "\tBasic testing for Brute-force passed! Correct results.\n\n";
}


//Testing Trie
echo "Testing Trie-array implementation: " . PHP_EOL;
$trie = new Trie();
echo "\tLoading Files..." . PHP_EOL;
$trie->loadWords("words.txt");
$trie->loadLetters("letters.txt");

echo "\tExecuting search..." . PHP_EOL;
$output = $trie->findWords();
sort($output["results"]);

if($correct_results === $output["results"]){
    echo "\tBasic testing for Trie-array passed! Correct results.\n\n";
}


//Execution/Search Time testing
echo "Moving to execution time testing (excluding file load time)...\n";
$brute->load("words_alpha.txt", "letters.txt");
$executionStartTime = microtime(true);
$output = $brute->bruteFind();
$executionEndTime = microtime(true);
$seconds = $executionEndTime - $executionStartTime;
echo "\tBrute-force of 350k word search took $seconds seconds to execute.\n";
echo "\t\t Process took " . number_format($output['count']) . " iterations!\n\n";

$trie->loadWords("words_alpha.txt");
$executionStartTime = microtime(true);
$output = $trie->findWords();
$executionEndTime = microtime(true);
$seconds = $executionEndTime - $executionStartTime;
echo "\tTrie-array of 350k word search took $seconds seconds to execute.\n";
echo "\t\t Process took " . number_format($output['count']) . " iterations!\n\n";
