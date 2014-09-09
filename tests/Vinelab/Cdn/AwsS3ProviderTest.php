<?php namespace Vinelab\Cdn\Tests;

use Illuminate\Support\Collection;
use Mockery as M;

class AwsS3ProviderTest extends TestCase {

    public function setUp()
    {
        parent::setUp();

        $this->m_console = M::mock('Symfony\Component\Console\Output\ConsoleOutput');
        $this->m_console->shouldReceive('writeln')->atLeast(2);

        $this->m_validator = M::mock('Vinelab\Cdn\Validators\Contracts\ProviderValidatorInterface');
        $this->m_validator->shouldReceive('validate');

        $this->m_helper = M::mock('Vinelab\Cdn\CdnHelper');

        $this->m_spl_file = M::mock('Symfony\Component\Finder\SplFileInfo');
        $this->m_spl_file->shouldReceive('getPathname')->andReturn('vinelab/cdn/tests/Vinelab/Cdn/AwsS3ProviderTest.php');
        $this->m_spl_file->shouldReceive('getRealPath')->andReturn(__DIR__ . '/AwsS3ProviderTest.php');

        $this->p_awsS3Provider = M::mock('\Vinelab\Cdn\Providers\AwsS3Provider[connect]', array
            ($this->m_console, $this->m_validator, $this->m_helper));

        $this->m_s3 = M::mock('Aws\S3\S3Client');
        $this->m_s3->shouldReceive('factory')->andReturn('Aws\S3\S3Client');
        $this->m_s3->shouldReceive('getCommand');
        $this->p_awsS3Provider->setS3Client($this->m_s3);

        $this->m_batch = M::mock('Guzzle\Batch\BatchBuilder');
        $this->m_batch->shouldReceive('factory')->andReturn('Guzzle\Batch\BatchBuilder');
        $this->m_batch->shouldReceive('add');
        $this->m_batch->shouldReceive('getHistory')->andReturn(null);
        $this->p_awsS3Provider->setBatchBuilder($this->m_batch);

        $this->p_awsS3Provider->shouldReceive('connect')->andReturn(true);
        
        $this->configurations = [
            'default' => 'aws.s3',
            'url' => 'https://s3.amazonaws.com',
            'threshold' => 10,
            'providers' => [
                'aws' => [
                    's3' => [
                        'credentials' => [
                            'key'       => 'XXXXXXX',
                            'secret'    => 'YYYYYYY',
                        ],
                        'buckets' => [
                            'ZZZZZZZ' => '*',
                        ],
                        'acl' => 'public-read'
                    ],
                ],
            ],
        ];

    }

    public function tearDown()
    {
        M::close();
        parent::tearDown();
    }

    public function testInitializingObject()
    {
        $returned = $this->p_awsS3Provider->init($this->configurations);

        assertInstanceOf('Vinelab\Cdn\Providers\AwsS3Provider', $returned);
    }

    public function testUploadingAssets()
    {
        $this->p_awsS3Provider->init($this->configurations);

        $result = $this->p_awsS3Provider->upload(new Collection([$this->m_spl_file]));

        assertEquals(true, $result);
    }

}
