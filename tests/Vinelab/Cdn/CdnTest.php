<?php namespace Vinelab\Cdn\Tests;

use Illuminate\Support\Collection;
use Mockery as M;

class CdnTest extends TestCase {

    public function setUp()
    {
        parent::setUp();

        $this->m_spl_file_info = M::mock('Symfony\Component\Finder\SplFileInfo');

    }

    public function tearDown()
    {
        M::close();
        parent::tearDown();
    }

    public function testPushCommandReturnTrue()
    {
        $this->m_asset = M::mock('Vinelab\Cdn\Contracts\AssetInterface');
        $this->m_asset->shouldReceive('init')
            ->once()
            ->andReturn($this->m_asset);
        $this->m_asset->shouldReceive('setAssets')
            ->once();

        $this->m_asset->shouldReceive('getAssets')
            ->once()
            ->andReturn(New Collection());

        $this->m_finder = M::mock('Vinelab\Cdn\Contracts\FinderInterface');
        $this->m_finder->shouldReceive('read')
            ->with($this->m_asset)
            ->once()
            ->andReturn(New Collection());

        $this->m_provider = M::mock('Vinelab\Cdn\Providers\Provider');
        $this->m_provider->shouldReceive('upload')
            ->once()
            ->andReturn(true);

        $this->m_provider_factory = M::mock('Vinelab\Cdn\Contracts\ProviderFactoryInterface');
        $this->m_provider_factory->shouldReceive('create')
            ->once()
            ->andReturn($this->m_provider);

        $this->m_helper = M::mock('Vinelab\Cdn\Contracts\CdnHelperInterface');
        $this->m_helper->shouldReceive('getConfigurations')
            ->once()
            ->andReturn([]);

        $this->cdn = new \Vinelab\Cdn\Cdn(
            $this->m_finder,
            $this->m_asset,
            $this->m_provider_factory,
            $this->m_helper);


        $result = $this->cdn->push();

        assertEquals($result, true);
    }

    public function testPushCommand()
    {

        $m_consol = M::mock('Symfony\Component\Console\Output\ConsoleOutput');
        $finder = new \Vinelab\Cdn\Finder($m_consol);
        $asset = new \Vinelab\Cdn\Asset();
        $provider_factory = new \Vinelab\Cdn\ProviderFactory();
        $config = new \Illuminate\Config\Repository;
        $helper = new \Vinelab\Cdn\CdnHelper($config);

        $cdn = new \Vinelab\Cdn\Cdn(    $finder,
                                        $asset,
                                        $provider_factory,
                                        $helper
                                    );

        $result = $cdn->push();

        assertEquals($result, true);
    }


}
