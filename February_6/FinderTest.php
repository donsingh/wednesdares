<?php

require_once '../vendor/autoload.php';
require_once 'cc.php';

use PHPUnit\Framework\TestCase;

class FinderTest extends TestCase
{
    protected $finder;

    protected function setUp(): void
    {
        $this->finder = new Find();
    }

    public function testLoad()
    {
        //makes sure something is loaded
        $this->assertNotNull($this->finder->words);
        $this->assertNotNull($this->finder->letters);

        //makes sure array of strings are loaded
        $this->assertTrue(is_array($this->finder->words) && is_array($this->finder->letters));
        $this->assertContainsOnly('string', $this->finder->words);
        $this->assertContainsOnly('string', $this->finder->letters);
    }
    
    public function testBasic()
    {
        $output = $this->finder->basicFind();
        sort($output);
        $this->assertEquals($output,['bee','go','goal','me']);
    }

}

