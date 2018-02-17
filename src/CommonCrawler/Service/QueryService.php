<?php

namespace CommonCrawler\Service;

use CommonCrawler\Mapper\QueryMapperInterface;

class QueryService implements QueryServiceInterface
{
    protected $queryService;

    public function __construct(QueryMapperInterface $queryService)
    {
        $this->queryService = $queryService;
    }

    public function findAllQueries()
    {
        return $this->queryService->findAll();
    }

    public function findAllActiveQueries()
    {
        return $this->queryService->findAllActiveQueries();
    }

    public function findAllInactiveQueries()
    {
        return $this->queryService->findAllInactiveQueries();
    }

    public function findQuery($id)
    {
        return $this->queryService->findQuery($id);
    }

    public function insertQuery(array $values)
    {
        return $this->queryService->insertQuery($values);
    }

    public function deleteQuery($id)
    {
        return $this->queryService->deleteQuery($id);
    }

    public function flushAllQuery()
    {
        return $this->queryService->flushAllQuery();
    }

    public function importSampleQuery()
    {
        return $this->queryService->importSampleQuery();
    }

    public function isQueryExists($id)
    {
        return $this->queryService->isQueryExists($id);
    }

    public function activeQuery($id)
    {
        return $this->queryService->activeQuery($id);
    }

    public function inactiveQuery($id)
    {
        return $this->queryService->inactiveQuery($id);
    }

    public function activeAllQuery()
    {
        return $this->queryService->activeAllQuery();
    }

    public function inactiveAllQuery()
    {
        return $this->queryService->inactiveAllQuery();
    }

    public function createdQueryBefore($timestamp)
    {
        return $this->queryService->createdQueryBefore($timestamp);
    }

    public function createdQueryAfter($timestamp)
    {
        return $this->queryService->createdQueryAfter($timestamp);
    }

    public function createdQueryBetween($fromTimestamp, $toTimestamp)
    {
        return $this->queryService->createdQueryBefore($fromTimestamp, $toTimestamp);
    }

    public function updatedQueryBefore($timestamp)
    {
        return $this->queryService->updatedQueryBefore($timestamp);
    }

    public function updatedQueryAfter($timestamp)
    {
        return $this->queryService->updatedQueryAfter($timestamp);
    }

    public function updatedQueryBetween($fromTimestamp, $toTimestamp)
    {
        $this->queryService->updatedQueryBetween($fromTimestamp, $toTimestamp);
    }

}