<?php

namespace PHPJasper;

use PHPUnit\Framework\TestCase;

final class PHPJasperTest extends TestCase
    /**
     * Class PHPJasperTest
     *
     * @author Rafael Queiroz <rafaelfqf@gmail.com>
     * @author Daniel Rodrigues Lima ( geekcom ) <danielrodrigues-ti@hotmail.com>
     * @package PHPJasper
     */
{
    private $PHPJasper;
    private $input;
    private $output;

    public function setUp()
    {
        $this->PHPJasper = new PHPJasper();
    }

    public function tearDown()
    {
        unset($this->PHPJasper);
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(PHPJasper::class, new PHPJasper());
    }

    public function testCompile()
    {
        $result = $this->PHPJasper->compile('{input_file}', '{output_file}');

        $this->assertInstanceOf(PHPJasper::class, $result);
        $this->assertEquals('jasperstarter compile "{input_file}" -o "{output_file}"', $result->output());
    }

    public function testListParameters()
    {
        $result = $this->PHPJasper->listParameters('{input_fille}');

        $this->assertInstanceOf(PHPJasper::class, $result);
        $this->assertEquals('jasperstarter list_parameters "{input_fille}"', $result->output());
    }

    /*public function testCompileWithWrongInput()
    {
        $this->setExpectedExceptionFromAnnotation(\PHPJasper\Exception\InvalidInputFile::class);

        $jasper = new PHPJasper();
        $jasper->compile(null);
    }*/
    /*public function testCompileWithWrongInput()
    {
        $this->setExpectedException(\PHPJasper\Exception\InvalidInputFile::class);

        $jasper = new PHPJasper();
        $jasper->compile(null);
    }

    public function testCompile()
    {
        $jasper = new PHPJasper();
        $result = $jasper->compile('hello_world.jrxml');

        $this->assertInstanceOf(PHPJasper::class, $result);
        $this->assertEquals('./jasperstarter compile "hello_world.jrxml"', $result->output());
    }

    public function testExecuteWithoutCompile()
    {
        $this->setExpectedException(\PHPJasper\Exception\InvalidCommandExecutable::class);

        $jasper = new PHPJasper();
        $jasper->execute();
    }

    public function testExecuteWithCompile()
    {
        $this->setExpectedException(\PHPJasper\Exception\ErrorCommandExecutable::class);

        $jasper = new PHPJasper();
        $jasper->compile('hello_world.jrxml')->execute();
    }

    public function testListParametersWithWrongInput()
    {
        $this->setExpectedException(\PHPJasper\Exception\InvalidInputFile::class);

        $jasper = new PHPJasper();
        $jasper->listParameters('');
    }

    public function testProcessWithWrongInput()
    {
        $this->setExpectedException(\PHPJasper\Exception\InvalidInputFile::class);

        $jasper = new PHPJasper();
        $jasper->process(0);
    }

    public function testProcessWithWrongFormat()
    {
        $this->setExpectedException(\PHPJasper\Exception\InvalidFormat::class);

        $jasper = new PHPJasper();
        $jasper->process('hello_world.jrxml', false, [
            'format' => 'mp3'
        ]);
    }

    public function testProcess()
    {
        $jasper = new PHPJasper();
        $this->assertInstanceOf(PHPJasper::class, $jasper->process('hello_world.jrxml'));
    }*/

}