<?php namespace Vinelab\Cdn\Tests;

use Mockery as M;
use Vinelab\Cdn\Finder;

class FinderTest extends TestCase {

    public function setUp()
    {
        parent::setUp();

        $this->finder = new Finder();
        $this->paths = M::mock('Vinelab\Cdn\Paths\Paths');

    }

    public function tearDown()
    {
        parent::tearDown();
        M::close();
    }


    public function testFirstCase(){
        $this->finder->read($this->paths); // <<<<<
        $this->assertEquals('1', '1');
    }



}