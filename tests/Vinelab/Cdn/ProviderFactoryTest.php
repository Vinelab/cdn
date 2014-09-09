<?php namespace Vinelab\Cdn\Tests;

use Mockery as M;

class ProviderFactoryTest extends TestCase {

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

    public function testAwsS3ProviderCreation()
    {
        $configurations = ['default' => 'aws.s3'];

        $m_aws_s3 = M::mock('Vinelab\Cdn\Providers\AwsS3Provider');

        \Illuminate\Support\Facades\App::shouldReceive('make')->once()->andReturn($m_aws_s3);

        $m_aws_s3->shouldReceive('init')
            ->with($configurations)
            ->once()
            ->andReturn($m_aws_s3);

        $provider = $this->provider_factory->create($configurations);

        assertEquals($provider, $m_aws_s3);
    }

}
