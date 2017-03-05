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
     * @return JasperPHP
     */
    public function testConstructor()
    {
        $this->assertInstanceOf(JasperPHP::class, new JasperPHP());
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
    public function testExecuteWithCompileAndWrongInput()
    {
        $this->setExpectedException(\JasperPHP\Exception\ErrorCommandExecutable::class);

        $jasper = new JasperPHP();
        $jasper->compile('hello_world.jrxml')->execute();
    }

}