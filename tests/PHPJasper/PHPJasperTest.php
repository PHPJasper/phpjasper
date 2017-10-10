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
        $this->windows = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN' ? true : false;
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

        $expected = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN' ? '' : './';
        $expected .= 'jasperstarter compile "{input_file}" -o "{output_file}"';

        $this->assertEquals($expected, $result->output());
    }

    public function testListParameters()
    {
        $result = $this->PHPJasper->listParameters('{input_fille}');

        $this->assertInstanceOf(PHPJasper::class, $result);

        $expected = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN' ? '' : './';
        $expected .= 'jasperstarter list_parameters "{input_fille}"';

        $this->assertEquals($expected, $result->output());
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

        $result = $jasper->compile('hello_world.jrxml');

        $this->assertInstanceOf(PHPJasper::class, $result);

        if ($this->windows) {

            $this->assertEquals('jasperstarter compile "hello_world.jrxml"', $result->output());

        } else {

            $this->assertEquals('./jasperstarter compile "hello_world.jrxml"', $result->output());
        }

    }

    public function testExecuteWithoutCompile()
    {
        $this->expectException(\PHPJasper\Exception\InvalidCommandExecutable::class);

        $jasper = new PHPJasper();
        $jasper->execute();
    }

    public function testExecuteWithCompile()
    {
        $this->expectException(\PHPJasper\Exception\ErrorCommandExecutable::class);

        $jasper = new PHPJasper();
        $jasper->compile('hello_world.jrxml')->execute();
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