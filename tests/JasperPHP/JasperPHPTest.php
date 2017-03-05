<?php
namespace JasperPHP;
/**
 * Class JasperPHPTest
 *
 * @author Rafael Queiroz <rafaelfqf@gmail.com>
 * @package JasperPHP
 */
class JasperPHPTest extends \PHPUnit_Framework_TestCase
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

}