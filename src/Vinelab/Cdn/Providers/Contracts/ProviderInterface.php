<?php
namespace Vinelab\Cdn\Providers\Contracts;

/**
 * Interface ProviderInterface
 * @package  Vinelab\Cdn\Providers\Contracts
 * @author   Mahmoud Zalt <mahmoud@vinelab.com>
 */
interface ProviderInterface
{

    public function init($configurations);

    public function upload($assets);

    public function emptyBucket();

    public function urlGenerator($path);

    public function getUrl();

    public function getCloudFront();

    public function getCloudFrontUrl();

    public function getBucket();

    public function setS3Client($s3_client);

    public function setBatchBuilder($batch);

} 
