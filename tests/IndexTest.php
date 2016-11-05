<?php

class IndexTest extends PHPUnit_Framework_TestCase
{
	public function testName()
	{
		$_GET['name'] = 'Meathanjay';

		ob_start();

		include('web/front.php');

		$content = ob_get_clean();

        $this->assertContains('Meathanjay', $content);
	}
}
