<?php
namespace JasperPHP;

use PHPUnit_Framework_TestCase;

class JasperPHPTest extends PHPUnit_Framework_TestCase
/**
 * Class JasperPHPTest
 *
 * @author Rafael Queiroz <rafaelfqf@gmail.com>
 * @package JasperPHP
 */
{

    /**
     *
     */
    public function testConstructor()
    {
        $this->assertInstanceOf(JasperPHP::class, new JasperPHP());
    }

    /**
     *
     */
    public function testCompileWithWrongInput()
    {
        $this->setExpectedException(\JasperPHP\Exception\InvalidInputFile::class);

        $jasper = new JasperPHP();
        $jasper->compile(null);
    }

    /**
     *
     */
    public function testCompile()
    {
        $jasper = new JasperPHP();
        $result = $jasper->compile('hello_world.jrxml');

        $this->assertInstanceOf(JasperPHP::class, $result);
        $this->assertEquals('./jasperstarter compile "hello_world.jrxml"', $result->output());
    }

    /**
     *
     */
    public function testExecuteWithoutCompile()
    {
        $this->setExpectedException(\JasperPHP\Exception\InvalidCommandExecutable::class);

        $jasper = new JasperPHP();
        $jasper->execute();
    }

    /**
     *
     */
    public function testExecuteWithCompile()
    {
        $this->setExpectedException(\JasperPHP\Exception\ErrorCommandExecutable::class);

        $jasper = new JasperPHP();
        $jasper->compile('hello_world.jrxml')->execute();
    }

    public function testListParametersWithWrongInput()
    {
        $this->setExpectedException(\JasperPHP\Exception\InvalidInputFile::class);

        $jasper = new JasperPHP();
        $jasper->listParameters('');
    }

    /**
     *
     */
    public function testListParameters()
    {
        $jasper = new JasperPHP();
        $result = $jasper->listParameters('hello_world.jrxml');

        $this->assertInstanceOf(JasperPHP::class, $result);
        $this->assertEquals('./jasperstarter list_parameters "hello_world.jrxml"', $result->output());
    }

    /**
     *
     */
    public function testProcessWithWrongInput()
    {
        $this->setExpectedException(\JasperPHP\Exception\InvalidInputFile::class);

        $jasper = new JasperPHP();
        $jasper->process(0);
    }

    /**
     *
     */
    public function testProcessWithWrongFormat()
    {
        $this->setExpectedException(\JasperPHP\Exception\InvalidFormat::class);

        $jasper = new JasperPHP();
        $jasper->process('hello_world.jrxml', false, [
            'format' => 'mp3'
        ]);
    }

    /**
     *
     */
    public function testProcess()
    {
        $jasper = new JasperPHP();
        $this->assertInstanceOf(JasperPHP::class, $jasper->process('hello_world.jrxml'));
    }

}