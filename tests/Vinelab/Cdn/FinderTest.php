<?php namespace Vinelab\Cdn\Tests;

use Illuminate\Support\Collection;
use Mockery as M;

class FinderTest extends TestCase {

    public function setUp()
    {
        parent::setUp();
    }

    public function tearDown()
    {
        M::close();
        parent::tearDown();
    }

    public function testReadingAllowedDirectories()
    {
        $asset_holder = new \Vinelab\Cdn\AssetHolder;

        $asset_holder->init(array(
                'include'    => [
                    'directories'   => [__DIR__],
                ]
            ));

        $console_output = M::mock('Symfony\Component\Console\Output\ConsoleOutput');
        $console_output->shouldReceive('writeln')
            ->atLeast(1);

        $finder = new \Vinelab\Cdn\Finder($console_output);

        $result = $finder->read($asset_holder);
        assertEquals($result, new Collection);
    }

}
