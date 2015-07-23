<?php

namespace Vinelab\Cdn\Tests;

use Mockery as M;

/**
 * Class AssetTest.
 *
 * @category Test
 *
 * @author  Mahmoud Zalt <mahmoud@vinelab.com>
 */
class AssetTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->asset = new \Vinelab\Cdn\Asset();
    }

    public function tearDown()
    {
        M::close();
        parent::tearDown();
    }

    public function testInitReturningAssetObject()
    {
        $dir = 'foo';

        $result = $this->asset->init([
            'include' => [
                'directories' => $dir,
            ],
        ]);

        // check the returned object is of type Vinelab\Cdn\Asset
        assertEquals($result, $this->asset);
    }

    public function testIncludedDirectories()
    {
        $dir = 'foo';

        $this->asset->init([
            'include' => [
                'directories' => $dir,
            ],
        ]);

        $result = $this->asset->getIncludedDirectories();

        assertEquals($result, $dir);
    }

    public function testIncludedExtensions()
    {
        $ext = 'foo';

        $this->asset->init([
            'include' => [
                'extensions' => $ext,
            ],
        ]);

        $result = $this->asset->getIncludedExtensions();

        assertEquals($result, $ext);
    }

    public function testIncludedPatterns()
    {
        $pat = 'foo';

        $this->asset->init([
            'include' => [
                'patterns' => $pat,
            ],
        ]);

        $result = $this->asset->getIncludedPatterns();

        assertEquals($result, $pat);
    }

    public function testExcludedDirectories()
    {
        $dir = 'foo';

        $this->asset->init([
            'exclude' => [
                'directories' => $dir,
            ],
        ]);

        $result = $this->asset->getExcludedDirectories();

        assertEquals($result, $dir);
    }

    public function testExcludedFiles()
    {
        $dir = 'foo';

        $this->asset->init([
            'exclude' => [
                'files' => $dir,
            ],
        ]);

        $result = $this->asset->getExcludedFiles();

        assertEquals($result, $dir);
    }

    public function testExcludedExtensions()
    {
        $dir = 'foo';

        $this->asset->init([
            'exclude' => [
                'extensions' => $dir,
            ],
        ]);

        $result = $this->asset->getExcludedExtensions();

        assertEquals($result, $dir);
    }

    public function testExcludedPatterns()
    {
        $dir = 'foo';

        $this->asset->init([
            'exclude' => [
                'patterns' => $dir,
            ],
        ]);

        $result = $this->asset->getExcludedPatterns();

        assertEquals($result, $dir);
    }

    public function testExcludedHidden()
    {
        $bol = true;

        $this->asset->init([
            'exclude' => [
                'hidden' => $bol,
            ],
        ]);

        $result = $this->asset->getExcludeHidden();

        assertEquals($result, $bol);
    }
}
