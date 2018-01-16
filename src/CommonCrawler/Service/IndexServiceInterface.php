<?php

namespace CommonCrawl\Service;


use CommonCrawl\Model\Index;

interface IndexServiceInterface
{
    public function findAllIndexes();

    public function findIndex($id);

    public function insertIndex(array $values);

    public function deleteIndex($id);

    public function flushAllIndex();

    public function importIndexFromServer();

    public function isIndexExists($id);

    public function activeIndex($id);

    public function inactiveIndex($id);

    public function activeAllIndex();

    public function inactiveAllIndex();

    public function getPageSize(Index $index, $url, $output = 'json', $showNumPages = true);

}