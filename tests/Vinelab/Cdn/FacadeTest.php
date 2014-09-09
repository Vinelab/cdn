<?php namespace Vinelab\Cdn\Tests;

use Mockery as M;

class FacadeTest extends TestCase {

    public function setUp()
    {
        parent::setUp();

        $this->cdn_url = 'https://amazon.foo.bar.com';

        $this->provider = M::mock('Vinelab\Cdn\Providers\AwsS3Provider');
        $this->provider->shouldReceive('urlGenerator')->once()->andReturn($this->cdn_url);

        $this->provider_factory = M::mock('Vinelab\Cdn\Contracts\ProviderFactoryInterface');
        $this->provider_factory->shouldReceive('create')->once()->andReturn($this->provider);

        $this->helper = M::mock('Vinelab\Cdn\Contracts\CdnHelperInterface');
        $this->helper->shouldReceive('getConfigurations')->once()->andReturn([]);

        $this->m_validator = M::mock('Vinelab\Cdn\Validators\CdnFacadeValidator');
        $this->m_validator->shouldReceive('checkIfEmpty')->once();

        $this->facade = new \Vinelab\Cdn\CdnFacade(
            $this->provider_factory, $this->helper, $this->m_validator);
    }

    public function tearDown()
    {
        M::close();
        parent::tearDown();
    }

    public function testAssetUrlGenerator()
    {
        $result = $this->facade->asset('file path here');

        // assert is calling the url generator
        assertEquals($result, $this->cdn_url);
    }

    public function testAssetUrlGeneratorWithEmpty()
    {
//        $result = $this->facade->asset();

    }


}
