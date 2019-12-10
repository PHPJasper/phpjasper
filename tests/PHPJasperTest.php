<?php

/*
 * This file is part of the PHPJasper.
 *
 * (c) Daniel Rodrigues (geekcom)
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace PHPJasper\Test;

use PHPUnit\Framework\TestCase;
use PHPJasper\PHPJasper;
use PHPJasper\Exception;
use ReflectionObject;

/**
 * @author Rafael Queiroz <rafaelfqf@gmail.com>
 */
final class PHPJasperTest extends TestCase
{
    private $instance;

    public function setUp()
    {
        $this->instance = new PHPJasper();
    }

    /** @test */
    public function constructor()
    {
        $this->assertInstanceOf(PHPJasper::class, new PHPJasper());
    }

    /** @test */
    public function compile()
    {
        $result = $this->instance->compile('examples/hello_world.jrxml');

        $this->expectOutputRegex('/.*jasperstarter compile ".*hello_world.jrxml"/', $result->printOutput());
    }

    /** @test */
    public function process()
    {
        $result = $this->instance->process('examples/hello_world.jrxml', '{output_file}');

        $expected = '.*jasperstarter process ".*hello_world.jrxml" -o "{output_file}"';

        $this->expectOutputRegex('/' . $expected . '/', $result->printOutput());
    }

    /** @test */
    public function processWithOptions()
    {
        $options = [
            'locale' => 'en_US',
            'params' => [
                'param_1' => 'value_1',
                'param_2' => 'value_2',
            ],
            'db_connection' => [
                'driver' => 'driver',
                'username' => 'user',
                'password' => '12345678',
                'database' => 'db'
            ],
            'resources' => 'foo',
        ];

        $result = $this->instance->process('examples/hello_world.jrxml', '{output_file}', $options);

        $expected = '.*jasperstarter --locale en_US process ".*hello_world.jrxml" -o "{output_file}" ';
        $expected .= '-f pdf -P  param_1="value_1"   param_2="value_2"   -t driver -u user -p 12345678 -n db -r foo';

        $this->expectOutputRegex('/' . $expected . '/', $result->printOutput());
    }

    /** @test */
    public function listParameters()
    {
        $result = $this->instance->listParameters('examples/hello_world.jrxml');

        $this->expectOutputRegex('/.*jasperstarter list_parameters ".*hello_world.jrxml"/', $result->printOutput());
    }

    /** @test */
    public function compileWithWrongInput()
    {
        $this->expectException(Exception\InvalidInputFile::class);

        $this->instance->compile('');
    }

    /** @test */
    public function outputWithUserOnExecute()
    {
        $this->expectException(Exception\ErrorCommandExecutable::class);

        $this->instance->compile(__DIR__ . '/test.jrxml', __DIR__ . '/test')->execute('phpjasper');

        $expected = 'su -u 1000 -c "./jasperstarter compile "/var/www/app/tests/test.jrxml" -o "/var/www/app/tests/test""';

        $this->expectOutputRegex('/' . $expected . '/', $this->instance->printOutput());
    }

    /** @test */
    public function executeWithoutCompile()
    {
        $this->expectException(Exception\InvalidCommandExecutable::class);

        $this->instance->execute();
    }

    /** @test */
    public function invalidInputFile()
    {
        $this->expectException(Exception\InvalidInputFile::class);

        $this->instance->compile('{invalid}')->execute();
    }

    /** @test */
    public function execute()
    {
        $actual = $this->instance->compile(__DIR__ . '/test.jrxml')->execute();

        $this->assertInternalType('array', $actual);
    }

    /** @test */
    public function executeWithOutput()
    {
        $actual = $this->instance->compile(__DIR__ . '/test.jrxml', __DIR__ . '/test')->execute();

        $this->assertInternalType('array', $actual);
    }

    /** @test */
    public function executeThrowsInvalidResourceDirectory()
    {
        $reflectionObject = new ReflectionObject($this->instance);
        $reflectionProperty = $reflectionObject->getProperty('pathExecutable');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($this->instance, '');

        $this->expectException(Exception\InvalidResourceDirectory::class);

        $this->instance->compile(__DIR__ . '/test.jrxml', __DIR__ . '/test')->execute();
    }

    /** @test */
    public function listParametersWithWrongInput()
    {
        $this->expectException(Exception\InvalidInputFile::class);

        $this->instance->listParameters('');
    }

    /** @test */
    public function processWithWrongInput()
    {
        $this->expectException(Exception\InvalidInputFile::class);

        $this->instance->process(
            '',
            '',
            [
                'format' => 'mp3'
            ]
        );
    }

    /** @test */
    public function processWithWrongFormat()
    {
        $this->expectException(Exception\InvalidFormat::class);

        $this->instance->process(
            'hello_world.jrxml',
            '',
            [
                'format' => 'mp3'
            ]
        );
    }

    /** @test */
    public function output()
    {
        $result = $this->instance->listParameters('examples/hello_world.jrxml');

        $this->expectOutputRegex('/.*jasperstarter list_parameters ".*hello_world.jrxml' . '/', $result->output() . "\n");
    }
}
