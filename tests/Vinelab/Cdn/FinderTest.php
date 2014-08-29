<?php namespace Vinelab\Cdn\Tests;

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
        $paths = new \Vinelab\Cdn\Paths;

        $paths->init(array(
                'include'    => [
                    'directories'   => [__DIR__],
                ]
            ));

        $ConsoleOutput = M::mock('Symfony\Component\Console\Output\ConsoleOutput');
        $ConsoleOutput->shouldReceive('writeln')
            ->atLeast(1);

        $finder = new \Vinelab\Cdn\Finder($ConsoleOutput);

        $result = $finder->read($paths);

        assertEquals($result, $paths);
    }

}
