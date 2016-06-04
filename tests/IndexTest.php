<?php 

class IndexTest extends PHPUnit_Framework_TestCase
{
	public function testName()
	{
		$_GET['name'] = 'Meathanjay';

		ob_start();

		include('index.php');

		$content = ob_get_clean();

        $this->assertEquals('Hello Meathanjay', $content);
	}
}