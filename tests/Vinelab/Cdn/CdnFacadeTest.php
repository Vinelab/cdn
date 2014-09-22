<?php namespace Vinelab\Cdn\Tests;

use Mockery as M;

class CdnFacadeTest extends TestCase {

    public function setUp()
    {
        parent::setUp();

        $this->asset_path = 'public/foo/bar.php';
        $this->cdn_url = 'https://amazon.foo.bar.com';

        $this->provider = M::mock('Vinelab\Cdn\Providers\AwsS3Provider');

        $this->provider_factory = M::mock('Vinelab\Cdn\Contracts\ProviderFactoryInterface');
        $this->provider_factory->shouldReceive('create')->once()->andReturn($this->provider);

        $this->helper = M::mock('Vinelab\Cdn\Contracts\CdnHelperInterface');
        $this->helper->shouldReceive('getConfigurations')->once()->andReturn([]);
        $this->helper->shouldReceive('cleanPath')->andReturn($this->asset_path);
        $this->helper->shouldReceive('startsWith')->andReturn(true);

        $this->validator = new \Vinelab\Cdn\Validators\CdnFacadeValidator;

        $this->facade = new \Vinelab\Cdn\CdnFacade(
            $this->provider_factory, $this->helper, $this->validator);
    }

    public function tearDown()
    {
        M::close();
        parent::tearDown();
    }

    public function testAssetIsCallingUrlGenerator()
    {
        $this->provider->shouldReceive('urlGenerator')
            ->with($this->asset_path)
            ->once()
            ->andReturn($this->cdn_url);

       $result = $this->facade->asset($this->asset_path);
 
        // assert is calling the url generator
        assertEquals($result, $this->cdn_url);
    }

    /**
     * @expectedException \Vinelab\Cdn\Exceptions\EmptyPathException
     */
    public function testUrlGeneratorThrowsException()
    {
        $this->invokeMethod($this->facade, 'generateUrl', array(null, null));
    }

}
