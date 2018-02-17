<?php
/**
 * Created by PhpStorm.
 * User: vallabh
 * Date: 03/02/18
 * Time: 3:46 PM
 */

namespace CommonCrawler\Model;


interface QueryInterface
{

    public function getQuery();

    public function getCindexId();

    public function getStatus();

    public function getResult();

    public function getPageGenerated();

    public function getCreatedAt();

    public function getUpdatedAt();

}