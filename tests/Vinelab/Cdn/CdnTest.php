<?php namespace Vinelab\Cdn\Tests;

use Illuminate\Support\Collection;
use Mockery as M;

class CdnTest extends TestCase {

    public function setUp()
    {
        parent::setUp();

        $this->m_finder = M::mock('Vinelab\Cdn\Contracts\FinderInterface');
        $this->m_finder->shouldReceive('read')->once()->andReturn(New Collection());

        $this->m_asset = M::mock('Vinelab\Cdn\Contracts\AssetInterface');
        $this->m_asset->shouldReceive('init')->once()->andReturn($this->m_asset);
        $this->m_asset->shouldReceive('setAssets')->once();
        $this->m_asset->shouldReceive('getAssets')->once()->andReturn(New Collection());


        $this->m_provider = M::mock('Vinelab\Cdn\Providers\Provider');
        $this->m_provider->shouldReceive('upload')->once()->andReturn(true);

        $this->m_provider_factory = M::mock('Vinelab\Cdn\Contracts\ProviderFactoryInterface');
        $this->m_provider_factory->shouldReceive('create')->once()->andReturn($this->m_provider);

        $this->m_helper = M::mock('Vinelab\Cdn\Contracts\CdnHelperInterface');
        $this->m_helper->shouldReceive('getConfigurations')->once()->andReturn(array());

        $this->cdn = new \Vinelab\Cdn\Cdn(
                            $this->m_finder,
                            $this->m_asset,
                            $this->m_provider_factory,
                            $this->m_helper);

    }

    public function tearDown()
    {
        M::close();
        parent::tearDown();
    }

    public function testPushingCommand()
    {
        $result = $this->cdn->push();
        assertEquals($result, true);
    }

}
