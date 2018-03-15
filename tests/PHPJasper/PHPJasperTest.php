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
    /**
     * @var
     */
    private $instance;

    public function setUp()
    {
        $this->instance = new PHPJasper();
    }

    public function tearDown()
    {
        unset($this->instance);
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(PHPJasper::class, new PHPJasper());
    }

    public function testCompile()
    {
        $result = $this->instance->compile('examples/hello_world.jrxml', '{output_file}');

        $expected = '.*jasperstarter compile ".*hello_world.jrxml" -o "{output_file}"';

        $this->assertRegExp('/'.$expected.'/', $result->output());
    }

    public function testProcess()
    {
        $result = $this->instance->process('examples/hello_world.jrxml', '{output_file}');

        $expected = '.*jasperstarter process ".*hello_world.jrxml" -o "{output_file}"';

        $this->assertRegExp('/'.$expected.'/', $result->output());

    }

    public function testListParameters()
    {
        $result = $this->instance->listParameters('examples/hello_world.jrxml');

        $this->assertRegExp(
            '/.*jasperstarter list_parameters ".*hello_world.jrxml"/',
            $result->output()
        );
    }

    public function testCompileWithWrongInput()
    {
        $this->expectException(\PHPJasper\Exception\InvalidInputFile::class);

        $this->instance->compile('');
    }

    public function testCompileHelloWorld()
    {
        $result = $this->instance->compile('examples/hello_world.jrxml');

        $this->assertRegExp('/.*jasperstarter compile ".*hello_world.jrxml"/', $result->output());
    }

    public function testExecuteWithoutCompile()
    {
        $this->expectException(\PHPJasper\Exception\InvalidCommandExecutable::class);

        $this->instance->execute();
    }

    public function testInvalidInputFile()
    {
        $this->expectException(\PHPJasper\Exception\InvalidInputFile::class);

        $this->instance->compile('{invalid}')->execute();
    }

    public function testExecute()
    {
        $actual = $this->instance->compile(__DIR__ . '/test.jrxml')->execute();

        $this->assertInternalType('array', $actual);
    }

    public function testListParametersWithWrongInput()
    {
        $this->expectException(\PHPJasper\Exception\InvalidInputFile::class);

        $this->instance->listParameters('');
    }

    public function testProcessWithWrongInput()
    {
        $this->expectException(\PHPJasper\Exception\InvalidInputFile::class);

        $this->instance->process('', '', [
            'format' => 'mp3'
        ]);
    }

    public function testProcessWithWrongFormat()
    {
        $this->expectException(\PHPJasper\Exception\InvalidFormat::class);

        $this->instance->process('hello_world.jrxml', '', [
            'format' => 'mp3'
        ]);
    }
}
