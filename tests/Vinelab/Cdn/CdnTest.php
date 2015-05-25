<?php
namespace Vinelab\Cdn\Tests;

use Illuminate\Support\Collection;
use Mockery as M;

/**
 * Class CdnTest
 *
 * @category Test
 * @package Vinelab\Cdn\Tests
 * @author  Mahmoud Zalt <mahmoud@vinelab.com>
 */
class CdnTest extends TestCase
{

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

    /**
     * Integration Test
     */
    public function testPushCommand()
    {
        $configuration_file = [
            'bypass'    => false,
            'default'   => 'AwsS3',
            'url'       => 'https://s3.amazonaws.com',
            'threshold' => 10,
            'providers' => [
                'aws' => [
                    's3' => [
                        'credentials' => [
                            'key'    => 'keeeeeeeeeeeeeeeeeeeeeeey',
                            'secret' => 'ssssssssccccccccccctttttt',
                        ],
                        'buckets'     => [
                            'bbbuuuucccctttt' => '*',
                        ],
                        'acl'         => 'public-read',
                        'cloudfront'  => [
                            'use'     => false,
                            'cdn_url' => '',
                            'version' => '',
                        ],
						'metadata' => [],

                        'expires' => gmdate("D, d M Y H:i:s T", strtotime("+5 years")),

                        'cache-control' => 'max-age=2628000',
                    ],
                ],
            ],
            'include'   => [
                'directories' => [__DIR__],
                'extensions'  => [],
                'patterns'    => [],
            ],
            'exclude'   => [
                'directories' => [],
                'files'       => [],
                'extensions'  => [],
                'patterns'    => [],
                'hidden'      => true,
            ],
        ];

        $m_consol = M::mock('Symfony\Component\Console\Output\ConsoleOutput');
        $m_consol->shouldReceive('writeln')
            ->atLeast(1);

        $finder = new \Vinelab\Cdn\Finder($m_consol);

        $asset = new \Vinelab\Cdn\Asset();

        $provider_factory = new \Vinelab\Cdn\ProviderFactory();

        $m_config = M::mock('Illuminate\Config\Repository');
        $m_config->shouldReceive('get')
            ->with('cdn')
            ->once()
            ->andReturn($configuration_file);

        $helper = new \Vinelab\Cdn\CdnHelper($m_config);

        $m_console = M::mock('Symfony\Component\Console\Output\ConsoleOutput');
        $m_console->shouldReceive('writeln')
            ->atLeast(2);

        $m_validator = M::mock('Vinelab\Cdn\Validators\Contracts\ProviderValidatorInterface');
        $m_validator->shouldReceive('validate');

        $m_helper = M::mock('Vinelab\Cdn\CdnHelper');

        $m_spl_file = M::mock('Symfony\Component\Finder\SplFileInfo');
        $m_spl_file->shouldReceive('getPathname')
            ->andReturn('vinelab/cdn/tests/Vinelab/Cdn/AwsS3ProviderTest.php');
        $m_spl_file->shouldReceive('getRealPath')
            ->andReturn(__DIR__ . '/AwsS3ProviderTest.php');

        $p_aws_s3_provider = M::mock('\Vinelab\Cdn\Providers\AwsS3Provider[connect]', array
        (
            $m_console,
            $m_validator,
            $m_helper
        ));

        $m_s3 = M::mock('Aws\S3\S3Client');
        $m_s3->shouldReceive('factory')
            ->andReturn('Aws\S3\S3Client');
        $m_s3->shouldReceive('getCommand');
        $p_aws_s3_provider->setS3Client($m_s3);

        $m_batch = M::mock('Guzzle\Batch\BatchBuilder');
        $m_batch->shouldReceive('factory')
            ->andReturn('Guzzle\Batch\BatchBuilder');
        $m_batch->shouldReceive('add');
        $m_batch->shouldReceive('getHistory')
            ->andReturn(null);
        $p_aws_s3_provider->setBatchBuilder($m_batch);

        $p_aws_s3_provider->shouldReceive('connect')
            ->andReturn(true);

        \Illuminate\Support\Facades\App::shouldReceive('make')
            ->once()
            ->andReturn($p_aws_s3_provider);

        $cdn = new \Vinelab\Cdn\Cdn($finder,
            $asset,
            $provider_factory,
            $helper
        );

        $result = $cdn->push();

        assertEquals($result, true);
    }

}
