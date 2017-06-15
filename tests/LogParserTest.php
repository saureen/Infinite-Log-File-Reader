<?php
use PHPUnit\Framework\TestCase;

include('./config.php');
include_once('./inc/LogParser.class.php');

class LogParserTest extends Testcase{

	/**
	 * Test if getLines returns the correct number of lines in a file
	 * @todo Complete the assertions
	 * @return
	 */
	public function testGetLinesReturnsCorrectCount(){
		$original_lines_count = 40;
		$expected_lines_count = 40;	
		//call to getLines of LogParser...WIP :/
    	$this->assertEquals($original_lines_count,$expected_lines_count);
	}
}

?>