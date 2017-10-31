<?php

/*
 * This file is part of the PHPJasper.
 *
 * (c) Daniel Rodrigues (geekcom)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace PHPJasper\Test;

use PHPUnit\Framework\TestCase;
use PHPJasper\PHPJasper;

/**
 * @author Rafael Queiroz <rafaelfqf@gmail.com>
 */
class PHPJasperTest extends TestCase
{
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
        $result = $this->PHPJasper->compile('examples/hello_world.jrxml', '{output_file}');

        $this->assertInstanceOf(PHPJasper::class, $result);

        $expected = '.*jasperstarter compile ".*hello_world.jrxml" -o "{output_file}"';

        $this->assertRegExp('/'.$expected.'/', $result->output());
    }

    public function testListParameters()
    {
        $result = $this->PHPJasper->listParameters('examples/hello_world.jrxml');

        $this->assertInstanceOf(PHPJasper::class, $result);

        $this->assertRegExp(
            '/.*jasperstarter list_parameters ".*hello_world.jrxml"/',
            $result->output()
        );
    }

    public function testCompileWithWrongInput()
    {
        $this->expectException(\PHPJasper\Exception\InvalidInputFile::class);

        $jasper = new PHPJasper();

        $jasper->compile('');
    }

    public function testCompileHelloWorld()
    {
        $jasper = new PHPJasper();

        $result = $jasper->compile('examples/hello_world.jrxml');

        $this->assertInstanceOf(PHPJasper::class, $result);

        $this->assertRegExp('/.*jasperstarter compile ".*hello_world.jrxml"/', $result->output());
    }

    public function testExecuteWithoutCompile()
    {
        $this->expectException(\PHPJasper\Exception\InvalidCommandExecutable::class);

        $jasper = new PHPJasper();
        $jasper->execute();
    }

    public function testInvalidInputFile()
    {
        $this->expectException(\PHPJasper\Exception\InvalidInputFile::class);

        $jasper = new PHPJasper();
        $jasper->compile('{invalid}')->execute();
    }

    public function testExecute()
    {
        $jasper = new PHPJasper();
        $actual = $jasper->compile(__DIR__ . '/test.jrxml')->execute();

        $this->assertInternalType('array', $actual);
    }

    public function testListParametersWithWrongInput()
    {
        $this->expectException(\PHPJasper\Exception\InvalidInputFile::class);

        $jasper = new PHPJasper();
        $jasper->listParameters('');
    }

    public function testProcessWithWrongInput()
    {
        $this->expectException(\PHPJasper\Exception\InvalidInputFile::class);

        $jasper = new PHPJasper();
        $jasper->process('', '', [
            'format' => 'mp3'
        ]);
    }

    public function testProcessWithWrongFormat()
    {
        $this->expectException(\PHPJasper\Exception\InvalidFormat::class);

        $jasper = new PHPJasper();
        $jasper->process('hello_world.jrxml', '', [
            'format' => 'mp3'
        ]);
    }

    public function testProcess()
    {
        $jasper = new PHPJasper();
        $this->assertInstanceOf(PHPJasper::class, $jasper->process('hello_world.jrxml', ""));
    }
}
