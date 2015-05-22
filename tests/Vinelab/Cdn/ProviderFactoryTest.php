<?php
namespace Vinelab\Cdn\Tests;

use Mockery as M;

/**
 * Class ProviderFactoryTest
 *
 * @category Test
 * @package Vinelab\Cdn\Tests
 * @author  Mahmoud Zalt <mahmoud@vinelab.com>
 */
class ProviderFactoryTest extends TestCase
{

    public function setUp()
    {
        parent::setUp();

        $this->provider_factory = new \Vinelab\Cdn\ProviderFactory;

    }

    public function tearDown()
    {
        M::close();
        parent::tearDown();
    }

    public function testCreateReturnCorrectProviderObject()
    {
        $configurations = ['default' => 'AwsS3'];

        $m_aws_s3 = M::mock('Vinelab\Cdn\Providers\AwsS3Provider');

        \Illuminate\Support\Facades\App::shouldReceive('make')->once()->andReturn($m_aws_s3);

        $m_aws_s3->shouldReceive('init')
            ->with($configurations)
            ->once()
            ->andReturn($m_aws_s3);

        $provider = $this->provider_factory->create($configurations);

        assertEquals($provider, $m_aws_s3);
    }


    /**
     * @expectedException \Vinelab\Cdn\Exceptions\MissingConfigurationException
     */
    public function testCreateThrowsExceptionWhenMissingDefaultConfiguration()
    {
        $configurations = ['default' => ''];

        $m_aws_s3 = M::mock('Vinelab\Cdn\Providers\AwsS3Provider');

        \Illuminate\Support\Facades\App::shouldReceive('make')->once()->andReturn($m_aws_s3);

        $this->provider_factory->create($configurations);
    }

}
