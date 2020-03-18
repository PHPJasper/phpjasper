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
 * @author Daniel Rodrigues <geekcom@php.net>
 */
final class PHPJasperTest extends TestCase
{
    private $instance;

    public function setUp(): void
    {
        $this->instance = new PHPJasper();
    }

    /** @test */
    public function constructor()
    {
        $this->assertInstanceOf(PHPJasper::class, new PHPJasper());
    }

    /** @test */
    public function compile(): void
    {
        $result = $this->instance->compile('examples/hello_world.jrxml');

        $this->expectOutputRegex('/.*jasperstarter compile ".*hello_world.jrxml"/', $result->printOutput());
    }

    /** @test */
    public function process(): void
    {
        $result = $this->instance->process('examples/hello_world.jrxml', '{output_file}');

        $expected = '.*jasperstarter process ".*hello_world.jrxml" -o "{output_file}"';

        $this->expectOutputRegex('/' . $expected . '/', $result->printOutput());
    }

    /** @test */
    public function processWithOptions(): void
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
    public function listParameters(): void
    {
        $result = $this->instance->listParameters('examples/hello_world.jrxml');

        $this->expectOutputRegex('/.*jasperstarter list_parameters ".*hello_world.jrxml"/', $result->printOutput());
    }

    /** @test */
    public function compileWithWrongInput(): void
    {
        $this->expectException(Exception\InvalidInputFile::class);

        $this->instance->compile('');
    }

    /** @test */
    public function outputWithUserOnExecute(): void
    {
        $this->expectException(Exception\ErrorCommandExecutable::class);

        $this->instance->compile(__DIR__ . '/test.jrxml', __DIR__ . '/test')->execute('phpjasper');

        $expected = 'su -u 1000 -c "./jasperstarter compile "/var/www/app/tests/test.jrxml" -o "/var/www/app/tests/test""';

        $this->expectOutputRegex('/' . $expected . '/', $this->instance->printOutput());
    }

    /** @test */
    public function executeWithoutCompile(): void
    {
        $this->expectException(Exception\InvalidCommandExecutable::class);

        $this->instance->execute();
    }

    /** @test */
    public function invalidInputFile(): void
    {
        $this->expectException(Exception\InvalidInputFile::class);

        $this->instance->compile('{invalid}')->execute();
    }

    /** @test */
    public function execute(): void
    {
        $actual = $this->instance->compile(__DIR__ . '/test.jrxml')->execute();

        $this->assertIsArray($actual);
    }

    /** @test */
    public function executeWithOutput(): void
    {
        $actual = $this->instance->compile(__DIR__ . '/test.jrxml', __DIR__ . '/test')->execute();

        $this->assertIsArray($actual);
    }

    /** @test */
    public function executeThrowsInvalidResourceDirectory(): void
    {
        $reflectionObject = new ReflectionObject($this->instance);
        $reflectionProperty = $reflectionObject->getProperty('pathExecutable');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($this->instance, '');

        $this->expectException(Exception\InvalidResourceDirectory::class);

        $this->instance->compile(__DIR__ . '/test.jrxml', __DIR__ . '/test')->execute();
    }

    /** @test */
    public function listParametersWithWrongInput(): void
    {
        $this->expectException(Exception\InvalidInputFile::class);

        $this->instance->listParameters('');
    }

    /** @test */
    public function processWithWrongInput(): void
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
    public function processWithWrongFormat(): void
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
}
