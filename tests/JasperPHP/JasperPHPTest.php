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

}