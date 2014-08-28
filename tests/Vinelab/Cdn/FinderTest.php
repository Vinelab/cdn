<?php namespace Vinelab\Cdn\Tests;

use Mockery as M;

class FinderTest extends TestCase {

    public function setUp()
    {
        parent::setUp();

        // mocking the Paths class (the directory configurations holder and presenter)
        $this->m_paths = M::mock('Vinelab\Cdn\Contracts\PathsInterface');
        // defining the Paths class behavior when calling the read function which takes this Paths class as parameter
        $this->m_paths
            ->shouldReceive('getIncludedDirectories')
            ->andReturn(['public', 'private'])

            ->shouldReceive('getExcludedDirectories')
            ->andReturn(['README.md', 'LICENSE'])

            ->shouldReceive('getExcludedExtensions')
            ->andReturn(['.txt'])

            ->shouldReceive('getExcludedPatterns')
            ->andReturn(['404.*']);

            // preparing fake data to be passed to the setAllowedPaths() function
            $allowed_paths = ['/var/www/html/VINELAB/CDN-Package/cdn-package/public/index.php',
                '/var/www/html/VINELAB/CDN-Package/cdn-package/public/file.php'];

            $this->m_paths->shouldReceive('setAllowedPaths');

        // making an object of the main class that im testing in this test class
        // by ->makePartial() I am just mocking some extended functions only
//        $this->p_finder = M::mock('Vinelab\Cdn\Finder[in,exclude,notName,files]');
        $this->p_finder = M::mock('Vinelab\Cdn\Finder')->makePartial();

        $this->p_finder
            ->shouldReceive('in')
            ->with($this->m_paths->getIncludedDirectories())
            ->andReturn($this->p_finder)

            ->shouldReceive('exclude')
            ->with($this->m_paths->getExcludedDirectories())
            ->andReturn($this->p_finder);

        foreach($this->m_paths->getExcludedExtensions() as $extension){
             $this->p_finder->shouldReceive('notName')
            ->with('*' . $extension)
            ->andReturn($this->p_finder);
        }

        foreach($this->m_paths->getExcludedPatterns() as $pattern){
            $this->p_finder->shouldReceive('notName')
                ->with($pattern)
                ->andReturn($this->p_finder);
        }

        // mocking a returned object from  $this->files(). the files() returns an object of multiple SplFileInfo objects
        $this->m_spl_file_info = M::mock('Symfony\Component\Finder\SplFileInfo')->makePartial();

        $this->m_spl_file_info
            ->shouldReceive('getRealpath')
            ->andReturn('/var/www/html/VINELAB/CDN-Package/cdn-package/public/assets/js/vendor/bootstrap.min.js');

        $this->p_finder
            ->shouldReceive('files')
            ->andReturn(new \Illuminate\Support\Collection([$this->m_spl_file_info]));

    }

    public function tearDown()
    {
        M::close();
        parent::tearDown();
    }


    public function testRead(){

        $result = $this->p_finder->read($this->m_paths);
        assertEquals($result, $this->m_paths);

    }




}
