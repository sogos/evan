<?php

namespace Evan\Test;


class BootTest extends \PHPUnit_Framework_TestCase
{

	protected $app;

	public function testBoot()
	{
		$app = require(__DIR__ .'/../../../app/Kernel.php');
		$this->assertInstanceof('\Pimple' , $app);
		return $app;
	}
	 /**
     * @depends testBoot
     */
    public function testPath(\Pimple $app)
    {
    	$app_path = $app['app_path'];
    	$web_path = $app['web_path'];
   		$this->assertFileExists($app_path . '/Kernel.php' , 'Kernel.php is present in app folder');
   		$this->assertFileExists($web_path . '/.htaccess' , '.htaccess is present in web folder');
    }
}

?>
