<?php

namespace CommonCrawler\Service;

interface QueryServiceInterface
{
    public function findAllQueries();

    public function findAllActiveQueries();

    public function findAllInactiveQueries();

    public function findQuery($id);

    public function insertQuery(array $values);

    public function deleteQuery($id);

    public function flushAllQuery();

    public function importSampleQuery();

    public function isQueryExists($id);

    public function activeQuery($id);

    public function inactiveQuery($id);

    public function activeAllQuery();

    public function inactiveAllQuery();

    public function createdQueryBefore($timestamp);

    public function createdQueryAfter($timestamp);

    public function createdQueryBetween($fromTimestamp, $toTimestamp);

    public function updatedQueryBefore($timestamp);

    public function updatedQueryAfter($timestamp);

    public function updatedQueryBetween($fromTimestamp, $toTimestamp);
}