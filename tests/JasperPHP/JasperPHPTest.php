<?php
namespace JasperPHP;

use PHPUnit_Framework_TestCase;

class JasperPHPTest extends PHPUnit_Framework_TestCase
{

    /**
	 *
	 */
	public function testCompileWithWrongArgs()
	{
        $this->setExpectedException('Exception', 'No input file');

        $jasper = new JasperPHP();
        $jasper->compile(null);
        $jasper->compile('');
	}

    /**
     *
     */
	public function testCompile()
    {
        $jasper = new JasperPHP();
        $jasper->compile('something');
    }

}
