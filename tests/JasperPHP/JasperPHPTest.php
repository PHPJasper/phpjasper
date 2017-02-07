<?php
class JasperPHPTest extends PHPUnit_Framework_TestCase
{

    /**
	 *
	 */
	public function testCompileWithWrongArgs()
	{
        $this->setExpectedException('Exception', 'No input file');

        $jasper = new \JasperPHP\JasperPHP();
        $jasper->compile(null);
        $jasper->compile('');
	}

	public function testCompile()
    {
        
    }

}
