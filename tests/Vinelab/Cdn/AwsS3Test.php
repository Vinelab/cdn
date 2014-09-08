<?php namespace Vinelab\Cdn\Tests;

use Mockery as M;

class AwsS3Test extends TestCase {

    public function setUp()
    {
        parent::setUp();
    }

    public function tearDown()
    {
        M::close();
        parent::tearDown();
    }

    public function testInitializingObject()
    {
        $console    = M::mock('Symfony\Component\Console\Output\ConsoleOutput');
        $validator  = M::mock('Vinelab\Cdn\Validators\Configurations');
        $helper     = M::mock('Vinelab\Cdn\CdnHelper');

        $validator->shouldReceive('validate');

        $awsS3Provider = new \Vinelab\Cdn\Providers\AwsS3Provider($console, $validator, $helper);

        $returned = $awsS3Provider->init([]);

        assertInstanceOf('Vinelab\Cdn\Providers\AwsS3Provider', $returned);
    }



}
